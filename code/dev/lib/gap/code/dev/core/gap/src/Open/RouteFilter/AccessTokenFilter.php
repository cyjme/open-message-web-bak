<?php
namespace Gap\Open\RouteFilter;

use Gap\Routing\RouteFilter\RouteFilterBase;
use Gap\Open\Exception\OpenException;

class AccessTokenFilter extends RouteFilterBase
{
    public function filter()
    {
        if ('token' === $this->route->getAccess()) {
            $server = $this->app->getOpenServer();
            $request = $this->request;

            if (!$server->verifyResourceRequest($request)) {
                throw new OpenException('invalid access_token');
            }
        }
    }
}
