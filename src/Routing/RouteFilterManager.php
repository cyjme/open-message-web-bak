<?php
namespace Gap\Routing;

use Gap\Http\Request;
use Gap\App\app;

class RouteFilterManager
{
    protected $filters = [];

    public function filter(App $app, Request $request, $route)
    {
        foreach ($this->filters as $filter) {
            $filter->setApp($app);
            $filter->setRequest($request);
            $filter->setRoute($route);
            if ($res = $filter->filter()) {
                return $res;
            }
        }
    }

    public function addFilters(array $filters = [])
    {
        $this->filters = array_merge($this->filters, $filters);
        return $this;
    }
}
