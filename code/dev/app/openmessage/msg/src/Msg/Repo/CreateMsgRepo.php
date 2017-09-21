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

        $this->cnn->insert('msg')
            ->value('type', $msg->getType())
            ->value('title', $msg->getTitle())
            ->value('content', $msg->getContent())
            ->value('contentType', $msg->getContentType())
            ->value('from', $msg->getFrom())
            ->value('to', $msg->getTo())
            ->value('created', $msg->getCreated())
            ->value('changed', $msg->getChanged())
            ->execute();
    }
}
