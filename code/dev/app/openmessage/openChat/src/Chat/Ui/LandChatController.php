<?php
namespace Openmessage\OpenChat\Chat\Ui;

use Openmessage\OpenChat\Chat\Service\FetchChatService;

class LandChatController extends ControllerBase
{
    public function show()
    {
        $chatCode = $this->getParam('chatCode');

        $chat = obj(new FetchChatService($this->app))
            ->fetchByCode($chatCode);

        return $this->view('page/landChat', [
            'fromAccToken' => $chat->getFromAccToken(),
            'toAccToken' => $chat->getToAccToken()
        ]);
    }
}
