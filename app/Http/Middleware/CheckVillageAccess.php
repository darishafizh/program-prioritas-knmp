<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVillageAccess
{
    /**
     * Handle an incoming request.
     * Restricts village users to only access their assigned KNMP.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If not authenticated, let auth middleware handle it
        if (!$user) {
            return $next($request);
        }

        // Admins and Super Admins can access everything
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return $next($request);
        }

        // If user is a village user (has knmp_id assigned)
        if ($user->isVillageUser()) {
            // Get the knmp parameter from the route
            $knmpParam = $request->route('knmp');

            if ($knmpParam) {
                // Handle both model binding and ID cases
                $knmpId = is_object($knmpParam) ? $knmpParam->id : $knmpParam;

                // Check if the user is trying to access their own KNMP
                if ((int) $knmpId !== (int) $user->knmp_id) {
                    abort(403, 'Anda tidak memiliki akses ke data desa ini.');
                }
            }
        }

        return $next($request);
    }
}
