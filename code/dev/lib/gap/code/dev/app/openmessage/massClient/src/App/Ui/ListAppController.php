<?php
namespace Openmessage\MassClient\App\Ui;

use Openmessage\MassClient\App\Dto\AppDto;
use Openmessage\MassClient\App\Service\ListAppService;

class ListAppController extends ControllerBase
{
    public function show()
    {
        $userId = $this->request->getUserId();
        
        $appSet = obj(new ListAppService($this->app))
                    ->listByUserId($userId);

        return $this->view('page/app/listApp', [
            'appSet' => $appSet
        ]);
    }
}
