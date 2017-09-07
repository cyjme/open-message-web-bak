<?php
namespace Openmessage\Auth\Reg\Service;

use Gap\App\App;

class VerifyEmailService extends ServiceBase
{
    protected $cache;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->cache = $this->app->getCmg()->connect('default');
    }

    public function generateCode($email, $effectiveTime)
    {
        $code = mt_rand(100000, 999999);

        $this->cache->set($email . '_code', $code, $effectiveTime);

        return $code;
    }

    public function verify($email, $code)
    {
        if ($code !== $this->cache->get($email . '_code')) {
            return false;
        }

        return true;
    }
}
