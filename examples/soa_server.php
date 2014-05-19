<?php
define('DEBUG', 'on');
define("WEBPATH", str_replace("\\","/", __DIR__));
require __DIR__.'/../libs/lib_config.php';

$AppSvr = new Swoole\Network\Protocol\SOAServer;
$AppSvr->setLogger(new \Swoole\Log\EchoLog(true)); //Logger
$AppSvr->addNameSpace('BL', __DIR__.'/class');

Swoole\Error::$echo_html = false;
$server = new \Swoole\Network\SelectTCP('0.0.0.0', 8888);
$server->setProtocol($AppSvr);
//$server->daemonize(); //作为守护进程
$server->run(array('worker_num' => 5, 'max_request' => 5000));