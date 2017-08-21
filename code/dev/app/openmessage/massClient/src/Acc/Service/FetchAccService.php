<?php
namespace Openmessage\MassClient\Acc\Service;

use Openmessage\MassClient\Acc\Repo\FetchAccRepo;

class FetchAccService extends ServiceBase
{
    public function fetchByToken($token)
    {
        return obj(new FetchAccRepo($this->getDmg()))
            ->fetchByToken($token);
    }
}
