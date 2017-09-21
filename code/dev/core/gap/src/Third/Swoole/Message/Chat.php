<?php
namespace Gap\Third\Swoole\Message;

use Gap\App\App;
use Openmessage\MassClient\Acc\Dto\AccDto;
use Gap\Third\Swoole\App\MsgApp;
use Openmessage\Group\Group\Service\FetchGroupService;
use Openmessage\Msg\Msg\Service\CreateMsgService;
use Openmessage\Msg\Msg\Dto\MsgDto;
use Openmessage\OpenChat\Chat\Service\ListChatHistoryService;

class Chat extends MessageBase
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
            $msg->to = $acc->accToken;

            $this->storeMsg($msg);

            $fds = json_decode($this->cache->hget($acc->accToken, 'fds'), true);
        }
        $msg->fds = $fds;

        return $msg;
    }

    public function handleAction($msg)
    {
        $actionType = $msg->actionType;
        if ($actionType == 'listHistory') {
        }

        $chatHistory = obj(new ListChatHistoryService($this->app))
            ->list($msg->accToken, $msg->withAccToken, $msg->sinceId, $msg->num);
        
        $chatHistoryArr = [];

        foreach ($chatHistory->getItems() as $item) {
            $msgItem = new \stdClass();
            $msgItem->msgId = $item->getMsgId();
            $msgItem->type = $item->getType();
            $msgItem->content = $item->getContent();
            $msgItem->contentType = $item->getContentType();
            $msgItem->from = $item->getFrom();
            $msgItem->to = $item->getTo();
            $msgItem->created = $item->getCreated();

            $chatHistoryArr[] = $msgItem;
        }

        $fds = json_decode($this->cache->hget($msg->accToken, 'fds'), true);

        $msg->fds = $fds;
        $msg->data = json_encode($chatHistoryArr);

        return $msg;
    }

    protected function getAccTokens($msg)
    {
        $accTokens = [];

        if ($msg->toAccToken) {
            $accTokens[] = (object)(['accToken'=>$msg->toAccToken]);
        }

        return $accTokens;
    }

    protected function storeMsg($msg)
    {
        $storeMsg = new MsgDto([
            "to" => $msg->to,
            "type" => 'im',
            "from" => $msg->fromAccToken,
            "content" => $msg->content,
            "contentType" => $msg->contentType,
        ]);
        obj(new CreateMsgService($this->app))
            ->create($storeMsg);
    }
}
