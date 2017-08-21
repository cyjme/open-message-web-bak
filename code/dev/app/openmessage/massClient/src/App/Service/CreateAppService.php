<?php
namespace Openmessage\MassClient\App\Service;

use Openmessage\MassClient\App\Repo\CreateAppRepo;
use Openmessage\MassClient\App\Dto\AppDto;

class CreateAppService extends ServiceBase
{
    public function create(AppDto $app)
    {
        return obj(new CreateAppRepo($this->getDmg()))
            ->create($app);
    }
}
