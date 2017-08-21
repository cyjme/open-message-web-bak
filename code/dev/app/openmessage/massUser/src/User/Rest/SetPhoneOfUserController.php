<?php
namespace Openmessage\MassUser\User\Rest;

use Openmessage\MassUser\User\Service\SetPhoneOfUserService;
use Openmessage\User\User\Dto\UserPhoneDto;

class SetPhoneOfUserController extends ControllerBase
{
    public function post()
    {
        $userId = $this->request->request->get('userId');
        $phone = $this->request->request->get('phone');
        $verifyCode = $this->request->request->get('verifyCode');

        $user = new UserPhoneDto([
            'userId' => $userId,
            'phone' => $phone,
            'verifyCode' => $verifyCode
        ]);

        obj(new SetPhoneOfUserService($this->app))
            ->setPhoneOfUser($user);

        return $this->jsonResponse(['phone' => $phone ]);
    }
}
