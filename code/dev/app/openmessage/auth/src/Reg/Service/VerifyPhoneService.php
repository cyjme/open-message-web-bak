<?php
namespace Openmessage\Auth\Reg\Service;

use Gap\App\App;

class VerifyPhoneService extends ServiceBase
{
    protected $cache;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->cache = $this->app->getCmg()->connect('default');
    }

    public function generateCode($phone, $effectiveTime)
    {
        $code = mt_rand(100000, 999999);

        $this->cache->set($phone . '_code', $code, $effectiveTime);

        return $code;
    }

    public function verify($phone, $code)
    {
        if ($code !== $this->cache->get($phone . '_code')) {
            return false;
        }

        return true;
    }
}
