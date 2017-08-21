<?php
namespace Openmessage\Group\Group\Repo;

class FetchGroupRepo extends RepoBase
{
    public function getAllAccIdsByAppId($appId)
    {
        return $this->cnn->select('accId')
            ->from('acc')
            ->where('appId', '=', $appId)
            ->listObj();
    }
}
