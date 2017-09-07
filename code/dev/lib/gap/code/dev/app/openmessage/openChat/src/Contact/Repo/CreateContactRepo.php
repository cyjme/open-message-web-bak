<?php
namespace Openmessage\OpenChat\Contact\Repo;

use Openmessage\OpenChat\Contact\Dto\ContactDto;

class CreateContactRepo extends RepoBase
{
    public function create(ContactDto $contact)
    {
        $now = micro_date();
        $contact->setCreated($now);
        $contact->setChanged($now);

        $isExist = $this->cnn->select()
            ->from('contact')
            ->where('accToken', '=', $contact->getAccToken())
            ->andWhere('contactAccToken', '=', $contact->getContactAccToken())
            ->fetchDtoOne(ContactDto::class);

        if ($isExist === null) {
            $this->cnn->insert('contact')
                ->value('accToken', $contact->getAccToken())
                ->value('contactAccToken', $contact->getContactAccToken())
                ->value('created', $contact->getCreated())
                ->value('changed', $contact->getChanged())
                ->execute();
            
            return ;
        }

        $this->cnn->update('contact')
            ->where('accToken', '=', $contact->getAccToken())
            ->andWhere('contactAccToken', '=', $contact->getContactAccToken())
            ->set('changed', $contact->getChanged())
            ->execute();
    }
}
