<?php
namespace Openmessage\MassClient\App\Ui;

use Openmessage\MassClient\App\Dto\AppDto;
use Openmessage\MassClient\App\Service\CreateAppService;

class CreateAppController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/app/createApp');
    }

    public function post()
    {
        $post = $this->request->request;

        $app = new AppDto([
            'appId'=>$post->get('appId'),
            'name'=>$post->get('name'),
            'desc'=>$post->get('desc'),
            'createdUser'=>$this->request->getUserId(),
            'status'=> 0,
        ]);

        $app->setKey(uniqid());
        $app->setSecret(uniqid());
        $app->setAppCode(uniqid());

        obj(new CreateAppService($this->app))
            ->create($app);
        
        return $this->gotoRoute('listApp');
    }
}
