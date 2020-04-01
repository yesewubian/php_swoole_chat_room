<?php

use \Swoole\WebSocket\Server;

class WebSocketServer
{
    protected $setting = [

    ];

    protected $server = null;

    public function __construct(string $ip = '0.0.0.0', int $port, array $setting = [])
    {
        $this->server = new Server($ip, $port);
        $this->server->set(array_merge($this->setting, $setting));
    }

    public function bindEvent()
    {
        $this->server->on('start', [$this, 'onStart']);
        $this->server->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('close', [$this, 'onClose']);
        $this->server->on('WorkerError', [$this, 'onWorkerError']);
        return $this;
    }

    public function run()
    {
        $this->server->start();
    }

    public function onStart(\Swoole\Server $server)
    {
        swoole_set_process_name('websocket server master');
    }

    public function onWorkerStart(\Swoole\Server $server, int $workerId)
    {
        swoole_set_process_name(sprintf('websocket server worker: %d', $workerId));
    }

    public function onOpen(Server $server, \Swoole\Http\Request $request)
    {
        echo $request->fd . '上线' . PHP_EOL;
    }

    public function onMessage(Swoole\Websocket\Server $server, Swoole\Websocket\Frame $frame)
    {
        //发言
        echo $data = $frame->fd . ' ：' . $frame->data . PHP_EOL;
        //广播
        foreach ($server->connections as $fd){
            $server->push($fd, $data);
        }
    }

    public function onClose(\Swoole\Server $server, int $fd, int $reactorId)
    {
        echo $fd . '下线' . PHP_EOL;//打印到我们终端
    }

    public function onWorkerError(Swoole\Server $server, int $worker_id, int $worker_pid, int $exit_code, int $signal)
    {
        echo 'error:' . $exit_code . PHP_EOL;//打印到我们终端
    }
}