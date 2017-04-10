<?php

if (! function_exists('active_url')) {
    function active_url($pattern, $default = 'active')
    {
        $path = request()->decodedPath();
        if (@preg_match('#^' . $pattern . '\z#u', $path)) {
            return $default;
        }
    }
}