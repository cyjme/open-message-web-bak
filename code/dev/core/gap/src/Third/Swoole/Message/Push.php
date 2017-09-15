<?php
namespace Gap\Third\Swoole\Message;

use Gap\App\App;
use Openmessage\MassClient\Acc\Dto\AccDto;
use Gap\Third\Swoole\App\MsgApp;
use Openmessage\Group\Group\Service\FetchGroupService;
use Openmessage\Msg\Msg\Service\CreateMsgService;
use Openmessage\Msg\Msg\Dto\MsgDto;

class Push extends MessageBase
{
    protected $cache;
    protected $db;
    protected $acc;

    public function __construct(MsgApp $app)
    {
        parent::__construct($app);
        $this->cache = $this->app->getCmg()->connect('msg');
        $this->db = $this->app->getDmg();
        $this->acc = new Acc($app);
    }

    public function handleMsg($msg)
    {
        $accs = $this->getAccTokens($msg);
        $fds = [];

        foreach ($accs as $acc) {
            $msg->to = $acc->accId;

            $this->storeMsg($msg);

            $fd = $this->cache->hget($acc->accId, 'fd');
            if ($fd !== false) {
                $fds[] = $fd;
            }
        }
        $msg->fds = $fds;

        return $msg;
    }

    protected function getAccTokens($msg)
    {
        $accTokens = [];
        $appId = $msg->appId;

        if ($msg->toGroupId === 'all') {
            $accTokens[] = obj(new FetchGroupService($this->app))
                ->getAllAccTokensByAppId($appId);
        }

        if ($msg->toGroupId) {
            $accTokens[] = obj(new FetchGroupService($this->app))
                ->getAccTokensByGroupId($groupId);
        }

        if ($msg->toAccToken) {
            $accTokens[] = (object)(['accToken'=>$msg->toAccToken]);
        }

        return $accTokens;
    }

    protected function storeMsg($msg)
    {
        $storeMsg = new MsgDto([
            "to" => $msg->to,
            "type" => 'push',
            "from" => 'push',
            "title" => $msg->title,
            "content" => $msg->content,
        ]);
        obj(new CreateMsgService($this->app))
            ->create($storeMsg);
    }
}
