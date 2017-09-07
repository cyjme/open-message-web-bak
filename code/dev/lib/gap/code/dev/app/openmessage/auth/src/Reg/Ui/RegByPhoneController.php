<?php
namespace Openmessage\Auth\Reg\Ui;

use Openmessage\Auth\Reg\Service\VerifyPhoneService;
use Openmessage\Auth\User\Dto\UserDto;
use Gap\Exception\ClientException;
use Gap\Security\PasshashProvider;
use Openmessage\Auth\Reg\Service\RegByPhoneService;

class RegByPhoneController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/reg/regByPhone');
    }

    public function post()
    {
        $phone = $this->request->request->get('phone');
        $code = $this->request->request->get('code');
        $type = $this->request->request->get('type');

        if (!obj(new VerifyPhoneService($this->app))->verify($phone, $code)) {
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

            obj(new RegByPhoneService($this->app))->create($user, $phone);
        } catch (ClientException $exception) {
            // todo
            return $this->response($exception->getKey() . ': ' . $exception->getMessage());
        }

        return $this->gotoRoute('login');
    }

    public function success()
    {
        return $this->response('reg phone success');
    }
}
