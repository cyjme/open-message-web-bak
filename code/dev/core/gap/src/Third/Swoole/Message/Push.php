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
        $accs = $this->getAccIds($msg);
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

    protected function getAccIds($msg)
    {
        $accIds = [];
        $appId = $msg->appId;

        if ($msg->toGroupId === 'all') {
            $accIds[] = obj(new FetchGroupService($this->app))
                ->getAllAccIdsByAppId($appId);
        }

        if ($msg->toGroupId) {
            $accIds[] = obj(new FetchGroupService($this->app))
                ->getAccIdsByGroupId($groupId);
        }

        if ($msg->toAccId) {
            $accIds[] = object(['accId'=>$msg->toAccId]);
        }

        return $accIds;
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
