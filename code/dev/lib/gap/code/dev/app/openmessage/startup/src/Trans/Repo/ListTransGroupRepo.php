<?php
namespace Openmessage\Startup\Trans\Repo;

use Openmessage\Startup\Trans\Dto\TransGroupDto;

class ListTransGroupRepo extends RepoBase
{
    public function listTransByCompany($group)
    {
        $cnn = $this->cnn->select()
            ->where('group', '=', $group)
            ->from('trans_group');

        return $this->dataSet($cnn, TransGroupDto::class);
    }
}
