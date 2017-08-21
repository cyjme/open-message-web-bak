<?php
namespace Openmessage\MassClient\App\Repo;

use Openmessage\MassClient\App\Dto\AppDto;

class ListAppRepo extends RepoBase
{
    public function listByUserId($userId)
    {
        $ssb = $this->cnn->select()
            ->from('app')
            ->where('createdUser', '=', $userId);

        return $this->DataSet($ssb, AppDto::class);
    }
}
