<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\HashIdService;
use Symfony\Component\HttpFoundation\Response;

class DecodeHashIds
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hashService = app(HashIdService::class);

        // Define which route parameters should be decoded
        $parametersToDecode = ['id', 'knmp', 'responden', 'keterangan_enumerator'];

        foreach ($parametersToDecode as $param) {
            $value = $request->route($param);
            
            if ($value) {
                // Ignore if it's already an integer (for backwards compatibility during transition or internal API routes)
                if (!is_numeric($value)) {
                    $decoded = $hashService->decode($value);
                    
                    if ($decoded) {
                        // Override the route parameter with the decoded integer
                        $request->route()->setParameter($param, $decoded);
                    } else {
                        // If it's not numeric and can't be decoded, it's an invalid hash
                        abort(404, 'Data tidak ditemukan.');
                    }
                }
            }
        }

        // Define which request inputs should be decoded
        $inputsToDecode = ['knmp_id', 'responden_id', 'responden'];
        foreach ($inputsToDecode as $input) {
            if ($request->has($input)) {
                $value = $request->input($input);
                if ($value && !is_numeric($value)) {
                    $decoded = $hashService->decode($value);
                    if ($decoded) {
                        $request->merge([$input => $decoded]);
                    }
                }
            }
        }

        // Handle array of IDs like responden_ids and file_ids
        $arrayInputsToDecode = ['responden_ids', 'file_ids'];
        foreach ($arrayInputsToDecode as $arrayInput) {
            if ($request->has($arrayInput) && is_array($request->input($arrayInput))) {
                $decodedIds = [];
                foreach ($request->input($arrayInput) as $val) {
                    if ($val && !is_numeric($val)) {
                        $decoded = $hashService->decode($val);
                        if ($decoded) {
                            $decodedIds[] = $decoded;
                        }
                    } else {
                        $decodedIds[] = $val;
                    }
                }
                $request->merge([$arrayInput => $decodedIds]);
            }
        }

        return $next($request);
    }
}
