<?php
$baseHost = $this->get('baseHost');

$this->set('site', [
    'www' => [
        'host' => 'www.' . $baseHost,
    ],
    'page' => [
        'host' => 'page.' . $baseHost,
    ],
    'api' => [
        'host' => 'api.' . $baseHost,
    ],
    'static' => [
        'host' => 'static.' . $baseHost,
        'dir' => $this->get('baseDir') . '/site/static',
    ],
    'nos_ipar_upload' => [
        'host' => 'ipar-upload.nos-eastchina1.126.net'
    ],
    'nos_ipar_avt' => [
        'host' => 'ipar-avt.nos-eastchina1.126.net'
    ]
]);
