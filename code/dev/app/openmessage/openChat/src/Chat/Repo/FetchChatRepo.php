<?php
namespace Openmessage\OpenChat\Chat\Repo;

use Openmessage\OpenChat\Chat\Dto\ChatDto;

class FetchChatRepo extends RepoBase
{
    public function fetchByCode($code)
    {
        $chat = $this->cnn->select()
            ->from('chat')
            ->where('chatCode', '=', $code)
            ->fetchDtoOne(ChatDto::class);

        return $chat;
    }
}
