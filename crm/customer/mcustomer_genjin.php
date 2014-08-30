<?php
session_start();
require_once '../session.php'; 
require_once '../inc/const.php';

$id= getvar('id');
$act = getvar("act");
$act = empty($act) ? "add" : $act;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
<body>
<div data-role="page" id="page1">
		<div data-role="header">
		<a href="../mindex.php">首页</a><h1>客户详细页面</h1>
	</div>
    <div data-role="content"> 
     	hello,all
    </div>
<div data-role="footer" data-id="foo1" data-position="fixed">
<div data-role="navbar">
<ul>
<li><a href="mcustomer_info.php?act=mod&id=<?php echo $id?>&page=1" class="ui-btn-active ui-state-persist">客户信息</a></li>
<li><a href="mcustomer_genjin.php">客户跟进</a></li> 
</ul>
</div><!-- /navbar -->
</div>
</div>
</body>
</html>
