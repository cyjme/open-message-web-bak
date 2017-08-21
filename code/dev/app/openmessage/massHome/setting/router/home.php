<?php
$this
    ->site('www')
    ->access('public')

    ->get(
        '/',
        'massHome',
        'Openmessage\MassHome\Home\Ui\HomeController@show'
    );
