<?php
namespace Openmessage\Startup\Meta\Ui;

use Openmessage\Startup\Meta\Service\SearchMetaKeyService;
use Openmessage\Startup\Meta\Service\FetchMetaService;

class LandMetaController extends ControllerBase
{
    public function show()
    {
        $metaKeySet = obj(new SearchMetaKeyService($this->app))
            ->searchSet([
                'query' => $this->request->query->get('q')
            ]);
        $metaKeySet->setCurrentPage($this->request->query->get('page'));

        return $this->view('app/openmessage/admin/page/meta/land-meta', [
            'metaKeySet' => $metaKeySet
        ]);
    }

    public function post()
    {
    }
}
