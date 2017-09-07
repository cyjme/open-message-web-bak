<?php
namespace Gap\Util\Coder\Cmd;

class BuildModuleCmd extends BuildCmdBase
{
    public function run()
    {
        if (!$this->appName) {
            throw new \Exception('app: ' . $this->appName . ' not found');
        }

        if (!$this->appDir) {
            throw new \Exception('appDir: ' . $this->appDir . ' not found');
        }

        if (!$this->moduleName) {
            throw new \Exception('module: ' . $this->moduleName . ' not found');
        }


        echo "build module: $this->appName - $this->moduleName \n";

        $this->generateBaseClass('Dto', 'DtoBase');
        $this->generateBaseClass('Repo', 'RepoBase');
        $this->generateBaseClass('Service', 'ServiceBase');
        $this->generateBaseClass('Valid', 'ValidBase');
        $this->generateBaseClass('Rest', 'ControllerBase');
        $this->generateBaseClass('Ui', 'ControllerBase');
        $this->generateBaseClass('Open', 'ControllerBase');

        $this->generateRouter();
    }

    protected function tpl($name, $val = [])
    {
        extract($val);

        ob_start();
        include __DIR__ . "/tpl/module/$name.tpl";
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    protected function generateBaseClass($type, $baseClass, $tpl = '')
    {
        $dir = $this->appDir . "/src/{$this->moduleName}/$type";
        $file = $dir . "/$baseClass.php";
        $tpl = $tpl ? $tpl : "$type/$baseClass";

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        if (!file_exists($file)) {
            $content = $this->tpl($tpl, [
                'appName' => $this->appName,
                'moduleName' => $this->moduleName
            ]);
            $content = "<?php\n" . $content;

            file_put_contents($file, $content);

            echo "generate file: $file \n";
        }
    }

    protected function generateRouter()
    {
        $dir = $this->appDir . '/setting/router/';
        if (!is_dir($dir)) {
            throw new \Exception("$dir does not exist");
        }

        $file = $this->appDir . '/setting/router/' . lcfirst($this->moduleName) . '.php';
        if (file_exists($file)) {
            return;
        }

        $content = $this->tpl('router', [
            'appName' => $this->appName,
            'moduleName' => $this->moduleName
        ]);
        file_put_contents($file, "<?php\n" . $content);
        echo "generate router: $file \n";
    }
}
