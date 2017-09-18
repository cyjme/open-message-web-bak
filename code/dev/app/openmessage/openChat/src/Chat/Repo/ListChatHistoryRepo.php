<?php
namespace Openmessage\OpenChat\Chat\Repo;

use Openmessage\OpenChat\Chat\Dto\ChatDto;
use Openmessage\Msg\Msg\Dto\MsgDto;

class ListChatHistoryRepo extends RepoBase
{
    public function list($accToken, $withAccToken, $sinceId, $num)
    {
        if($num == null){
            $num = 10;
        }
        $ssb = $this->cnn->select()
            ->from('msg')
            ->where('from', '=', $accToken)
            ->andWhere('to', '=', $withAccToken)
            ->andWhere('msgId','<', $sinceId);

        $ssb->startGroup('OR')
            ->where('from', '=', $withAccToken)
            ->andWhere('to', '=', $accToken)
            ->andWhere('msgId', '<', $sinceId)
            ->endGroup();
        
        $ssb->limit($num);

        $ssb->orderBy('msgId','desc');

        return $this->DataSet($ssb, MsgDto::class);
    }
}
