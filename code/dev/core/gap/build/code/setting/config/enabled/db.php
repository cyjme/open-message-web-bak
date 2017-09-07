<?php
$localDbHost = $this->get('local.db.host');
$localDbUsername = $this->get('local.db.username');
$localDbPassword = $this->get('local.db.password');
$localDatabase = $this->get('local.db.database');

$this
    ->set('db', [
        'default' => [
            'driver' => 'mysql',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'database' => $localDatabase,
            'host' => $localDbHost,
            'username' => $localDbUsername,
            'password' => $localDbPassword
        ],
        'i18n' => [
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'driver' => 'mysql',
            'database' => $localDatabase,
            'host' => $localDbHost,
            'username' => $localDbUsername,
            'password' => $localDbPassword
        ],
        'meta' => [
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'driver' => 'mysql',
            'database' => $localDatabase,
            'host' => $localDbHost,
            'username' => $localDbUsername,
            'password' => $localDbPassword
        ],
    ]);
