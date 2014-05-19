<?php
class ajax extends Swoole\Controller
{
    public $is_ajax = true;
/**

 */
    function response($data, $status, $info)
    {
        return array('json' => array(
            'data' => $data,
            'status' => $statue,
            'info' => $info,
        ));
    }
}