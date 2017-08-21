<?php
namespace Openmessage\MassUser\User\Rest;

use Openmessage\MassUser\User\Service\SetAvtOfUserService;
use Openmessage\User\User\Dto\UserDto;

class SetAvtOfUserController extends ControllerBase
{
    public function post()
    {
        $avt = $this->request->request->get('avt');

        $user = new UserDto([
            'userId' => $this->request->getUserId(),
            'avt' => $avt
        ]);

        obj(new SetAvtOfUserService($this->app))
            ->setAvtOfUser($user);

        return $this->jsonResponse(['status' => 'ok' ]);
    }
}
