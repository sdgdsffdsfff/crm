<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_start();
require_once "../session.php";
require_once '../inc/const.php';

$act = $_GET['act'];
$id =getvar('id');
//getvar() 函数在function.php170行
$id = empty($id)?0:$id;
$name 		=getvar('name');
$addr 		=getvar('addr');
$httpurl	=getvar('httpurl');
$tel		=getvar('tel');
$mobile		=getvar('mobile');
$fax 		=getvar('fax');
$email 		=getvar('email');
$qq 		=getvar('qq');
$area 		=getvar('area');
$industry	=getvar('industry');
$rank		=getvar('rank');
$services=getvar('services');
$managerId=getvar('managerId');
$website=getvar('website');
if($act=='add' || $act=='add2'){   
	/*
	*  操作：修改
	*  作用：验证联系电话商户名称是否已经存在
	*  修改时间：2014.7.4
	*  修改人：赵兴壮
	*  修改行：39-89行
	*/
	
	if (empty($name)){
	   echo "<script type='text/javascript' charset='utf-8'>alert('客户名称不能为空!');history.go(-1)</script>";
	   exit();
	}

    $checknamestatus=checkcustomername_add($name);
    if($checknamestatus==0){
    	$checktelstatus=checkcustomertel_add($tel);
    	if($checktelstatus==0){
    	 $record = array(
			'name'		=>$name,
			'addr'		=>$addr,
			'httpurl'	=>$httpurl,
			'website'   =>$website,
			'tel'		=>$tel,
			'mobile'	=>$mobile,
			'fax'		=>$fax,
			'email'		=>$email,
			'qq'		=>$qq,
			'area'		=>$area,
			'industry'	=>$industry,
			'services'	=>$services,
			'rank'		=>$rank, 
			'managerid' =>$_SESSION['username'],
			'msn' =>getvar('msn'),
			'skype' =>getvar('skype'),
			'source' =>getvar('source'),
			'level' =>getvar('level'),
			'createTime' =>date('Y-m-d h-m-s'),
			'createUser' =>$_SESSION['username'],
			'updateTime' =>date('Y-m-d h-m-s'),
			'dateline'	=>date('Y-m-d h-m-s')
			);
			$id = $db->insert($GLOBALS[databasePrefix].'customer',$record);	
			if($act=='add'){
				echo "<script type='text/javascript' charset='utf-8'>alert('添加成功!');window.location='customer_action.php?act=mod&id=".$id."';</script>";
			}else{
				echo "<script type='text/javascript' charset='utf-8'>alert('手机添加成功!');window.location='mcustomer_add.php?act=mod2&id=".$id."';</script>";
			}
    	}
    	else{
    	    echo "<script type='text/javascript' charset='utf-8'>alert('此客户电话已存在!');history.back(-1)</script>";
    	}
    }
    else{
            echo "<script type='text/javascript' charset='utf-8'>alert('此客户名称已存在!');history.back(-1)</script>";
    }
}

if ($act=='mod'||$act=='mod2'){
   /*
	*  操作：修改
	*  作用：更新数据时验证联系电话商户名称是否已经存在
	*  修改时间：2014.7.4
	*  修改人：赵兴壮
	*  修改：98-147行
	*/

    if (empty($name)){
	   echo "<script type='text/javascript' charset='utf-8'>alert('客户名称不能为空!');history.go(-1)</script>";
	   exit();
	}

	$checknamestatus=checkcustomername_up($id,$name);
	if($checknamestatus==0){
	      $checktelstatus=checkcustomertel_up($id,$tel);
		  if($checktelstatus==0)
		   {
	   			$record = array(
					'name'		=>$name,
					'addr'		=>$addr,
					'website'   =>$website,
					'httpurl'	=>$httpurl,
					'tel'		=>$tel,
					'mobile'	=>$mobile,
					'fax'		=>$fax,
					'email'		=>$email,
					'qq'		=>$qq,
					'area'		=>$area,
					'industry'	=>$industry,
					'services'	=>$services, 
					'rank'		=>$rank,
					'msn' =>getvar('msn'),
					'skype' =>getvar('skype'),
					'source' =>getvar('source'),
					'level' =>getvar('level'), 
					'updateTime' =>date('Y-m-d h-m-s'),
					'dateline'	=>date('Y-m-d h-m-s')
				);
				$db->update($GLOBALS[databasePrefix].'customer',$record,'id='.$id);
				if($act=='mod' ){
					echo "<script type='text/javascript' charset='utf-8'>alert('修改成功!".$temp_fwnr."');window.location='customer_action.php?act=mod&id=".$id."';</script>";
				}else{
					echo "<script type='text/javascript' charset='utf-8'>alert('手机修改成功!".$temp_fwnr."');window.location='mcustomer_add.php?act=mod2&id=".$id."';</script>";
				}  
		   }else{
		   	   echo "<script type='text/javascript' charset='utf-8'>alert('此客户电话已存在!');history.back(-1)</script>"; 
		   }
	}else{
		//跳转位置;
		echo "<script type='text/javascript' charset='utf-8'>alert('此客户名称已存在!');history.back(-1)</script>"; 
	}
}

