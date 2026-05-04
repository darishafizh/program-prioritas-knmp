<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Knmp;

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
            // Get the knmp parameter from the route (now a nama string)
            $knmpParam = $request->route('knmp');

            if ($knmpParam) {
                // Handle model binding (object), nama string, or numeric ID
                if (is_object($knmpParam)) {
                    $knmpId = $knmpParam->id;
                } elseif (is_numeric($knmpParam)) {
                    $knmpId = (int) $knmpParam;
                } else {
                    // Resolve nama to ID
                    $knmp = Knmp::where('nama', $knmpParam)->first();
                    $knmpId = $knmp ? $knmp->id : null;
                }

                // Check if the user is trying to access their own KNMP
                if (!$knmpId || (int) $knmpId !== (int) $user->knmp_id) {
                    abort(403, 'Anda tidak memiliki akses ke data desa ini.');
                }
            }
        }

        return $next($request);
    }
}
