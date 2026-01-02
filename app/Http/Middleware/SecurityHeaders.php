<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Add baseline security headers for all responses.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $headers = [
            'X-Frame-Options' => 'DENY',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'no-referrer',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
            'Cross-Origin-Opener-Policy' => 'same-origin',
            'Cross-Origin-Resource-Policy' => 'same-origin',
            'X-Permitted-Cross-Domain-Policies' => 'none',
            'Content-Security-Policy' => implode('; ', [
                "default-src 'self'",
                // allow local Vite (HTTP) during dev + HTTPS CDNs
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' http: https: 127.0.0.1:* localhost:*",
                "style-src 'self' 'unsafe-inline' http: https: fonts.googleapis.com 127.0.0.1:* localhost:*",
                "img-src 'self' data: https:",
                "font-src 'self' data: https: fonts.gstatic.com",
                "connect-src 'self' ws: wss: http: https: 127.0.0.1:* localhost:*",
                "frame-ancestors 'none'",
                "form-action 'self'",
                "base-uri 'self'",
                "object-src 'none'",
                "upgrade-insecure-requests"
            ]),
        ];

        // Only send HSTS in production over HTTPS (or when the proxy forwarded HTTPS).
        $isHttps = $request->isSecure()
            || strcasecmp((string) $request->header('X-Forwarded-Proto'), 'https') === 0;

        if (app()->environment('production') && $isHttps) {
            $headers['Strict-Transport-Security'] = 'max-age=63072000; includeSubDomains; preload';
        }

        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value, false);
        }

        return $response;
    }
}
