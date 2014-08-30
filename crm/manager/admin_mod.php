<?php session_start();
//echo $_SESSION['username'];
require '../session.php'; 
include '../inc/const.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script>
function checkreg()
{
if (document.myform.username.value=="") {
	window.alert("用户名不能为空！！");
	document.myform.username.focus();		
	 return (false);
	}
if (document.myform.password.value=="") {
	window.alert("密码不能为空！！");
	document.myform.password.focus();		
	 return (false);
	}
if (document.myform.password1.value==""){
	window.alert("确认密码不能为空!!");
	document.myform.password1.focus();		
	return (false);
	}
if (document.myform.password.value!=document.myform.password1.value){
	window.alert("两次输入的密码不一样!!");
	document.myform.password.focus();
	document.myform.password1.value=="";	
	return (false);
	}
	return true;
}
</script>
<link href="../css/admin_css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="98%" height="101" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
<?php
$id = getvar('id');
$list = $db->getOneRow(get_sql("select * from {pre}manager where id = " . $id));
?>
  <form name="myform" action="admin_ok.php?act=mod" method="POST" onSubmit="return checkreg();">
    <tr>
      <td height="24" colspan="2" bgcolor="#555555"><font color="#FFFFFF">&nbsp;<strong>管理员修改</strong></font></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f8f8f8">用户名：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f8f8f8"><input name="username" type="text" id="username" size="50" value="<?php echo $list['username']; ?>" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f8f8f8">请输入密码：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f8f8f8"><input name="password" type="password" id="password" onblur="if(this.value==''){this.value='<?php echo $list['password']; ?>';}" onclick="if(this.value='<?php echo $list['password']; ?>'){this.value='';}" onfocus="if(this.value='<?php echo $list['password']; ?>'){this.value='';}" value="<?php echo $list['password']; ?>" size="50" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f8f8f8">请再次输入密码：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f8f8f8"><input name="password1" type="password" id="password1" onblur="if(this.value==''){this.value='<?php echo $list['password']; ?>';}" onclick="if(this.value='<?php echo $list['password']; ?>'){this.value='';}" value="<?php echo $list['password']; ?>" onfocus="if(this.value='<?php echo $list['password']; ?>'){this.value='';}" size="50" />
      </td>
    </tr>
    <tr>
      <td height="24" bgcolor="#f8f8f8">&nbsp;</td>
      <td height="24" bgcolor="#f8f8f8"><input type="hidden" name="id" value="<?php echo $list['id']; ?>">
        <input type="submit" name="button" id="button" value="提交" /> <input type="button" name="back" id="back" value="返回" onclick="javascript:window.history.go(-1);" /></td>
    </tr>
  </form>
</table>
</body>
</html>
