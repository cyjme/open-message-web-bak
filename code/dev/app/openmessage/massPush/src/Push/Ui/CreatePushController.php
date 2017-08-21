<?php
namespace Openmessage\MassPush\Push\Ui;

use Openmessage\MassClient\App\Service\FetchAppService;

class CreatePushController extends ControllerBase
{
    public function show()
    {
        $appCode = $this->getParam('appCode');
        $app = obj(new FetchAppService($this->app))
                ->fetchByCode($appCode);

        return $this->view('page/push/createPush', [
            'app' => $app
        ]);
    }
}
