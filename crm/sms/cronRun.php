<?php
//session_start();
//include_once '../session.php'; 
include_once '../inc/const.php';

require_once 'HttpClient.class.php'; 
require_once 'smsClass.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

//关掉浏览器，PHP脚本也可以继续执行.
//ignore_user_abort();
// 通过set_time_limit(0)可以让程序无限制的执行下去
//set_time_limit(0);
// 每天运行
//$interval=60*60*24;
//$interval=60*60*24;
//$interval=10;
//do{
	

$run = include 'config.php';
//if(!$run) die("短信发送停止"); 
//if($run) print("短信发送开始");
flush(); 
ob_flush(); 
//if($interval/60==0){
//这里是你要执行的代码 
$cron_arr = $db->getList (get_sql("SELECT * FROM {pre}sms WHERE isstop ='0'" ));
 
foreach ( $cron_arr as $cron ) {
	$sql = $cron ['conditions'];
	$title = $cron ['title']; 
	$customer_arr=$db->getList(get_sql($sql));
	
	foreach ( $customer_arr as $customer ) {///循环发送信息
		$mobile=$customer['mobile'];
		$name=$customer['NAME']; 
		 
		$title2=str_replace("#name#",$name,$title);
		//$title2=$mobile ."发送短信：". $title2;
		
		$record = array(
		'type'		=>"01",
		'name'		=>$title2,
		'dateline'		=>date('Y-m-d h-m-s'),
		'remindTime'	=>"",
		'userid'		=>"system",
		'fid'	=>$customer['ID']
	);
	$sid = $db->insert($GLOBALS[databasePrefix].'services',$record); 
	
	
		//dlswSdk::sendSms( 'qxinfo@163.com', 'ab8a292372d3e8ad983fd8d323816e12',$title.'【旗云科技】',$mobile)		
	}
	 
} 
//}
//sleep($interval);// 等待5分钟
//}while(true);
?>