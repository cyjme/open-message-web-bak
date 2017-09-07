<?php
$this
    ->site('www')
    ->access('public')

    ->postOpen(
        '/open/upload',
        'apiUpload',
        'Openmessage\Startup\Upload\Rest\UploadController@post'
    );
