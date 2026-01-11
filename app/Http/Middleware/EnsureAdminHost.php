<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminHost
{
    /**
     * Redirects admin routes to the configured admin host.
     *
     * This keeps admin reachable at e.g. https://admin.example.com/admin/*
     * while preventing access from the main domain when ADMIN_HOST is set.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminHost = config('app.admin_host');

        if (!$adminHost) {
            return $next($request);
        }

        if (strcasecmp($request->getHost(), $adminHost) === 0) {
            return $next($request);
        }

        $adminUrl = (string) config('app.admin_url');
        $requestUri = $request->getRequestUri();

        if ($adminUrl !== '') {
            return redirect()->to(rtrim($adminUrl, '/') . $requestUri);
        }

        $scheme = $request->isSecure() ? 'https' : 'http';

        return redirect()->to($scheme . '://' . $adminHost . $requestUri);
    }
}
