<?php
session_start();
require '../session.php'; 
include '../inc/const.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="../css/admin_css.css" rel="stylesheet" type="text/css" />
<link href="../js/boxy.css" rel="stylesheet" type="text/css" />
</head>
 <style type="text/css">
.container{padding:10px;background:#e1e1e1;}
h2{padding-left:10px;}
</style>
<body styel="background:#e1e1e1;">
<div class="container">
<div class="row">
	<div class="col12">
	<h1 style="text-align:center;font-size:24px;margin-bottom:10px;">客户关系系统 汇总统计</h1>
	</div>
	<div class="col6">
	<h2>今天新增客户统计</h2>
<table width="98%" height="94" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <thead>
  <tr bgcolor="#f9f9f9">
    <td width="5%"   align="center" valign="middle">用户名</td>
    <td width="20%"   align="center" valign="middle">数量</td> 
  </tr>
  </thead>
  <?php
  	 
	$sqlstr=get_sql("SELECT CREATEUSER,COUNT(*) as c FROM {pre}customer WHERE DATE_SUB(CURDATE(), INTERVAL 0 DAY) <= DATE(createTime) GROUP BY CREATEUSER");
	$list = $db->getList($sqlstr);

  	foreach($list as $c){ 
  ?>
  <tr bgcolor="#f9f9f9">
    <td width="5%"  align="center" valign="middle"><?php echo getRealnamebyName($c['CREATEUSER']);?></td>
    <td align="center" valign="middle"><?php echo $c['c'];?></td>   </tr>
  <?php
	}
  ?> 
</table>
</div>
<div class="col6">
	<h2>最近7天新增客户统计</h2>
<table width="98%" height="94" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <thead>
  <tr bgcolor="#f9f9f9">
    <td width="5%" height="24" align="center" valign="middle">用户名</td>
    <td width="20%" height="24" align="center" valign="middle">数量</td> 
  </tr>
  </thead>
  <?php
  	 
	$sqlstr=get_sql("SELECT CREATEUSER,COUNT(*) as c FROM {pre}customer WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE(createTime) GROUP BY CREATEUSER");
	$list = $db->getList($sqlstr);

  	foreach($list as $c){ 
  ?>
  <tr bgcolor="#f9f9f9">
    <td width="5%"   align="center" valign="middle"><?php echo getRealnamebyName($c['CREATEUSER']);?></td>
    <td align="center" valign="middle"><?php echo $c['c'];?></td>   </tr>
  <?php
	}
  ?> 
</table>
</div>


<div class="col6">
	<h2>今天新增客户跟进统计</h2>
<table width="98%" height="94" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <thead>
  <tr bgcolor="#f9f9f9">
    <td width="5%" height="24" align="center" valign="middle">用户名</td>
    <td width="20%" height="24" align="center" valign="middle">数量</td> 
  </tr>
  </thead>
  <?php
  	 
	$sqlstr=get_sql("SELECT userid,COUNT(*) AS c FROM {pre}services WHERE DATE_SUB(CURDATE(), INTERVAL 0 DAY) <= DATE(dateline) GROUP BY userid");
	$list = $db->getList($sqlstr);

  	foreach($list as $c){ 
  ?>
  <tr bgcolor="#f9f9f9">
    <td width="5%"   align="center" valign="middle"><?php echo getRealnamebyName($c['userid']); ?></td>
    <td align="center" valign="middle"><?php echo $c['c'];?></td>   </tr>
  <?php
	}
  ?> 
</table>
</div>

<div class="col6">
	<h2>最近7天新增客户跟进统计</h2>
<table width="98%" height="94" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <thead>
  <tr bgcolor="#f9f9f9">
    <td width="5%" height="24" align="center" valign="middle">用户名</td>
    <td width="20%" height="24" align="center" valign="middle">数量</td> 
  </tr>
  </thead>
  <?php
  	 
	$sqlstr=get_sql("SELECT userid,COUNT(*) AS c FROM {pre}services WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE(dateline) GROUP BY userid");
	$list = $db->getList($sqlstr);

  	foreach($list as $c){ 
  ?>
  <tr bgcolor="#f9f9f9">
    <td width="5%"   align="center" valign="middle"><?php echo getRealnamebyName($c['userid']);?></td>
    <td align="center" valign="middle"><?php echo $c['c'];?></td>   </tr>
  <?php
	}
  ?> 
</table>
</div>


</div>
</div>
</body>
</html>
