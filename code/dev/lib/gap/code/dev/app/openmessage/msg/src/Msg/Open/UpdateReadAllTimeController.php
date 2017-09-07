<?php
namespace Openmessage\Msg\Msg\Open;

use Openmessage\Msg\Msg\Service\UpdateReadAllTimeService;
use Openmessage\MassClient\Acc\Service\FetchAccService;

class UpdateReadAllTimeController extends ControllerBase
{
    public function update()
    {
        $token = $this->request->get('token');

        $time = obj(new UpdateReadAllTimeService($this->app))
            ->updateByToken($token);

        return $this->jsonResponse(['time'=>$time]);
    }
}
