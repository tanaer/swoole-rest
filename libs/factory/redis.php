<?php
global $php;
$config = $php->config['redis']['master'];
if (empty($config["host"]))
{
    $php->config['redis']['master']["host"] = '127.0.0.1';
}
if (empty($config["port"]))
{
    $config["port"] = 6379;
}
$redis = new Redis();
$redis->connect($config["host"], $config["port"]);
