<?php
namespace Openmessage\MassUser\User\Ui;

use Openmessage\MassUser\User\Service\SetNameOfUserService;
use Openmessage\MassUser\User\Service\SetWeixinOfUserService;
use Openmessage\User\User\Dto\UserDto;
use Openmessage\User\User\Service\FetchUserService;

class SetNameAndWxForUserController extends ControllerBase
{
    public function show()
    {
        $user = obj(new FetchUserService($this->app))->fetchOneByUserId($this->request->getUserId());

        return $this->view('page/user/setNameAndWxForUser', compact('user'));
    }

    public function post()
    {
        $post = $this->request->request;

        $user = new UserDto([
            'userId' => $this->request->getUserId(),
            'nick' => $post->get('nick'),
            'weixin' => $post->get('weixin')
        ]);
        $this->request->setUserName($post->get('nick'));

        obj(new SetNameOfUserService($this->app))->setNameOfUser($user);
        obj(new SetWeixinOfUserService($this->app))->setWeixinOfUser($user);

        return $this->gotoRoute('massHome');
    }
}
