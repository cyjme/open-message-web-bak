<?php
namespace Openmessage\MassPush\Push\Service;

use Openmessage\MassPush\Push\Dto\PushDto;
use Redis;
use Gap\Cache\CacheManager;

class CreatePushToQueueService extends ServiceBase
{
    public function create($push)
    {
        $redis = $this->app->getCmg()->connect('push');
        $redis->lpush('push_list', json_encode($push));
        $redis->close();
    }
}
