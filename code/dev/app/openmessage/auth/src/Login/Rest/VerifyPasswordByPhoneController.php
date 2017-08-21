<?php
namespace Openmessage\Auth\Login\Rest;

use Openmessage\Auth\Login\Service\VerifyPasswordByPhoneService;

class VerifyPasswordByPhoneController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;
        $password = $post->get('password');
        $phone = $post->get('phone');

        if (!$password || !$phone) {
            return $this->jsonResponse([
                'status' => 'fail',
                'openmessage' => 'data empty'
            ]);
        }

        if (obj(new VerifyPasswordByPhoneService($this->app))->verify($phone, $password)) {
            return $this->jsonResponse(['status' => true]);
        }

        return $this->jsonResponse(['status' => false]);
    }
}
