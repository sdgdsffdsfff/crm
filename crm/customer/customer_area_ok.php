<?php
session_start();
require_once "../session.php";
require_once '../inc/const.php';
$act = $_GET['act'];
$id =getvar('id');

$fid =getvar('fid');
$name =getvar('name');
$rank=getvar('rank');

if($act=='add'){
	$record = array(
		'fid'		=>$fid,
		'name'		=>$name,
		'rank'		=>$rank,
		'dateline'	=>date("y-m-d H-i-s")
	);
	$id = $db->insert($GLOBALS[databasePrefix].'area',$record);
	echo "<script>alert('添加成功!');window.location='customer_area.php';</script>";
}
if ($act=='mod'){
	$record = array(
		'fid'		=>$fid,
		'name'		=>$name,
		'rank'		=>$rank
	);
	$db->update($GLOBALS[databasePrefix].'area',$record,'id='.$id);
	echo "<script>alert('修改成功!');window.location='customer_area.php';</script>";
}

//删除
if ($act=='del') {
	$db->delete($GLOBALS[databasePrefix].'area','id='.$id);
	echo "<script>alert('删除成功!');window.location='customer_area.php';</script>";
}
?>
