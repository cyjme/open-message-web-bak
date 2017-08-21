<?php
namespace Gap\Third\Swoole;

use swoole_client;
use Gap\Contract\Task\ClientInterface;

class Client implements ClientInterface
{
    protected $client;

    public function __construct($host = '127.0.0.1', $port = 9502, $timeout = 0.1)
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
        $this->client->connect($host, $port, $timeout);
    }

    public function sendTask($workerClass, $taskName, $taskAttrs = [])
    {
        $sent = $this->client->send(json_encode([
            $workerClass,
            $taskName,
            $taskAttrs,
            microtime()
        ]));
        //var_dump($sent);
        if (!$sent) {
            // todo
            throw new \Exception('send failed');
        }

        $recv = $this->client->recv();
        //var_dump($recv);
        if (!$recv) {
            // todo
            throw new \Exception('recv failed');
        }
    }

    public function __destruct()
    {
        $this->client->close();
    }
}
