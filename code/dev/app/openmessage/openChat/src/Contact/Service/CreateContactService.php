<?php
namespace Openmessage\OpenChat\Contact\Service;

use Openmessage\OpenChat\Contact\Dto\ContactDto;
use Openmessage\OpenChat\Contact\Repo\CreateContactRepo;

class CreateContactService extends ServiceBase
{
    public function create(ContactDto $contact)
    {
        return obj(new CreateContactRepo($this->getDmg()))
            ->create($contact);
    }
}
