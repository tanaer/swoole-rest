<?php
$db['master'] = array(
    'type'    => Swoole\Database::TYPE_MYSQLi,
    'host'    => "localhost",
    'port'    => 3306,
    'dbms'    => 'mysql',
    'engine'  => 'MyISAM',
    'user'    => "root",
    'passwd'  => "leying888",
    'name'    => "Analysis",
    'charset' => "utf8",
    'setname' => true,
);
return $db;