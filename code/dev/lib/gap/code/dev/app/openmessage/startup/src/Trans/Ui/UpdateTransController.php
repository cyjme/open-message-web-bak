<?php
namespace Openmessage\Startup\Trans\Ui;

class UpdateTransController extends ControllerBase
{
    public function show()
    {
        $key = $this->request->query->get('key');

        return $this->view('page/trans/updateTrans', [
            'key' => $key
        ]);
    }
}
