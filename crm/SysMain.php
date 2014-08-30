<?php 
session_start();
include_once 'session.php'; 
include_once 'inc/const.php';
$act = getvar('act');

if ($act=='update'){
	$file_name = 'inc/const.php'; //要替换操作的文件
	$fp = fopen($file_name,'r'); //打开要替换的文件
	$sitename = htmlspecialchars(stripcslashes($_POST['sitename']),ENT_QUOTES);
	$httpurl = htmlspecialchars(stripcslashes($_POST['httpurl']),ENT_QUOTES);
	if (substr($httpurl,-1) != '/'){
		$httpurl = $httpurl."/";
	}
	$httpurl = "http://".$httpurl;
	$keywords = htmlspecialchars(stripcslashes($_POST['keywords']),ENT_QUOTES);
	$description = htmlspecialchars(stripcslashes($_POST['description']),ENT_QUOTES);
	$installdir = htmlspecialchars(stripcslashes($_POST['installdir']),ENT_QUOTES);
	if ($installdir=="./"){
		$installdir="";
	}elseif(substr($installdir,-1,1) != '/'){
		$installdir = $installdir."/";
	}
	$manager_email = htmlspecialchars(stripcslashes($_POST['manager_email']),ENT_QUOTES);
	$site_beian = htmlspecialchars(stripcslashes($_POST['site_beian']),ENT_QUOTES);
	//$author = htmlspecialchars(stripcslashes($_POST['author']),ENT_QUOTES);
	//$source = htmlspecialchars(stripcslashes($_POST['source']),ENT_QUOTES);
	$indexname = htmlspecialchars(stripcslashes($_POST['indexname']),ENT_QUOTES);
	//$templatedir = htmlspecialchars(stripcslashes($_POST['templatedir']),ENT_QUOTES);
	if(!$fp){
		echo $file_name."文件不存在！";
	}
	@$conf_file = fread($fp,filesize($file_name));
	$conf_file = preg_replace("/sitename\s*\=\s(\'|\")(.*?)(\"|')/","sitename = \"" . $sitename. "\"",$conf_file); 
	$conf_file = preg_replace("/httpurl\s*\=\s(\'|\")(.*?)(\"|')/","httpurl = \"" . $httpurl. "\"",$conf_file); 
	$conf_file = preg_replace("/keywords\s*\=\s(\'|\")(.*?)(\"|')/","keywords = \"" . $keywords. "\"",$conf_file); 
	$conf_file = preg_replace("/description\s*\=\s(\'|\")(.*?)(\"|')/","description = \"" . $description. "\"",$conf_file); 
	$conf_file = preg_replace("/installdir\s*\=\s(\'|\")(.*?)(\"|')/","installdir = \"" . $installdir. "\"",$conf_file); 
	$conf_file = preg_replace("/manager_email\s*\=\s(\'|\")(.*?)(\"|')/","manager_email = \"" . $manager_email. "\"",$conf_file); 
	$conf_file = preg_replace("/site_beian\s*\=\s(\'|\")(.*?)(\"|')/","site_beian = \"" . $site_beian. "\"",$conf_file); 
	//$conf_file = preg_replace("/author\s*\=\s(\'|\")(.*?)(\"|')/","author = \"" . $author. "\"",$conf_file); 
	//$conf_file = preg_replace("/source\s*\=\s(\'|\")(.*?)(\"|')/","source = \"" . $source. "\"",$conf_file); 
	$conf_file = preg_replace("/indexname\s*\=\s(\'|\")(.*?)(\"|')/","indexname = \"" . $indexname. "\"",$conf_file); 
	//$conf_file = preg_replace("/templatedir\s*\=\s(\'|\")(.*?)(\"|')/","templatedir = \"" . $templatedir. "\"",$conf_file); 
	
	if(!@$fp = fopen($file_name,'w')) 
	echo "没有写入".$file_name."的权限";
	$fw = fwrite($fp, trim($conf_file));
	fclose($fp);	
	echo "<script>alert('操作成功!');window.location='SysMain.php';</script>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/admin_css.css" rel="stylesheet" type="text/css" />
</head>
<script>
function checksubmit()
{
if (document.form1.sitename.value=="") {
	window.alert("站点名称不能为空！！");
	document.form1.sitename.focus();		
	 return (false);
	}
if (document.form1.httpurl.value=="") {
	window.alert("站点域名不能为空！！");
	document.form1.httpurl.focus();		
	 return (false);
	}
if (document.form1.installdir.value=="") {
	window.alert("安装目录不能为空！！");
	document.form1.installdir.focus();		
	 return (false);
	}
	return true;
}
</script>
<body>
<table width="98%" border="0" cellpadding="1" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <form name="form1" method="post" action="?act=update"  onSubmit="return checksubmit();">
  <tr>
    <td height="24" colspan="2" bgcolor="#555555"><font color="#FFFFFF">&nbsp;<span class="Main_Title"><strong>系统全局设定</strong></span></font></td>
  </tr>
  <tr>
    <td height="24" colspan="2" align="left" valign="middle" bgcolor="#f1f1f1" class="sys_title">　　<span class="hong">站点基本信息</span></td>
  </tr>
  <tr>
    <td width="150" height="24" align="right" valign="middle" bgcolor="#f1f1f1"> 　站点名称：</td>
    <td width="1101" height="24" bgcolor="#f1f1f1"><input name="sitename" type="text" class="login_text" id="sitename"  value="<?php echo $sitename;?>"/>
      <span class="hong">*</span>　<span class="hui">      系统名称，例如：pifasoft</span></td>
  </tr>
  <tr>
    <td width="150" height="24" align="right" valign="middle" bgcolor="#f1f1f1">　域名：</td>
    <td width="1101" height="24" bgcolor="#f1f1f1"><input name="httpurl" type="text" class="login_text" id="httpurl" value="<?php echo substr($httpurl,7);?>"/>
    <span class="hong">*</span>　<span class="hui"> 域名，例如：pifasoft.com，不需要http://www.</span></td>
  </tr>
  <tr>
    <td width="150" height="24" align="right" valign="middle" bgcolor="#f1f1f1">　首页关健字： </td>
    <td height="24" bgcolor="#f1f1f1"><input name="keywords" type="text" class="login_text" style="width:80%" id="keywords" value="<?php echo $keywords;?>" />
    <br />
    <span class="hui">首页关健字，显示在标题和Keywords中，例如：crm,客户关系管理系统,多个关健字用‘，’或‘|’隔开</span></td>
  </tr>
  <tr>
    <td width="150" height="24" align="right" valign="middle" bgcolor="#f1f1f1">　首页描述：</td>
    <td height="24" bgcolor="#f1f1f1"><textarea name="description" cols="45" rows="5" style="width:80%;height:100px;" id="description"><?php echo $description;?></textarea>　
    <br />
    <span class="hui">首页描述，显示在首页description中.字数控制在200个以内。</span></td>
  </tr>
  <tr>
    <td height="24" align="right" valign="middle" bgcolor="#f1f1f1">安装目录：</td>
    <td height="24" bgcolor="#f1f1f1"><input name="installdir" type="text" class="login_text" id="installdir" value="<?php echo $temp = ($installdir == '') ? "./" : $installdir;?>" />
      <span class="hong">*</span>　 <span class="hui"> 根目录用&quot;./&quot;,子目录用&quot;子目录名/&quot;</span></td>
  </tr>
  <tr>
    <td width="150" height="24" align="right" valign="middle" bgcolor="#f1f1f1">管理员邮箱：</td>
    <td height="24" bgcolor="#f1f1f1"><input name="manager_email" type="text" class="login_text" id="manager_email" value="<?php echo $manager_email;?>" />　
    <span class="hui"> 管理员邮箱，例如：info@pifasoft.com</span></td>
  </tr>
  <tr>
    <td width="150" height="24" align="right" valign="middle" bgcolor="#f1f1f1">备案号：</td>
    <td height="24" bgcolor="#f1f1f1"><input name="site_beian" type="text" class="login_text" id="site_beian" value="<?php echo $site_beian;?>"/>
    　 <span class="hui"> 网站备案号</span></td>
  </tr>
  <tr>
    <td width="150" height="24" align="right" valign="middle" bgcolor="#f1f1f1">　首页名称： </td>
    <td height="24" bgcolor="#f1f1f1"><input name="indexname" type="text" class="login_text" id="indexname" value="<?php echo $indexname;?>"/></td>
  </tr>
  <tr>
    <td width="150" height="24" align="right" valign="middle" bgcolor="#f1f1f1">&nbsp;</td>
    <td width="1101" height="24" bgcolor="#f1f1f1"><input name="button" type="submit" class="login_text" style="width:50px;" id="button" value="确定"/></td>
  </tr>
  </form>
</table>

</body>
</html>
