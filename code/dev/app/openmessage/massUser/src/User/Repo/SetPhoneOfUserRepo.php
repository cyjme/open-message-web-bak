<?php
namespace Openmessage\MassUser\User\Repo;

use Openmessage\User\User\Dto\UserPhoneDto;

class SetPhoneOfUserRepo extends RepoBase
{
    public function setPhoneOfUser(UserPhoneDto $user)
    {
        $existed = $this->cnn->select()
            ->from('user_phone')
            ->where('userId', '=', $user->getUserId())
            ->fetchDtoOne(UserPhoneDto::class);

        if ($existed) {
            $this->cnn->update('user_phone')
                ->where('userId', '=', $user->getUserId())
                ->set('phone', trim($user->getPhone()))
                ->execute();
        } else {
            $user->setIsActive(1);

            $this->cnn->insert('user_phone')
                ->value('userPhoneId', $this->cnn->zid())
                ->value('userId', $user->getUserId())
                ->value('phone', trim($user->getPhone()))
                ->value('isActive', $user->getIsActive())
                ->value('isPrimary', 1, 'int')
                ->execute();
        }
    }
}
