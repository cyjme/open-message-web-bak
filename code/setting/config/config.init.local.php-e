<?php
$this
    ->set('debug', true)
    ->set('baseHost', '{tecposter.com}')
    ->set('local', [
        'db' => [
            'host' => 'db',
            'database' => '{dbDatabase}',
            'username' => '{dbUsername}',
            'password' => '{dbPassword}'
        ],
        'cache' => [
            'host' => 'redis'
        ],
        'session' => [
            'save_path' => 'tcp://redis:6379?database=10'
        ]
    ]);
