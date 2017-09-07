<?php
namespace Gap\Contract\Task;

abstract class Task
{
    protected $created;
    protected $name;
    protected $attrs = [];

    public function __construct($name, $attrs = [])
    {
        $this->name = $name;
        $this->attrs = $attrs;
        $this->created = microtime();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function loadAttrs($attrs)
    {
        $this->attrs = array_merge($this->arrts, $attrs);
    }

    public function getAllAttrs()
    {
        return $this->attrs;
    }

    public function getAttr($key)
    {
        return $this->attrs[$key] ?? null;
    }

    public function setAttr($key, $val)
    {
        $this->attrs[$key] = $val;
        return $this;
    }
}
