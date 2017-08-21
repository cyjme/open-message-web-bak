<?php
$baseDir = realpath(__DIR__ . '/../../');
require $baseDir . '/vendor/autoload.php';

$request = new \Gap\Http\Request(
    $_GET,
    $_POST,
    array(),
    $_COOKIE,
    $_FILES,
    $_SERVER
);

//$response = obj(new \Gap\App\Http\HttpApp($baseDir))->handle($request);
//$response = \Gap\App\Factory::http($baseDir)->handle($request);
$response = app($baseDir, 'http')->handle($request);
$response->send();
