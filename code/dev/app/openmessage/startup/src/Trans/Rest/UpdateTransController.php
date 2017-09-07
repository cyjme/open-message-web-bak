<?php
namespace Openmessage\Startup\Trans\Rest;

use Openmessage\Startup\Trans\Service\UpdateTransService;

class UpdateTransController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $localeKey = $post->get('localeKey');
        $key = $post->get('key');
        $value = $post->get('value');

        obj(new UpdateTransService($this->app))
            ->update(
                $localeKey,
                $key,
                $value
            );

        return $this->jsonResponse([
            'localeKey' => $localeKey,
            'key' => $key,
            'value' => $value
        ]);
    }
}
