<?php
$this
    ->set('secure', [
        'fetchUserService' => 'Openmessage\User\User\Service\FetchUserService',
        'fetchAclService' => 'Openmessage\Acl\Acl\Service\FetchAclService',
        'privilege' => [
            'super' => 100,
            'admin' => 180,
            'root' => 213
        ]
    ]);
