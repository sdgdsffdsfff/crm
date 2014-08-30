<?php
session_start();
require '../session.php';
include '../inc/const.php';

$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
$page_size 		= 10;
$manager_type = $_SESSION['supermanager'] + 1;
$sqlstr=get_sql("select a.id,username,supermanager,usermenu,loginip,logintime,logincount,a.pid as pid from {pre}manager a order by a.id desc");
$manager_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
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
<body>
<table width="98%" height="101" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <tr>
    <td height="22" colspan="9" bgcolor="#555555"><font color="#FFFFFF">&nbsp;<strong>管理</strong></font></td>
  </tr>
  <tr>
    <td width="4%" height="24" align="center" valign="middle" bgcolor="#f8f8f8">ID</td>
    <td width="10%" height="24" align="center" valign="middle" bgcolor="#f8f8f8">用户名</td>     
    <td width="13%" height="24" align="center" valign="middle" bgcolor="#f8f8f8">姓名</td>
    <td width="15%" align="center" valign="middle" bgcolor="#f8f8f8">组别</td>
    <td width="15%" align="center" valign="middle" bgcolor="#f8f8f8">上级领导</td>
    <td width="16%" align="center" valign="middle" bgcolor="#f8f8f8">最后登录IP</td>
    <td width="16%" align="center" valign="middle" bgcolor="#f8f8f8">最后登录时间</td>
    <td width="10%" height="24" align="center" valign="middle" bgcolor="#f8f8f8">登录次数</td>
    <td width="8%" align="center" valign="middle" bgcolor="#f8f8f8">操作</td>
  </tr>
  <?php
	foreach ($manager_list as $list){
  ?>
  <tr onMouseOver="this.style.background='#D7E4F7'" onMouseOut="this.style.background='#EBF2F9';"  bgcolor="#EBF2F9">
    <td width="4%" height="24" align="center" valign="middle" bgcolor="#f8f8f8"><?php echo $list['id']; ?></td>
    <td height="24" align="center" valign="middle" bgcolor="#f8f8f8"><a href="admin_mod.php?id=<?php echo $list['id']; ?>"><?php echo $list['username']; ?></a></td>
	  <td height="24" align="center" valign="middle" bgcolor="#f8f8f8"><?php echo $list['usermenu']; ?></td>
    <td height="24" align="center" valign="middle" bgcolor="#f8f8f8"><?php echo getCategoryName('role',$list['supermanager']); ?></td>
    <td height="24" align="center" valign="middle" bgcolor="#f8f8f8"><?php echo get_supermanager($list['pid']); ?></td>
    <td height="24" align="center" valign="middle" bgcolor="#f8f8f8"><?php echo $list['loginip']; ?></td>
    <td height="24" align="center" valign="middle" bgcolor="#f8f8f8"><?php echo $list['logintime']; ?></td>
    <td height="24" align="center" valign="middle" bgcolor="#f8f8f8"><?php echo $list['logincount']; ?></td>
    <td height="24" align="center" valign="middle" bgcolor="#f8f8f8"><a href="admin_add.php?id=<?php echo $list['id']; ?>"><img src="../images/edit.gif" border="0" /></a>&nbsp;<?php
    	if($list['id'] !== '1'){
	?><a href="admin_ok.php?id=<?php echo $list['id']; ?>&act=del" onClick="javascript:return confirm('确实要删除吗?')"><img src="../images/del.gif" border="0" /></a><?php }?></td>
  </tr>
  <?php
  	}
  ?>
  <tr>
    <td height="24" colspan="9" align="center" valign="middle" bgcolor="#F8FCF6"><?php page($sqlstr,$page_size,"admin_manage.php?page",$page);?></td>
  </tr>
</table>
</body>
</html>
