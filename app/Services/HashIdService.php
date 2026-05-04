<?php

namespace App\Services;

use Hashids\Hashids;

class HashIdService
{
    protected $hashids;

    public function __construct()
    {
        // Use APP_KEY as salt, but remove the base64: prefix if it exists to make it a clean string
        $salt = str_replace('base64:', '', config('app.key', 'default-salt'));
        
        // Initialize Hashids with salt, minimum length of 8, and an alphabet that avoids visually similar characters
        $this->hashids = new Hashids($salt, 8, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    }

    /**
     * Encode an integer ID into a hash string.
     *
     * @param int $id
     * @return string
     */
    public function encode($id)
    {
        if (!$id) {
            return null;
        }
        return $this->hashids->encode($id);
    }

    /**
     * Decode a hash string back into an integer ID.
     *
     * @param string $hash
     * @return int|null
     */
    public function decode($hash)
    {
        if (!$hash) {
            return null;
        }
        $decoded = $this->hashids->decode($hash);
        
        // decode returns an array, we just need the first element
        return count($decoded) > 0 ? $decoded[0] : null;
    }
}
