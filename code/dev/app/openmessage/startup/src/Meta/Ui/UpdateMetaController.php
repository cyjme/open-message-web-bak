<?php
namespace Openmessage\Startup\Meta\Ui;

class UpdateMetaController extends ControllerBase
{
    public function show()
    {
        $key = $this->request->query->get('key');

        return $this->view('app/openmessage/admin/page/meta/update-meta', [
            'key' => $key
        ]);
    }
}
