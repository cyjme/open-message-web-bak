<?php
namespace Gap\Util\Coder\Cmd;

class RemoveAppCmd extends AppCmdBase
{
    public function run()
    {
        if (!$this->appName) {
            throw new \Exception('app: ' . $this->appName . ' not found');
        }

        if (!$this->appDir) {
            throw new \Exception('appDir: ' . $this->appDir . ' not found');
        }


        echo "remove app: $this->appName \n";

        $this->buildAppConfig();
        $this->buildComposer();
        $this->buildPhpunit();

        $this->removeDir($this->appDir);
    }

    protected function buildAppConfig()
    {
        echo "buildAppConfig \n";

        $appAsm = $this->config->get('app');
        unset($appAsm[$this->appName]);
        $this->saveAppConfig($appAsm);
    }

    protected function buildComposer()
    {
        echo "buildComposer \n";

        $composerAsm = json_decode(file_get_contents($this->baseDir . '/../composer.json'), true);
        unset($composerAsm['autoload']['psr-4'][$this->appName]);
        unset($composerAsm['autoload-dev']['psr-4']["cmdtest\\{$this->appName}"]);
        $this->saveComposer($composerAsm);
    }

    protected function buildPhpunit()
    {
        echo "buildPhpunit \n";

        $appAsm = $this->app->getConfig()->get('app');
        unset($appAsm[$this->appName]);
        $this->savePhpunit($appAsm);
    }

    protected function removeDir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        $this->removeDir($dir . "/" . $object);
                        continue;
                    }

                    unlink($dir . "/" . $object);
                    echo "remove file: $dir/$object \n";
                }
            }

            rmdir($dir);
            echo "remove dir: $dir \n";
        }
    }
}
