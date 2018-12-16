<?php

if (!function_exists('dd')) {
    /**
     * @param $var
     */
    function dd($var = null)
    {
        return call_user_func_array('dump', func_get_args());
        exit(1);
    }
}
