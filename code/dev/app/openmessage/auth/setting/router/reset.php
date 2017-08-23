<?php
$this
    ->access('public')
    ->site('www')

    ->get(
        '/reset',
        'resetByAccount',
        'Openmessage\Auth\Reg\Ui\ResetByAccountController@show'
    )
    ->post(
        '/reset',
        'resetByAccount',
        'Openmessage\Auth\Reg\Ui\ResetByAccountController@post'
    )
    ->postRest(
        '/user',
        'fetchUserByAccount',
        'Openmessage\Auth\Reg\Rest\FetchUserByAccount@post'
    );