<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401, 'Authentication required.');
        }

        if (($user->is_suspended ?? false) === true) {
            abort(403, 'This account has been suspended.');
        }

        if (! $user->isSuperAdmin()) {
            AuditLog::create([
                'admin_id' => $user->getKey(),
                'action' => 'access_denied',
                'model_type' => 'SuperAdminMiddleware',
                'model_id' => $user->getKey(),
                'changes' => [
                    'before' => null,
                    'after' => [
                        'route' => $request->path(),
                        'reason' => 'missing_super_admin_role',
                    ],
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            abort(403, 'Super administrator access is required.');
        }

        return $next($request);
    }
}
