<?php
namespace Swoole\Network;
use Swoole;
/**
 * Class Server
 * @package Swoole\Network
 */
class Server extends \Swoole\Server implements \Swoole\Server\Driver
{
    static $sw_mode = SWOOLE_PROCESS;
    /**
     * @var \swoole_server
     */
    protected $sw;
    protected $swooleSetting;

    function __construct($host, $port, $timeout=0)
    {
        $this->sw = new \swoole_server($host, $port, self::$sw_mode, SWOOLE_SOCK_TCP);
        $this->host = $host;
        $this->port = $port;
        \Swoole\Error::$stop = false;
        \Swoole_js::$return = true;
        $this->swooleSetting = array('timeout' => 2.5,  //select and epoll_wait timeout.
            //'poll_thread_num' => 4,  //reactor thread num
            //'writer_num' => 4,       //writer thread num
            //'worker_num' => 4,       //worker process num
            'backlog' => 128,        //listen backlog
            //'open_cpu_affinity' => 1,
            //'open_tcp_nodelay' => 1,
            'log_file' => '/tmp/swoole.log', 
        );
    }
    function daemonize()
    {
        $this->swooleSetting['daemonize'] = 1;
    }

    function run($setting = array())
    {
        $set = array_merge($this->swooleSetting, $setting);
        $this->sw->set($set);
        $version = explode('.', SWOOLE_VERSION);
        //1.7.0
        if ($version[1] >= 7)
        {
            $this->sw->on('ManagerStart', function($serv){
                global $argv;
                Swoole\Console::setProcessName('php '.$argv[0].': manager');
            });
        }
        $this->sw->on('Start', function ($serv) {
            global $argv;
            Swoole\Console::setProcessName('php ' . $argv[0] . ': master -host=' . $this->host . ' -port=' . $this->port);
        });
        $this->sw->on('WorkerStart', array($this->protocol, 'onStart'));
        $this->sw->on('Connect', array($this->protocol, 'onConnect'));
        $this->sw->on('Receive', array($this->protocol, 'onReceive'));
        $this->sw->on('Close', array($this->protocol, 'onClose'));
        $this->sw->on('WorkerStop', array($this->protocol, 'onShutdown'));
        if (is_callable(array($this->protocol, 'onTimer')))
        {
            $this->sw->on('Timer', array($this->protocol, 'onTimer'));
        }
        if (is_callable(array($this->protocol, 'onTask')))
        {
            $this->sw->on('Task', array($this->protocol, 'onTask'));
            $this->sw->on('Finish', array($this->protocol, 'onFinish'));
        }
        $this->sw->start();
    }

    function shutdown()
    {
        $this->sw->shutdown();
    }

    function close($client_id)
    {
        $this->sw->close($client_id);
    }

    function addListener($host, $port)
    {
        $this->sw->addlistener($host, $port);
    }

    function send($client_id, $data)
    {
        $this->sw->send($client_id, $data);
    }
}
