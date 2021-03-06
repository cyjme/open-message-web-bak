<?php
namespace Gap\Routing\RouteFilter;

use Gap\Exception\NotLoginException;
use Gap\Exception\NoPermissionException;

class PrivilegeFilter extends RouteFilterBase
{
    public function filter()
    {
        $config = $this->app->getConfig();
        $access = $this->route->getAccess();
        $privilege = $config->get("secure.privilege.$access");

        if (!$privilege) {
            return;
        }

        $serviceClass = $config->get('secure.fetchUserService');
        if (!class_exists($serviceClass)) {
            // todo
            throw new \Exception('secure.fetchUserService not-found: ' . $serviceClass);
        }

        $fetchUserService = new $serviceClass($this->app);

        $userId = $this->request->getUserId();
        if (!$userId) {
            throw new NotLoginException("access-$access-need-login");
        }
        $user = $fetchUserService->fetchOneByUserId($userId);
        if (!$user) {
            // todo
            throw new NotLoginException("userId[$userId]-not-found");
        }

        if ($user->getPrivilege() < $privilege) {
            // todo
            throw new NoPermissionException("access-$access");
        }
    }
}
