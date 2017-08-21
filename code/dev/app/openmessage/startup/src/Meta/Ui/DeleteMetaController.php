<?php
namespace Openmessage\Startup\Meta\Ui;

use Openmessage\Startup\Meta\Service\DeleteMetaService;

class DeleteMetaController extends ControllerBase
{
    public function show()
    {
        $key = $this->request->query->get('key');
        return $this->view('app/openmessage/admin/page/meta/delete-meta', [
            'key' => $key
        ]);
    }

    public function post()
    {
        $key = $this->request->request->get('key');
        obj(new DeleteMetaService($this->app))
            ->deleteByKey($key);

        return $this->gotoRoute('landMeta');
    }
}
