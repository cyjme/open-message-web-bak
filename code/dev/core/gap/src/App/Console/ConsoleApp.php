<?php
namespace Gap\App\Console;

use Gap\App\App;
use Gap\Database\DatabaseManager;

class ConsoleApp extends App
{
    protected $type = 'console';

    protected $databaseManager;

    public function cmd($argv)
    {
        $cmdMap = $this->buildCmdMap();

        if (!isset($argv[1])) {
            $this->printHelp($cmdMap);
            return;
        }

        $commandName = $argv[1];
        $commandClass = prop($cmdMap, $commandName);
        if (!$commandClass) {
            echo "cannot find command [$commandName];\n";
            return;
        }
        obj(new $commandClass($this, $argv))
            ->run();
    }


    public function getCnn($name)
    {
        return $this->getDatabaseManager()->connect($name);
    }

    public function getDatabaseManager()
    {
        if ($this->databaseManager) {
            return $this->databaseManager;
        }

        $this->databaseManager = new DatabaseManager(
            $this->config->get('db'),
            $this->config->get('server.id')
        );
        return $this->databaseManager;
    }

    public function zid()
    {
        return uniqid($this->getServerId() . '-');
    }

    public function getServerId()
    {
        return $this->config->get('server.id');
    }

    protected function printHelp($cmdMap)
    {
        $help = "Useage: \n"
        . "  gap COMMAND [options]\n"
        . "  COMMAND:\n";

        foreach ($cmdMap as $key => $val) {
            $help .= "    $key => $val \n";
        }
        echo $help;
    }

    protected function buildCmdMap()
    {
        return require $this->baseDir . '/setting/cmd/cmd.php';
        /*
        $cmdMap = require $this->baseDir . '/setting/cmd/cmd.php';
        //if ($this->isDebug) {
        //    $cmdMap['test'] = 'Gap\Util\Test\Cmd\TestCmd';
        //}

        $cmdMap['test'] = 'Gap\Util\Test\Cmd\TestCmd';

        $cmdMap['buildConfig'] = 'Gap\Util\Config\Cmd\BuildConfigCmd';
        $cmdMap['buildRoute'] = 'Gap\Util\Routing\Cmd\BuildRouteCmd';

        $cmdMap['buildApp'] = 'Gap\Util\Coder\Cmd\BuildAppCmd';
        $cmdMap['removeApp'] = 'Gap\Util\Coder\Cmd\RemoveAppCmd';
        $cmdMap['listApp'] = 'Gap\Util\Coder\Cmd\ListAppCmd';

        $cmdMap['buildModule'] = 'Gap\Util\Coder\Cmd\BuildModuleCmd';
        $cmdMap['listModule'] = 'Gap\Util\Coder\Cmd\ListModuleCmd';

        $cmdMap['buildEntity'] = 'Gap\Util\Coder\Cmd\BuildEntityCmd';

        return $cmdMap;
         */
    }
}
