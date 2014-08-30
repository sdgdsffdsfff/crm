<?php
session_start();
require '../session.php'; 
include '../inc/const.php';

$id = getvar("id");
$id = empty($id)?0:$id;

$page 			= getvar("page") ? getvar("page") : 1;
$page_size 		= 20;
$sqlstr="select * from {pre}dic where isedit=0 ";
if(getvar("act")=="del"){
	$vo = $db->delete($GLOBALS[databasePrefix].'dic',"id=".$id);;
}
if(getvar("act")=="search"){
	if(getvar("type")!=""){
		$sqlstr = $sqlstr . " and type='".getvar("type")."'";
	}
	if(getvar("code")!=""){
		$sqlstr = $sqlstr . " and code='".getvar("code")."'";
	}
	if(getvar("name")!=""){
		$sqlstr = $sqlstr . " and name='".getvar("name")."'";
	}
}
if(getvar("act")=="submit"){
	$record = array(
		'type'		=>getvar("type"), 
		'code'		=>getvar("code"),
		'name'  =>getvar("name"),
		'sort'=>getvar("sort"),
		'remark'=>getvar("remark")
	);
	if($id>0){
		$db->update($GLOBALS[databasePrefix].'dic',$record,'id='.$id);
	}else{ 
		$id = $db->insert($GLOBALS[databasePrefix].'dic',$record);
	}
	
	echo "<script>alert('保存成功!');window.location='customer_dic.php';</script>";
}
if(getvar("act")=="mod"){
	$vo = $db->getOneRow(get_sql("select * from {pre}dic where id = " . $id));
}
$sqlstr=get_sql($sqlstr." order by id asc");
$area_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
$total_nums = $db->getRowsNum ( $sqlstr );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="../css/admin_css.css" rel="stylesheet" type="text/css" />
<link href="../js/boxy.css" rel="stylesheet" type="text/css" />
</head>
<script>
function checkreg()
{
if (document.myform.name.value=="") {
	window.alert("类别名称不能为空！！");
	document.myform.name.focus();		
	 return (false);
	}
if (document.myform.sort.value=="") {
	window.alert("排序ID不能为空！！");
	document.myform.sort.focus();		
	 return (false);
	}
	return true;
}
function onSearch(){
	document.myform.action="customer_dic.php?act=search";
	document.myform.submit();
}
function onSubmit(){
	document.myform.action="customer_dic.php?act=submit";
	document.myform.submit();
}
</script>
<body>
<table width="98%" height="126" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <form name="myform" action="customer_dic.php" method="post" onSubmit="return checkreg();">
    <tr>
      <td height="24" colspan="4" bgcolor="#555555"><font color="#FFFFFF">&nbsp;<strong>添加字典</strong></font></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">类别：</td>
      <td width="87%" height="24" colspan="3"  align="left" valign="middle" bgcolor="#f1f1f1">
        <select name="type" style="width:260px"> 
           	<option value="leveltype">客户等级</option>
           	<option value="sourcetype">客户来源</option>
           	<option value="servicetype">跟进类型</option>
           	<option value="notetype">公告类型</option> 
           	<option value="role">角色</option> 
        </select>      
      </td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">代码：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="code" type="text" id="code" value="<?php echo  $vo['code']?>" size="30" /></td>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">名称：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="name" type="text" id="name" value="<?php echo $vo['name']?>" size="30" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">排序ID：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="sort" type="text" id="sort" value="<?php echo $vo['sort']?>" size="30" /></td>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">备注：</td>
      <td width="37%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><textarea name="remark" type="text" id="remark" row=5 style="width:260px"><?php echo $vo['remark']?></textarea></td>
    </tr>
    <tr>
      <td height="24" bgcolor="#f1f1f1" colspan="4"> 
      <input name="id" type="hidden" id="id" value="<?php echo $vo['id'];?>"/>
      <input type="button" class="button orange" name="button" id="button" value="查询" onclick="onSearch()" />
      <input type="button" class="button blue" name="button" id="button" value="保存" onclick="onSubmit()" />
      </td>
    </tr>
  </form>
</table><br />
<table width="98%" height="94" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <thead>
  <tr bgcolor="#f9f9f9">
    <td width="5%" height="24" align="center" valign="middle">ID</td>
    <td width="20%" height="24" align="center" valign="middle">类别</td>
    <td width="20%" height="24" align="center" valign="middle">代码</td>
    <td align="center" valign="middle">名称</td>
    <td align="center" valign="middle">排序</td>
    <td align="center" valign="middle">备注</td>
    <td width="25%" height="24" align="center" valign="middle">操作</td>
  </tr>
  </thead>
  <?php
  	foreach($area_list as $list){ 
  ?>
  <tr bgcolor="#f9f9f9">
    <td width="5%" height="24" align="center" valign="middle"><?php echo $list['id'];?></td>
    <td align="center" valign="middle"><?php echo $list['type'];?></td>
    <td align="center" valign="middle"><?php echo $list['code'];?></td>
    <td height="24" align="center" valign="middle"><a href="customer_dic.php?act=mod&id=<?php echo $list['id'];?>"><?php echo $list['name'];?></a></td>
    <td align="center" valign="middle"><?php echo $list['sort'];?></td>
    <td align="center" valign="middle"><?php echo utf_substr($list['remark'],20);?></td>
    <td  height="24" align="center" valign="middle"><a href="customer_dic.php?act=mod&id=<?php echo $list['id']; ?>&page=<?php echo $page;?>"><img src="../images/edit.gif" border="0" /></a> 
    <a href="customer_dic.php?id=<?php echo $list['id']; ?>&act=del" onClick="javascript:return confirm('确实要删除吗?')"><img src="../images/del.gif" border="0" /></a></td>
  </tr>
  <?php
	}
  ?>
  <script>document.all.type.value="<?=$vo['type']?>"</script>
  <tr>
    <td height="24" colspan="4" bgcolor="#F8FCF6"><?php page($sqlstr,$page_size,"customer_area.php?page",$page);?></td>
  </tr>
</table>
</body>
</html>
