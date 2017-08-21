<?php
namespace Openmessage\Auth\Reg\Repo;

use Gap\Exception\ClientException;
use Openmessage\Auth\User\Dto\UserDto;
use Openmessage\Auth\User\Valid\ValidEmail;

class SaveUserRepo extends RepoBase
{
    public function save(UserDto $user, $email = '', $phone = '')
    {
        $this->cnn->beginTransaction();
        try {
            $this->cnn->insert('user')
                ->value('userId', $user->getUserId())
                ->value('zcode', $user->getZcode())
                ->value('nick', $user->getNick())
                ->value('type', $user->getType())
                ->value('verifyCode', '666')
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

            $this->cnn->insert('user_phone')
                ->value('userPhoneId', $this->cnn->zid())
                ->value('userId', $user->getUserId())
                ->value('phone', $phone)
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

    protected function assertPhoneNotExists($phone)
    {
        if ($this->cnn
            ->select('userId')
            ->from('user_phone')
            ->where('phone', '=', $phone)
            ->fetchObjOne()
        ) {
            throw new ClientException('already-exists', 'phone');
        }
    }
}
