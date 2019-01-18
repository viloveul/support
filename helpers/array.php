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

if (!function_exists('item_to_array')) {
    /**
     * @param  $attr
     * @return mixed
     */
    function item_to_array($attr): array
    {
        if (is_array($attr)) {
            return $attr;
        } elseif (is_object($attr) && method_exists($attr, 'getAttributes')) {
            return $attr->getAttributes();
        } elseif (is_object($attr) && method_exists($attr, 'toArray')) {
            return $attr->toArray();
        } elseif (is_object($attr) && method_exists($attr, 'toJson')) {
            return json_decode($attr->toJson(), true);
        } elseif (is_object($attr) && method_exists($attr, 'all')) {
            return $attr->all();
        } elseif ($attr instanceof JsonSerializable) {
            return $attr->jsonSerialize();
        } elseif ($attr instanceof Traversable) {
            return iterator_to_array($attr);
        } elseif (is_object($attr)) {
            return get_object_vars($attr);
        } else {
            if (is_scalar($attr)) {
                $decoded = json_decode($attr, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $decoded;
                }
            }
            throw new InvalidArgumentException("Parameter cannot converted to array.");
        }
    }
}
