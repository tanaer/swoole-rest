<?php
namespace Swoole\Network;

/**
 * 协议基类，实现一些公用的方法
 * @package Swoole\Network
 */
class Protocol
{
    public $default_port;
    public $default_host;
    /**
     * @var \Swoole\IFace\Log
     */
    public $log;

    /**
     * @var \Swoole\Server
     */
    public $server;

    /**
     * @var array
     */
    protected $clients;

    /**
     * 设置Logger
     * @param $log
     */
    function setLogger($log)
    {
        $this->log = $log;
    }

    /**
     * 打印Log信息
     * @param $msg
     * @param string $type
     */
    function log($msg, $type = 'INFO')
    {
        $this->log->put($type, $msg);
    }

    function onStart($server)
    {

    }
    function onConnect($server, $client_id, $from_id)
    {

    }
    function onClose($server, $client_id, $from_id)
    {

    }
    function onShutdown($server)
    {

    }
}