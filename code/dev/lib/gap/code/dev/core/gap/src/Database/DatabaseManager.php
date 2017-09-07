<?php
namespace Gap\Database;

use Gap\Config\ConfigManager;

class DatabaseManager
{
    protected $optsSet;
    protected $cnns;
    protected $serverId;

    public function __construct($optsSet, $serverId)
    {
        $this->optsSet = $optsSet;
        $this->serverId = $serverId;
    }

    public function connect($name)
    {
        if (isset($this->cnns[$name])) {
            return $this->cnns[$name];
        }

        if (!$opts = prop($this->optsSet, $name)) {
            throw new Exception\DatabaseException("Cannot find db: $name");
        }

        $driver = prop($opts, 'driver', 'mysql');
        $host = prop($opts, 'host', '');
        $database = prop($opts, 'database', '');
        $port = prop($opts, 'prot', 3306);
        $username = $opts['username'];
        $password = $opts['password'];
        $charset = prop($opts, 'charset', 'utf8mb4');

        $dsn = "$driver:host=$host;port=$port;dbname=$database;charset=$charset";
        if (!$driver || !$host || !$database) {
            throw new Exception\DatabaseException("$name error db config: $dsn");
        }

        $pdo = new \Pdo(
            $dsn,
            $username,
            $password,
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => false,
                \PDO::MYSQL_ATTR_INIT_COMMAND =>"SET time_zone = '+00:00'"
            ]
        );
        // todo ATTR_PERSISTENT true OR false

        $class = "Gap\\Database\\Connection\\" . ucfirst($driver);
        $this->cnns[$name] = new $class($pdo, $this->serverId);

        return $this->cnns[$name];
    }
}
