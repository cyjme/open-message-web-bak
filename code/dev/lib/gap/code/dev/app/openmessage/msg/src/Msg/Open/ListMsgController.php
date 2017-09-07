<?php
namespace Openmessage\Msg\Msg\Open;

use Openmessage\Msg\Msg\Service\ListMsgService;
use Openmessage\MassClient\Acc\Service\FetchAccService;

class ListMsgController extends ControllerBase
{
    public function list()
    {
        $token = $this->request->get('token');

        $acc = obj(new FetchAccService($this->app))
            ->fetchByToken($token);

        if ($acc == null) {
            return $this->jsonResponse('token err');
        }
        
        $msgSet = obj(new ListMsgService($this->app))
            ->list($acc->getAccId());

        $msgArr = [];
        foreach ($msgSet->getItems() as $msg) {
            $msgArr[] = $msg;
        }

        return $this->jsonResponse($msgArr);
    }
}
