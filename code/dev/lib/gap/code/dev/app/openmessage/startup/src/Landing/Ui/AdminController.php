<?php
namespace Openmessage\Startup\Landing\Ui;

class AdminController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/landing/home');
    }
}
