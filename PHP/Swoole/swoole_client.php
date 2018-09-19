<?php
/*$client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
//设置事件回调函数
$client->on("connect", function($cli) {
   $cli->send("hello world\n");
});
$client->on("receive", function($cli, $data){
   echo "Received: ".$data."\n";
});
$client->on("error", function($cli){
   echo "Connect failed\n";
});
$client->on("close", function($cli){
   echo "Connection close\n";
});
//发起网络连接
$client->connect('127.0.0.1', 9502, 0.5);*/


class Client
{
    private $client;

    public function __construct() {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
    }

    public function connect() {
        if( !$this->client->connect("127.0.0.1", 9501 , 1) ) {
            echo "Error: {$this->client->errMsg}[{$this->client->errCode}]\n";
        }

        fwrite(STDOUT, "请输入消息 Please input msg：");
        $msg = trim(fgets(STDIN));
        $this->client->send( $msg );

        $message = $this->client->recv();
        echo "Get Message From Server:{$message}\n";
    }
}

$client = new Client();
$client->connect();