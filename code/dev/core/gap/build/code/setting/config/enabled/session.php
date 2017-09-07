<?php
$this
    ->set('session', [
        'cookie_domain' => $this->get('baseHost'),
        'cookie_path' => '/',
        'cookie_lifetime' => 86400000,
        'gc_maxlifetime' => 86400000,
        'name' => 'IPARSESS',
        'save_handler' => 'redis',
        'save_path' => $this->get('local.session.save_path')
    ]);
