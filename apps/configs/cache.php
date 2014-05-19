<?php
$cache['session'] = array(
  'type' => 'FileCache',
);
$cache['master'] = array(
    'type' => 'Memcache',
);
return $cache;