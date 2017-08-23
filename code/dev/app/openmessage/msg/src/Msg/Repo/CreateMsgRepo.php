<?php
namespace Openmessage\Msg\Msg\Repo;

use Openmessage\Msg\Msg\Dto\MsgDto;

class CreateMsgRepo extends RepoBase
{
    public function create(MsgDto $msg)
    {
        $now = micro_date();
        $msg->setCreated($now);
        $msg->setChanged($now);

        if (!$msg->getMsgId()) {
            $msg->setMsgId($this->cnn->zid());
        }

        $this->cnn->insert('msg')
            ->value('msgId', $msg->getMsgId())
            ->value('type', $msg->getType())
            ->value('title', $msg->getTitle())
            ->value('content', $msg->getContent())
            ->value('from', $msg->getFrom())
            ->value('to', $msg->getTo())
            ->value('created', $msg->getCreated())
            ->value('changed', $msg->getChanged())
            ->execute();
    }
}