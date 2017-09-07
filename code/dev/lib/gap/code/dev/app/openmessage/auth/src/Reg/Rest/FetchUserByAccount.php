<?php
namespace Openmessage\Auth\Reg\Rest;

use Openmessage\Auth\User\Service\FetchUserByAccountService;

class FetchUserByAccount extends ControllerBase
{
    public function post()
    {
        $account = $this->request->get('account');
        $user = obj(new FetchUserByAccountService($this->app))->fetchOneByAccount($account);
        if ($user) {
            return $this->jsonResponse(['existed' => true]);
        }

        return $this->jsonResponse(['existed' => false]);
    }
}
