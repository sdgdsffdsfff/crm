<?php
session_start();
require_once '../session.php';
require_once '../inc/const.php';
$fid= getvar('fid');
$id= getvar('id');
$act= getvar('act');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script>
function checkreg()
{
if (document.myform.name.value=="") {
	window.alert("类别名称不能为空！！");
	document.myform.name.focus();		
	 return (false);
	}
if (document.myform.rank.value=="") {
	window.alert("排序ID不能为空！！");
	document.myform.rank.focus();		
	 return (false);
	}
	return true;
}
</script>
<link href="../css/admin_css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if($act == "add"){
?>
<table width="98%" height="126" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <form name="myform" action="customer_area_ok.php?act=add" method="post" onSubmit="return checkreg();">
    <tr>
      <td height="24" colspan="2" bgcolor="#555555"><font color="#FFFFFF">&nbsp;<strong>添加地区</strong></font></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">上级地区：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><select name="fid">
          <option value="0">--顶级类别--</option>
          <?php getCategorySelect("area",$fid); ?>
        </select>      </td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">地区名称：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="name" type="text" id="name" size="30" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">排序ID：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="rank" type="text" id="rank" size="20" value="0" /></td>
    </tr>
    <tr>
      <td height="24" bgcolor="#f1f1f1">&nbsp;</td>
      <td height="24" bgcolor="#f1f1f1"><input type="submit" name="button" id="button" value="提交" /> <input type="button" name="back" id="back" value="返回" onclick="javascript:window.history.go(-1);" /></td>
    </tr>
  </form>
</table>
<?php
}
?>
<?php
if($act == "mod"){
	$sql = get_sql("select id,name,fid,rank from {pre}area where id=".$id);
	$list = $db->getonerow($sql);
?>
<table width="98%" height="126" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <form name="myform" action="customer_area_ok.php?act=mod" method="post" onSubmit="return checkreg();">
    <tr>
      <td height="24" colspan="2" bgcolor="#555555"><font color="#FFFFFF">&nbsp;<strong>修改地区</strong></font></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">上级地区：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><select name="fid">
          <option value="0">--顶级地区--</option>
          <?php getCategorySelect("area",$fid); ?>
        </select>      </td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">栏目名称：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="name" type="text" id="name" size="30" value="<?php echo $list['name'];?>" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">排序ID：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="rank" type="text" id="rank" size="20" value="<?php echo $list['rank'];?>" /></td>
    </tr>
    <tr>
      <td height="24" bgcolor="#f1f1f1">&nbsp;</td>
      <td height="24" bgcolor="#f1f1f1"><input type="hidden" value="<?php echo $list['id'];?>" name="id" id="id"><input type="submit" name="button" id="button" value="提交" /> <input type="button" name="back" id="back" value="返回" onclick="javascript:window.history.go(-1);" /></td>
    </tr>
  </form>
</table>
<?php
}
?>
</body>
</html>
