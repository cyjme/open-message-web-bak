<?php
namespace Openmessage\MassClient\Acc\Open;

use Openmessage\MassClient\App\Service\FetchAppService;
use Openmessage\MassClient\Acc\Service\CreateAccService;
use Openmessage\MassClient\Acc\Dto\AccDto;

class FetchTokenController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $key = $post->get('key');
        $secret = $post->get('secret');
        $userId = $post->get('userId');
        $props = $post->get('props');

        $app = obj(new FetchAppService($this->app))
            ->fetchByKey($key);

        if ($app === null) {
            throw new \Exception("cannot find app");
        }

        if ($secret === $app->getSecret()) {
            $acc = new AccDto([
                'appId' => $app->getAppId(),
                'userId' => $userId,
                'props' => $props
            ]);

            $acc = obj(new CreateAccService($this->app))
                ->create($acc);

            return $this->jsonResponse(['token'=>$acc->getToken()]);
        }
    }
}
