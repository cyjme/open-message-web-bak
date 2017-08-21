<?php
namespace Openmessage\MassUser\User\Rest;

use Openmessage\MassUser\User\Service\SetNameOfUserService;
use Openmessage\User\User\Dto\UserDto;

class SetNameOfUserController extends ControllerBase
{
    public function post()
    {
        $userId = $this->request->request->get('userId');
        $nick = $this->request->request->get('nick');

        $user = new UserDto([
            'userId' => $userId,
            'nick' => $nick
        ]);
        
        $this->request->setUserName($nick);

        obj(new SetNameOfUserService($this->app))
            ->setNameOfUser($user);

        return $this->jsonResponse(['nick' => $nick ]);
    }
}
