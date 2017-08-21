<?php
namespace Openmessage\Startup\Trans\Rest;

use Openmessage\Startup\Trans\Dto\TransGroupDto;
use Openmessage\Startup\Trans\Service\CreateTransGroupService;

class CreateTransGroupController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $transGroup = new TransGroupDto([
            'key'   => $post->get('key'),
            'group' => $post->get('group'),
        ]);

        obj(new CreateTransGroupService($this->app))
            ->create($transGroup);

        $transValue = $this->getTranslator()->get($post->get('key'), [], $post->get('localeKey'));

        return $this->jsonResponse($transValue);
    }
}
