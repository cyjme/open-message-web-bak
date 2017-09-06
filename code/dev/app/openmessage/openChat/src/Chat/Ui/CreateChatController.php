<?php
namespace Openmessage\OpenChat\Chat\Ui;

use Openmessage\OpenChat\Chat\Dto\ChatDto;
use Openmessage\OpenChat\Contact\Dto\ContactDto;
use Openmessage\OpenChat\Chat\Service\CreateChatService;
use Openmessage\OpenChat\Contact\Service\CreateContactService;

class CreateChatController extends ControllerBase
{
    public function create()
    {
        $params = $this->request->query;

        $createChatUrl = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
        $createChatIp  = $_SERVER['REMOTE_ADDR'];
        $fromAccToken  = $params->get('fromAccToken');
        $toAccToken    = $params->get('toAccToken');
        
        $chat = new ChatDto([
            'createChatUrl' => $createChatUrl,
            'createChatIp'  => $createChatIp,
            'fromAccToken'  => $fromAccToken,
            'toAccToken'    => $toAccToken
        ]);

        $chat = obj(new CreateChatService($this->app))
            ->create($chat);
        
        $contact = new ContactDto([
            'accToken' => $fromAccToken,
            'contactAccToken' => $toAccToken
        ]);

        obj(new CreateContactService($this->app))
            ->create($contact);
        
        return $this->gotoRoute('landChat', [
            'chatCode'=>$chat->getChatCode()
        ]);
    }
}
