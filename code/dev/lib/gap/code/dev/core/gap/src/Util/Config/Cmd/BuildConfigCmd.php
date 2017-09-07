<?php
namespace Gap\Util\Config\Cmd;

class BuildConfigCmd extends CmdBase
{
    // http://stackoverflow.com/questions/5947742/how-to-change-the-output-color-of-echo-in-linux
    public function run()
    {
        $config = $this->app->getConfig();

        $jsConfig = [
            'baseHost' => $config->get('baseHost'),
            'debug' => $config->get('debug'),
        ];

        $this->writeConfig('config.local.js', $jsConfig);

        foreach ($config->get('front') as $item) {
            $this->writeConfig($item . '.local.js', $config->get($item));
        }

        $baseDir = $config->get('baseDir');
        $this->writeVersionConfig(
            $baseDir . '/setting/config/local/version.php',
            mt_rand(100000, 999999)
        );
    }

    protected function writeConfig($file, $config)
    {
        $baseDir = $this->app->getConfig()->get('baseDir');

        $jsConfigDir = $baseDir . '/dev/front/js/setting/config';
        $frontConfigDir = $baseDir . '/dev/front/setting/config';

        $this->writeJsConfig($jsConfigDir . '/' . $file, $config, 'config');
        $this->writeFrontConfig($frontConfigDir . '/' . $file, $config);
    }

    protected function writeJsConfig($path, $config, $var)
    {
        $this->makePathDir($path);

        file_put_contents($path, implode([
            'let ', $var, ' = ',
            json_encode($config),
            '; ',
            'export {', $var, '};'
        ]));
        $this->echoGreen("Wrote js config to $path");
    }

    protected function writeFrontConfig($path, $config)
    {
        $this->makePathDir($path);

        file_put_contents($path, implode([
            'module.exports = ',
            json_encode($config),
            ';'
        ]));
        $this->echoGreen("Wrote front config to $path");
    }

    protected function writeVersionConfig($path, $version)
    {
        $this->makePathDir($path);
        file_put_contents($path, implode("\n", [
            '<?php',
            '$this->set("version", ' . $version . ');' . "\n"
        ]));
        $this->echoGreen("Wrote version config to $path");
    }

    protected function makePathDir($path)
    {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    protected function echoGreen($msg)
    {
        $green = "\033[0;32m";
        $noColor = "\033[0m";
        echo $green . $msg . $noColor . "\n";
    }
}
