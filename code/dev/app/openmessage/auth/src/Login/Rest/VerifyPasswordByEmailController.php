<?php
namespace Openmessage\Auth\Login\Rest;

use Openmessage\Auth\Login\Service\VerifyPasswordByEmailService;

class VerifyPasswordByEmailController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;
        $password = $post->get('password');
        $email = $post->get('email');

        if (!$password || !$email) {
            return $this->jsonResponse([
                'status' => 'fail',
                'openmessage' => 'data empty'
            ]);
        }

        if (obj(new VerifyPasswordByEmailService($this->app))->verify($email, $password)) {
            return $this->jsonResponse(['status' => true]);
        }

        return $this->jsonResponse(['status' => false]);
    }
}
