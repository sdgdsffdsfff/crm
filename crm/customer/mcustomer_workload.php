<?php
session_start();
require_once '../session.php'; 
require_once '../inc/const.php';

$type= getvar('type'); 
$type = empty($type) ? "01" : $type;
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>公告信息</title>
<head>
<link rel="stylesheet" href="/jquerymobile/jquery.mobile-1.3.2.min.css">
<script src="/jquerymobile/jquery-1.8.3.min.js"></script>
<script src="/jquerymobile/jquery.mobile-1.3.2.min.js"></script>
</head>
<body> 
<div data-role="page"> 
    <div data-role="header" data-position="fixed">
		<a href="../cm.php" data-icon="home"  data-ajax="false" >首页</a><h1>明星榜</h1>
	</div>
   <div data-role="content"  style="margin-top:0px;">
    	 <ul data-role="listview" data-inset="true"> 
    	<?php
  if($type=="00"){
		$sqlstr=get_sql("SELECT CREATEUSER,COUNT(*) as c FROM {pre}customer WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE(createTime) GROUP BY CREATEUSER");
	}else{
		$sqlstr=get_sql("SELECT userid as CREATEUSER,COUNT(*) AS c FROM {pre}services WHERE isdel=0 and type='". $type ."' and DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE(dateline) GROUP BY userid");	
	}
	//echo $sqlstr;
	$list = $db->getList($sqlstr);

  	foreach($list as $c){ 
  ?>  
      <li><a href="#"><?php echo $c['CREATEUSER'];?><span class="ui-li-count"><?php echo $c['c'];?></span></a></li> 
  <?php
	}
  ?> 
     </ul>
  </div>
   <?php include '../foot.php';  ?>
</div>
</body>
</html>