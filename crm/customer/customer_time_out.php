<?php
session_start();
require_once '../session.php';
require_once '../inc/const.php';

$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
$page_size 		= 20;
$act = getvar("act"); 
$act = empty($act) ? "remind2" : $act;  
$type = getvar('type');
$managerid = getvar('managerid');
$username=getvar('username');
$username = empty($username) ? $_SESSION['username'] : $username; 
$userId=getUserIDbyName($username); 

$sqlstr="select a.id as id,a.name as company,a.tel as tel,a.mobile as mobile,b.dateline as dateline,b.name as name,b.remindTime as remindTime from {pre}customer a right join {pre}services b on a.id=b.fid where isdel=0 ";
if($managerid=='my'){
$sqlstr=$sqlstr." and managerid='" . $username . "'";
}else{//显示会员的等级关系	
$sqlstr=$sqlstr." and managerid in ('" . $username."'" . getsubmanager($userId) . ")";
}

if($type!=""){
$sqlstr=$sqlstr." and b.type='" . $type . "'"; 
}
if($act=="remind"){
	$sqlstr=$sqlstr." and b.remindTime!='0000-00-00'";
}

$sqlstr=$sqlstr."  order by b.dateline desc ";

$sqlstr=get_sql($sqlstr);
//echo $sqlstr;
//exit;
$s_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
$total_nums = $db->getRowsNum ( $sqlstr );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="../js/boxy.css" rel="stylesheet" type="text/css" />
<link href="../js/bootstrap.min.css" rel="stylesheet" type="text/css" />

<link href="../css/admin_css.css" rel="stylesheet" type="text/css" />
</head>
<body style="padding:15px;">
 
   
  <table width="100%" height="1" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc">
    
  <tr>
    <td colspan=6><strong><a href="./customer_time_out.php?managerid=<?php echo $managerid=="my"?"all":"my";?>&act=<?php echo $act;?>" class="button green">查看<?php echo $managerid=="my"?"所有":"自己";?></a></strong></td>
  </tr> 	
  
  <tr bgcolor="#f5f5f5">
    <td width="4%" height="24" align="center" valign="middle">ID</td>
    <td width="25%" height="24" align="center" valign="middle">客户名称</td>
	<td width="17%" align="center" valign="middle">电话</td>
    <td width="12%" align="center" valign="middle">联系时间</td>
    <td width="25%" align="center" valign="middle">小记</td>
    <td width="17%" align="center" valign="middle">提醒时间</td> 
  </tr>
   
  <?php
	foreach ($s_list as $list){
		 
			$endtime = $list['remindTime'];
			if(empty($endtime)){
				$temp_endtime = "<font color=green>没有时间</font>";
			}else{
				$temp_endtime = (strtotime($endtime)-strtotime(date("Y-m-d")))/(3600*24);
				if($temp_endtime<0){
					$temp_endtime = "<font color=gray>已过期</font>";	
				}elseif($temp_endtime<30){
					$temp_endtime = "<font color=red>还有".$temp_endtime."天过期</font>";
				}elseif($temp_endtime<60){
					$temp_endtime = "<font color=Orange>还有".$temp_endtime."天过期</font>";
				}else{
					$temp_endtime = "<font color=green>到期时间：".$endtime."</font>";
				}
			}
  ?>
  <tr onMouseOver="this.style.background='#f5f5f5'" onMouseOut="this.style.background='#ffffff';"  bgcolor="#ffffff">
    <td width="4%" height="24" align="center" valign="middle"><?php echo $list['id'];?></td>
    <td height="24" align="left" valign="middle"><a href="customer_action.php?act=mod&id=<?php echo $list['id'];?>&page=<?php echo $page;?>"><?php echo $list['company'];?></a></td>
	<td height="24" align="center" valign="middle"><?php echo  $list['tel']."<BR>".$list['mobile'];?></td>
    <td height="24" align="center" valign="middle"><?php echo  date('Y-m-d',strtotime($list['dateline']));?></td>
    <td height="24" align="center" valign="middle" title="<?php echo $list['name'];?>"><?php echo  utf_substr($list['name'],60);?></td>
    <td height="24" align="center" valign="middle"><?php echo  $list['remindTime']."<BR>".$temp_endtime;?></td>
  </tr>
  <?php		 
  	}
  ?>
  <tr>
    <td height="24" colspan="8" bgcolor="#F8FCF6"><?php page($sqlstr,$page_size,"customer_time_out.php?page",$page);?></td>
  </tr>
</table>
</body>
</html>
