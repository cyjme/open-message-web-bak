<?php
namespace Openmessage\OpenChat\Contact\Service;

use Openmessage\OpenChat\Contact\Dto\ContactDto;
use Openmessage\OpenChat\Contact\Repo\ListContactRepo;

class ListContactService extends ServiceBase
{
    public function listByAccToken($accToken)
    {
        return obj(new ListContactRepo($this->getDmg()))
            ->listByAccToken($accToken);
    }
}
