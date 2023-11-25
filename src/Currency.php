<?php

namespace Jeffgreco13\Wave;

use Exception;
use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Currency implements ArrayAccess, Arrayable
{
    protected array $attributes = [];

    public function __construct(?array $attributes = null)
    {
        $this->attributes = $attributes;
    }

    protected static function fetch()
    {
        if (!file_exists(storage_path('wave_currencies.json'))) {
            throw new Exception('Currencies file missing. Download using php artisan wave:pull-currencies');
        }
        return collect(Cache::rememberForever('currencies', function () {
            return json_decode(file_get_contents(storage_path('wave_currencies.json')), true);
        }));
    }

    public static function all()
    {
        return static::fetch()->map(function($item){
            return new self($item);
        });
    }

    public static function firstWhere(string $key,string $value)
    {
        $first = static::fetch()->first(function($item) use ($key,$value){
            return $item[$key] == $value;
        });
        return $first ? new self($first) : null;
    }

    /**
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->getAttribute($key);
        }

        throw new Exception('Property ' . $key . ' does not exist on ' . get_called_class());
    }

    /**
     * @param  string  $key
     */
    public function __isset($key): bool
    {
        return array_key_exists($key, $this->attributes);
    }
    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return $this
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        return $this->setAttribute($offset, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Get an attribute.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function getAttribute($key)
    {
        return $this->attributes[$key];
    }

    /**
     * Set an attribute.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function toArray()
    {
        return $this->attributes;
    }

}
