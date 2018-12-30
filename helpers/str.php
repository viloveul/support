<?php

if (!function_exists('str_contains')) {
    /**
     * @param $str
     * @param $needle
     * @param $sensitive
     */
    function str_contains($str, $needle, $sensitive = true)
    {
        return Stringy\Stringy::create($str)->contains($needle, $sensitive);
    }
}
