<?php
$this
    ->site('www')
    ->access('acl')

    ->postRest(
        '/api/list-trans-group',
        'listTransGroup',
        'Openmessage\Startup\Trans\Rest\ListTransGroupController@post'
    )
    ->postRest(
        '/api/create-trans-group',
        'createTransGroup',
        'Openmessage\Startup\Trans\Rest\CreateTransGroupController@post'
    );
