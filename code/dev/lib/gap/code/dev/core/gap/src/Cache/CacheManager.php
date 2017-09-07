<?php
namespace Gap\Cache;

class CacheManager
{
    protected $cnns;
    protected $optsSet;

    public function __construct($optsSet)
    {
        $this->optsSet = $optsSet;
    }

    public function connect($name)
    {
        if (isset($this->cnns[$name])) {
            return $this->cnns[$name];
        }

        if (!$opts = prop($this->optsSet, $name)) {
            throw new \Exception("cannot find config for cache [$name]");
        }

        if ('redis' === prop($opts, 'adapter', 'redis')) {
            $host = prop($opts, 'host', '127.0.0.1');
            $port = prop($opts, 'port', 6379);
            $database = prop($opts, 'database', 0);

            $redis = new \Redis();
            $redis->connect($host, $port);
            $redis->select($database);

            $this->cnns[$name] = $redis;
        }

        return $this->cnns[$name];
    }
}
