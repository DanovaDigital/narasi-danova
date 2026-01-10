<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCacheHeaders
{
    /**
     * Handle an incoming request and set appropriate cache headers.
     */
    public function handle(Request $request, Closure $next, ?string $ttl = '300'): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            $response->headers->set('Cache-Control', "public, max-age={$ttl}");
            $response->headers->set('Vary', 'Accept-Encoding');
        }

        return $response;
    }
}
