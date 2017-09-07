<?php
namespace Gap\Routing;

class Route
{
    protected $status;
    protected $name;
    protected $action;
    protected $site;
    protected $app;
    protected $mode;
    protected $access;
    protected $params;
    protected $pattern;
    protected $method;

    public static function __set_state($data)
    {
        return new Route($data);
    }

    public function __construct($data)
    {
        if (!isset($data['name'])) {
            throw new \Exception('route name could not be empty');
        }
        if (!isset($data['site'])) {
            throw new \Exception('route site could not be empty');
        }

        $this->method = $data['method'];
        $this->status = $data['status'] ?? 0;
        $this->name = $data['name'];
        $this->action = $data['action'];
        $this->site = $data['site'];
        $this->app = $data['app'];
        $this->mode = $data['mode'] ?? 'ui';
        $this->access = $data['access'];
        $this->params = $data['params'] ?? [];
        $this->pattern = $data['pattern'];
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function getApp()
    {
        return $this->app;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }
}
