<?php
$this
    ->site('www')
    ->access('public')

    ->getRest(
        '/api/fetch-upload-token',
        'fetchUpToken',
        'Openmessage\Startup\Qiniu\Rest\FetchUpTokenController@show'
    )
    ->postRest(
        '/api/delete-qiniu-resource',
        'deleteQiniuResource',
        'Openmessage\Startup\Qiniu\Rest\DeleteQiniuResourceController@post'
    );
