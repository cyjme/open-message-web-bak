<?php
namespace Openmessage\Group\Group\Service;

use Openmessage\Group\Group\Repo\FetchGroupRepo;

class FetchGroupService extends ServiceBase
{
    public function getAllAccTokensByAppId($appId)
    {
        return obj(new FetchGroupRepo($this->getDmg()))
            ->getAllAccTokensByAppId($appId);
    }

    public function fetchGroupByNameAndAppId($groupName, $appId)
    {
        return obj(new FetchGroupRepo($this->getDmg()))
            ->fetchGroupByNameAndAppId($groupName, $appId);
    }

    public function getAccTokensByGroupId($groupId)
    {
        return obj(new FetchGroupRepo($this->getDmg()))
            ->getAccTokensByGroupId($groupId);
    }
}
