<?php
define('DEBUG', 'on');
define("WEBPATH", realpath(__DIR__.'/../'));

require __DIR__ . '/../libs/lib_config.php';

$AppSvr = Swoole\Network\Protocol\WebServer::create(__DIR__.'/swoole.ini');
Swoole\Config::$debug = false;

$AppSvr->setAppPath(WEBPATH.'/apps/'); //设置应用所在的目录
$AppSvr->setDocumentRoot(WEBPATH);
$AppSvr->setLogger(new \Swoole\Log\EchoLog(__DIR__."/webserver.log")); //Logger

Swoole\Error::$echo_html = true;

/**
 * 如果你没有安装swoole扩展，这里还可选择
 * BlockTCP 阻塞的TCP，支持windows平台
 * SelectTCP 使用select做事件循环，支持windows平台
 * EventTCP 使用libevent，需要安装libevent扩展
 */
$server = new \Swoole\Network\SelectTCP($AppSvr->default_host, $AppSvr->default_port);
$server->setProtocol($AppSvr);
//$server->daemonize(); //作为守护进程
$server->run(array('worker_num' => 1, 'max_request' => 5000, 'log_file' => '/tmp/swoole.log'));
