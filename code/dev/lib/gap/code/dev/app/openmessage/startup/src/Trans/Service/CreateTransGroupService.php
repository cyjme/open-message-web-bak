<?php
namespace Openmessage\Startup\Trans\Service;

use Openmessage\Startup\Trans\Dto\TransGroupDto;
use Openmessage\Startup\Trans\Repo\CreateTransGroupRepo;

class CreateTransGroupService extends ServiceBase
{
    public function create(TransGroupDto $transGroup)
    {
        return obj(new CreateTransGroupRepo($this->getDmg()))
            ->create($transGroup);
    }
}
