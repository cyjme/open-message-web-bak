<?php
$this
    ->site('www')
    ->access('public')

    ->postOpen(
        '/open/fetchToken',
        'fetchToken',
        'Openmessage\MassClient\Acc\Open\FetchTokenController@post'
    );
