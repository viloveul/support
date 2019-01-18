<?php

if (!function_exists('is_invokable')) {
    /**
     * @param object $object
     */
    function is_invokable(object $object)
    {
        return ($object instanceof Closure) or method_exists($object, '__invoke');
    }
}

if (!function_exists('is_instantiable')) {
    /**
     * @param  $class
     * @return mixed
     */
    function is_instantiable($class)
    {
        try {
            $ref = new ReflectionClass($class);
            return $ref->isInstantiable();
        } catch (ReflectionException $e) {
            return false;
        }
    }
}

if (!function_exists('is_implements_of')) {
    /**
     * @param  $class
     * @param  $interface
     * @return mixed
     */
    function is_implements_of($class, $interface)
    {
        try {
            $ref = new ReflectionClass($class);
            return $ref->implementsInterface($interface);
        } catch (ReflectionException $e) {
            return false;
        }
    }
}
