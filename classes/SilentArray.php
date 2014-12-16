<?php

/**
 * Simple Wrapper for array.
 *
 * Can be used to access invalid keys without throwing a PHP notice.
 *
 * @author  Christian Blos <christian.blos@gmx.de>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link    https://github.com/christianblos
 */
class SilentArray implements \Iterator, \Countable, \ArrayAccess
{

    /**
     * @var array
     */
    protected $list = [];

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        if ($value instanceof self) {
            $this->list = $value->list;
        } elseif ($value instanceof \Traversable) {
            $this->list = [];
            foreach ($value as $k => $v) {
                $this->list[$k] = $v;
            }
        } elseif ($value === null) {
            $this->list = [];
        } else {
            $this->list = (array)$value;
        }
    }

    /**
     * Returns the current element.
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->list);
    }

    /**
     * Returns the key of the current element.
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->list);
    }

    /**
     * Moves the current position to the next element.
     *
     * @return mixed
     */
    public function next()
    {
        return next($this->list);
    }

    /**
     * Rewinds back to the first element of the Iterator.
     *
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->list);
    }

    /**
     * Check if the current position is valid.
     *
     * @return bool
     */
    public function valid()
    {
        return key($this->list) !== null;
    }

    /**
     * Count elements.
     *
     * @return int
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * Check if offset exists.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->list[$offset]);
    }

    /**
     * Unsets an offset.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->list[$offset]);
    }

    /**
     * Assigns a value to the specified offset.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->list[] = $value;
        } else {
            $this->list[$offset] = $value;
        }
    }

    /**
     * Returns the value at specified offset.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (isset($this->list[$offset])) {
            return $this->list[$offset];
        } else {
            return null;
        }
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->list;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->list);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return array_values($this->list);
    }
}
