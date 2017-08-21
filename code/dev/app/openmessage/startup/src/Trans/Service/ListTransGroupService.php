<?php
namespace Openmessage\Startup\Trans\Service;

use Openmessage\Startup\Trans\Repo\ListTransGroupRepo;

class ListTransGroupService extends ServiceBase
{
    public function listTransByCompany($group)
    {
        return obj(new ListTransGroupRepo($this->getDmg()))
            ->listTransByCompany($group);
    }
}
