<?php
namespace Openmessage\OpenChat\Contact\Repo;

use Openmessage\MassClient\Acc\Dto\AccDto;

class ListContactRepo extends RepoBase
{
    public function listByAccToken($accToken)
    {
        $ssb = $this->cnn->select(
                ['acc','*']
            )
            ->from(
                ['contact','contact']
            )
            ->where('accToken', '=', $accToken)
            ->leftJoin(
                ['acc','acc'],
                ['contact','contactAccToken'],
                '=',
                ['acc','token']
            );

        $ssb->orderBy('changed','desc');

        return $this->DataSet($ssb, AccDto::class);
    }
}
