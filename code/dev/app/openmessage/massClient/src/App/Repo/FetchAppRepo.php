<?php
namespace Openmessage\MassClient\App\Repo;

use Openmessage\MassClient\Acc\Dto\AppDto;

class FetchAppRepo extends RepoBase
{
    public function fetchByKey($key)
    {
        return $this->cnn->select()
            ->from('app')
            ->where('key', '=', $key)
            ->fetchDtoOne(AppDto::class);
    }

    public function fetchByCode($code)
    {
        return $this->cnn->select()
            ->from('app')
            ->where('appCode', '=', $code)
            ->fetchDtoOne(AppDto::class);
    }
}
