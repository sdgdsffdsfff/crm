<?php
session_start();
require_once 'inc/const.php';
global $luo_session_name; 

if (isset($_GET['act']) && addslashes($_GET['act']) == "login") login();
if (isset($_GET['act']) && addslashes($_GET['act']) == "quit") quit();

function login() {
	global $db;
	if($_POST['code']=="" || $_POST['code']!=$_SESSION["codeNumber"])
	{
	 //echo "<script>alert('验证码错误');window.location.href='login.php';</script>";	 
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
		 
		if (empty($username)||empty($password)){
			exit("<script>alert('用户名或密码不能为空！');window.history.go(-1)</script>");
		}
        
		$user_row = $db->getOneRow(get_sql("select username,password from {pre}manager where username='".$username."' and password='".md5($password)."'"));
		

		if (!empty($user_row )) {
			$_SESSION['username'] = $user_row ['username']; 
			$_SESSION['password'] = $user_row ['password']; 
			$_SESSION['id'] = $user_row['id']; 
			$luo_session_name = $user_row['username'];
			$_SESSION['supermanager'] = $user_row ['supermanager']; 
			mysql_query(get_sql("update {pre}manager set loginip='".get_userip()."',logintime='".date ( "Y-m-d H:i:s" )."' where username='".$username."'"));
			if("on"==$_POST["iscookie"]
){//登录成功保存cookie
				setcookie("username", $username,time()+3600*24*7);
				setcookie("password", $password,time()+3600*24*7);
			}else{
				setcookie("username", "",time());
				setcookie("password", "",time());
			}
			//echo "<script>window.location='mindex.php';</script>";
			echo "<script>window.location='cm.php';</script>";
		}else{
			echo "<script>alert('用户名或密码不正确！');window.history.go(-1);</script>";
		}
	
	}
} 

function quit() {
	session_unset();
	session_destroy(); 
	setcookie("username", "",time());
	setcookie("password", "",time());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title><?php echo $sitename;?></title>
<link href="css/admin_css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/jquerymobile/jquery.mobile-1.3.2.min.css">
<script src="/jquerymobile/jquery-1.8.3.min.js"></script>
<script src="/jquerymobile/jquery.mobile-1.3.2.min.js"></script>
</script>
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

<form name="form1" action="m.php?act=login" method="post" data-ajax="false">
<div data-role="fieldcontain" class="ui-hide-label">
	<label for="username">用户名:</label>
	<input type="text" name="username" id="username" value="<?php echo $_COOKIE["username"];?>" placeholder="用户名"/>
</div> 
<div data-role="fieldcontain" class="ui-hide-label">
	<label for="username">密码:</label>
	<input type="password" name="password" id="password" value="<?php echo $_COOKIE["password"];?>" placeholder="密码"/>
</div>
<div class="ui-block-b">
	<select name="iscookie" id="iscookie" data-role="slider">
      <option value="on" selected>记住</option>
      <option value="off">不记</option>
    </select><button type="submit">登录</button></div>
</form>
<div id='topf'><? //echo 'user-agent=' . $_SERVER['HTTP_USER_AGENT']; ?></div>
    <script>
			var width=0;
			function autologin(){
				//document.form1.username.value="admin";
				//document.form1.password.value="admin";
				if(document.form1.username.value!=""  && document.form1.password.value!=""){
						document.form1.submit();
					}
			}							
      <?php if($_GET['act'] != "quit"){echo "autologin();";}?>
     </script>
</body>
</html>

