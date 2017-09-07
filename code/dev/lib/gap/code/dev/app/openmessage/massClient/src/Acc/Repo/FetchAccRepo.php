<?php
namespace Openmessage\MassClient\Acc\Repo;

use Openmessage\MassClient\Acc\Dto\AccDto;

class FetchAccRepo extends RepoBase
{
    public function fetchByToken($token)
    {
        return $this->cnn->select()
            ->from('acc')
            ->where('token', '=', $token)
            ->fetchDtoOne(AccDto::class);
    }
}
