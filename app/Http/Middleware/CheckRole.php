<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // If no roles specified, allow access
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has any of the required roles
        if ($request->user()->hasAnyRole($roles)) {
            return $next($request);
        }

        // User doesn't have required role
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
