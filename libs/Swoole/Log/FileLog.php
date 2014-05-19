<?php
namespace Swoole\Log;
/**
 * 文件日志类
 * @author Tianfeng.Han
 *
 */
class FileLog extends \Swoole\Log implements \Swoole\IFace\Log
{
    private $log_file;
    protected $fp;
    static $date_format = 'Y-m-d H:i:s';

	function __construct($log_file)
    {
    	$this->log_file = $log_file;
        $this->fp = fopen($log_file, 'a+');
        if (!$this->fp)
        {
            throw new \Exception(__CLASS__.": can not open log_file[$log_file]");
        }
    }
	/**
	 * 写入日志
	 * @param $type 事件类型
	 * @param $msg  信息
	 * @return bool
	 */
    function put($type,$msg)
    {
    	$msg = date(self::$date_format).' '.$type.' '.$msg.NL;
    	return fputs($this->fp, $msg);
    }
}
