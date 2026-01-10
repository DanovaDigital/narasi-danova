<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

class RequireAdminKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('news.admin_key');

        if ($expected === '') {
            throw new HttpException(500, 'ADMIN_KEY is not configured.');
        }

        $provided = (string) $request->header('X-Admin-Key', $request->query('admin_key', ''));

        if (! hash_equals($expected, $provided)) {
            throw new HttpException(403, 'Forbidden');
        }

        return $next($request);
    }
}
