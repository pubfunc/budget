<?php namespace App\Accounting\Statements;

use Brick\Money\Money;
use ArrayAccess;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Statement implements ArrayAccess
{

    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Get an attribute from the $attributes array.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = Arr::get($this->attributes, $key);
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set.
        if (method_exists($this, 'get' . Str::studly($key) . 'Attribute')) {
            $method = 'get' . Str::studly($key) . 'Attribute';
            return $this->{$method}($value);
        }
        return $value;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }


    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /**
     *
     * @param $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }
}