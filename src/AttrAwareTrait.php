<?php

namespace Viloveul\Support;

use ArrayIterator;
use InvalidArgumentException;

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
        if ($this->has($key)) {
            $this->attributes[$key] = null;
            unset($this->attributes[$key]);
        }
    }

    /**
     * @param  string     $key
     * @param  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $this->attributes[$key] : $default;
    }

    /**
     * @return mixed
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * @param string $key
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
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
            $this->attributes[$key] = $value;
        }
    }

    /**
     * @param $attributes
     */
    public function setAttributes($attributes): void
    {
        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $this->set($key, $value);
            }
        } elseif (is_object($attributes)) {
            $this->setAttributes(get_object_vars($attributes));
        } else {
            throw new InvalidArgumentException("Parameter must be object or array");
        }
    }

    /**
     * @return mixed
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * @param int $opt
     */
    public function toJson(int $opt = 0): string
    {
        return json_encode($this->toArray(), $opt);
    }
}
