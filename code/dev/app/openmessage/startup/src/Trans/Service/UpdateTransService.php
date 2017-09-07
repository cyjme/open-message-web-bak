<?php
namespace Openmessage\Startup\Trans\Service;

class UpdateTransService extends ServiceBase
{
    public function update($localeKey, $key, $value)
    {
        $localeKey = trim($localeKey);
        $key = trim($key);
        $value = trim($value);

        $this->app->getTranslator()
            ->set($localeKey, $key, $value);
    }
}
