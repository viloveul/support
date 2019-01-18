<?php

if (!function_exists('str_contains')) {
    /**
     * @param string $str
     * @param mixed  $needles
     * @param bool   $sensitive
     */
    function str_contains(string $str, $needles, bool $sensitive = true): bool
    {
        $posHandler = $sensitive === true ? 'mb_strpos' : 'mb_stripos';
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && $posHandler($str, $needle) !== false) {
                return true;
            }
        }
        return false;
    }
}
