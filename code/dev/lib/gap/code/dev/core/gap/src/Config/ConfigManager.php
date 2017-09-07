<?php
namespace Gap\Config;

class ConfigManager
{
    protected $config;
    protected $baseDir;
    protected $type;

    public function __construct($baseDir, $type)
    {
        $this->baseDir = $baseDir;
        $this->type = $type;
    }

    public function getConfig()
    {
        if ($this->config) {
            return $this->config;
        }

        $compiledPath = $this->getCompiledPath();
        if (file_exists($compiledPath)) {
            $config = new Config();
            $config->load(require $compiledPath);
            $this->config = $config;

            return $this->config;
        }

        return null;
    }

    public function buildConfig()
    {
        $config = new Config();
        $config->set('baseDir', $this->baseDir);
        $config->includeFile($this->baseDir . '/setting/config/config.php');
        $config->includeFile($this->baseDir . '/setting/config/config.app.php');
        $config->includeFile($this->baseDir . '/setting/config/config.init.local.php');


        foreach ($config->get('app', []) as $name => $app) {
            if (!$dir = $this->baseDir . $app['dir'] ?? false) {
                continue;
            }

            $file = $dir . '/config.init.php';
            if (file_exists($file)) {
                $config->includeFile($file);
                continue;
            }

            $config->set('router', [
                'dir' => [
                    $name => [$dir . '/setting/router']
                ]
            ]);
            $config->includeDir($dir . '/setting/config');
        }

        $config->includeDir($this->baseDir . '/setting/config/enabled');
        $config->includeDir($this->baseDir . '/setting/config/local');

        $this->config = $config;
        return $this->config;
    }

    public function compile()
    {
        $compiledPath = $this->getCompiledPath();
        var2file($compiledPath, $this->config->all());
    }

    protected function getCompiledPath()
    {
        return $this->baseDir . '/cache/setting-config-' . $this->type . '.php';
    }
}
