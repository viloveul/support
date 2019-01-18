<?php

namespace Viloveul\Support;

use ArrayIterator;
use BadMethodCallException;

trait AttrAwareTrait
{
    /**
     * @param  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param  $key
     * @return mixed
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * @param $key
     */
    public function __unset($key)
    {
        $this->delete($key);
    }

    /**
     * @param string $key
     */
    public function delete(string $key): void
    {
        throw new BadMethodCallException("Cannot delete using AttrAwareTrait, please overwrite this method.");
    }

    /**
     * @param  string     $key
     * @param  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return array_get($this->getAttributes(), $key, $default);
    }

    /**
     * @return mixed
     */
    abstract public function getAttributes(): array;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * @param string $key
     */
    public function has(string $key): bool
    {
        return array_has($this->getAttributes(), $key);
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param  $key
     * @return mixed
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * @param  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * @param $key
     */
    public function offsetUnset($key)
    {
        $this->delete($key);
    }

    /**
     * @param string       $key
     * @param $value
     * @param $overwrite
     */
    public function set(string $key, $value = null, $overwrite = true): void
    {
        if (!$this->has($key) || $overwrite === true) {
            $this->setAttributes([$key => $value]);
        }
    }

    /**
     * @param $attributes
     */
    abstract public function setAttributes($attributes): void;

    /**
     * @return mixed
     */
    public function toArray(): array
    {
        return $this->getAttributes();
    }

    /**
     * @param int $opt
     */
    public function toJson(int $opt = 0): string
    {
        return json_encode($this->toArray(), $opt);
    }
}
