<?php
namespace Openmessage\Startup\Trans\Repo;

use Openmessage\Startup\Trans\Dto\TransGroupDto;

class CreateTransGroupRepo extends RepoBase
{
    public function create(TransGroupDto $transGroup)
    {
        $this->cnn->insert('trans_group')
            ->value('key', $transGroup->getKey())
            ->value('group', $transGroup->getGroup())
            ->execute();
    }
}
