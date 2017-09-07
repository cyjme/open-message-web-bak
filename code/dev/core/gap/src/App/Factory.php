<?php
namespace Gap\App;

use Gap\App\Http\HttpApp;
use Gap\App\Console\ConsoleApp;

class Factory
{
    protected static $app;

    public static function http($baseDir)
    {
        self::$app = new HttpApp($baseDir);
        return self::$app;
    }

    public static function console($baseDir)
    {
        self::$app = new ConsoleApp($baseDir);
        return self::$app;
    }

    public static function app()
    {
        return self::$app;
    }
}
