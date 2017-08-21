<?php
$localCacheHost = $this->get('local.cache.host');

$this->set('cache', [
    'default' => [
        'host' => $localCacheHost,
        'database' => 1,
    ],
    'i18n' => [
        'host' => $localCacheHost,
        'database' => 3,
    ],
    'meta' => [
        'host' => $localCacheHost,
        'database' => 4,
    ],
]);
