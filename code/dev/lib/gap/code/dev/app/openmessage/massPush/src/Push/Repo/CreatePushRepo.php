<?php
namespace Openmessage\MassPush\Push\Repo;

use Openmessage\MassPush\Push\Dto\PushDto;

class CreatePushRepo extends RepoBase
{
    public function create(PushDto $push)
    {
        $now = micro_date();
        $push->setChanged($now);

        if (!$push->getPushId()) {
            $push->setPushId($this->cnn->zid());
        }

        if (!$push->getCreated()) {
            $push->setCreated($now);
        }

        $this->cnn->insert('push')
            ->value('pushId', $push->getPushId())
            ->value('createdUser', $push->getCreatedUser())
            ->value('companyId', $push->getCompanyId())
            ->value('appId', $push->getAppId())
            ->value('title', $push->getTitle())
            ->value('content', $push->getContent())
            ->value('toAccId', $push->getToAccId())
            ->value('toGroupId', $push->getToGroupId())
            ->value('created', $push->getCreated())
            ->value('changed', $push->getChanged())
            ->execute();
    }
}
