<?php

use App\Services\HashIdService;

if (!function_exists('hashid')) {
    /**
     * Encode an integer ID into a hash string.
     *
     * @param int|null $id
     * @return string|null
     */
    function hashid($id)
    {
        if (!$id) {
            return $id;
        }
        $service = app(HashIdService::class);
        return $service->encode($id);
    }
}

if (!function_exists('hashdecode')) {
    /**
     * Decode a hash string into an integer ID.
     *
     * @param string|null $hash
     * @return int|null
     */
    function hashdecode($hash)
    {
        if (!$hash) {
            return $hash;
        }
        $service = app(HashIdService::class);
        return $service->decode($hash);
    }
}
