<?php
namespace Openmessage\Group\Group\Repo;

use Openmessage\Group\Group\Dto\GroupDto;

class FetchGroupRepo extends RepoBase
{
    public function getAllAccIdsByAppId($appId)
    {
        return $this->cnn->select('accId')
            ->from('acc')
            ->where('appId', '=', $appId)
            ->listObj();
    }

    public function fetchGroupByNameAndAppId($groupName, $appId)
    {
        return $this->cnn->select()
            ->from('group')
            ->where('name', '=', $groupName)
            ->andWhere('appId', '=', $appId)
            ->fetchDtoOne(GroupDto::class);
    }

    public function getAccIdsByGroupId($groupId)
    {
        return $this->cnn->select('accId')
            ->from('acc_group')
            ->where('groupId', '=', $groupId)
            ->listObj();
    }
}
