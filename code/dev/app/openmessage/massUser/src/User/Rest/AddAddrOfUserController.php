<?php
namespace Openmessage\MassUser\User\Rest;

use Openmessage\MassUser\User\Service\AddAddrOfUserService;
use Openmessage\User\User\Dto\UserAddrDto;

class AddAddrOfUserController extends ControllerBase
{
    public function post()
    {
        $userId = $this->request->request->get('userId');
        $addr = $this->request->request->get('addr');

        $userAddr = new UserAddrDto([
            'userId' => $userId,
            'addr' => $addr
        ]);

        obj(new AddAddrOfUserService($this->app))
            ->add($userAddr);

        return $this->jsonResponse(['status' => 'ok' ]);
    }
}
