<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  array<int, string>  $roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401, 'Authentication required.');
        }

        if ($user->is_suspended ?? false) {
            abort(403, 'This account has been suspended.');
        }

        $allowedRoles = array_values(array_filter(array_map('trim', $roles), fn (string $role): bool => $role !== ''));

        if ($allowedRoles === []) {
            $allowedRoles = [Role::ADMIN];
        }

        $hasRequiredRole = $user->roles()->whereIn('name', $allowedRoles)->exists();

        if (! $hasRequiredRole) {
            AuditLog::create([
                'admin_id' => $user->getKey(),
                'action' => 'access_denied',
                'model_type' => 'RoleMiddleware',
                'model_id' => $user->getKey(),
                'changes' => [
                    'before' => null,
                    'after' => [
                        'route' => $request->path(),
                        'required_roles' => $allowedRoles,
                    ],
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            abort(403, 'You do not have the required role for this area.');
        }

        return $next($request);
    }
}
