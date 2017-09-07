<?php
namespace Gap\Config;

use Gap\Tool\Code\IncludeTrait;

class Config implements \ArrayAccess
{
    use IncludeTrait;

    protected $items = [];

    public function __construct($items = [])
    {
        if ($items) {
            $this->load($items);
        }
    }

    public function load($items)
    {
        $this->items = array_merge_recursive($this->items, $items);
    }

    public function has($key)
    {
        if (!isset($this->items[0]) || !$key) {
            return false;
        }

        $arr = $this->items;
        foreach (explode('.', $key) as $segment) {
            if (!$arr || !is_array($arr) || !array_key_exists($segment, $arr)) {
                return false;
            }
            $arr = $arr[$segment];
        }

        return true;
    }

    public function get($key, $default = '')
    {
        if (!$key) {
            return null;
        }

        $arr = $this->items;
        foreach (explode('.', $key) as $segment) {
            if (!$arr || !is_array($arr) || !array_key_exists($segment, $arr)) {
                return $this->value($default);
            }
            $arr = $arr[$segment];
        }

        return $this->value($arr);
    }

    public function getConfig($key)
    {
        return new Config($this->get($key, null));
    }

    public function set($key, $val = null)
    {
        if (is_array($key)) {
            foreach ($key as $subKey => $subVal) {
                $this->set($subKey, $subVal);
            }

            return $this;
        }

        if (is_string($key)) {
            if (is_array($val)) {
                foreach ($val as $subKey => $subVal) {
                    $this->set($key . '.' . $subKey, $subVal);
                }
                return $this;
            }

            $this->setItem($key, $val);
            return $this;
        }

        throw new \RuntimeException('config::set error format');
    }

    public function all()
    {
        return $this->items;
    }

    // implements ArrayAccess
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $val)
    {
        $this->set($offset, $val);
    }

    public function offsetUnset($offset)
    {
        $this->set($offset, null);
    }

    public function clear()
    {
        unset($this->items);
    }

    // protected
    protected function setItem($key, $val)
    {
        if (!$key) {
            return;
        }

        $arr = &$this->items;
        $keys = explode('.', $key);
        while (isset($keys[1])) {
            $segment = array_shift($keys);
            if (!isset($arr[$segment]) || !is_array($arr[$segment])) {
                $arr[$segment] = [];
            }
            $arr = &$arr[$segment];
        }
        $arr[array_shift($keys)] = $val;
    }

    protected function value($val)
    {
        return $val instanceof \Closure ? $val() : $val;
    }
}
