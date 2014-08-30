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
		<a href="./mcustomer_list.php">返回</a><h1>客户详细页面</h1>
	</div>
    <div data-role="content"> 
     	<?php
			$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
			$page_size 		= 20;
			$sqlstr=get_sql("select * from {pre}services where 1=1 and fid=".$id." order by dateline desc");
			$s_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
			$total_nums = $db->getRowsNum ( $sqlstr );
			?>
			
			
  <?php
    $i=0;
	foreach ($s_list as $lists){	
		$i=$i+1;
		$remindTime=$lists['remindTime'];
		$dateline=$lists['dateline'];
  ?>
  <div class="ui-block-a"  style="width:120px" ><?php echo $i?>.时间 
  <a href="customer_ok.php?act=delService&sid=<?php echo $lists['id'];?>&id=<?php echo $list['id'];?>" onClick="javascript:return confirm('确实要删除吗?')"><img src="../images/del.gif" border="0" /></a>	
  </div> 
  <div class="ui-block-b"><?php echo  date("Y-m-d",strtotime($dateline))?></div><!--
  <div class="ui-block-a"  style="width:120px" >提醒时间</div> 
  <div class="ui-block-b"><?php echo  date("Y-m-d",strtotime($remindTime))?></div> -->
  <div class="ui-block-a"  style="width:120px" >内容</div> 
  <div class="ui-block-b"><?php echo $lists['name'] ?></div>  
  <?php 
  	}
  ?>   
    </div>
     <?php page($sqlstr,$page_size,"customer_action.php?page",$page);?> 
      <table width="98%" height="101" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
   
  <form name="myform2" method="post" action="customer_ok.php?act=addService">
  <tr bgcolor="#f5f5f5">
    <td width="8%" height="24" align="center" valign="middle">跟踪时间</td>
    <td width="42%" height="24" align="center" valign="middle"><div align="left">
	<input size="20" onfocus="HS_setDate(this)" type="text" name="dateline" id="dateline" value="" /> 
	</div></td>
	</tr>
  <tr bgcolor="#f5f5f5">
    <td width="11%" align="center" valign="middle">提醒时间</td>
    <td width="39%" align="center" valign="middle"><div align="left"><input size="20" onfocus="HS_setDate(this)" type="text" name="remindTime" id="remindTime" value="" /> 
      </div></td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td height="24" colspan="4" align="center" valign="top"> <div align="left">
      <textarea name="name" cols="80" rows="3"></textarea>
	  <input type="hidden" value="<?php echo $list['id'];?>" name="id" id="id">
      <input type="submit" name="modbtn2" id="modbtn2" value="联系小记" />
    </div></td>
  </tr>
  </form>
</table>
</div>
</body>
</html>
