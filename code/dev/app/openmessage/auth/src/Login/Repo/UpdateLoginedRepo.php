<?php
namespace Openmessage\Auth\Login\Repo;

use Gap\Valid\MicroDateValid;

class UpdateLoginedRepo extends RepoBase
{
    public function updateByUserId($userId, $logined)
    {
        obj(new MicroDateValid())->assert($logined, 'logined');
        $this->cnn->update('user')
            ->where('userId', '=', $userId, 'userId')
            ->set('logined', $logined)
            ->execute();
    }
}
