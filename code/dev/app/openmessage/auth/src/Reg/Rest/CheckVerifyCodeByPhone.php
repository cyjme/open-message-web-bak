<?php
namespace Openmessage\Auth\Reg\Rest;

use Openmessage\Auth\Reg\Service\VerifyPhoneService;

class CheckVerifyCodeByPhone extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $phone = $post->get('phone');
        $code = $post->get('code');

        if (obj(new VerifyPhoneService($this->app))->verify($phone, $code)) {
            return $this->jsonResponse(['status' => true]);
        } else {
            return $this->jsonResponse(['status' => false]);
        }
    }
}
