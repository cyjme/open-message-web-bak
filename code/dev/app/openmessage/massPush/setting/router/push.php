<?php
$this
    ->site('www')
    ->access('public')

    ->get(
        '/app/{appCode:[0-9a-z-]+}/createPush',
        'createPush',
        'Openmessage\MassPush\Push\Ui\CreatePushController@show'
    )
    ->postOpen(
        '/open/createPush',
        'createPush',
        'Openmessage\MassPush\Push\Open\CreatePushController@post'
    );
