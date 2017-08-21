<?php
namespace Openmessage\MassUser\User\Rest;

use Openmessage\MassUser\User\Service\SetAddrOfUserService;
use Openmessage\User\User\Dto\UserAddrDto;

class SetAddrOfUserController extends ControllerBase
{
    public function post()
    {
        $userAddrId = $this->request->request->get('userAddrId');
        $addr = $this->request->request->get('addr');

        $userAddr = new UserAddrDto([
            'userAddrId' => $userAddrId,
            'addr' => $addr
        ]);

        obj(new SetAddrOfUserService($this->app))
            ->setAddrOfUser($userAddr);

        return $this->jsonResponse(['addr' => $addr ]);
    }
}
