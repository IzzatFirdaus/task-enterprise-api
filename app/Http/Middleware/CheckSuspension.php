<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->is_suspended) {
            return $request->expectsJson() 
                ? response()->json(['message' => 'Your account has been suspended.'], 403)
                : redirect()->route('login')->withErrors(['email' => 'Your account has been suspended.']);
        }

        return $next($request);
    }
}
