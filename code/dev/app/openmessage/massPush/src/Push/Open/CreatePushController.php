<?php
namespace Openmessage\MassPush\Push\Open;

use Openmessage\MassPush\Push\Dto\PushDto;
use Openmessage\MassPush\Push\Service\CreatePushService;
use Openmessage\MassPush\Push\Service\CreatePushToQueueService;
use Openmessage\MassClient\App\Service\FetchAppService;
use Openmessage\Group\Group\Service\FetchGroupService;

use Gap\Third\Swoole\WebSocket\WebSocket;

class CreatePushController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $key = $post->get('key');
        $secret = $post->get('secret');
        $props = $post->get('props');

        $app = $this->checkApp($key, $secret);

        $pushArr = [
            'appId'=>$app->getAppId(),
            'title'=>$post->get('title'),
            'content'=>$post->get('content'),
            'toAccId'=>$post->get('toAccId'),
            'toGroupId'=>$post->get('toGroupId'),
            'created' => micro_date()
        ];

        if ($toGroupName = $post->get('toGroupName')) {
            $group = obj(new FetchGroupService($this->app))
                        ->fetchGroupByNameAndAppId($toGroupName, $app->getAppId());
            $pushArr['toGroupId'] = $group->getGroupId();
        }

        if ($toAccToken = $post->get('toAccToken')) {
            $acc = obj(new FetchAccService($this->app))
                    ->fetchByToken($token);
            
            $pushArr['toAccId'] = $acc->getAccId();
        }

        $push = new PushDto($pushArr);

        obj(new CreatePushService($this->app))
            ->create($push);
        
        $this->createPushToSocket($pushArr);

        return $this->response('success');
    }

    protected function checkApp($key, $secret)
    {
        $app = obj(new FetchAppService($this->app))
            ->fetchByKey($key);

        if ($app === null) {
            throw new \Exception("cannot find app");
        }

        if ($secret !== $app->getSecret()) {
            throw new \Exception("key secret not match");
        }

        return $app;
    }

    protected function createPushToSocket($msg)
    {
        // 不再使用 redis list ，直接把数据通过 websocket_client 发送到 server
        // obj(new CreatePushToQueueService($this->app))
        //     ->create($pushArr);

        $msg['type'] = "push";
        $client = new WebSocket('192.168.99.100', '9503');
        $client->connect();

        $client->send(json_encode($msg));
        $data = $client->recv();

        if (!$data) {
            throw new \Exception("create push error");
            die("recv failed.");
        }

        $client->disconnect();

        return $this->jsonResponse();
    }
}
