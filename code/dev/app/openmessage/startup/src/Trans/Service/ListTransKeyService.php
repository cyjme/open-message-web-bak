<?php
namespace Openmessage\Startup\Trans\Service;

use Openmessage\Startup\Trans\Repo\ListTransKeyRepo;

class ListTransKeyService extends ServiceBase
{
    public function listSet($opts)
    {
        return obj(new ListTransKeyRepo($this->getDmg()))
            ->listSet($opts);
    }
}
