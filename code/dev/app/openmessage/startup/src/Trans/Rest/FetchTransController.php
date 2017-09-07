<?php
namespace Openmessage\Startup\Trans\Rest;

class FetchTransController extends ControllerBase
{
    public function post()
    {
        $post = $this->request->request;

        $localeKey = $post->get('localeKey');
        $key = $post->get('key');
        $value = $this->app->getTranslator()
            ->get($key, [], $localeKey);

        return $this->jsonResponse([
            'localeKey' => $localeKey,
            'key' => $key,
            'value' => $value
        ]);
    }
}
