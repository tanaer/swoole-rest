<?php
namespace Swoole;

class Request
{
    /**
     * 文件描述符
     * @var int
     */
    public $fd;
    public $id;

    public $get = array();
    public $post = array();
    public $file = array();
    public $cookie = array();
    public $session = array();
    public $server = array();

    /**
     * @var \StdClass
     */
    public $attrs;

    public $head = array();
    public $body;
    public $meta = array();

    public $finish = false;
    public $ext_name;
    public $status;

    /**
     * 将原始请求信息转换到PHP超全局变量中
     */
    function setGlobal()
    {
        if ($this->get) $_GET = $this->get;
        if ($this->post) $_POST = $this->post;
        if ($this->file) $_FILES = $this->file;
        if ($this->cookie) $_COOKIE = $this->cookie;
        if ($this->server) $_SERVER = $this->server;
        $_REQUEST = array_merge($this->get, $this->post, $this->cookie);
        if (isset($this->head['Host']))
        {
            $_SERVER["HTTP_HOST"] = $this->head['Host'];
        }
        if (isset($this->head['User-Agent']))
        {
            $_SERVER["HTTP_USER_AGENT"] = $this->head['User-Agent'];
        }
        if (!isset($_SERVER['REQUEST_URI']))
        {
            $_SERVER['REQUEST_URI'] = $this->meta['uri'];
        }
    }

    function unsetGlobal()
    {
        $_REQUEST = $_SESSION = $_COOKIE = $_FILES = $_POST = $_SERVER = $_GET = array();
    }
}
