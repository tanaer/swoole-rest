<?php
define('DEBUG', 'on');
define("WEBPATH", realpath(__DIR__.'/../'));
require __DIR__ . '/../libs/lib_config.php';
//require __DIR__'/phar://swoole.phar';
Swoole\Config::$debug = false;

class EchoServer extends Swoole\Network\Protocol implements Swoole\Server\Protocol
{
    function onReceive($server,$client_id, $from_id, $data)
    {
        $this->server->send($client_id, "Swoole: ".$data);
    }
}
$AppSvr = new EchoServer();
/**
 * 如果你没有安装swoole扩展，这里还可选择
 * BlockTCP 阻塞的TCP，支持windows平台
 * SelectTCP 使用select做事件循环，支持windows平台
 * EventTCP 使用libevent，需要安装libevent扩展
 */
$server = new \Swoole\Network\EventTCP('0.0.0.0', 9505);
$server->setProtocol($AppSvr);
$server->run(array('worker_num' => 1));
