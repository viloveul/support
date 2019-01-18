<?php

if (!function_exists('isInvokable')) {
    /**
     * @param $object
     */
    function isInvokable($object)
    {
        if (is_object($object)) {
            return ($object instanceof Closure) or method_exists($object, '__invoke');
        }
        return is_callable($object);
    }
}

if (!function_exists('isInstantiable')) {
    /**
     * @param  $class
     * @return mixed
     */
    function isInstantiable($class)
    {
        $ref = new ReflectionClass($class);
        return $ref->isInstantiable();
    }
}

if (!function_exists('isImplementsOf')) {
    /**
     * @param  $class
     * @param  $interface
     * @return mixed
     */
    function isImplementsOf($class, $interface)
    {
        $ref = new ReflectionClass($class);
        return $ref->implementsInterface($interface);
    }
}
