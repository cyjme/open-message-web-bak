<?php
$this
    ->site('www')
    ->access('public')

    ->get('/createApp', 'createApp', 'Openmessage\MassClient\App\Ui\CreateAppController@show')
    ->get('/apps', 'listApp', 'Openmessage\MassClient\App\Ui\ListAppController@show')
    ->post('/createApp', 'createApp', 'Openmessage\MassClient\App\Ui\CreateAppController@post');
