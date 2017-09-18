<?php
namespace Openmessage\OpenChat\Chat\Service;

use Openmessage\OpenChat\Chat\Dto\ChatDto;

use Openmessage\OpenChat\Chat\Repo\ListChatHistoryRepo;

class ListChatHistoryService extends ServiceBase
{
    public function list($accToken, $withAccToken, $sinceId, $num)
    {
        return obj(new ListChatHistoryRepo($this->getDmg()))
            ->list($accToken, $withAccToken, $sinceId, $num);
    }
}
