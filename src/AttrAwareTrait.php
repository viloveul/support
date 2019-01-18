<?php

namespace Viloveul\Support;

use ArrayIterator;
use BadMethodCallException;
use Closure;
use ReflectionException;
use ReflectionObject;

trait AttrAwareTrait
{
    /**
     * @param  $key
     * @param  $params
     * @return mixed
     */
    public function __call($key, $params)
    {
        $switcher = substr($key, 0, 3);
        $value = isset($params[0]) ? $params[0] : null;
        $name = lcfirst(substr($key, 3));
        switch ($switcher) {
            case 'set':
                $this->set($name, $value);
                break;
            case 'get':
            default:
                return $this->get($name, $value);
                break;
        }
    }

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
        $this->forget($key);
    }

    /**
     * @param Closure $handler
     */
    public function all(Closure $handler = null): array
    {
        return is_null($handler) ? $this->getAttributes() : $handler($this->getAttributes());
    }

    /**
     * @return string
     */
    public function attrkey(): string
    {
        $hasProperty = false;
        try {
            $ref = new ReflectionObject($this);
            $hasProperty = $ref->hasProperty('attributes') !== false;
        } catch (ReflectionException $e) {
            throw $e;
        }
        if ($hasProperty === false) {
            throw new BadMethodCallException("Property 'attributes' does not exists.");
        }
        return 'attributes';
    }

    /**
     * @param $callback
     */
    public function filter(callable $callback)
    {
        return new static(array_filter($this->all(), $callback));
    }

    /**
     * @param string $key
     */
    public function forget(string $key): void
    {
        if ($this->has($key)) {
            unset($this->{$this->attrkey()}[$key]);
        }
    }

    /**
     * @param  string     $key
     * @param  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $this->{$this->attrkey()}[$key] : $default;
    }

    /**
     * @return mixed
     */
    public function getAttributes(): array
    {
        return $this->{$this->attrkey()};
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
        return array_key_exists($key, $this->{$this->attrkey()});
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param $callback
     */
    public function map(callable $callback)
    {
        return new static(array_map($callback, $this->all()));
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
        $this->forget($key);
    }

    /**
     * @param  $key
     * @return mixed
     */
    public function only($key): array
    {
        return array_only($this->all(), func_get_args());
    }

    /**
     * @param string       $key
     * @param $value
     * @param $overwrite
     */
    public function set(string $key, $value = null, $overwrite = true): void
    {
        if (!$this->has($key) || $overwrite === true) {
            $this->{$this->attrkey()}[$key] = $value;
        }
    }

    /**
     * @param $attributes
     */
    public function setAttributes($attributes): void
    {
        $items = item_to_array($attributes) ?: [];
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
    }

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
