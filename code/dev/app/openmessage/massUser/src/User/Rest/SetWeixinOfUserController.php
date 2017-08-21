<?php
namespace Openmessage\MassUser\User\Rest;

use Openmessage\MassUser\User\Service\SetWeixinOfUserService;
use Openmessage\User\User\Dto\UserDto;

class SetWeixinOfUserController extends ControllerBase
{
    public function post()
    {
        $userId = $this->request->request->get('userId');
        $weixin = $this->request->request->get('weixin');

        $user = new UserDto([
            'userId' => $userId,
            'weixin' => $weixin
        ]);

        obj(new SetWeixinOfUserService($this->app))
            ->setWeixinOfUser($user);

        return $this->jsonResponse(['weixin' => $weixin ]);
    }
}
