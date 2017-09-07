<?php
namespace Openmessage\OpenChat\Chat\Service;

use Openmessage\OpenChat\Chat\Dto\ChatDto;
use Openmessage\OpenChat\Chat\Repo\FetchChatRepo;

class FetchChatService extends ServiceBase
{
    public function fetchByCode($code)
    {
        return obj(new FetchChatRepo($this->getDmg()))
            ->fetchByCode($code);
    }
}
