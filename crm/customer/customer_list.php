<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="../js/boxy.css" rel="stylesheet" type="text/css" /> 
<link href="../js/bootstrap.min.css" rel="stylesheet" type="text/css" /> 
<script src="../js/jquery-1.5.js" type="text/javascript"></script>
</head>
<body style="padding:10px;">  
<?php 
require_once '../session.php';
require_once '../inc/const.php';
$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
$page_size 		= 20;

$sqlstr="select distinct a.* from {pre}customer a left join {pre}person b on a.id=b.cid where 1=1 ";
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


$queryname=getvar(queryname);
if(!empty($queryname) && $queryname!="可以输入客户|联系人名称、地址、电话和手机或电子邮件来查询"){
	$sqlstr=$sqlstr." and (managerid = '".$queryname."' or a.name like '%".$queryname."%' or a.addr like '%".$queryname."%' or a.tel like '%".$queryname."%' or a.mobile like '%".$queryname."%' or a.qq like '%".$queryname."%' or a.email like '%".$queryname."%' or b.email like '%".$queryname."%'  or b.name like '%".$queryname."%')";
}

$source =getvar("source");
if(!empty($source)){
	$sqlstr=$sqlstr." and (a.source='".$source."')";
}
$level =getvar("level");
if(!empty($level)){
	$sqlstr=$sqlstr." and (a.level='".$level."')";
} 
$area =getvar("area");
if(!empty($area)){
	$sqlstr=$sqlstr." and (a.area='".$area."')";
}  



$sqlstr=$sqlstr." order by id desc";
$sqlstr = get_sql($sqlstr);

//echo $sqlstr;
//exit;
$s_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
$total_nums = $db->getRowsNum ( $sqlstr );
?>

