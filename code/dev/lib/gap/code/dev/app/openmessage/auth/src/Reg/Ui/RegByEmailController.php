<?php
namespace Openmessage\Auth\Reg\Ui;

use Openmessage\Auth\Reg\Service\VerifyEmailService;
use Openmessage\Auth\User\Dto\UserDto;
use Gap\Exception\ClientException;
use Gap\Security\PasshashProvider;
use Openmessage\Auth\Reg\Service\RegByEmailService;

class RegByEmailController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/reg/regByEmail');
    }

    public function post()
    {
        $email = $this->request->request->get('email');
        $code = $this->request->request->get('code');
        $type = $this->request->request->get('type');

        if (!obj(new VerifyEmailService($this->app))->verify($email, $code)) {
            return $this->response('verify code is not valid');
        }

        try {
            $password = $this->request->request->get('password');

            $passhashProvider = new PasshashProvider();

            $user = new UserDto([
                'type' => $type,
                'passhash' => $passhashProvider->hash($password),
                'verifyCode' => $passhashProvider->randCode()
            ]);

            obj(new RegByEmailService($this->app))->create($user, $email);
        } catch (ClientException $exception) {
            // todo
            return $this->response($exception->getKey() . ': ' . $exception->getMessage());
        }

        return $this->gotoRoute('login');
    }

    public function success()
    {
        return $this->response('reg email success');
    }
}
