<?php
namespace Gap\Util\Coder\Cmd;

class BuildEntityCmd extends BuildCmdBase
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
            throw new \Exception('moduleName: cannot be empty');
        }

        if (!$this->layerName) {
            throw new \Exception('layerName cannot be empty');
        }

        if (!$this->entityName) {
            throw new \Exception('EntityName cannot be empty');
        }

        $moduleDir = $this->appDir . '/src/' . $this->moduleName;

        if (!is_dir($moduleDir)) {
            throw new \Exception("{$this->moduleName} does not exist");
        }

        echo "build $this->layerName: $this->input \n";

        $this->generateEntityClass($this->layerName, $this->entityName);
    }

    protected function generateEntityClass($layerName, $entityName)
    {
        $dir = $this->appDir . "/src/{$this->moduleName}/$layerName";
        $file = $dir . "/$entityName.php";
        $tpl = "{$layerName}/{$layerName}Entity";

        if (file_exists($file)) {
            echo "$file has already existed";
            return;
        }

        $content = $this->tpl($tpl, [
            'appName' => $this->appName,
            'moduleName' => $this->moduleName,
            'layerName' => $layerName,
            'entityName' => $entityName
        ]);

        file_put_contents($file, "<?php\n" . $content);
        echo "generate file: $file \n";
    }

    protected function tpl($name, $val = [])
    {
        extract($val);

        ob_start();
        include __DIR__ . "/tpl/entity/$name.tpl";
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
