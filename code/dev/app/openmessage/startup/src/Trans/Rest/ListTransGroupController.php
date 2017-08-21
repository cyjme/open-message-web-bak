<?php
namespace Openmessage\Startup\Trans\Rest;

use Openmessage\Startup\Trans\Service\ListTransGroupService;

class ListTransGroupController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $transGroupSet = obj(new ListTransGroupService($this->app))
            ->listTransByCompany($post->get('group'))->setCountPerPage(0);

        $transGroupAsm = [];
        foreach ($transGroupSet->getItems() as $item) {
            $transGroup = $item->getData();
            $transValue = $this->getTranslator()->get($transGroup['key'], [], $post->get('localeKey'));
            $transGroupAsm[$transGroup['key']] = $transValue;
        }

        return $this->jsonResponse($transGroupAsm);
    }
}
