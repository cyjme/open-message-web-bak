<?php
namespace Gap\Routing\RouteFilter;

class AclFilter extends RouteFilterBase
{
    public function filter()
    {
        if ('acl' !== $this->route->getAccess()) {
            return;
        }

        // todo acl
    }
}
