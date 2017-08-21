<?php
namespace Openmessage\MassUser\User\Repo;

use Openmessage\User\User\Dto\UserEmailDto;

class SetEmailOfUserRepo extends RepoBase
{
    public function setEmailOfUser(UserEmailDto $user)
    {
        $existed = $this->cnn->select()
            ->from('user_email')
            ->where('userId', '=', $user->getUserId())
            ->fetchDtoOne(UserEmailDto::class);

        if ($existed) {
            $this->cnn->update('user_email')
                ->where('userId', '=', $user->getUserId())
                ->set('email', trim($user->getEmail()))
                ->execute();
        } else {
            $user->setIsActive(1);

            $this->cnn->insert('user_email')
                ->value('userEmailId', $this->cnn->zid())
                ->value('userId', $user->getUserId())
                ->value('email', trim($user->getEmail()))
                ->value('isActive', $user->getIsActive())
                ->value('isPrimary', 1, 'int')
                ->execute();
        }
    }
}
