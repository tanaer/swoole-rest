<?php
namespace Swoole\Network\Protocol;
class UDPQueue implements \Swoole\Server\Protocol
{
    public $queue;
    function __construct($name)
    {
        $this->queue = new FileQueue(array('name'=>$name));
    }
    function onData($peer,$data)
    {
        $this->queue->put($data);
        echo "queue in data:".$data.NL;
    }
    function onStart()
    {
        echo "server running!";
    }

    function onShutdown()
    {
        echo "server shutdown!";
    }
}

class TCPQueue implements \Swoole\Server\Protocol
{
    public $queue;
    function __construct($name)
    {
        $this->queue = new FileQueue(array('name'=>$name));
    }
    function onRecive($client_id,$data)
    {
        $this->queue->put($data);
        $this->server->log("queue in data:".$data.NL);
        $this->server->send($client_id,'ok');
        $this->server->close($client_id);
    }
    function onConnect($client_id)
    {
        $this->server->log("login");
    }
    function onClose($client_id)
    {
        $this->server->log("logout");
    }
    function onStart()
    {
        echo "server running!";
    }
    function onShutdown()
    {
        echo "server shutdown!";
    }
}