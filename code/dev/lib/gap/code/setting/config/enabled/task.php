<?php
$this->set('task', [
    'server' => [
        'class' => 'Tec\Swoole\Task\Server',
        'host' => '0.0.0.0',
        'port' => 9502,
        'logFile' => $this->get('baseDir') . '/log/task-server.log',
        'debugFile' => $this->get('baseDir') . '/log/task-server-debug.log',
    ],
    'client' => [
        'class' => 'Tec\Swoole\Task\Client',
        'port' => 9502,
        'host' => 'task-server',
        'timeout' => -1
        //'timeout' => 0.1,
    ],
]);
