<?php
namespace Gap\App;

use Gap\Config\ConfigManager;
use Gap\Database\DatabaseManager;
use Gap\Cache\CacheManager;
use Gap\I18n\Translator\Translator;

class App
{
    protected $type = 'base';
    protected $isDebug = false;
    protected $baseDir;
    protected $config;

    protected $dmg;
    protected $cmg;
    protected $translator;

    public function __construct($baseDir)
    {
        $configManager = new ConfigManager($baseDir, $this->type);

        if (!$config = $configManager->getConfig()) {
            $config = $configManager->buildConfig();
        }

        $this->isDebug = $config->get('debug');

        if ($this->isDebug === true) {
            $config = $configManager->buildConfig();
            $configManager->compile();
        }

        $this->baseDir = $baseDir;
        $this->config = $config;
    }

    public function getBaseDir()
    {
        return $this->baseDir;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getDmg()
    {
        if ($this->dmg) {
            return $this->dmg;
        }
        $this->dmg = new DatabaseManager($this->config->get('db'), $this->getServerId());
        return $this->dmg;
    }

    public function getCmg()
    {
        if ($this->cmg) {
            return $this->cmg;
        }
        $this->cmg = new CacheManager($this->config->get('cache'), $this->getServerId());
        return $this->cmg;
    }

    public function getServerId()
    {
        return $this->config->get('server.id');
    }

    public function getTranslator()
    {
        if ($this->translator) {
            return $this->translator;
        }
        $this->translator = new Translator(
            $this->getDmg()->connect($this->config->get('i18n.db')),
            $this->getCmg()->connect($this->config->get('i18n.cache'))
        );
        return $this->translator;
    }
}
