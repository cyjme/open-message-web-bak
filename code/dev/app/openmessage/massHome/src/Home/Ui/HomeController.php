<?php
namespace Openmessage\MassHome\Home\Ui;

class HomeController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/home/home');
    }
}
