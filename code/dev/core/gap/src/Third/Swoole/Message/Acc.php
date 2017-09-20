<?php
namespace Gap\Third\Swoole\Message;

use Gap\App\App;
use Openmessage\MassClient\Acc\Dto\AccDto;
use Openmessage\MassClient\Acc\Service\FetchAccService;
use Gap\Third\Swoole\App\MsgApp;

class Acc extends MessageBase
{
    protected $cache;
    protected $db;

    public function __construct(MsgApp $app)
    {
        parent::__construct($app);
        $this->cache = $this->app->getCmg()->connect('msg');
        $this->db = $this->app->getDmg();
    }

    //用户登录，检查用户的 token 获取 accId, 把 AccId 和 fd 放入 cache
    public function login($accToken, $fd)
    {
        // $accId = $this->getAccIdByToken($token);
        // if ($accId === 0) {
        //     return 0;
        // }
        $fds = [];
        $fds[] = $fd;
        // $this->cache->hset($accToken, 'fd', $fd);
        $this->cache->hset($fd, 'accToken', $accToken);

        if($oldFds = $this->cache->hget($accToken, 'fds')){
            $newFds = json_decode($oldFds, true);
            $newFds[] = $fd;
            $this->cache->hset($accToken, 'fds', json_encode($newFds));

            return;
        }
        $this->cache->hset($accToken, 'fds', json_encode($fds));
    }

    public function logout($fd)
    {
        $accToken = $this->cache->hget($fd, 'accToken');
        $oldFds = $this->cache->hget($accToken, 'fds');
        $newFds = array_diff(json_decode($oldFds, true), [$fd]);
        $this->cache->hdel($fd, 'accToken');
        if (count($newFds)===0) {
            $this->cache->hdel($accToken, 'fds');

            return ;
        }
        $this->cache->hset($accToken, 'fds', json_encode($newFds));
    }

    protected function getAccIdByToken($token)
    {
        $acc = obj(new FetchAccService($this->app))
            ->fetchByToken($token);

        if ($acc == null) {
            return 0;
        }

        return $acc->getAccId();
    }
}
