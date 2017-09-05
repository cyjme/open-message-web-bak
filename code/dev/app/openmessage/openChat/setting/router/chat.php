<?php
$this
    ->site('www')
    ->access('public')

    ->get(
        '/chat',
        'landChat',
        'Openmessage\OpenChat\Chat\Ui\LandChatController@show'
    )
    ->postOpen(
        '/open/create-chat',
        'createChat',
        'Openmessage\OpenChat\Chat\Open\CreateChatController@post'
    );
