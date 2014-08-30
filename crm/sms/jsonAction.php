<?php
header('Content-type:text/json');
session_start();
include_once '../session.php'; 
include_once '../inc/const.php';

$json			= getvar("json"); 
$json = str_replace("\\","",$json); 
$act=getvar("act") ? getvar("act") : "search";
if($act=="search"){
$page 			= getvar("page") ? getvar("page") : 1;
$page_size 		= 20;
$sqlstr="select id,type,conditions,title,content,isstop from {pre}sms where 1=1 "; 
$sqlstr = get_sql($sqlstr);
//echo $sqlstr ;
$penson_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
$total_nums = $db->getRowsNum ( $sqlstr );
foreach($penson_list as $vo){
	$output[]=$vo;
} 
if($total_nums==0){
	$output[0]="{id:0,companyName:没有数据}";
	$total_nums=1;
}
$rst['total']=$total_nums;
$rst['rows']=$output;
print(json_encode($rst));
}elseif($act=="mod"){
	$record =  json_decode($json,true);
	if($record["id"] ==0){
		$db->insert($GLOBALS[databasePrefix].'sms',$record);
	}else{
		$db->update($GLOBALS[databasePrefix].'sms',$record,'id='.$record["id"]);
	}
	print($record['id']."修改成功"); 
}elseif($act=="del"){
	$ids=getvar("ids");
	$sqlstr = "delete from {pre}sms where id in (".$ids.")";
	$sqlstr = get_sql($sqlstr); 
	$db->query($sqlstr); 
	print("删除成功"); 

}elseif($act=="add"){
	$record =  json_decode($json,true);
	$db->insert($GLOBALS[databasePrefix].'sms',$record);
	print("新增成功");  
}
?>
