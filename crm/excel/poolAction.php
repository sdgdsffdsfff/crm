<?php 
session_start();
include_once '../session.php'; 
include_once '../inc/const.php';
$json			= getvar("json"); 
$json = str_replace("\\","",$json); 
$act=getvar("act");
if($act=="mod"){
	$record =  json_decode($json,true);
	$db->update($GLOBALS[databasePrefix].'pool',$record,'id='.$record["id"]);
	print($record['id']."成功");
}elseif($act=="mobile"){
	$ids=getvar("ids");
	$sqlstr = " update {pre}pool set mobilecount=mobilecount+1,mobiletime='".date('Y-m-d') ."' where id in (".$ids.")";
	$sqlstr = get_sql($sqlstr); 
	$db->query($sqlstr); 
}elseif($act=="email"){
	$ids=getvar("ids");
	$sqlstr = " update {pre}pool set emailcount=emailcount+1,emailtime='".date('Y-m-d') ."' where id in (".$ids.")";
	$sqlstr = get_sql($sqlstr); 
	$db->query($sqlstr); 
}elseif($act=="del"){
	$ids=getvar("ids");
	$sqlstr = "delete from {pre}pool where id in (".$ids.")";
	$sqlstr = get_sql($sqlstr); 
	$db->query($sqlstr); 
}elseif($act=="copy"){
	$ids=getvar("ids");
	$sqlstr = "INSERT INTO {pre}customer(NAME,httpurl,addr,tel,mobile,qq,email,managerid,dateline,createTime,createUser,services,website) SELECT companyName,name,addr,tel,mobile,qq,email,'',NOW(),NOW(),'".$_SESSION['username']."',remark,url FROM {pre}pool where id in (".$ids.")";
	$sqlstr = get_sql($sqlstr); 
	$db->query($sqlstr); 
	$sqlstr = "delete from {pre}pool where id in (".$ids.")";
	$sqlstr = get_sql($sqlstr); 
	$db->query($sqlstr); 
}
		

//print($record['Id']."成功".var_dump($record)."====".json_last_error());
//
?>
