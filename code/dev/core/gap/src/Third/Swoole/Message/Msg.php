<?php
namespace Gap\Third\Swoole\Message;

use Gap\App\App;
use Openmessage\MassClient\Acc\Dto\AccDto;
use Gap\Third\Swoole\App\MsgApp;
use Openmessage\Group\Group\Service\FetchGroupService;
use Openmessage\Msg\Msg\Dto\MsgDto;

class Msg extends MessageBase
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
        $this->push = new Push($app);
        $this->chat = new Chat($app);
    }

    public function handleMsg($msg, $fd)
    {
        $msg = json_decode($msg);

        switch ($msg->type) {
            case 'login':
                $this->acc->login($msg->token, $fd);
                break;
            case 'push':
                return $this->push->handleMsg($msg);
                break;
            case 'im':
                return $this->chat->handleMsg($msg);
                break;
            case 'imAction':
                return $this->chat->handleAction($msg);
                break;
            case 'pushAction':
                break;
            default:
                break;
        }
    }
}
