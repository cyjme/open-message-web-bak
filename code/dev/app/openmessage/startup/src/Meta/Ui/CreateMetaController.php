<?php
namespace Openmessage\Startup\Meta\Ui;

class CreateMetaController extends ControllerBase
{
    public function show()
    {
        return $this->view('app/openmessage/admin/page/meta/create-meta');
    }

    public function post()
    {
    }
}
