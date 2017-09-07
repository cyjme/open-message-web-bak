<?php
$baseDir = realpath(__DIR__ . '/../../');
require $baseDir . '/vendor/autoload.php';

//$request = \OAuth2\Request::createFromGlobals();
$request = new \Gap\Open\Request(
    $_GET,
    $_POST,
    array(),
    $_COOKIE,
    $_FILES,
    $_SERVER
);

$response = app($baseDir, 'open')->handle($request);
$response->send();