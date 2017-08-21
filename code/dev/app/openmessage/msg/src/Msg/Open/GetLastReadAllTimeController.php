<?php
namespace Openmessage\Msg\Msg\Open;

use Openmessage\Msg\Msg\Service\UpdateReadAllTimeService;
use Openmessage\MassClient\Acc\Service\FetchAccService;

class GetLastReadAllTimeController extends ControllerBase
{
    public function show()
    {
        $token = $this->request->get('token');

        $acc = obj(new FetchAccService($this->app))
            ->fetchByToken($token);

        return $this->jsonResponse(['time'=>$acc->getChanged()]);
    }
}
