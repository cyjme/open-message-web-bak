<?php
namespace Gap\Third\Swoole\App;

use swoole_server;
use Gap\Contract\Task\Task;
use Gap\App\App;

class ServerApp extends App
{
    protected $serv;
    protected $debugFile;

    protected $type = 'task-server';

    public function __construct($baseDir)
    {
        parent::__construct($baseDir);

        $taskServerConfig = $this->config->getConfig('task.server');

        $host = $taskServerConfig->get('host');
        $port = $taskServerConfig->get('port');
        $logFile = $taskServerConfig->get('logFile');
        $debugFile = $this->isDebug ? $taskServerConfig->get('debugFile') : '';

        $this->serv = new swoole_server($host, $port);
        $this->debugFile = $debugFile;
        //$this->debug = $debugFile ? true : false;

        $this->isDebug ?
            $this->serv->set([
                'task_worker_num' => 1,
                'log_file' => $logFile
            ])
            :
            $this->serv->set([
                'task_worker_num' => 8,
                'log_file' => $logFile,
                'daemonize' => true
            ]);

        $this->serv->on('Receive', [$this, 'onReceive']);
        $this->serv->on('Task', [$this, 'onTask']);
        $this->serv->on('Finish', [$this, 'onFinish']);
    }

    public function run()
    {
        $this->serv->start();
    }

    public function onReceive($serv, $clientFd, $fromId, $data)
    {
        $taskId = $serv->task($data);
        $serv->send($clientFd, 1);
        $serv->close($clientFd);

        $this->debugLog("receive: [from:$fromId], [task:$taskId], [data: $data] \n");
    }

    public function onTask($serv, $taskId, $fromId, $data)
    {
        list($workerClass, $taskName, $taskAttrs, $taskCreated) = json_decode($data, true);
        $task = new Task($taskName, $taskAttrs);
        $task->setCreated($taskCreated);

        try {
            $worker = new $workerClass($this);
            $worker->setTask($task);
            $worker->work();

            $this->debugLog("task: [from:$fromId], [task:$taskId], [data: $data] \n");
        } catch (\Exception $e) {
            if ($this->isDebug) {
                $serv->reload();
            }
            $this->debugLog($this->printR($e));
        }
    }

    public function onFinish($serv, $clientFd, $data)
    {
        $this->debugLog("finish: [clientFd: $clientFd], [data: $data]");

        if ($this->isDebug) {
            $this->debugLog($this->printR($serv->stats()));
        }
    }

    public function reload()
    {
        $this->serv->reload();
    }

    protected function debugLog($log)
    {
        echo $log . "\n";
        /*
        if ($this->isDebug) {
            file_put_contents($this->debugFile, $log, FILE_APPEND);
        }
         */
    }

    protected function printR($mixed = null)
    {
        ob_start();
        print_r($mixed);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
