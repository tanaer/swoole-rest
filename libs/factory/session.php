<?php
if (!empty($php->config['session']['use_swoole_sesion']) or defined('SWOOLE_SERVER'))
{
    $cache = \Swoole\Factory::getCache('session');
    $session = new Swoole\Session($cache);
}
else
{
    $session = new Swoole\Session;
}
return $session;