<?php
namespace Openmessage\Startup\Trans\Ui;

use Openmessage\Startup\Trans\Service\SaveTransService;

class SaveTransController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        obj(new SaveTransService($this->app))
            ->save($post->get('key'), $post->get('value'));

        return $this->gotoRoute('landTrans');
    }
}
