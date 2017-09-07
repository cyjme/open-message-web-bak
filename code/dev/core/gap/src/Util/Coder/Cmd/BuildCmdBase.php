<?php
namespace Gap\Util\Coder\Cmd;

use Gap\App\Console\ConsoleApp;

class BuildCmdBase extends CmdBase
{
    protected $config;
    protected $segs = [];
    protected $appName = '';
    protected $moduleName = '';
    protected $layerName = '';
    protected $entityName = '';
    protected $baseDir = '';
    protected $appDir = '';

    public function __construct(ConsoleApp $app, array $argv = [])
    {
        parent::__construct($app, $argv);

        if (!isset($this->argv[2])) {
            throw new \Exception("appName cannot be empty \n");
        }
        $this->config = $this->app->getConfig();

        $baseDir = $this->config->get('baseDir');


        $this->input = $this->formatInput($this->argv[2]);

        $this->parseInput($this->input);

        $this->baseDir = $baseDir;

        $this->appDir = $this->extractAppDir($this->appName);
    }

    protected function extractAppDir($appName)
    {
        if ($appName) {
            $appPath = $this->extractAppPath($appName);
            $appDir = $this->baseDir
                . '/dev/app'
                . $appPath;

            return $appDir;
        }

        return '';
    }

    protected function extractAppPath($appName)
    {
        $appSegs = explode("\\", trim($appName, "\\"));

        $appPath = "";
        foreach ($appSegs as $appSeg) {
            $appPath .= '/' . lcfirst($appSeg);
        }
        return $appPath;
    }

    protected function formatInput($input)
    {
        $input = ucwords(str_replace("/", "\\", $input), "\\");
        $input = trim($input, "  \t\n\r\0\x0B\\");
        return $input;
    }

    protected function parseInput($input)
    {
        $apps = $this->config->get('app');

        $segs = explode("\\", $input);
        $length = count($segs);
        $index = 0;

        $appName = '';
        for (; $index < $length; $index++) {
            $seg = $segs[$index];
            $appName .=  $seg . "\\";
            if (isset($apps[$appName])) {
                $this->appName = $appName;
                break;
            }
        }

        $index++;
        if ($index >= $length) {
            return;
        }
        $this->moduleName = $segs[$index];

        $index++;
        if ($index >= $length) {
            return;
        }
        $this->layerName = $segs[$index];

        $index++;
        if ($index >= $length) {
            return;
        }

        $this->entityName = implode("\\", array_slice($segs, $index));
    }
}
