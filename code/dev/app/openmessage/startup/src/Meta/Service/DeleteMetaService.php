<?php
namespace Openmessage\Startup\Meta\Service;

class DeleteMetaService extends ServiceBase
{
    public function deleteByKey($key)
    {
        $meta = $this->app->getMeta();

        foreach ($this->app->getConfig()->get('i18n.locale.enabled') as $localeKey) {
            $meta->delete($localeKey, $key);
        }
    }
}
