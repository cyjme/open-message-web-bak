<?php
namespace Openmessage\OpenChat\Chat\Open;

use Openmessage\OpenChat\Chat\Dto\ChatDto;
use Openmessage\OpenChat\Contact\Dto\ContactDto;
use Openmessage\OpenChat\Chat\Service\CreateChatService;

class CreateChatController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $createChatUrl = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
        $createChatIp  = $_SERVER['REMOTE_ADDR'];
        $fromAccToken  = $post->get('fromAccToken');
        $toAccToken    = $post->get('toAccToken');
        
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
        
        return $this->jsonResponse(['chatCode'=>$chat->getChatCode()]);
    }
}
