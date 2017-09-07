<?php
namespace Openmessage\MassClient\Acc\Repo;

use Openmessage\MassClient\Acc\Dto\AccDto;

class CreateAccRepo extends RepoBase
{
    public function create(AccDto $acc)
    {
        $now = micro_date();
        $acc->setCreated($now);
        $acc->setChanged($now);
        $acc->setStatus(1);

        $existAcc = $this->checkUserExist($acc);
        if ($existAcc != null) {
            return $existAcc;
        }

        if (!$acc->getAccId()) {
            $acc->setAccId($this->cnn->zid());
        }
        if (!$acc->getToken()) {
            $acc->setToken(uniqid('acc-'));
        }

        $this->cnn->insert('acc')
            ->value('accId', $acc->getAccId())
            ->value('userId', $acc->getUserId())
            ->value('token', $acc->getToken())
            ->value('appId', $acc->getAppId())
            ->value('props', $acc->getProps())
            ->value('status', $acc->getStatus())
            ->value('created', $acc->getCreated())
            ->value('changed', $acc->getChanged())
            ->execute();

        return $acc;
    }

    protected function checkUserExist($acc)
    {
        return $this->cnn->select()
            ->from('acc')
            ->where('appId', '=', $acc->getAppId())
            ->andWhere('userId', '=', $acc->getUserId())
            ->fetchDtoOne(AccDto::class);
    }
}
