<?php
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>客户信息</title>  
<script src="../js/jquery-1.5.js" type="text/javascript"></script>
<script src="../js/jquery.boxy.js" type="text/javascript"></script> 
<script type="text/javascript" src="../editor/umeditor.config.js"></script> 
<script type="text/javascript" src="../editor/umeditor.min.js"></script>  
<link href="../editor/default/css/umeditor.css" type="text/css" rel="stylesheet">  
<link href="../js/boxy.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../inc/js/calenderJS.js"></script>
<script> 
function check_time_out(sid){
	whichEl = eval("service" + sid);
	if (whichEl.style.display == "none"){
		eval("service" + sid + ".style.display=\"\";");
	}else{
		eval("service" + sid + ".style.display=\"none\";");
	}
}
function change_submit(act){
	document.myform1.action = document.myform1.action + "?act=" +act;
	document.myform1.submit(); 
}
function tabPageControl(n)
{
	for (var i = 0; i < tabTitles.cells.length; i++){
		tabTitles.cells[i].className = "tabTitleUnSelected";
	}
	tabTitles.cells[n].className = "tabTitleSelected";
	
	for (var i = 0; i < tabPagesContainer.tBodies.length; i++){
		tabPagesContainer.tBodies[i].className = "tabPageUnSelected";
	}
	tabPagesContainer.tBodies[n].className = "tabPageSelected";
}
function movemsgform(vpid){
	document.myform2.pid.value=vpid;  
	bo=new Boxy($('#msgform'),
	{				title:"跟进",
                    modal: true, //是否为模式窗口 
                    closeText: "关闭",   //关闭功能按钮的标题文字 
                    draggable: false //是否可以拖动
                }
	);
	 
}

function movetome(vpid){
	document.myformnow.pid.value=vpid;
	document.myformnow.submit();
	
}

function moveCustomer(){
	bo=new Boxy($('#moveCustomerdiv'),
	{				title:"客户转移",
                    modal: true, //是否为模式窗口 
                    closeText: "关闭",   //关闭功能按钮的标题文字 
                    draggable: false //是否可以拖动
                }
	);
}

