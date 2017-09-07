<?php
namespace Gap\Third\Swoole\App;

use swoole_websocket_server;
use Gap\Contract\Task\Task;
use Gap\App\App;
use Gap\Third\Swoole\Message\Acc;
use Gap\Third\Swoole\Message\Msg;

class MsgApp extends App
{
    protected $serv;
    protected $debugFile;
    protected $acc;

    protected $type = 'task-server';

    public function __construct($baseDir)
    {
        parent::__construct($baseDir);

        $msgServerConfig = $this->config->getConfig('msg.server');

        $host = $msgServerConfig->get('host');
        $port = $msgServerConfig->get('port');
        $logFile = $msgServerConfig->get('logFile');
        $debugFile = $this->isDebug ? $msgServerConfig->get('debugFile') : '';

        // $this->serv = new swoole_server($host, $port);

        $this->serv = new swoole_websocket_server($host, $port);
        $this->debugFile = $debugFile;
        //$this->debug = $debugFile ? true : false;
        $this->acc = new Acc($this);
        $this->msg = new Msg($this);

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

        $this->serv->on('Task', [$this, 'onTask']);
        $this->serv->on('Finish', [$this, 'onFinish']);

        $this->serv->on('open', [$this, 'onOpen']);
        $this->serv->on('message', [$this, 'onMessage']);
        $this->serv->on('close', [$this, 'onClose']);
    }

    public function onOpen($server, $request)
    {
        echo "test open";
        echo "server: handshake success with fd{$request->fd}\n";
    }

    public function onMessage($serv, $frame)
    {
        $msg = $frame->data;
        $msg = $this->msg->handleMsg($msg, $frame->fd);

        if ($msg->type === "push") {
            $serv->push($frame->fd, 'ok');
        }

        foreach ($msg->fds as $fd) {
            $serv->push($fd, json_encode($msg));
        }
    }

    public function onClose($server, $fd)
    {
         echo "test close";
         echo "client {$fd} closed\n";
    }

    public function run()
    {
        echo "msgApp run";
        $this->serv->start();
        echo "msgApp run end";
    }

    public function onTask($serv, $taskId, $fromId, $data)
    {
        // 不再从 redis list 中读取数据
        // $redis = $this->getCmg()->connect('msg');
        // while (true) {
        //     if ($redis->lsize('msg_list') > 0) {
        //         $msg = $redis -> rpop('msg_list');
        //         $msg = $this->msg->handleMsg($msg);
        //         foreach($msg->fds as $fd){
        //             $serv->msg($fd, $msg->content);
        //         }
        //     } else {
        //     }
        // }
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
