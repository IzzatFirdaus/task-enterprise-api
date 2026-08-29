<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function create(): View
    {
        return view('auth.admin-login');
    }

    /**
     * Authenticate a user against the admin role gate.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        /** @var User|null $user */
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, $credentials) || ! $user->canModerate()) {
            AuditLog::create([
                'admin_id' => $user?->getKey(),
                'action' => 'login_failed',
                'model_type' => 'AdminLogin',
                'model_id' => $user?->getKey(),
                'changes' => [
                    'before' => null,
                    'after' => [
                        'email' => $request->input('email'),
                        'route' => $request->path(),
                    ],
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            return back()->withErrors([
                'email' => 'These credentials do not match an active administrator account.',
            ]);
        }

        if ($user->is_suspended) {
            return back()->withErrors([
                'email' => 'This administrator account is suspended.',
            ]);
        }

        Auth::guard('web')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

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

        return redirect()->intended($user->isAdmin() ? route('admin.dashboard') : route('admin.tasks.index'));
    }
}
