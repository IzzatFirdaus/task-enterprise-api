<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $response instanceof Response) {
            return $response;
        }

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        if (! app()->environment('local', 'testing')) {
            $this->setContentSecurityPolicy($response, $request);
        }

        return $response;
    }

    protected function setContentSecurityPolicy(Response $response, Request $request): void
    {
        $self = "'self'";
        $nonce = defined('LARAVEL_START') ? base64_encode(hash('sha256', config('app.key', ''), true)) : null;

        $cspParts = [
            "default-src $self",
            "script-src $self".($nonce ? " 'nonce-$nonce'" : ''),
            "style-src $self 'unsafe-inline'",
            "img-src $self data:",
            "font-src $self",
            "connect-src $self",
            "frame-ancestors 'none'",
            "form-action $self",
            "base-uri $self",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $cspParts));
    }
}
