<?php
namespace Openmessage\MassClient\App\Service;

use Openmessage\MassClient\App\Repo\FetchAppRepo;

class FetchAppService extends ServiceBase
{
    public function fetchByKey($key)
    {
        return obj(new FetchAppRepo($this->getDmg()))
            ->fetchByKey($key);
    }

    public function fetchByCode($code)
    {
        return obj(new FetchAppRepo($this->getDmg()))
            ->fetchByCode($code);
    }
}
