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
        $this->cache->hset($accToken, 'fd', $fd);
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
