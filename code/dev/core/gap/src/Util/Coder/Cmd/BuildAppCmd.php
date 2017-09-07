<?php
namespace Gap\Util\Coder\Cmd;

class BuildAppCmd extends AppCmdBase
{
    protected $baseAppName = '';

    public function run()
    {
        //parent::run();

        /*
        if ($this->appName) {
            throw new \Exception($this->appName . ' already existed');
        }
         */

        $this->appName = $this->input . "\\";
        $this->appDir = $this->extractAppDir($this->appName);

        if (isset($this->argv[3]) && '-b' == $this->argv[3]) {
            if ($baseInput = $this->argv[4]) {
                $baseInput = $this->formatInput($baseInput);
                $baseAppName = $baseInput . "\\";

                $appConfig = $this->config->getConfig('app');
                if (!$appConfig->get($baseAppName)) {
                    throw new \Exception("cannot find base app  $baseAppName");
                }
                $this->baseAppName = $baseAppName;
            }
        }



        echo "build app: $this->appName \n";

        $this->makeDir('phpunit');
        $this->makeDir('setting/config');
        $this->makeDir('setting/router');
        $this->makeDir('front/js');
        $this->makeDir('front/scss');
        $this->makeDir('view');
        $this->makeDir('src');

        $this->generateBaseClass('Dto', 'DtoBase');
        $this->generateBaseClass('Repo', 'RepoBase');
        $this->generateBaseClass('Service', 'ServiceBase');
        $this->generateBaseClass('Valid', 'ValidBase');
        $this->generateBaseClass('Rest', 'ControllerBase');
        $this->generateBaseClass('Ui', 'ControllerBase');
        $this->generateBaseClass('Open', 'ControllerBase');

        $this->buildAppConfig();
        $this->buildComposer();
        $this->buildPhpunit();
    }

    protected function tpl($name, $val = [])
    {
        extract($val);

        ob_start();
        include __DIR__ . "/tpl/app/$name.tpl";
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    protected function makeDir($subDir)
    {
        $dir = $this->appDir . '/' . $subDir;

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $gitignore = $dir . '/.gitignore';

        if (!file_exists($gitignore)) {
            touch($gitignore);
        }
    }

    protected function generateBaseClass($type, $baseClass, $tpl = '')
    {
        $dir = $this->appDir . "/src/Base/$type";
        $file = $dir . "/$baseClass.php";
        $tpl = $tpl ? $tpl : "$type/$baseClass";

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        if (!file_exists($file)) {
            $baseAppName = $this->baseAppName ? $this->baseAppName . "Base\\" : 'Gap\Contract\\';
            $content = $this->tpl($tpl, ['appName' => $this->appName, 'baseAppName' => $baseAppName]);
            $content = "<?php\n" . $content;

            file_put_contents($file, $content);

            echo "create file: $file \n";
        }
    }

    protected function buildAppConfig()
    {
        echo "buildAppConfig \n";

        $appPath = $this->extractAppPath($this->appName);

        $appAsm = $this->config->get('app', []);
        $appAsm[$this->appName] = [
            'dir' => "/dev/app" . $appPath
        ];

        $this->saveAppConfig($appAsm);
    }

    protected function buildComposer()
    {
        echo "buildComposer \n";

        $composerAsm = json_decode(file_get_contents($this->baseDir . '/../composer.json'), true);

        $appPath = $this->extractAppPath($this->appName);
        $composerAsm['autoload']['psr-4'][$this->appName]
            = "code/dev/app{$appPath}/src/";

        $composerAsm['autoload-dev']['psr-4']["cmdtest\\{$this->appName}"]
            = "code/dev/app{$appPath}/cmdtest/";

        $this->saveComposer($composerAsm);
    }

    protected function buildPhpunit()
    {
        echo "buildPhpunit \n";
        $appAsm = $this->app->getConfig()->get('app', []);
        $appAsm[$this->appName] = 'newApp';

        $this->savePhpunit($appAsm);
    }
}
