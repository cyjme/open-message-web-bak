<?php
namespace Openmessage\OpenChat\Chat\Ui;

use Openmessage\OpenChat\Chat\Service\FetchChatService;
use Openmessage\MassClient\Acc\Service\FetchAccService;

class LandChatController extends ControllerBase
{
    public function show()
    {
        $chatCode = $this->getParam('chatCode');

        $chat = obj(new FetchChatService($this->app))
            ->fetchByCode($chatCode);
        
        $profile = obj(new FetchAccService($this->app))
            ->fetchByToken($chat->getFromAccToken());

        return $this->view('page/landChat', [
            'fromAccToken' => $chat->getFromAccToken(),
            'toAccToken' => $chat->getToAccToken(),
            'profile' => $profile
        ]);
    }
}