</script>
<link href="../css/admin_css.css" rel="stylesheet" type="text/css">
<style id="positionstyle"  type="text/css">
.tabTitlesContainer{text-align:center;font-weight:bold;font-size:16px;cursor:hand;width:98%;margin:20px 20px 0px 20px;}
.tabTitleUnSelected{background-color:Gray;width:100px;}
.tabTitleUnSelected:hover{background-color:#9cafdc;}
.tabTitleSelected{background-color:#f1f1f1;width:100px;font-weight:bold;}

#tabPagesContainer{text-align:left;font-size:14;width:98%;margin:0px 20px 20px 20px;}
.tabPageUnSelected{background-color:#f1f1f1;display: none;}
.tabPageSelected{background-color: #f1f1f1;display:block;} 

</style>
</head>
<body>
<?php 
require_once '../session.php'; 
require_once '../inc/const.php'; 
$id= getvar('id');
$id=empty($id)?0:$id;
$act = getvar("act");
$act = empty($act) ? "add" : $act;
?>
<div id="moveCustomerdiv" style="display:none;">
		<form name="myformnow" method="post" action="customer_ok.php?act=move">
		<input type="hidden" name="id" id="id" value="<?=$id?>">
		业务员：
		<select name="pid">
			 <option value="0">请选择</option>
			 <?php 
			 $sqlstr=get_sql("select * from {pre}manager where 1=1 order by id desc");
			 $s_list = $db->getlist ( $sqlstr); 
			 foreach ($s_list as $vo){ 
			 		echo "<option value='".$vo['username']."' >".$vo['usermenu']."</option>"; 
			 }	
			 ?>
		</select>
		<input type="submit" name="button" class="button blue" id="button" value="确定" />
		</form>
</div>
<?php 

	mysql_query(get_sql("update {pre}customer set viewcount=IF(ISNULL(viewcount),0,viewcount) + 1 where id=".$id));
	
	//$db->update($GLOBALS[databasePrefix].'customer',$record,'id='.$id);
	$sql = get_sql("select * from {pre}customer where id=".$id." order by id");
	$list = $db->getonerow($sql);
?>
<table class="tabTitlesContainer"  width="96%" border="0" cellpadding="0" cellspacing="0">
<tr id="tabTitles">
<td height="24" class="tabTitleSelected" onClick="tabPageControl(0)">客户信息</td>
<?php if($act=="mod"){?>
<td class="tabTitleUnSelected" onClick="tabPageControl(1)">跟进信息</td>
<td class="tabTitleUnSelected" onClick="tabPageControl(2)">联系人信息</td>
<?php }?>
<td class="tabTitleUnSelected" onClick="tabPageControl(3)"> </td>
<td class="tabTitleUnSelected" onClick="tabPageControl(3)"> </td>
<td class="tabTitleUnSelected" onClick="tabPageControl(3)"> </td>
</tr>
</table>
<table id="tabPagesContainer" width="100%" height="251" border="0" cellpadding="3" cellspacing="0">
  <tbody class="tabPageSelected">
  <form name="myform1" method="post" action="customer_ok.php" onSubmit="return checksubmit();">
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1"><span class="l_col">名称：</span></td>
      <td width="87%" height="24" colspan="3" align="left" valign="middle" bgcolor="#f1f1f1" nowrap="nowrap"><input name="name" type="text" id="name" size="50" value="<?php echo $list['name']?>" />
      	<?php if($list['managerid']!=""){
      			echo "负责人：".getRealnamebyName($list['managerid']);
      		}?>
      </td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" bgcolor="#f1f1f1">地址：</td>
      <td height="24" colspan="3" align="left" valign="middle" bgcolor="#f1f1f1"><input name="addr" type="text" id="addr" size="50" value="<?php echo $list['addr']?>" />
        <?php
		if(!empty($list['viewcount'] )){       
       echo "查看次数：".$list['viewcount']; 
	   }
        ?>
      </td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" bgcolor="#f1f1f1">联系人：</td>
      <td height="24"  align="left" valign="middle" bgcolor="#f1f1f1"><input name="httpurl" type="text" id="httpurl" size="50" value="<?php echo $list['httpurl']?>" /></td>
	  <td align="left" valign="middle" bgcolor="#f1f1f1">网站：</td>
      <td align="left" valign="middle" bgcolor="#f1f1f1"><input name="website" type="text" id="website" size="30" value="<?php echo $list['website']?>" /></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" bgcolor="#f1f1f1">电话：</td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="tel" type="text" id="tel" size="30" value="<?php echo $list['tel']?>" /></td>
      <td align="left" valign="middle" bgcolor="#f1f1f1">手机：</td>
      <td align="left" valign="middle" bgcolor="#f1f1f1"><input name="mobile" type="text" id="mobile" size="28" value="<?php echo $list['mobile']?>" /><image alt="给客户发短信" onclick="opensms('','<?php echo $list['mobile']?>')" title="给客户发短信" src="../js/icons/tel_arrow2.gif"></a></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" bgcolor="#f1f1f1">传真：</td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="fax" type="text" id="fax" size="30" value="<?php echo $list['fax']?>" /></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><span class="l_col">QQ：</span></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><span class="r_col">
        <input name="qq" type="text" id="qq" size="30" value="<?php echo $list['qq']?>" />
      </span></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" bgcolor="#f1f1f1"><span class="l_col">邮箱：</span></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="email" type="text" id="email" size="30" value="<?php echo $list['email']?>" /><image alt="给客户发邮件" onclick="opensms('邮件','<?php echo $list['email']?>')" title="给客户发邮件" src="../js/icons/sms.gif"></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><span class="l_col">快递帐号：</span></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><span class="r_col">
        <input name="rank" type="text" id="rank" size="30" value="<?php echo $list['rank']?>" />
      </span></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" bgcolor="#f1f1f1"><span class="l_col">msn：</span></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="msn" type="text" id="msn" size="30" value="<?php echo $list['msn']?>" /></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><span class="l_col">skype：</span></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><span class="r_col">
        <input name="skype" type="text" id="skype" size="30" value="<?php echo $list['skype']?>" />
      </span></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" bgcolor="#f1f1f1"><span class="l_col">来源：</span></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1">
      <select name="source" id="source">
        <option>选择来源</option>
        <?php getCategorySelect2("sourcetype",$list['source']); ?>
      </select>
      </td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><span class="l_col">等级：</span></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><span class="r_col"><select name="level" id="level">
        <option>选择等级</option>
        <?php getCategorySelect2("leveltype",$list['level']); ?>
      </select>
      </span></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" bgcolor="#f1f1f1">地区：</td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><select name="area" id="area">
        <option>所属地区</option>
        <?php getCategorySelect("area",$list['area']); ?>
      </select></td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1">状态：</td>
      <td height="24" align="left" valign="middle" bgcolor="#f1f1f1"><select name="industry" id="industry">
        <option>选择状态</option>
        <?php getCategorySelect("industry",$list['industry']); ?>
      </select></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="top" bgcolor="#f1f1f1"><span class="l_col">首次需求:</span></td>
      <td height="24" colspan="3" bgcolor="#f1f1f1">
       <!--
       	<?php  
       			echo "<input name=\"managerId\" id=\"managerId\"  type='hidden' value='" . $_SESSION['username'] ."'/>";
       	?>
       	-->
      	<textarea name="services" id="services" style="width:680px;height:60px;"><?php echo $list['services']?></textarea> 
      	 
      	
      	</td>
    </tr>
    <tr>
      <td height="24" colspan="4" ><div align="center">
        <input type="hidden" value="<?php echo $list['id'];?>" name="id" id="id">
        <input type="button" class="button blue"  name="modbtn" id="modbtn" value="保存" onClick="change_submit('<?=$act?>')" />
        <?php if($list['id']==""){ //新增客户?>    
         	<input type="button" class="button orange"name="modbtn" id="modbtn" value="公海客户"  titile="设置成公海客户" onClick="change_submit('public')" /> 
        <?}else{
        		if($list['managerid']==""){ //公海客户
        ?>
        	<input type="button" class="button green"name="modbtn" id="modbtn" value="我要客户" onClick="movetome('<?=$_SESSION['username']?>')" />          
          <?php }elseif($_SESSION['supermanager']<6){ //管理员
          	?>         
         <input type="button" class="button green"name="modbtn" id="modbtn" value="客户转移" onClick="moveCustomer()" />
          <input type="button" class="button orange"name="modbtn" id="modbtn" value="公海客户"  titile="设置成公海客户" onClick="change_submit('public')" /> 
         <?php }else{ //自己客户 
         ?>
         		<input type="button" class="button orange"name="modbtn" id="modbtn" value="公海客户" titile="设置成公海客户" onClick="change_submit('public')" /> 
         <?php }
         
         }//修改客户?>    
        <input type="button" class="button" name="back" id="back" value="返回" onClick="javascript:window.history.go(-1);" />
      </div></td>
    </tr>
  </form>
  </tbody>
  <tbody class="tabPageUnSelected">
  		<?php
if($act == "mod"){

?>
    <tr>
      <td width="13%" height="24"colspan="4"valign="middle" bgcolor="#f1f1f1"> </td>      
    </tr>
    <tr>
      <td width="13%" height="24"colspan="4"valign="middle" bgcolor="#f1f1f1">
  <div id="msgform"  style="position:relative;left:0px;top:0px;float:left;border:2px solid #9cafdc">
  
  <form name="myform2" method="post" enctype="multipart/form-data" action="customer_ok.php?act=addService">
  <table>
  <tr bgcolor="#f5f5f5">
    <td width="100%" colspan="4"  height="24" align="left" valign="middle" nobr>跟进时间： 
	<input size="20" onFocus="HS_setDate(this)" type="text" name="dateline" id="dateline" value="<?php echo date("Y-m-d");?>" /> 
	 提醒时间： <input size="20" onFocus="HS_setDate(this)" type="text" name="remindTime" id="remindTime" value="" /> 
	 
	文件上传：<input type="file" name="upfile" />
    </td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td height="24" colspan="4" align="left" valign="top"> <div align="left">
      <textarea id="name" name="name" style="width:680px;height:60px;"></textarea> 
	  <input type="hidden" value="<?php echo $list['id'];?>" name="id" id="id">
	  <input type="hidden" value="<?php echo getvar("pid");?>" name="pid" id="pid">	  
      <input type="submit" name="modbtn2" class="button blue" id="modbtn2" value="联系小记" />
    </div></td>
  </tr>
  </table>  
  </form> 
  </div>  
  </td>      
    </tr>
  <tr bgcolor="#f5f5f5">
    <td height="24" colspan="4" align="left" valign="top"> 
  <?php
  	$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
	$page_size 		= 20;
	$sqlstr=get_sql("select * from {pre}services where isdel=0 and pid=0 and fid=".$list['id']." order by id desc");
	$s_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
	$total_nums = $db->getRowsNum ( $sqlstr );
    $i=count($s_list)+1;
	foreach ($s_list as $lists){	
		$i=$i-1;
		$remindTime=$lists['remindTime'];
		$remindStatus=$lists['remindStatus']=="0"?"<span title='没有完成'>×</span>":"<span title='已经完成'>√</span>";
		$dateline=$lists['dateline'];
		$pathArr = pathinfo($lists['filename']);
		if($i%2==0){
			$bgcolor="#E8E8E8";
		}else{
			$bgcolor="#f5f5f5";
		}
  ?>
  
  <div style="border:1px solid #9cafdc">
  <table style="margin:5px 5px 5px 25px;paddin-left:5px;border:0px;" cellpadding="0" cellspacing="0">
  <tr bgcolor="<?=$bgcolor?>">
    <td width="8%" height="24" colspan="4" align="left" valign="middle"><?php echo $i?>. <?php echo getRealnamebyName($lists['userid']); ?> 在 <?php echo $dateline?> 跟进了
    <?php if("0000-00-00"!=$remindTime){echo "，提醒下次联系时间：".$remindTime." ".$remindStatus;}?>
    <?php if($lists['filename']!=""){?>  　　<a href="download.php?filename=<?php echo $lists['filename']?>&orgfilename=<?php echo $lists['orgfilename']?>"><img src="../images/paperclip.png" width=15px heigh=16px border="0" title="下载这个附件[<?php echo $lists['orgfilename']?>]"/></a><?php }?>
    　<a onClick="movemsgform('<?php echo $lists['id'];?>')" href="#customer_action.php?tab=1&act=mod&pid=<?php echo $lists['id'];?>&id=<?php echo $id;?>"><img src="../images/repeat.png" width=15px heigh=16px border="0" title="回复这个跟进"/></a>  
    　<a href="customer_ok.php?act=delService&sid=<?php echo $lists['id'];?>&id=<?php echo $list['id'];?>" onClick="javascript:return confirm('确实要删除吗?')"><img src="../images/remove.png" width=15px heigh=16px border="0" title="删除这个跟进"/></a></div></td>
  </tr>
  <tr bgcolor="<?=$bgcolor?>">
    <td height="24" colspan="4" align="center" valign="top"> <div align="left"><?php echo $lists['name']?></div>
    <?php echo genServices($lists['id'],$id);?>
    </td>
  </tr>
  </table></div>
  <?php 
  	}
  ?>
  </td></tr>
  <tr>
    <td height="24" colspan="4" bgcolor="#F8FCF6"><?php page($sqlstr,$page_size,"customer_action.php?page",$page);?></td>
  </tr>
  
  
<?php
}
?>
</tbody> 
<tbody class="tabPageUnSelected"> 
	<SCRIPT> 
<!-- 
function openwin(id){
	//window.open ('customer_person.php?cid=<?=$id?>&id='+id,'newwindow','height=300,width=600,top=20,left=50,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no')
	Boxy.load("customer_person.php?cid=<?=$id?>&id="+id,
	{				title:"联系人管理",
                    modal: true, //是否为模式窗口  
                    closeText: "关闭",   //关闭功能按钮的标题文字
                    draggable: false //是否可以拖动
                }
	);
} 
function opensms(act,target){
	//window.open ('customer_person.php?cid=<?=$id?>&id='+id,'newwindow','height=300,width=600,top=20,left=50,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no')
	Boxy.load("../sms/send.php?act="+act+"&cid=<?=$id?>&target="+target,
	{				title:"发送消息",
                    modal: true, //是否为模式窗口  
                    closeText: "关闭",   //关闭功能按钮的标题文字
                    draggable: false //是否可以拖动
                }
	);
} 
//写成一行 
--> 
</SCRIPT>
    <tr>
      <td width="13%" height="0"colspan="4"valign="middle" bgcolor="#f1f1f1"><a href="#"  onclick="openwin(0)" class="button blue">新增联系人</a></td>      
    </tr>
    <tr>
      <td width="13%" height="0"colspan="4"valign="top" bgcolor="#f1f1f1">
      
      <table width="98%" height="" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc">
  <thead>
  <tr bgcolor="#f9f9f9">
    <td width="15%" height="24" align="center" valign="middle">名字</td>
    <td width="15%" height="24" align="center" valign="middle">电话</td>
    <td width="15%" align="center" valign="middle">手机</td>
    <td width="15%" align="center" valign="middle">email</td>
    <td width="15%" align="center" valign="middle">skype</td>
    <td width="15%" align="center" valign="middle">msn</td>
    <td width="10%" height="24" align="center" valign="middle">操作</td>
  </tr>
  </thead>
  <?php
	$page 			= getvar("page") ? getvar("page") : 1;
	$page_size 		= 20;
	$sqlstr=get_sql("select * from {pre}person where isdel=0 and cid=" .$id." order by id asc");
	$penson_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
	$total_nums = $db->getRowsNum ( $sqlstr );
  	foreach($penson_list as $vo){
  ?>
  <tr bgcolor="#f9f9f9">
    <td width="15%" height="24" align="left" valign="middle"><?php echo $vo['name'];?></td>
    <td width="15%" height="24" align="left" valign="middle"><?php echo $vo['tel'];?></td>
    <td width="15%" height="24" align="left" valign="middle"><?php echo $vo['mobile'];?></td>
    <td width="15%" height="24" align="left" valign="middle"><?php echo $vo['email'];?></td>
    <td width="15%" height="24" align="left" valign="middle"><?php echo $vo['skype'];?></td>
    <td width="15%" height="24" align="left" valign="middle"><?php echo $vo['msn'];?></td>
    <td width="10%" height="24" align="center" valign="middle">
    	<a onClick="openwin(<?=$vo['id']?>)" href="#"><img src="../images/edit.gif" border="0" /></a> 
    	<a href="customer_person.php?cid=<?=$id?>&id=<?php echo $vo['id']; ?>&act=del" onClick="javascript:return confirm('确实要删除吗?')"><img src="../images/del.gif" border="0" /></a></td>
  </tr>
  <?php
	}
  ?>
  <tr>
    <td height="24" colspan="7" bgcolor="#F8FCF6"><?php page($sqlstr,$page_size,"customer_person.php?page",$page);?></td>
  </tr>
</table> 
      
      </td>      
    </tr>
</tbody>
</table>
<script>
<?php  
$tab = getvar("tab");
if(!empty($tab)){
	echo "tabPageControl(".$tab.");";
}
?>
</script>
</body>
</html>