//删除
if ($act=='del') {
	$db->delete($GLOBALS[databasePrefix].'customer','id='.$id);
	$db->delete($GLOBALS[databasePrefix].'services','fid='.$id);
	echo "<script type='text/javascript' charset='utf-8'>alert('删除成功!');window.location='customer_list.php';</script>";
}
//删除
if ($act=='move') {
	$record = array(
		'managerid'		=>getvar("pid")
	);
	$db->update($GLOBALS[databasePrefix].'customer',$record,'id='.$id);
	echo "<script type='text/javascript' charset='utf-8'>alert('转移客户成功!');window.location='customer_list.php';</script>";
}
//公共客户
if ($act=='public') {
	$record = array(
		'name'		=>$name,
		'addr'		=>$addr,
		'httpurl'	=>$httpurl,
		'tel'		=>$tel,
		'mobile'	=>$mobile,
		'fax'		=>$fax,
		'email'		=>$email,
		'qq'		=>$qq,
		'area'		=>$area,
		'industry'	=>$industry,
		'services'	=>$services,
		'rank'		=>$rank, 
		'managerid' =>'',
		'msn' =>getvar('msn'),
		'skype' =>getvar('skype'),
		'source' =>getvar('source'),
		'level' =>getvar('level'),
		'createTime' =>date('Y-m-d h-m-s'),
		'createUser' =>$_SESSION['username'],
		'updateTime' =>date('Y-m-d h-m-s'),
		'dateline'	=>date('Y-m-d h-m-s') 
	);
	if($id>0){
		$db->update($GLOBALS[databasePrefix].'customer',$record,'id='.$id);
	}else{
		$id=$db->insert($GLOBALS[databasePrefix].'customer',$record);
	}
	echo "<script type='text/javascript' charset='utf-8'>alert('公海客户成功!');window.location='customer_list.php?managerid=public';</script>";
}

//删除
if ($act=='delService' || $act=="delService2"){
	
	$sql = get_sql("select * from {pre}services where isdel=0 and pid=".getvar("sid"));
	$rowCount = $db->getRowsNum($sql); 
	if($rowCount>0){
		echo "<script type='text/javascript' charset='utf-8'>alert('请先删除下面的回复！');window.location='customer_action.php?tab=1&act=mod&id=".getvar("id")."';</script>";
		exit;
	}
  $record = array(
		'isdel'		=>'1',
		'userid'    =>$_SESSION['username']
	);
	$db->update($GLOBALS[databasePrefix].'services',$record,'id='.getvar("sid"));
	if($act=="delService2"){
		echo "<script type='text/javascript' charset='utf-8'>window.location.href='mservice_add.php?act=mod&id=".getvar("id")."';</script>";
	}else{
		echo "<script type='text/javascript' charset='utf-8'>window.location='customer_action.php?tab=1&act=mod&id=".getvar("id")."';</script>";
	}
}  

//新增联系小记
if ($act=='addService' || $act=='addService2') {
	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){ 
		$upfile=$_FILES["upfile"]; 
		//获取数组里面的值 
		$name=$upfile["name"];//上传文件的文件名 
		$type=pathinfo($name);//上传文件的类型  
		$size=$upfile["size"];//上传文件的大小 
		$tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径 
		$error=$upfile["error"];//上传后系统返回的值  
		//把上传的临时文件移动到up目录下面 
		$destination=time().".".$type['extension'];
		move_uploaded_file($tmp_name,'../files/'.$destination);
	}
	$record = array(
		'type'		=>getvar("type"),
		'name'		=>getvar("name"),
		'dateline'		=>getvar("dateline"),
		'remindTime'	=>getvar("remindTime"),
		'userid'		=>$_SESSION['username'],
		'fid'	=>getvar("id"),
		'pid'	=>getvar("pid"),
		'filename' =>$destination,
		'orgfilename'=>$name
	);
	$sid = $db->insert($GLOBALS[databasePrefix].'services',$record); 
	if($act=='addService' ){
			echo "<script type='text/javascript' charset='utf-8'>alert('小记成功!');window.location='customer_action.php?tab=1&act=mod&id=".getvar("id")."';</script>";
	}else{
			echo "<script type='text/javascript' charset='utf-8'>alert('手机小记成功!');window.location.href='mservice_add.php?act=mod&id=".getvar("id")."';</script>";
	}
}
?>
