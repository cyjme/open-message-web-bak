<?php
namespace Openmessage\Auth\Reg\Rest;

use Openmessage\Auth\Reg\Service\VerifyEmailService;

class CheckVerifyCodeByEmail extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $email = $post->get('email');
        $code = $post->get('code');

        if (obj(new VerifyEmailService($this->app))->verify($email, $code)) {
            return $this->jsonResponse(['status' => true]);
        } else {
            return $this->jsonResponse(['status' => false]);
        }
    }
}
