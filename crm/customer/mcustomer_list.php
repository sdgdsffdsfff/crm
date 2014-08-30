<?php
session_start();
require_once '../session.php';
require_once '../inc/const.php';

$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
$page_size 		= 20;
$sqlstr="select * from {pre}customer where 1=1 ";
$industry = getvar('industry');
$managerid = getvar('managerid');
$username=getvar('username');
$username = empty($username) ? $_SESSION['username'] : $username; 
$userId=getUserIDbyName($username);   

if(!empty($industry)){
	$sqlstr=$sqlstr." and industry=".$industry;
}
if($managerid=='public'){
	$sqlstr=$sqlstr." and managerid=''";
}elseif($managerid=='my'){
	$sqlstr=$sqlstr." and managerid='" . $username . "'";
}else{//看所有下属
	$sqlstr=$sqlstr." and managerid in ('" . $username ."'" . getsubmanager($userId) . ")";
	//$sqlstr=$sqlstr." and managerid='" . $username . "'";
} 

$queryname=getvar('search');
if(!empty($queryname)){
	$sqlstr=$sqlstr." and (name like '%".$queryname."%' or addr like '%".$queryname."%' or tel like '%".$queryname."%' or mobile like '%".$queryname."%' or qq like '%".$queryname."%' or services like '%".$queryname."%')";
}
$sqlstr=$sqlstr." order by id desc";
$sqlstr = get_sql($sqlstr);


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
<!-- Home  -->
<div data-role="page" id="page1">
		<div data-role="header" data-position="fixed">
		<a href="../cm.php" data-icon="home" data-ajax="false" >首页</a><h1>客户列表页面</h1><a data-ajax="false" href="./mcustomer_add.php?industry=<?php echo $industry?>" data-icon="plus">新增</a>
	</div>
    <div data-role="content">
        <form method="post" name="customerSearch" action="mcustomer_list.php?industry=<?php echo $industry?>"> 
	        	<div data-role="controlgroup" data-type="vertical" style="margin-top:0px;padding-top:0px;">    	 
    <fieldset data-role="controlgroup" data-type="horizontal">   
				<input type="radio" id="major_comp" name="managerid" checked="true" value="all" onclick="document.customerSearch.submit();"/>  
				<label for="major_comp" onclick="document.customerSearch.submit();">全部</label>  
		  
				<input type="radio" id="major_eng" name="managerid" <?php if($managerid=="my")echo "checked='true'";?> value="my" onclick="document.customerSearch.submit();"/>  
				<label for="major_eng" onclick="document.customerSearch.submit();">自己</label>   
		</fieldset>
    <input type="search" name="search" id="search" placeholder="搜索内容..."> 
     <!--
  <input type="submit" value="查询" data-icon="search">  
   --> 
    </div>  
         </form> 
         
           
        <div data-role="collapsible-set">
           
         		<?php
							foreach ($s_list as $list){		  
						?>
						 
            <div data-role="collapsible" data-collapsed="true">
                <h3>
                    <?php echo $list['name'] ;?> 
                </h3>  
                 <!--
                 <div data-role="controlgroup" data-type="horizontal"> 
                  	<li><?php echo $list['services'];?> <span style="float:right">aaaaa</a> </li>
                 </div> 	 
                 
                  	
                 <div data-role="listview">
						      <li><?php echo $list['httpurl'];?>/<?php echo "<a href='tel:".$list[tel]."'>".$list['tel']."</a>";?>/<?php echo "<a href='tel:".$list[mobile]."'>".$list['mobile']."</a>";?>
						      	<span style="float:right">aaaaa</a>
						      	</li>
						      <li><?php echo $list['addr'];?></li>
						      <li><?php echo $list['services'];?> <span style="float:right">aaaaa</a> </li>
						    </div>
						    --> 
						     
                <div class="ui-grid-c">
                    <div class="ui-block-a" style="width:20%">联系</div>
                    <div class="ui-block-b" style="width:80%">                  
                     	<?php echo $list['httpurl'];?>/<?php echo "<a href='tel:".$list[tel]."'>".$list['tel']."</a>";?>/<?php echo "<a href='tel:".$list[mobile]."'>".$list['mobile']."</a>";?>
                     	<a style="float:right" data-ajax="false" href="mservice_add.php?act=mod&id=<?php echo $list['id'];?>"  data-role="button" data-icon="Gear" data-iconpos="notext" data-theme="c" data-inline="true">客户跟进</a>
                    </div>
                    
                     <div class="ui-block-a" style="width:20%">行业                     	
                    </div>
                    <div class="ui-block-b" style="width:80%"><?php echo $list['addr'];?>
                     	<span style="float:right"><a  data-ajax="false" href="mcustomer_add.php?act=mod2&id=<?php echo $list['id'];?>"  data-role="button" data-icon="edit" data-iconpos="notext" data-theme="c" data-inline="true">修改客户信息</a></span>
                    </div>
                    
                     <div class="ui-block-a" style="width:20%">备注
                    </div>
                    <div class="ui-block-b" style="width:80%"><?php echo $list['services'];?> 
                    </div>
                </div>
                
            </div>
             <?php		 
					  	}
					  ?>
					   <?php page($sqlstr,$page_size,"mcustomer_list.php?industry=" . $industry . "&managerid=". $managerid ."&page",$page);?>
        </div>
         
          <?php
					     $sqlstr=get_sql("select id,username from {pre}manager where pid=".$userId." order by id desc"); 
					     $s_list = $db->getlist($sqlstr); 
								$tabStr ="";
								foreach ($s_list as $vo){	
					     ?>
					  <div data-role="controlgroup" data-type="vertical"> 
				    <a href="./mcustomer_list.php?industry=<?php echo $industry;?>&username=<?php echo $vo['username'];?>" data-ajax="false"  data-role="button"><?php echo $vo['username'];?>
				    	<span class="tips"><?php echo getCustomerCount2($industry,$vo['username'],"true");?></span></a> 				    
				  </div> 
 					 <?php		 
					  	}
					  ?>
    </div>
</div> 
</body>
</html>
