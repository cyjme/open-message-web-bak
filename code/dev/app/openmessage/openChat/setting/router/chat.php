<?php
$this
    ->site('www') 
    ->access('public')

    ->postOpen(
        '/open/create-chat',
        'createChat',
        'Openmessage\OpenChat\Chat\Open\CreateChatController@post'
    );
