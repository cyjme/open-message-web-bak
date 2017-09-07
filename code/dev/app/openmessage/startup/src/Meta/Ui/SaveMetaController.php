<?php
namespace Openmessage\Startup\Meta\Ui;

use Openmessage\Startup\Meta\Service\SaveMetaService;

class SaveMetaController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        obj(new SaveMetaService($this->app))
            ->save($post->get('key'), $post->get('value'));

        return $this->gotoRoute('landMeta');
    }
}
