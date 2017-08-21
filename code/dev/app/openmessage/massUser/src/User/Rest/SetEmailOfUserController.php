<?php
namespace Openmessage\MassUser\User\Rest;

use Openmessage\MassUser\User\Service\SetEmailOfUserService;
use Openmessage\User\User\Dto\UserEmailDto;

class SetEmailOfUserController extends ControllerBase
{
    public function post()
    {
        $userId = $this->request->request->get('userId');
        $email = $this->request->request->get('email');
        $verifyCode = $this->request->request->get('verifyCode');

        $user = new UserEmailDto([
            'userId' => $userId,
            'email' => $email,
            'verifyCode' => $verifyCode
        ]);

        obj(new SetEmailOfUserService($this->app))
            ->setEmailOfUser($user);

        return $this->jsonResponse(['email' => $email ]);
    }
}
