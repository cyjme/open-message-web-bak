<?php
namespace Openmessage\Startup\Trans\Ui;

use Openmessage\Startup\Trans\Service\DeleteTransService;

class DeleteTransController extends ControllerBase
{
    public function show()
    {
        $key = $this->request->query->get('key');
        return $this->view('page/trans/deleteTrans', [
            'key' => $key
        ]);
    }

    public function post()
    {
        $key = $this->request->request->get('key');
        obj(new DeleteTransService($this->app))
            ->deleteByKey($key);

        return $this->gotoRoute('landTrans');
    }
}
