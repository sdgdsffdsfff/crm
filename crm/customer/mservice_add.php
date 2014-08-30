<?php
session_start();
require_once '../session.php'; 
require_once '../inc/const.php';

$id= getvar('id');
$pid= getvar('pid');
$act = getvar("act");
$act = empty($act) ? "add" : $act;

/// 取客户的信息出来
$sql = get_sql("select * from {pre}customer where id=".$id." order by id");
$list = $db->getonerow($sql); 
$industry = empty($industry) ? $list['industry'] : $industry;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>小记信息</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="../jquerymobile/jquery.mobile-1.3.2.min.css">
<script src="../jquerymobile/jquery-1.8.3.min.js"></script>
<script src="../jquerymobile/jquery.mobile-1.3.2.min.js"></script>
<body>
<div data-role="page" id="page1">
		<div data-role="header" data-position="fixed">
		<a href="../cm.php" data-icon="home"  data-ajax="false" >首页</a><h1>小记信息</h1><a   data-ajax="false" href="./mcustomer_list.php?industry=<?php echo $industry;?>" data-icon="back">返回</a>
	</div>
    <div data-role="content"> 
     	
 <form name="myform2" method="post" data-ajax="false" action="customer_ok.php?act=addService2">
  	<div data-role="fieldcontain">
    <label for="colors">类型:</label>
    <select name="type" id="type"> 
        <?php getCategorySelect2("servicetype",""); ?>
      </select>
  </div>
   	 <div data-role="fieldcontain">
    <label for="name">跟踪时间</label>
    <input   type="date" name="dateline" id="dateline" value="<?php echo date('Y-m-d');?>" placeholder="跟踪时间"/> 
    </div>
    <div data-role="fieldcontain">
    <label for="name">提醒时间</label>
    <input type="date" name="remindTime" id="remindTime" value="" placeholder="提醒时间"/> 
    </div>
    
    <div data-role="fieldcontain"> 
     	<textarea name="name" id="name" rows="10" placeholder="写下你们交流的内容."></textarea>  
    </div> 
	  <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
	  <input type="hidden" value="<?php echo $pid;?>" name="pid" id="pid">
	   <div data-role="controlgroup" data-type="horizontal" align="center"> 
    <input type="submit" name="modbtn2" id="modbtn2" value="保存小记" />
    <input type="button" name="modbtn2" id="modbtn2" onclick="location.href='mcustomer_add.php?act=mod2&id=<?php echo $id;?>';" value="客户信息" />
    </div>
  </form>  
   
   
     	<?php
			$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
			$page_size 		= 20;
			$sqlstr=get_sql("select * from {pre}services where isdel=0 and fid=".$id." order by id desc");
			$s_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
			$total_nums = $db->getRowsNum ( $sqlstr );
			?>
			
	<ul data-role="listview" data-inset="true">		
  <?php
    $i=0;
	foreach ($s_list as $lists){	
		$i=$i+1;
		$remindTime=$lists['remindTime'];
		$dateline=$lists['dateline'];
  ?>
  <li> 
  	<h2><?php echo $i?>.  <?php echo $lists['userid'];?> <?php echo  date("Y-m-d",strtotime($dateline))?> <?php echo getCategoryName("servicetype",$lists['type']);?> 
  		<span style="flot:left"><a data-ajax="false" href="customer_ok.php?act=delService2&sid=<?php echo $lists['id'];?>&id=<?php echo $id;?>" onClick="javascript:return confirm('确实要删除吗?')"><img src="../images/del.gif" border="0" /></a></spen></h2>
  <p><?php echo $lists['name'] ?></p> 
 </li>
  <?php 
  	}
  ?>   
  </ul>
   
     <?php page($sqlstr,$page_size,"customer_action.php?page",$page);?> 
       
  
  
</div>
</body>
</html>
