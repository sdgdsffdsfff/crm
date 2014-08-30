<?php 
session_start();
require_once '../session.php';
require_once '../inc/const.php';

$act = trim($_GET['act']);
$id = getvar('id');
$id=empty($id)?0:$id;

$username = getvar("username");
$password = getvar("password");
$addtime = date("Y-m-d H:i:s");
$supermanager = getvar('supermanager');
$usermenu = getvar('usermenu');
$pid=getvar("pid");
//添加数据
if ($act=='add') {
	
	if(empty($password)){
		$record = array(
		'username'		=>$username, 
		'usermenu'		=>$usermenu, 
		'addtime'		=>$addtime,
		'supermanager'  =>$supermanager,
		'pid'=>$pid
	);
	}else{
		$record = array(
			'username'		=>$username,
			'password'		=>md5($password ),
			'addtime'		=>$addtime,
			'usermenu'		=>$usermenu, 
			'supermanager'  =>$supermanager,
			'pid'=>$pid
		);
	}
	if($id>0){
		if(check_username($username,$id)){
			exit("<script>alert('修改用户 ".$username." 已经存在!');window.history.go(-1)</script>");
		}
		$db->update($GLOBALS[databasePrefix].'manager',$record,'id='.$id);
		echo "<script>alert('修改成功!');window.location='admin_manage.php';</script>";
	}else{
		if(check_username($username)){
			exit("<script>alert('用户 ".$username." 已经存在!');window.history.go(-1)</script>");
		}
		$id = $db->insert($GLOBALS[databasePrefix].'manager',$record);
		echo "<script>alert('添加成功!');window.location='admin_manage.php';</script>";
	}
	
	
}
//修改
if ($act=='mod'){
	
	$record = array(
		'username'		=>$username,
		'password'		=>md5($password )
	);
	if(check_username($username,$id)){
			exit("<script>alert('用户 ".$username." 已经存在!');window.history.go(-1)</script>");
		}
	$db->update($GLOBALS[databasePrefix].'manager',$record,'id='.$id);
	echo "<script>alert('修改成功!');window.location='admin_mod.php?id=".$id."';</script>";
}

//删除
if ($act=='del') {	
	//$where = "id=".$id;
	$record = array(
		'managerid'		=>''
	);
	$db->delete($GLOBALS[databasePrefix].'manager',"id=".$id);
	$db->update($GLOBALS[databasePrefix].'customer',$record,"id=".$id);
	
	echo "<script>alert('删除成功!');window.location='admin_manage.php';</script>";
}

function check_username($username,$id=0){
	global $db; 
	if($id==0){
		return $db->getRowsNum(get_sql("select id,username from {pre}manager where username='".$username."'"));
	}else{
		return $db->getRowsNum(get_sql("select id,username from {pre}manager where id!=" . $id . " and username='".$username."'"));
	}
}

?>
