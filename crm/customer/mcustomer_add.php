<?php
session_start();
require_once '../session.php'; 
require_once '../inc/const.php';

$id= getvar('id');
$id=empty($id)?0:$id; 

$industry= getvar('industry');
$act = getvar("act");
$act = empty($act) ? "add2" : $act;

mysql_query(get_sql("update {pre}customer set viewcount=IF(ISNULL(viewcount),0,viewcount) + 1 where id=".$id)); 
$sql = get_sql("select * from {pre}customer where id=".$id." order by id");
$list = $db->getonerow($sql); 
$industry = empty($industry) ? $list['industry'] : $industry;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>客户信息</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="../jquerymobile/jquery.mobile-1.3.2.min.css">
<script src="../jquerymobile/jquery-1.8.3.min.js"></script>
<script src="../jquerymobile/jquery.mobile-1.3.2.min.js"></script>
<body>
<form method="post" action="./customer_ok.php?act=<?php echo $act ?>"  data-ajax="false" >
<div data-role="page" id="page1">
		<div data-role="header" data-position="fixed">
		<a href="../cm.php" data-icon="home"  data-ajax="false" >首页</a><h1>客户信息</h1><a  data-ajax="false"  href="./mcustomer_list.php?industry=<?php echo $industry;?>" data-icon="back">返回</a>
	</div>
    <div data-role="content" style="margin-top:0px;padding-top:0px;"> 

  <div data-role="fieldcontain">
    <label for="name">姓名：</label>
    <input type="text" name="name" id="name" value="<?php echo $list['name']?>" placeholder="你的姓名是？">
    </div>
     
     <div data-role="fieldcontain">
    <label for="name">电话：</label>
    <input name="tel" type="text" id="tel"  value="<?php echo $list['tel']?>"  placeholder="电话"/>
    </div>
    <div data-role="fieldcontain">
    <label for="name">手机：</label>
    <input name="mobile" type="text" id="mobile"  value="<?php echo $list['mobile']?>"  placeholder="手机" />
    </div>
     <div data-role="fieldcontain">
    <label for="name">QQ：</label>    
        <input name="qq" type="text" id="qq"  value="<?php echo $list['qq']?>"  placeholder="QQ" />
    </div>
      
  <div data-role="fieldcontain">
    <label for="name">行业：</label>
    <input name="addr" type="text" id="addr" size="50" value="<?php echo $list['addr']?>"  placeholder="行业"/>
    </div>
     <div data-role="fieldcontain">
    <label for="colors">状态:</label>
     
        <?php getCategoryRadio("industry",$industry); ?>
      
  </div>
     <div data-role="fieldcontain">
     	<textarea name="services" id="services" rows="10" placeholder="首次业务需求"><?php echo $list['services']?></textarea> 
    </div>
 
  <fieldset data-role="collapsible">
        <legend>更多-拥有者:<?php echo $list['managerid']?>-查看次数:<?php echo $list['viewcount']?></legend>
         <!--
    <div data-role="fieldcontain">
    <label for="colors">地区：:</label>
    <select name="area" id="area">
        <option>选择地区</option>
        <?php getCategorySelect("area",$list['area']); ?>
      </select>
  </div> 
  <div data-role="fieldcontain">
    <label for="colors">行业:</label>
    <select name="source" id="source">
        <option>选择行业</option>
        <?php getCategorySelect2("sourcetype",$list['source']); ?>
     </select>
  </div>
     <div data-role="fieldcontain">
    <label for="name">地址：</label>
    <input name="addr" type="text" id="addr" size="50" value="<?php echo $list['addr']?>"  placeholder="地址"/>
    </div>
     <div data-role="fieldcontain">
    <label for="name">联系人：</label>
    <input name="httpurl" type="text" id="httpurl" size="50" value="<?php echo $list['httpurl']?>"  placeholder="联系人"/>
    </div>    
    <div data-role="fieldcontain">
    <label for="name">网站：</label>
    <input name="website" type="text" id="website"  value="<?php echo $list['website']?>" />
    </div> 
    <div data-role="fieldcontain">
    <label for="name">传真：</label>
    <input name="fax" type="text" id="fax"  value="<?php echo $list['fax']?>" />
    </div> 
     <div data-role="fieldcontain">
    <label for="name">邮箱：</label>
    <input name="email" type="text" id="email"  value="<?php echo $list['email']?>" />
    </div>
     <div data-role="fieldcontain">
    <label for="name">快递单号：</label> 
        <input name="rank" type="text" id="rank"  value="<?php echo $list['rank']?>" />
    </div>
     <div data-role="fieldcontain">
    <label for="name">skype：</label>
        <input name="skype" type="text" id="skype"  value="<?php echo $list['skype']?>" /> 
    </div> 
     <div data-role="fieldcontain">
    <label for="name">MSN：</label>
    <input name="msn" type="text" id="msn"  value="<?php echo $list['msn']?>" />
    </div>   
 
   <div data-role="fieldcontain">
    <label for="colors">等级:</label>
    <select name="level" id="level">
        <option>选择等级</option>
        <?php getCategorySelect2("leveltype",$list['level']); ?>
      </select>
  </div>   
  -->  
</fieldset> 


<div data-role="controlgroup" data-type="horizontal" align="center"> 
		<input name="id" type="hidden" id="id"  value="<?php echo $list['id']?>" />
    	<input type="submit" data-inline="true" data-icon="check" value="保存"> 
    	<input type="reset" data-inline="true"  data-icon="delete" value="取消"> 
    	<input type="button" data-inline="true" onclick="location.href='mservice_add.php?act=mod&id=<?php echo $list['id']?>';"  data-icon="add" value="小记"> 
  </div>
  
  </div><!--page end-->
   <div data-role="footer" data-position="fixed" style="text-align:center;"> 
    	
    		<h4>Copyright 2014 苏州旗云</h4>
  </div>
   
</div>
</form>
</body>
</html>