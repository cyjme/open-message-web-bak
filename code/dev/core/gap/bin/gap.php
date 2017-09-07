#!/usr/bin/env php
<?php
$baseDir = realpath(__DIR__ . '/../../../../');
require $baseDir . '/vendor/autoload.php';

obj(new \Gap\App\Console\ConsoleApp($baseDir))->cmd($argv);
