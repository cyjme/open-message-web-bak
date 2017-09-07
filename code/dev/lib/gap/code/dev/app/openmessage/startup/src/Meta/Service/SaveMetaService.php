<?php
namespace Openmessage\Startup\Meta\Service;

class SaveMetaService extends ServiceBase
{
    public function save($key, $values)
    {
        $meta = $this->app->getMeta();

        foreach ($values as $localeKey => $value) {
            if ($value) {
                $meta->set($localeKey, $key, $value);
            }
        }
    }
}
