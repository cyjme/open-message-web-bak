<?php
namespace Openmessage\MassClient\App\Repo;

use Openmessage\MassClient\App\Dto\AppDto;

class CreateAppRepo extends RepoBase
{
    public function create(AppDto $app)
    {
        $now = micro_date();
        $app->setCreated($now);
        $app->setChanged($now);

        if (!$app->getAppId()) {
            $app->setAppId($this->cnn->zid());
        }

        $this->cnn->insert('app')
            ->value('appId', $app->getAppId())
            ->value('appCode', $app->getAppCode())
            ->value('name', $app->getName())
            ->value('desc', $app->getDesc())
            ->value('createdUser', $app->getCreatedUser())
            ->value('key', $app->getKey())
            ->value('secret', $app->getSecret())
            ->value('status', $app->getStatus())
            ->value('created', $app->getCreated())
            ->value('changed', $app->getChanged())
            ->execute();
    }
}
