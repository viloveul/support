<?php

if (!function_exists('array_get')) {
    /**
     * @param  array      $array
     * @param  $key
     * @param  $default
     * @return mixed
     */
    function array_get(array $array, $key, $default = null)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        } elseif (false !== strpos($key, '.')) {
            $parts = explode('.', $key);
            $options = $array;

            while ($k = array_shift($parts)) {
                if (is_array($options) && array_key_exists($k, $options)) {
                    $options = $options[$k];
                } else {
                    return $default;
                }
            }

            return $options;

        } else {
            return $default;
        }
    }
}

if (!function_exists('array_has')) {
    /**
     * @param  array   $array
     * @param  $key
     * @return mixed
     */
    function array_has(array $array, $key)
    {
        if (array_key_exists($key, $array)) {
            return true;
        } elseif (false !== strpos($key, '.')) {
            $parts = explode('.', $key);
            $options = $array;

            while ($k = array_shift($parts)) {
                if (is_array($options) && array_key_exists($k, $options)) {
                    $options = $options[$k];
                } else {
                    return false;
                }
            }

            return true;

        } else {
            return false;
        }
    }
}

if (!function_exists('array_only')) {
    /**
     * @param array   $array
     * @param $keys
     */
    function array_only(array $array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }
}
