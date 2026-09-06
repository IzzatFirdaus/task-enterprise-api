<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Authenticate an admin user via the API.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        /** @var User|null $user */
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, $credentials) || ! $user->isAdmin()) {
            AuditLog::create([
                'admin_id' => $user?->getKey(),
                'action' => 'login_failed',
                'model_type' => 'AdminAuthController',
                'model_id' => $user?->getKey(),
                'changes' => [
                    'before' => null,
                    'after' => [
                        'email_hash' => hash('sha256', mb_strtolower((string) $request->input('email'))),
                        'route' => $request->path(),
                    ],
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            return response()->json(['message' => 'These credentials do not match an active administrator account.'], 403);
        }

        if ($user->is_suspended) {
            return response()->json(['message' => 'This administrator account is suspended.'], 403);
        }

        Auth::guard('web')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $token = $user->createToken('admin-api')->plainTextToken;

        AuditLog::create([
            'admin_id' => $user->getKey(),
            'action' => 'login',
            'model_type' => 'User',
            'model_id' => $user->getKey(),
            'changes' => [
                'before' => null,
                'after' => ['role' => $user->roles()->pluck('name')->toArray()],
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Admin authenticated successfully.',
            'token' => $token,
            'user' => (new UserResource($user->load('roles')))->resolve($request),
        ], 200);
    }
}
