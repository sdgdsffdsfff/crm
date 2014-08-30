<?php
session_start();
require '../session.php'; 
include '../inc/const.php';

$fid = getvar("fid");

$page 			= getvar("page") ? getvar("page") : 1;
$page_size 		= 20;
$sqlstr=get_sql("select * from {pre}industry order by rank asc,id asc");
$area_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
$total_nums = $db->getRowsNum ( $sqlstr );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="../css/admin_css.css" rel="stylesheet" type="text/css" /></head>
<script>
function checkreg()
{
if (document.myform.name.value=="") {
	window.alert("类别名称不能为空！！");
	document.myform.name.focus();		
	 return (false);
	}
if (document.myform.rank.value=="") {
	window.alert("排序ID不能为空！！");
	document.myform.rank.focus();		
	 return (false);
	}
	return true;
}
</script>
<body>
<table width="98%" height="126" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <form name="myform" action="customer_industry_ok.php?act=add" method="post" onSubmit="return checkreg();">
    <tr>
      <td height="24" colspan="2" bgcolor="#555555"><font color="#FFFFFF">&nbsp;<strong>添加客户状态</strong></font></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">上级客户状态：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><select name="fid">
        <option value="0">--顶级类别--</option>
          <?php getCategorySelect("industry",$fid); ?>
        </select>      </td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">客户状态：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="name" type="text" id="name" size="30" /></td>
    </tr>
    <tr>
      <td width="13%" height="24" align="right" valign="middle" bgcolor="#f1f1f1">排序ID：</td>
      <td width="87%" height="24" align="left" valign="middle" bgcolor="#f1f1f1"><input name="rank" type="text" id="rank" size="20" value="0" /></td>
    </tr>
    <tr>
      <td height="24" bgcolor="#f1f1f1">&nbsp;</td>
      <td height="24" bgcolor="#f1f1f1"><input type="submit" name="button" id="button" value="提交" /></td>
    </tr>
  </form>
</table><br />
<table width="98%" height="94" border="0" cellpadding="3" cellspacing="1" bgcolor="#cccccc" style="margin:0 auto;padding-top:10px;">
  <tr bgcolor="#666666">
    <td height="22" colspan="4" bgcolor="#555555"><font color="#FFFFFF">&nbsp;<strong>客户状态</strong></font></td>
  </tr>
  <tr bgcolor="#f9f9f9">
    <td width="5%" height="24" align="center" valign="middle">ID</td>
    <td width="30%" height="24" align="center" valign="middle">客户状态</td>
    <td align="center" valign="middle">上级状态</td>
    <td width="25%" height="24" align="center" valign="middle">操作</td>
  </tr>
  <?php
  	foreach($area_list as $list){
		$fid_name = get_table_row("industry",$list['fid'],"name");
		$fid_name = empty($fid_name) ? "顶级类别" : $fid_name;
  ?>
  <tr bgcolor="#f9f9f9">
    <td width="5%" height="24" align="center" valign="middle"><?php echo $list['id'];?></td>
    <td width="30%" height="24" align="center" valign="middle"><a href="customer_industry_action.php?act=mod&id=<?php echo $list['id'];?>&fid=<?php echo $list['fid'];?>"><?php echo $list['name'];?></a></td>
    <td align="center" valign="middle"><?php echo $fid_name;?></td>
    <td width="25%" height="24" align="center" valign="middle"><a href="customer_industry_action.php?act=mod&id=<?php echo $list['id']; ?>&page=<?php echo $page;?>"><img src="../images/edit.gif" border="0" /></a> <a href="customer_industry_ok.php?id=<?php echo $list['id']; ?>&act=del" onClick="javascript:return confirm('确实要删除吗?')"><img src="../images/del.gif" border="0" /></a></td>
  </tr>
  <?php
	}
  ?>
  <tr>
    <td height="24" colspan="4" bgcolor="#F8FCF6"><?php page($sqlstr,$page_size,"customer_industry.php?page",$page);?></td>
  </tr>
</table>
</body>
</html>
