<?php
namespace Openmessage\MassPush\Push\Repo;

use Openmessage\MassPush\Push\Dto\PushDto;

class CreatePushRepo extends RepoBase
{
    public function create(PushDto $push)
    {
        $now = micro_date();
        $push->setCreated($now);
        $push->setChanged($now);

        if (!$push->getPushId()) {
            $push->setPushId($this->cnn->zid());
        }

        $ssb = $this->cnn->select()
            ->from('push')
            ->where('accId', '=', $accId);

        return $this->DataSet($ssb, AppDto::class);
    }
}
