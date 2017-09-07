<?php
namespace Openmessage\Startup\Trans\Service;

class SaveTransService extends ServiceBase
{
    public function save($key, $values)
    {
        $trans = $this->app->getTranslator();

        foreach ($values as $localeKey => $value) {
            if ($value) {
                $trans->set($localeKey, $key, $value);
            }
        }
    }
}
