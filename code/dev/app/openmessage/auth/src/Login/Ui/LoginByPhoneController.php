<?php
namespace Openmessage\Auth\Login\Ui;

use Gap\Exception\ClientException;
use Openmessage\Auth\Login\Service\LoginByPhoneService;
use Openmessage\Proofer\Proofer\Service\FetchProoferService;

class LoginByPhoneController extends ControllerBase
{
    public function post()
    {
        $phone = $this->request->get('account');
        $password = $this->request->get('password');

        if (!$phone || !$password) {
            throw new ClientException('data empty');
        }

        try {
            $user = obj(new LoginByPhoneService($this->app))
                ->login($phone, $password);
        } catch (ClientException $exception) {
            return $this->response($exception->getKey() . ': ' . $exception->getMessage());
        }

        $this->request->setUserId($user->getUserId());
        $this->request->setUserName($user->getNick());

        return $this->gotoRoute('massHome');
    }
}
