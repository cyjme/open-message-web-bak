<?php
namespace Openmessage\Auth\Login\Ui;

use Gap\Exception\ClientException;
use Openmessage\Auth\Login\Service\LoginByEmailService;
use Openmessage\Proofer\Proofer\Service\FetchProoferService;

class LoginByEmailController extends ControllerBase
{
    public function post()
    {
        $email = $this->request->get('account');
        $password = $this->request->get('password');

        if (!$email || !$password) {
            throw new ClientException('data empty');
        }

        try {
            $user = obj(new LoginByEmailService($this->app))
                ->login($email, $password);
        } catch (ClientException $exception) {
            return $this->response($exception->getKey() . ': ' . $exception->getMessage());
        }

        $this->request->setUserId($user->getUserId());
        $this->request->setUserName($user->getNick());

        return $this->gotoRoute('massHome');
    }
}
