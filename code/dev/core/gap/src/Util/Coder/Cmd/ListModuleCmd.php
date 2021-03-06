<?php
namespace Gap\Util\Coder\Cmd;

class ListModuleCmd extends CmdBase
{
    public function run()
    {
        $config = $this->app->getConfig();
        $apps = $config->get('app');
        $baseDir = $config->get('baseDir');

        foreach ($apps as $appName => $opts) {
            echo $appName . ' - ';
            foreach ($opts as $optKey => $optVal) {
                echo "[$optKey]($optVal)";
            }

            echo "\n";

            $srcDir = $baseDir . $opts['dir'] . '/src';

            if (!is_dir($srcDir)) {
                continue;
            }

            $files = scandir($srcDir);
            foreach ($files as $file) {
                if ($file == '.') {
                    continue;
                }

                if ($file == '..') {
                    continue;
                }

                if ($file == 'Base') {
                    continue;
                }

                if (is_dir($srcDir . '/' . $file)) {
                    echo " - $file\n";
                }
            }
        }
    }
}
