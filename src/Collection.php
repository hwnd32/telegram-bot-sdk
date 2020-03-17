<?php
/**
 * Created by @kondratev.v
 * Date: 16.03.2020 17:53
 */

namespace Telegram\Bot;

use ArrayAccess;

class Collection implements ArrayAccess {

    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection.
     *
     * @param mixed $items
     * @return void
     */
    public function __construct($items = []) {
        $this->items = $this->getArrayableItems($items);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all() {
        return $this->items;
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key) {
        return array_key_exists($key, $this->items);
    }

    public function intersect($items)
    {
        return new static(array_intersect($this->items, $this->getArrayableItems($items)));
    }
    
    public function keys()
    {
        return new static(array_keys($this->items));
    }

    /**
     * Determine if an item exists in the collection by key.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function has($key)
    {
        $keys = is_array($key) ? $key : func_get_args();

        foreach ($keys as $value) {
            if (! $this->offsetExists($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get and remove the last item from the collection.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Get the last item from the collection.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return mixed
     */
    public function last(callable $callback = null, $default = null) {
        return $this->_last($this->items, $callback, $default);
    }

    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param array $array
     * @param callable|null $callback
     * @param mixed $default
     * @return mixed
     */
    public function _last($array, callable $callback = null, $default = null) {
        if ($callback === null) {
            return empty($array) ? $default : end($array);
        }

        return $this->first(array_reverse($array, true), $callback, $default);
    }

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param iterable $array
     * @param callable|null $callback
     * @param mixed $default
     * @return mixed
     */
    public function first($array, callable $callback = null, $default = null) {
        if ($callback === null) {
            if (empty($array)) {
                return $default;
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }
        return $default;
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if ($key === null) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Results array of items from Collection or Arrayable.
     *
     * @param mixed $items
     * @return array
     */
    protected function getArrayableItems($items) {
        if (is_array($items)) {
            return $items;
        }
        return [$items];
    }

}