<?php
namespace Openmessage\MassPush\Push\Open;

use Openmessage\MassPush\Push\Service\ListPushService;
use Openmessage\MassPush\Push\Service\CreatePushToQueueService;

class ListPushController extends ControllerBase
{
    public function list()
    {
        $post = $this->request->request;

        $key = $post->get('key');
        $secret = $post->get('secret');
        $props = $post->get('props');

        obj(new ListPushService($this->app))
            ->list($push);
        
        return $this->response('success');
    }
}
