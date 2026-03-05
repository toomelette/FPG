<?php

use Illuminate\Support\Str;

if (!function_exists('randString')) {
    /**
     * Generate a random string.
     *
     * @param int $length
     * @return string
     */
    function randString($length = 10)
    {
        return Str::random($length);
    }
}