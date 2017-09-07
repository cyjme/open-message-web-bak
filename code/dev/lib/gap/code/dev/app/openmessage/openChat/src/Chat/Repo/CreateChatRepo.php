<?php
namespace Openmessage\OpenChat\Chat\Repo;

use Openmessage\OpenChat\Chat\Dto\ChatDto;

class CreateChatRepo extends RepoBase
{
    public function create(ChatDto $chat)
    {
        $now = micro_date();
        $chat->setCreated($now);
        $chat->setChanged($now);

        if (!$chat->getChatId()) {
            $chat->setChatId($this->cnn->zid());
        }
        if (!$chat->getChatCode()) {
            $chat->setChatCode($this->cnn->zid());
        }

        $this->cnn->insert('chat')
            ->value('chatId', $chat->getChatId())
            ->value('chatCode', $chat->getChatCode())
            ->value('fromAccToken', $chat->getFromAccToken())
            ->value('toAccToken', $chat->getToAccToken())
            ->value('createChatIp', $chat->getCreateChatIp())
            ->value('createChatUrl', $chat->getCreateChatUrl())
            ->value('userInfo', $chat->getUserInfo())
            ->value('created', $chat->getCreated())
            ->value('changed', $chat->getChanged())
            ->execute();

        return $chat;
    }
}
