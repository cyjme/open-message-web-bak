<?php
namespace Openmessage\Auth\Reg\Repo;

use Gap\Exception\ClientException;
use Openmessage\Auth\User\Dto\UserDto;
use Openmessage\Auth\User\Valid\ValidEmail;

class RegByEmailRepo extends RepoBase
{
    public function create(UserDto $user, $email)
    {
        obj(new ValidEmail())->assert($email, 'email');
        $this->assertEmailNotExists($email);

        $now = micro_date();
        $user->setNick('new user' . uniqid());
        $user->setUserId($this->cnn->zid());
        $user->setZcode($this->cnn->zcode());
        $user->setLogined($now);
        $user->setCreated($now);
        $user->setChanged($now);
        $user->setPrivilege(0);
        $user->setIsActive(1);

        $this->cnn->beginTransaction();
        try {
            $this->cnn->insert('user')
                ->value('userId', $user->getUserId())
                ->value('zcode', $user->getZcode())
                ->value('nick', $user->getNick())
                ->value('type', $user->getType())
                ->value('passhash', $user->getPasshash())
                ->value('verifyCode', $user->getVerifyCode())
                ->value('privilege', $user->getPrivilege())
                ->value('isActive', $user->getIsActive())
                ->value('logined', $user->getLogined())
                ->value('created', $user->getCreated())
                ->value('changed', $user->getChanged())
                ->execute();

            $this->cnn->insert('user_email')
                ->value('userEmailId', $this->cnn->zid())
                ->value('userId', $user->getUserId())
                ->value('email', $email)
                ->value('isActive', $user->getIsActive(0))
                ->value('isPrimary', 1, 'int')
                ->execute();
        } catch (\Exception $e) {
            $this->cnn->rollback();
            throw $e;
        }

        $this->cnn->commit();
    }

    protected function assertEmailNotExists($email)
    {
        if ($this->cnn
            ->select('userId')
            ->from('user_email')
            ->where('email', '=', $email)
            ->fetchObjOne()
        ) {
            throw new ClientException('already-exists', 'email');
        }
    }
}
