<?php
define('DEBUG', 'on');
define("WEBPATH", realpath(__DIR__.'/../'));
require __DIR__ . '/../libs/lib_config.php';


$ftpSvr = new Swoole\Network\Protocol\Ftp();

$ftpSvr->users['test'] = array(
    'password' => 'test',
    'home' => '/tmp/',
    'chroot' => true,
);

//$ftpSvr->users['anonymous'] = array(
//    'password' => 'anon@localhost',
//    'home' => '/tmp/',
//    'chroot' => true,
//);

/**
 * 如果你没有安装swoole扩展，这里还可选择
 * BlockTCP 阻塞的TCP，支持windows平台
 * SelectTCP 使用select做事件循环，支持windows平台
 * EventTCP 使用libevent，需要安装libevent扩展
 */
$server = new \Swoole\Network\SelectTCP('0.0.0.0', 21);
$server->setProtocol($ftpSvr);
$server->run(array('worker_num' => 1));