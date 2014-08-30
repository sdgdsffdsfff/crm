<?php

require_once 'HttpClient.class.php';
require_once 'mailClass.php'; 
require_once 'smsClass.php';

if($_POST["act"]=="短信"){
	print(dlswSdk::sendSms( '18962557155', '5eb4925587b90b951cf4e271b9f2767e',$_POST["content"].'【旗云科技】',$_POST["target"]));
}elseif($_POST['act']=="邮件"){

	$smtpserver = "smtp.gmail.com";//SMTP服务器 
	$smtpserverport = 25;//SMTP服务器端口 
	$smtpusermail = "pifasoft@gmail.com";//SMTP服务器的用户邮箱 	
	$smtpuser = "pifasoft";//SMTP服务器的用户帐号 
	$smtppass = "danny2huang";//SMTP服务器的用户密码 
	
	
	$smtpemailto = $_POST['target'];//发送给谁 
	$mailsubject = $_POST['title'];//邮件主题 
	$mailbody = $_POST['content'];//邮件内容 
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件  

$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
$smtp->debug = TRUE;//是否显示发送的调试信息 
$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);  


}
$act=$_GET["act"]; 
$actionName = empty($act)?"短信":"邮件";
$targetName = empty($act)?"输入手机号码":"输入邮箱地址";
?> 
<link href="../js/boxy.css" rel="stylesheet" type="text/css" /> 
<form class="form-horizontal" method="post" action="">
  <fieldset>
    <legend>发送<?php echo $actionName;?></legend> 
    
     <input type="text" name="target"  placeholder="<?php echo $targetName;?>" value="<?php echo $_GET["target"]?>" style="width:600px;overflow-x:visible;overflow-y:visible;"><br><br>
     <?php if("邮件"==$actionName){?>
    <input type="text" name="title"  placeholder="邮件标题" style="width:600px;overflow-x:visible;overflow-y:visible;"><br><br>
     <?php }?>
    <textarea rows="6" name="content" placeholder="输入<?php echo $actionName;?>内容" style="width:600px;overflow-x:visible;overflow-y:visible;"></textarea><BR><br>
    <input type="hidden" name="act" value="<?php echo $actionName;?>"/>
    <input type="submit" name="button" style="width:600px;" class="button blue" id="button" value="发送" />
  </fieldset>
</form>