<?php
namespace Openmessage\Startup\Trans\Service;

class DeleteTransService extends ServiceBase
{
    public function deleteByKey($key)
    {
        $trans = $this->app->getTranslator();

        foreach ($this->app->getConfig()->get('i18n.locale.enabled') as $localeKey) {
            $trans->delete($localeKey, $key);
        }
    }

    public function delete($localeKey, $key)
    {
        $this->app->getTranslator()->delete($localeKey, $key);
    }
}
