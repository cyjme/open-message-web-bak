<?php
namespace Openmessage\Auth\Reg\Ui;

class FetchAgreementController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/reg/agreement');
    }
}
