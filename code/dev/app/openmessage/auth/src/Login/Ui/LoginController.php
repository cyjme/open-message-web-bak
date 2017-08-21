<?php
namespace Openmessage\Auth\Login\Ui;

use Gap\Exception\ClientException;
use Openmessage\Auth\Login\Service\LoginByEmailService;
use Openmessage\Auth\Login\Service\LoginByPhoneService;

class LoginController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/login/login');
    }

    public function post()
    {
        $account = $this->request->get('account');
        $password = $this->request->get('password');

        if (!$account || !$password) {
            throw new ClientException('data empty');
        }

        
        try {
            if (filter_var($account, FILTER_VALIDATE_EMAIL)) {
                $user = obj(new LoginByEmailService($this->app))
                    ->login($account, $password);
            }

            if (preg_match('~^(\d{11})$~u', $account)) {
                $user = obj(new LoginByPhoneService($this->app))
                    ->login($account, $password);
            }
        } catch (ClientException $exception) {
            return $this->response($exception->getKey() . ': ' . $exception->getMessage());
        }

        $this->request->setUserId($user->getUserId());
        return $this->gotoRoute('massHome');
    }
}
