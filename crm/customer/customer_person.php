<?php
session_start();
require '../session.php'; 
include '../inc/const.php'; 
$id = getvar('id');
$cid = getvar('cid');
if(empty($id) && empty($cid)){
	echo "非法入侵，你想干嘛呢";
	exit;
}
if(getvar("act")=="del"){
	$record = array(
		'isdel'=>1,
		'updatetime' =>date('Y-m-d h-m-s'),
		'updateuser' =>$_SESSION['username']
	);
	$db->update($GLOBALS[databasePrefix].'person',$record,'id='.$id);
	echo "<script>alert('删除成功!');window.location='customer_action.php?tab=2&page=1&act=mod&id=".$cid."'</script>";
}
if(getvar("act")=="add"){
	$record = array(
		'cid'=>$cid,
		'name'		=>getvar('name'),
		'tel'		=>getvar('tel'),
		'mobile'		=>getvar('mobile'),
		'email'		=>getvar('email'),
		'address'		=>getvar('address'),
		'msn' =>getvar('msn'),
		'skype' =>getvar('skype'), 
		'remark' =>getvar('remark'), 
		'isdel'=>0,
		'updatetime' =>date('Y-m-d h-m-s'),
		'updateuser' =>$_SESSION['username']
	);
	if($id>0){
		$db->update($GLOBALS[databasePrefix].'person',$record,'id='.$id);
	}else{
		$db->insert($GLOBALS[databasePrefix].'person',$record);
	}
	echo "<script>alert('保存成功!');window.location='customer_action.php?tab=2&page=1&act=mod&id=".$cid."'</script>";
}
$id = empty($id)?0:$id;
$sqlstr=get_sql("select * from {pre}person where id=".$id."  order by id asc"); 
$vo = $db->getonerow($sqlstr);
$cid = empty($cid)?$vo['cid']:$cid;
?>
<div id="divperson">
<link href="../js/boxy.css" rel="stylesheet" type="text/css" /> 
<form name="myform2" method="post" enctype="multipart/form-data" action="customer_person.php?act=add"> 
<table width="98%" height="126" border="0" style="border: 0px;">
   <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">姓名：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input type="text" name="name" id="name" value="<?=$vo['name']?>" size="30" /></td> 
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">电话：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input type="text" name="tel"  id="tel" value="<?=$vo['tel']?>" size="30" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">手机：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input type="text" name="mobile" value="<?=$vo['mobile']?>" size="30" /></td>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">email：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input type="text" name="email" value="<?=$vo['email']?>" size="30" /></td>
    </tr>
      <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">skype：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input type="text" name="skype" value="<?=$vo['skype']?>" size="30" /></td>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">msn：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input type="text" name="msn" value="<?=$vo['msn']?>" size="30" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">地址：</td>
      <td width="87%" height="24" colspan="3" align="left" valign="middle" bgcolor="#f1f1f1"><input type="text" name="address" value="<?=$vo['address']?>" size="80" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">备注：</td>
      <td width="87%" height="24" colspan="3" align="left" valign="middle" bgcolor="#f1f1f1"><textarea name="remark" cols="70" rows="4"><?=$vo['remark']?></textarea></td>
    </tr>
    <tr>
      <td height="24" align="center" bgcolor="#f1f1f1" colspan="4">
      <input type="hidden" name="cid" value="<?=$cid?>" size="30" />
      <input type="hidden" name="id" value="<?=$id?>" size="30" />
       <input type="submit" name="button" class="button blue" id="button" value="提交" />
       </td>
    </tr>
</table>  
   
  </form>
</div>
</html>
