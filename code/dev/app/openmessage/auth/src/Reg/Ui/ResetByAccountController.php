<?php
namespace Openmessage\Auth\Reg\Ui;

use Gap\Exception\ClientException;
use Gap\Security\PasshashProvider;
use Openmessage\Auth\Reg\Service\ResetByAccountService;
use Openmessage\Auth\Reg\Service\VerifyEmailService;
use Openmessage\Auth\Reg\Service\VerifyPhoneService;
use Openmessage\Auth\User\Service\FetchUserByAccountService;

class ResetByAccountController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/reset/resetByAccount');
    }

    public function post()
    {
        $account = $this->request->get('account');
        $code = $this->request->get('code');
        $password = $this->request->get('password');
        $passwordConfirm = $this->request->get('password_confirm');

        if (!$account || !$code || !$password || !$passwordConfirm) {
            throw new ClientException('data empty');
        }


        if ($password != $passwordConfirm) {
            throw new ClientException('password and password_confirm not same');
        }


        $phoneCodeIsValid = obj(new VerifyPhoneService($this->app))->verify($account, $code);
        $emailCodeIsValid = obj(new VerifyEmailService($this->app))->verify($account, $code);

        if (!$phoneCodeIsValid && !$emailCodeIsValid) {
            throw new ClientException('code not valid');
        }

        $user = obj(new FetchUserByAccountService($this->app))->fetchOneByAccount($account);

        $passhashProvider = new PasshashProvider();
        $passhash = $passhashProvider->hash($password);
        $user->setPasshash($passhash);

        obj(new ResetByAccountService($this->app))->resetByAccount($user);

        return $this->gotoRoute('login');
    }
}
