<?php
namespace Openmessage\OpenChat\Contact\Open;

use Openmessage\OpenChat\Contact\Service\ListContactService;

class ListContactController extends ControllerBase
{
    public function listByAccToken()
    {
        $post = $this->request->request;

        $contactSet = obj(new ListContactService($this->app))
            ->listByAccToken($post->get('accToken'));

        $contactArr = [];

        foreach ($contactSet->getItems() as $item) {
            $contactArr[] = $item;
        }

        return $this->jsonResponse($contactArr);
    }
}
