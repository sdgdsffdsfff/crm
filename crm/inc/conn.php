<?php
//header('Content-Type: text/html; charset=utf-8');
$dbhost = "192.168.0.95"; //数据库地址 
$dbuser = "root"; //MySql数据库用户名 
$dbpass = "123456"; //MySql数据库密码 
$dbname = "crm20140704"; //MySql数据库名称
$dbcharset = "utf8"; //数据库读写所采用的编码,utf8或gb2312

if(empty($dbname)){
	echo '<script>top.location="install.php";</script>';
}

require_once 'db_function.php';	//数据库操作类
require_once 'function.php';   //引用函数

/*------------------------------------------------
 * 数据库连接
 *-----------------------------------------------*/
$db = new db_mysql();
$db->connect($dbhost,$dbuser,$dbpass,$dbname,$dbcharset);
//mysql_query("set names utf8");

/*防止 PHP 5.1.x 使用时间函数报错*/
if(function_exists('date_default_timezone_set')) date_default_timezone_set('PRC');
?>