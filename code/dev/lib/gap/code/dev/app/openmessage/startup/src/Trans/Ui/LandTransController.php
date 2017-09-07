<?php
namespace Openmessage\Startup\Trans\Ui;

use Openmessage\Startup\Trans\Service\ListTransKeyService;
use Openmessage\Startup\Trans\Service\FetchTransService;

class LandTransController extends ControllerBase
{
    public function show()
    {
        $transKeySet = obj(new ListTransKeyService($this->app))
            ->listSet([
                'query' => $this->request->query->get('q')
            ]);
        $transKeySet->setCurrentPage($this->request->query->get('page'));

        return $this->view('page/trans/landTrans', [
            'transKeySet' => $transKeySet
        ]);
    }

    public function post()
    {
    }
}
