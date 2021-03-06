<?php
namespace Gap\I18n\Locale;

use Gap\Config\ConfigManager;

class LocaleManager
{
    protected $localeOpts;

    public function __construct($localeOpts)
    {
        $this->localeOpts = $localeOpts;
    }

    public function getMode()
    {
        return $this->localeOpts['mode'];
    }

    public function getAvailable()
    {
        return $this->localeOpts['available'];
    }

    public function getDefaultLocaleKey()
    {
        return $this->localeOpts['default'];
    }

    public function isAvailableLocaleKey($localeKey)
    {
        return isset($this->localeOpts['available'][$localeKey]);
    }
}
