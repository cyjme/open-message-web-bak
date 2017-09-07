<?php
namespace Openmessage\Msg\Msg\Repo;

use Openmessage\Msg\Msg\Dto\MsgDto;

class ListMsgRepo extends RepoBase
{
    public function list($accId)
    {
        $ssb = $this->cnn->select()
            ->from('msg')
            ->where('to', '=', $accId);

        return $this->DataSet($ssb, MsgDto::class);
    }
}
