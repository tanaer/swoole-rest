<?php
/**
 * 使用函数方式调用系统功能
 */

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $strict = true) {
    header("Content-type:text/html; charset=utf-8");
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}
/**
 * 创建表名模型的别名函数
 * @param $table_name
 * @return unknown_type
 */
function T($table_name)
{
    return table($table_name);
}
/**
 * 创建模型的别名函数
 * @param $model_name
 * @return unknown_type
 */
function M($model_name)
{
    return model($model_name);
}
/**
 * 执行一条SQL语句并返回结果
 * @param $sql
 * @return unknown_type
 */
function sql($sql,$num=0)
{
	if(empty($sql)) return false;
	global $php;

	//数据库是否连接，对象是否可用，如果不可用则返回false
	if(empty($php->db)) return false;
	else return $php->db->query($sql)->fetchall();
}
function update()
{
	global $php;
	return $php->db->update($id,$data,$table,$where='id');
}
function insert($data,$table)
{
	global $php;
	return $php->db->insert($data,$table);
}
/**
 * 赋值给模板
 * @param $name
 * @param $value
 * @return unknown_type
 */
function assign($name,$value)
{
	global $php;
	return $php->tpl->assign($name,$value);
}
function ref($name,&$value)
{
    global $php;
	return $php->tpl->ref($name,$value);
}
/**
 * 渲染模板
 * @param $tplname
 * @return unknown_type
 */
function display($tplname=null)
{
	global $php;
	return $php->tpl->display($tplname);
}
/**
 * 缓存设置
 * @param $name
 * @param $value
 * @param $time
 * @return unknown_type
 */
function cache_set($name,$value,$time)
{
	global $php;
	return $php->cache->set($name,$value,$time);
}
/**
 * 缓存删除
 * @param $name
 * @return unknown_type
 */
function cache_delete($name)
{
	global $php;
	return $php->cache->delete($name);
}
/**
 * 缓存获取
 * @param $name
 * @return unknown_type
 */
function cache_get($name)
{
	global $php;
	return $php->cache->get($name);
}