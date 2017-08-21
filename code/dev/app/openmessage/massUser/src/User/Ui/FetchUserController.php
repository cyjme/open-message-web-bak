<?php
namespace Openmessage\MassUser\User\Ui;

use Openmessage\User\User\Service\FetchUserService;
use Openmessage\User\User\Service\FetchUserEmailService;
use Openmessage\User\User\Service\FetchUserPhoneService;
use Openmessage\Proofer\Proofer\Service\FetchProoferService;
use Openmessage\User\User\Service\ListAddrByUserService;

class FetchUserController extends ControllerBase
{
    public function show()
    {
        $userId = $this->request->getUserId();

        $user = obj(new FetchUserService($this->app))
            ->fetchOneByUserId($userId);

        $userType = $user->getType();

        if ($userType == 0) {
            $userEmail = obj(new FetchUserEmailService($this->app))
                ->fetchOneByUserId($userId);

            $userPhone = obj(new FetchUserPhoneService($this->app))
                ->fetchOneByUserId($userId);

            $userAddrSet = obj(new ListAddrByUserService($this->app))
                ->listByUserId($userId);
            
            return $this->view('/page/user/fetchUser', [
                'user' => $user,
                'userEmail' => $userEmail ? $userEmail : '',
                'userPhone' => $userPhone ? $userPhone : '',
                'userAddrSet' => $userAddrSet ? $userAddrSet : '',
            ]);
        } else {
            $proofer = obj(new FetchProoferService($this->app))
                ->fetch($userId);

            return $this->view('page/user/setProofer', [
                'user' => $user,
                'proofer' => $proofer,
            ]);
        }
    }
}
