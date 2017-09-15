<?php
namespace Openmessage\OpenChat\Chat\Repo;

use Openmessage\OpenChat\Chat\Dto\ChatDto;
use Openmessage\Msg\Msg\Dto\MsgDto;

class ListChatHistoryRepo extends RepoBase
{
    public function list($accToken, $withAccToken, $sinceCreated, $num = 10)
    {
        $ssb = $this->cnn->select()
            ->from('msg')
            ->where('from', '=', $accToken)
            ->andWhere('to', '=', $withAccToken)
            ->andWhere('created','<', $sinceCreated);

        $ssb->startGroup('OR')
            ->where('from', '=', $withAccToken)
            ->andWhere('to', '=', $accToken)
            ->andWhere('created', '<', $sinceCreated)
            ->endGroup();
        
        $ssb->limit($num);

        $ssb->orderBy('created');

        return $this->DataSet($ssb, MsgDto::class);
    }
}
