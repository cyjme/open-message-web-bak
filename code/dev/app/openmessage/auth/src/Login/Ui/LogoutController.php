<?php
namespace Openmessage\Auth\Login\Ui;

class LogoutController extends ControllerBase
{
    public function show()
    {
        $this->request->getSession()->clear();
        return $this->gotoRoute('massHome');
    }
}
