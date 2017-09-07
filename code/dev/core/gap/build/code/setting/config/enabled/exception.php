<?php
// todo
$this->set('exception', [
    'handler' => [
        'notLogin' => 'Gap\ExceptionHandler\NotLoginHandler',
        'noPermission' => 'Gap\ExceptionHandler\NoPermissionHandler'
    ]
]);
