<?php
namespace Openmessage\Startup\Trans\Rest;

use Openmessage\Startup\Trans\Service\DeleteTransService;

class DeleteTransController extends ControllerBase
{
    public function post()
    {
        $key = $this->request->request->get('key');
        $localeKey = $this->request->request->get('localeKey');

        obj(new DeleteTransService($this->app))
            ->delete($localeKey, $key);

        return $this->jsonResponse([
            'ok' => 1,
            'key' => $key,
            'localeKey' => $localeKey
        ]);
    }
}
