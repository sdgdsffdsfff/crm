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
//if($managerid=='my'){
$sqlstr=$sqlstr." and managerid='" . $username . "'";
//}else{//显示会员的等级关系	
//	$sqlstr=$sqlstr." and managerid in ('" . $username."'" . getsubmanager($userId) . ")";
//}


$sqlstr=$sqlstr." and b.type='" . $type . "'"; 
if($act!="remind"){
	$sqlstr=$sqlstr." and b.remindTime!='0000-00-00'";
}

$sqlstr=$sqlstr."  order by b.dateline desc ";

$sqlstr=get_sql($sqlstr);
echo $sqlstr;
//exit;
$s_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
$total_nums = $db->getRowsNum ( $sqlstr );
?>
<!DOCTYPE html> 
<html> 
<head> 
	<title>CRM</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">  
<link rel="stylesheet" href="../jquerymobile/jquery.mobile-1.3.2.min.css">
<script src="../jquerymobile/jquery-1.8.3.min.js"></script>
<script src="../jquerymobile/jquery.mobile-1.3.2.min.js"></script>
</head> 
<body>  
<div data-role="page"> 
<div data-role="header">
		<a href="../cm.php" data-ajax="false">首页</a><h1>需要联系的客户</h1>
	</div><!-- /header -->  
	
	<div data-role="content">	
		<div data-role="collapsible-set">
         		<?php
							foreach ($s_list as $list){	　
						?>
            <div data-role="collapsible" data-collapsed="true">
                <h3>
                    <?php echo $list['company'] ;?>
                </h3>
                <div class="ui-grid-a">
                    <div class="ui-block-a"  style="width:120px" >联系
                    </div>
                    <div class="ui-block-b"><?php echo $list['httpurl'];?>/<?php echo "<a href='tel:".$list[tel]."'>".$list['tel']."</a>";?>/<?php echo "<a href='tel:".$list[mobile]."'>".$list['mobile']."</a>";?>
                    </div>
                     <?php if($list['remindTime']!='0000-00-00'){ ?>
                      <div class="ui-block-a"  style="width:120px" >提醒时间</div>
                     <div class="ui-block-b"><?php echo $list['remindTime'];?> </div>
                     <?php } ?>  
                     
                     <div class="ui-block-a"  style="width:120px" >时间
                    </div>
                     <div class="ui-block-b"><?php echo $list['dateline'];?>
                      <span style="float:right"><a  data-ajax="false" href="mcustomer_add.php?act=mod2&id=<?php echo $list['id'];?>"  data-role="button" data-icon="edit" data-iconpos="notext" data-theme="c" data-inline="true">修改客户信息</a></span>
                    </div>
                     <div class="ui-block-a" style="width:120px">备注</a>
                    </div>
                    <div class="ui-block-b"><?php echo $list['name'];?> 
                     	<a style="float:right" data-ajax="false" href="mservice_add.php?act=mod&id=<?php echo $list['id'];?>"  data-role="button" data-icon="Gear" data-iconpos="notext" data-theme="c" data-inline="true">客户跟进</a>
                    </div>
                </div> 
            </div>
             <?php		 
					  	}
					  ?>
					   <?php mpage($sqlstr,$page_size,"mcustomer_time_out.php?type=" . $type . "&managerid=". $managerid ."&page",$page);?>
					    
					     <?php
					     $sqlstr=get_sql("select id,username from {pre}manager where pid=".$userId." order by id desc"); 
					     $s_list = $db->getlist($sqlstr); 
								$tabStr ="";
								foreach ($s_list as $vo){	
					     ?>
					  <div data-role="controlgroup" data-type="vertical"> 
				    <a href="./mcustomer_time_out.php?type=<?php echo $type;?>&username=<?php echo $vo['username'];?>" data-ajax="false"  data-role="button"><?php echo $vo['username'];?>
				    	<span class="tips"><?php echo getServicesCount($type,$vo['username'],"true");?></span></a> 				    
				  </div> 
 					 <?php		 
					  	}
					  ?>
        </div>
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>
 
 
   
