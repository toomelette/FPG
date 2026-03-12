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

if (!function_exists('nested_collection')) {
    function nested_collection($array)
    {
        return collect($array)->map(function ($item) {
            return is_array($item) ? collect($item) : $item;
        });
    }
}

if (!function_exists('null_if_zero')) {
    function null_if_zero($value)
    {
        if($value == null){
            return null;
        }
        if($value == 0){
            return null;
        }
        if($value == '0'){
            return null;
        }
        return $value;
    }
}