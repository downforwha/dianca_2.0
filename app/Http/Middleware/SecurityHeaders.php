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

        // Clickjacking protection
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        // MIME sniffing protection
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        // HSTS (HTTPS only)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        // Referrer info
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        // Restrict browser features
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), interest-cohort=()');
        // Content Security Policy — allow Google Fonts, CDN, WhatsApp, Google Translate
        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; "
            . "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://translate.google.com https://translate.googleapis.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://translate.googleapis.com; "
            . "font-src 'self' https://fonts.gstatic.com; "
            . "img-src 'self' data: https://www.gstatic.com https://translate.google.com; "
            . "connect-src 'self'; "
            . "frame-src https://translate.google.com; "
            . "object-src 'none'; "
            . "base-uri 'self';"
        );

        return $response;
    }
}
