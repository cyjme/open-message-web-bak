<?php
namespace Openmessage\Group\Group\Service;

use Openmessage\Group\Group\Repo\FetchGroupRepo;

class FetchGroupService extends ServiceBase
{
    public function getAllAccIdsByAppId($appId)
    {
        return obj(new FetchGroupRepo($this->getDmg()))
            ->getAllAccIdsByAppId($appId);
    }

    function fetchGroupByNameAndAppId($groupName, $appId)
    {
        return obj(new FetchGroupRepo($this->getDmg()))
            ->fetchGroupByNameAndAppId($groupName, $appId);
    }

    public function getAccIdsByGroupId($groupId)
    {
        return obj(new FetchGroupRepo($this->getDmg()))
            ->getAccIdsByGroupId($groupId);
    }
}
