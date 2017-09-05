<?php
namespace Openmessage\OpenChat\Chat\Ui;

class LandChatController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/landChat');
    }
}
