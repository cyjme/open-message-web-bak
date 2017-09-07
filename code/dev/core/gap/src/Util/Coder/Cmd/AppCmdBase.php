<?php
namespace Gap\Util\Coder\Cmd;

class AppCmdBase extends BuildCmdBase
{
    protected function saveAppConfig($appAsm)
    {
        $baseDir = $this->baseDir;

        $codes = [];
        $codes[] = '<?php';
        $codes[] = '$this';
        $codes[] = "    ->set(\"app\", [";
        foreach ($appAsm as $appName => $appOpts) {
            $appName = str_replace("\\", "\\\\", $appName);
            $codes[] = "        \"$appName\" => [";
            foreach ($appOpts as $key => $val) {
                $codes[] = "            \"$key\" => \"$val\",";
            }
            $codes[] = "        ],";
        }
        $codes[] = "    ]);";

        file_put_contents(
            $baseDir . '/setting/config/config.app.php',
            implode("\n", $codes) . "\n"
        );
    }

    protected function saveComposer($composerAsm)
    {
        file_put_contents(
            $this->baseDir . '/../composer.json',
            json_encode($composerAsm, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        chdir($this->baseDir . '/../');

        exec('composer dumpautoload');
    }

    protected function savePhpunit($appAsm)
    {
        $codes = [];
        $codes[] = '<phpunit bootstrap="code/bootstrap/autoload-phpunit.php">';
        $codes[] = '    <testsuites>';

        foreach (array_keys($appAsm) as $appName) {
            $appPath = trim($this->extractAppPath($appName), '/');
            $codes[] = "        <testsuite name=\"$appPath\">";
            $codes[] = "            <directory>code/dev/app/$appPath/phpunit</directory>";
            $codes[] = "        </testsuite>";
        }

        $codes[] = "        <testsuite name=\"gap\">";
        $codes[] = "            <directory>code/dev/core/gap/phpunit</directory>";
        $codes[] = "        </testsuite>";

        $codes[] = '    </testsuites>';
        $codes[] = '</phpunit>';

        file_put_contents(
            $this->baseDir . '/../phpunit.xml',
            implode("\n", $codes) . "\n"
        );
    }
}
