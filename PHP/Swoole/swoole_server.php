<?php
/*$serv = new Swoole\Server("127.0.0.1", 9502);
$serv->set(array(
   'worker_num' => 8,   //工作进程数量
   'daemonize' => true, //是否作为守护进程
));
$serv->on('connect', function ($serv, $fd){
   echo "Client:Connect.\n";
});
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
   $serv->send($fd, 'Swoole: '.$data);
   $serv->close($fd);
});
$serv->on('close', function ($serv, $fd) {
   echo "Client: Close.\n";
});
$serv->start();*/


class Server
{
    public $serv;

    public function __construct()
    {
        //实例化一个server类
        $this->serv = new swoole_server('127.0.0.1', 9501);

        $this->serv->set(array(
            'worker_num' => 4,
            'daemonize' => false,
        ));

        $this->serv->on('Start', array($this, 'onStart'));
        $this->serv->on('Connect', array($this, 'onConnect'));
        $this->serv->on('Receive', array($this, 'onReceive'));
        $this->serv->on('Close', array($this, 'onClose'));

        $this->serv->start();
    }

    public function onStart($serv)
    {
        echo 'Start' . PHP_EOL;
    }

    public function onConnect($serv, $fd, $from_id)
    {
        $serv->send($fd, "hello {$fd}!");
    }

    public function onReceive(swoole_server $serv, $fd, $from_id, $data) {
        echo "Get Message From Client {$fd}:{$data}\n";
        $serv->send($fd, $data);
    }

    public function onClose($serv, $fd, $from_id) {
        echo "Client {$fd} close connection\n";
    }
}

$server = new Server();