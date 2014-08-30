<?php 
session_start();
require_once 'session.php';
include_once 'inc/const.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/admin_css.css" rel="stylesheet" type="text/css" />  
</head>
<SCRIPT language=javascript1.2>
function showsubmenu(sid)
{
whichEl = eval("submenu" + sid);
if (whichEl.style.display == "none")
{
eval("submenu" + sid + ".style.display=\"\";");
}
else
{
eval("submenu" + sid + ".style.display=\"none\";");
}
}
</SCRIPT>
<body> 
<table width="199" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle" ><a href="customer/customer_workload.php"  target="mainFrame">PIFASOFT CRM SYSTEM</a></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" align="center" valign="top"><table width="100%" height="158" border="0" cellpadding="0" cellspacing="0" class="left_main_table">
        <tr>
          <td width="100%" align="center" valign="top" bgcolor="#FFFFFF"><table cellspacing="0" cellpadding="0" width="100%" align="center" >
            </table>
           
            <table cellspacing="0" cellpadding="0" width="99%" align="center">
              <tbody>
                <tr>
                  <td height="25" align="center" valign="middle" 
          background="images/admin_left-titlebg.gif" class="menu_title" id="menuTitle1" style="CURSOR: hand" 
          onclick="showsubmenu(3)" 
          onmouseover="this.className='menu_title2';" onmouseout="this.className='menu_title';"><table width="100%" height="24" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="45" height="24" align="center" valign="middle" background="./images/manage/admin_left-titlebg.gif"><img src="images/admin_left-tubiao.gif" width="9" height="9" /></td>
                        <td align="left" valign="middle" background="./images/manage/admin_left-titlebg.gif" class="bai12"><strong class="bai">客户管理</strong></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                	
                  <td align="center" valign="middle" id="submenu3"><table width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#dde3ec" class="sub_table">
                      <tbody>
                       	 <tr>
                          <td height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="customer/customer_workload.php?act=add"target="mainFrame">客户汇总统计</a></td>
                        </tr>
                        <tr>
                          <td height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="customer/customer_action.php?act=add"target="mainFrame">添加客户</a></td>
                        </tr>
                        <tr>
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td">
                          	<a href="customer/customer_list.php" target="mainFrame">所有客户</a><BR>
                          	<a href="customer/customer_list.php?managerid=my" target="mainFrame">我的客户</a><BR>
                          	<?php
                          	
                          	function getCategoryMenu($tablename,$id = 0,$level = 0){
															global $db;
															$category_arr = $db->getList (get_sql( "SELECT * FROM {pre}$tablename WHERE fid = " . $id . " order by rank" ));
															for($lev = 0; $lev < $level * 2 - 1; $lev ++) {
																$level_nbsp .= "&nbsp;";
															}
															if ($level++)
																$level_nbsp .= "　";
															foreach ( $category_arr as $category ) {
																$id = $category ['id'];
																$fid = $category ['fid'];
																$name = $category ['name']; 
																echo $level_nbsp . "<a href='customer/customer_list.php?managerid=my&industry=".$id."' target='mainFrame'>" . $name."</a><BR>";
																getCategoryMenu ($tablename, $id, $level );
															} 
														}
                        	 														 
													  getCategoryMenu ("industry",0);
														?>
                          	<a href="customer/customer_list.php?managerid=public" target="mainFrame">公海客户</a><BR>
                          	</td>
                        </tr>
                         <tr>
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="customer/customer_time_out.php?managerid=my&act=follow" target="mainFrame">最近跟进列表</a></td>
                        </tr> 
                        <tr>
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="customer/customer_time_out.php?managerid=my&act=remind" target="mainFrame">客户提醒列表</a></td>
                        </tr>
                        <tr>
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="excel/index.php" target="mainFrame">大客户池</a></td>
                        </tr> 
                        <tr>
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="sms/send.php" target="mainFrame">发送短信</a></td>
                        </tr>  
                        
                      </tbody> 
                    </table>
                    </td>
                </tr> 
      </table>
       <table cellspacing="0" cellpadding="0" width="100%" align="center" >
              
                <tr>
                  <td height="25" align="center" valign="middle" 
          background="images/admin_left-titlebg.gif" class="menu_title" id="menuTitle1" style="CURSOR: hand" 
          onclick="showsubmenu(0)" 
          onmouseover="this.className='menu_title2';" onmouseout="this.className='menu_title';"><table width="100%" height="26" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="45" align="center" valign="middle" background="./images/manage/admin_left-titlebg.gif"><img src="images/admin_left-tubiao.gif" width="9" height="9" /></td>
                        <td align="left" valign="middle" background="./images/manage/admin_left-titlebg.gif" class="bai12"><strong class="bai">管理员中心</strong></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle" id="submenu0" style="display:block"><table width="100%" align="center" cellpadding="0" cellspacing="0" class="sub_table">
                      <tbody>
                       	<?php
                       	
                       	if($_SESSION['username'] =="admin"){
                       	?>                       	                       
                        <tr>
                          <td height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="customer/customer_industry.php" target="mainFrame">客户状态设置</a></td>
                        </tr>
                        <tr>
                          <td height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="customer/customer_area.php" target="mainFrame">地区设置</a></td>
                        </tr>
                        <tr>
                          <td height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a href="customer/customer_dic.php" target="mainFrame">字典设置</a></td>
                        </tr>
                        <tr class="sub_table_tr">
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" class="sub_table_td"><a 
                  href="manager/admin_add.php" target="mainFrame">添加用户</a></td>
                        </tr>
                        <tr>
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" class="sub_table_td"><a 
                  href="manager/admin_manage.php" target="mainFrame">用户管理</a></td>
                        </tr>  
                        <?php }?>
                        <tr>
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" class="sub_table_td"><a href="manager/admin_mod.php?id=<?php echo $_SESSION['id'];?>" target="mainFrame">密码修改</a></td>
                        </tr> 
                      
                        <tr>
                          <td width="45" height="26" align="center" class="sub_table_td"><img src="images/jt.gif" width="6" height="5" /></td>
                          <td height="26" align="left" valign="middle" class="sub_table_td"><a 
                  href="login.php?act=quit" 
                  target="_parent" onclick="javascript:return confirm('确实要退出管理吗?')">退出管理<?=$_SESSION['username']?></a></td>
                        </tr>
                        
                      </tbody>
                    </table></td>
                </tr> 
            </table>
</body>
</html>
