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
}
