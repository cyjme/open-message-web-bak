<?php
namespace Openmessage\MassClient\Acc\Service;

use Openmessage\MassClient\Acc\Repo\CreateAccRepo;
use Openmessage\MassClient\Acc\Dto\AccDto;

class CreateAccService extends ServiceBase
{
    public function create(AccDto $acc)
    {
        return obj(new CreateAccRepo($this->getDmg()))
            ->create($acc);
    }
}
