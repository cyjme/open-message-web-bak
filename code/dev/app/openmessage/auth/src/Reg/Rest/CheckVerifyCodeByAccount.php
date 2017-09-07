<?php
namespace Openmessage\Auth\Reg\Rest;

use Openmessage\Auth\Reg\Service\VerifyEmailService;
use Openmessage\Auth\Reg\Service\VerifyPhoneService;

class CheckVerifyCodeByAccount extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $account = $post->get('account');
        $code = $post->get('code');

        if (filter_var($account, FILTER_VALIDATE_EMAIL)) {
            if (obj(new VerifyPhoneService($this->app))->verify($account, $code)) {
                return $this->jsonResponse(['status' => true]);
            } else {
                return $this->jsonResponse(['status' => false]);
            }
        }

        if (preg_match('~^(\d{11})$~u', $account)) {
            if (obj(new VerifyEmailService($this->app))->verify($account, $code)) {
                return $this->jsonResponse(['status' => true]);
            } else {
                return $this->jsonResponse(['status' => false]);
            }
        }
    }
}