<table width="98%" height="1" border="0" cellpadding="3" cellspacing="1" class="table bordered" style="margin:0 auto;padding-top:10px;">
  <form name="myform3" method="post" action="customer_list.php?industry=<?php echo $industry?>">
  <tr>
    <td height="24" colspan="9">
     	<input style="color: #636365;" type="text" name="queryname" id="queryname" size="60" value="<?php echo empty($queryname)?"可以输入客户|联系人名称、地址、电话和手机或电子邮件来查询":$queryname?>" onkeydown="if (event.keyCode==13) {}" onblur="if(this.value=='')value='可以输入客户|联系人名称、地址、电话和手机或电子邮件来查询';" onfocus="if(this.value=='可以输入客户|联系人名称、地址、电话和手机或电子邮件来查询')value='';" value="可以输入客户|联系人名称、地址、电话和手机或电子邮件来查询">
     	<input type="submit" class="button orange" value="查询"><input type="button" onclick="document.all.managerid.value='<?php echo $managerid=="my"?"all":"my";?>';document.myform3.submit();"class="button green" value="查看<?php echo $managerid=="my"?"所有":"自己";?>"> <a href="#" onclick="document.all.queryname.value='';$('#moveCustomerdiv').toggle();">高级查询</a>
     	<div id="moveCustomerdiv" style="display:none;">  来源： 
      <select name="source" id="source">
        <option value="">选择来源</option>
        <?php getCategorySelect2("sourcetype",$source); ?>
      </select>
      等级 
      <select name="level" id="level">
        <option value="">选择等级</option>
        <?php getCategorySelect2("leveltype",$level); ?>
      </select> 
      地区： <select name="area" id="area">
        <option value="">所属地区</option>
        <?php getCategorySelect("area",$area); ?>
      </select>
      状态：
      <select name="industry" id="industry">
        <option value="">选择状态</option>
        <?php getCategorySelect("industry",$industry); ?>
      </select> 
      <input tyep="hidden" name="managerid" value="<?php echo $managerid?>"/>
			</div>
     	</td>
  </tr> 
  </form>
 </table>
 <table width="98%" height="101" border="0" cellpadding="3" cellspacing="1" class="table bordered" style="margin:0 auto;padding-top:0px;">
  <thead>
  <tr bgcolor="#f5f5f5">
    <td width="5%" height="24" align="center" valign="middle">ID</td>
    <td width="18%" height="24" align="center" valign="middle">客户名称<br>联系人</td>
    <td width="18%" align="center" valign="middle">地址<BR>EMail</td>
    <td width="12%" align="center" valign="middle">电话<br>手机</td>    
    <td width="12%" align="center" valign="middle">最近跟进<br />跟进日期</td>
    <td width="10%" align="center" valign="middle">修改日期<br>负责人</td>
    <td   align="center" valign="middle"><?php if($industry=='4'){ echo '金额';} else {echo '首次需求';}?></td> 
    <td width="4%" height="24" align="center" valign="middle">操作</td>
  </tr> 
  </thead>
  <?php
	foreach ($s_list as $list){		 
			$temp_qq = empty($list['qq']) ? "-" : "<a href=\"http://wpa.qq.com/msgrd?V=1&amp;Uin=".$list['qq']."&amp;Site=xitong.jia-xing.net&amp;Menu=yes\" target=\"blank\"><img alt=\"在线洽谈\" src=\"http://wpa.qq.com/pa?p=1:".$list['qq'].":4\" border=\"0\" />".$list['qq']."</a>";
  ?>
  <tr onMouseOver="this.style.background='#f5f5f5'" onMouseOut="this.style.background='#ffffff';"  bgcolor="#ffffff">
    <td width="5%" height="24" align="center" valign="middle"><?php echo $list['id'];?></td>
    <td height="24" align="left" valign="middle"><a href="customer_action.php?act=mod&id=<?php echo $list['id'];?>&page=<?php echo $page;?>"><?php echo $list['name']."<br>".$list['httpurl'];?></a></td>
    <td height="24" align="left" valign="middle"><?php echo $list['addr']. "<br>" . $list['email'];?></td>
    <td height="24" align="left" valign="middle"><?php echo $list['mobile'] . "<br>" . $list['tel'];?></td>
    <td height="24" align="left" valign="middle"><?php echo getLastServices($list['id']);?></td>
    <td height="24" align="left" valign="middle"><?php echo  date('Y-m-d',strtotime($list['dateline'])) ?><br><?=empty($list['managerid'])?"公海":getRealnamebyName($list['managerid']);?></td>
    <td width="15%" height="24" align="left" valign="middle">&nbsp;<?php if($industry=='4'){ echo $list['rank'];} else {
	echo "<a href='customer_action.php?act=mod&id=".$list['id']."&tab=0' title='".$list['services']."'>".utf_substr($list['services'],20)."</a>";}?></td> 
    <td height="24" align="center" valign="middle">&nbsp;<a href="customer_action.php?act=mod&id=<?php echo $list['id'];?>&page=<?php echo $page;?>"><img src="../images/edit.gif" border="0" /></a> 
	<?php if($_SESSION['supermanager']<6){?>
	<a href="customer_ok.php?id=<?php echo $list['id']; ?>&act=del" onClick="javascript:return confirm('确实要删除吗?')"><img src="../images/del.gif" border="0" /></a>
	<? } ?>
	</td>
  </tr>
  <?php		 
  	}
  ?>
  <tr>
    <td height="24" colspan="9" bgcolor="#F8FCF6"><?php page($sqlstr,$page_size,"customer_list.php?industry=" . getvar(industry) . "&managerid=". $managerid . "&queryname=" .$queryname ."&page",$page);?></td>
  </tr>
   </table>
      
	<div class="h2 text-center">下属客户情况</a>
	<table class="table table-hover table-bordered"> 
	 <thead>
  <tr bgcolor="#f5f5f5" class="text-center"><td>姓名</td><td>客户数量</td></tr>
   </thead>
    <?php
     $sqlstr=get_sql("select id,username,usermenu from {pre}manager where pid=".$userId." order by id desc"); 
     $s_list = $db->getlist($sqlstr); 
			$tabStr ="";
			foreach ($s_list as $vo){	
     ?>
   <tr><td>
    <a href="./customer_list.php?industry=<?php echo $industry;?>&username=<?php echo $vo['username'];?>"><?php echo $vo['usermenu'];?></a>
   </td><td>
    <span class="tips"><?php echo getCustomerCount2($industry,$vo['username'],"true");?></span>
   </td></tr>
     <?php		 
		  	}
		  ?>
</table>
	    
					  
 					
</body>
</html> 
