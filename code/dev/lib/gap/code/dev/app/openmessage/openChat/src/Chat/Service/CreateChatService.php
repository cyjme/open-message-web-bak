<?php
namespace Openmessage\OpenChat\Chat\Service;

use Openmessage\OpenChat\Chat\Dto\ChatDto;
use Openmessage\OpenChat\Chat\Repo\CreateChatRepo;

class CreateChatService extends ServiceBase
{
    public function create(ChatDto $chat)
    {
        return obj(new CreateChatRepo($this->getDmg()))
            ->create($chat);
    }
}
