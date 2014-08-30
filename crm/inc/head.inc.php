 

<table width="100%" height="13%" border="0" class="allhead" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="74%" height="50%" class="websitename">&nbsp;&nbsp;<?=$global_websitename;?></td>
    <td width="26%" align="center" valign="top" ><table class="topdh"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="247" align="center" style="color:#ff0;">&nbsp;
          	<?
          	if ($_SESSION["userdlname"]<>"") echo "当前用户：".$_SESSION["username"];
          	?>
          	
          	</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="50%" valign="bottom" >
    	<div id="topmenu">
    		<ul id="topmenuul">
    			
    			<li class="topmenuli"  style="color:#FBF8D5;"><a href="client_manage.php" style="color:#FBF8D5;" title="客户资料管理">客户管理</a></li>
    			<li class="topmenuli"><a href="market_manage.php" style="color:#FBF8D5;" title="管理市场活动信息">市场活动</a></li>
    			<li class="topmenuli"><a href="chance_manage.php" style="color:#FBF8D5;" title="商机、项目管理">商机管理</a> </li>
    			<li class="topmenuli"><a href="calendar_manage.php" style="color:#FBF8D5;" title="销售日程">日程管理</a></li>
    			<?
    			if (trim($_SESSION["userdlname"])=="admin")
    			{
    			?>
    			<li class="topmenuli"><a href="user_manage.php" style="color:#FBF8D5;" title="管理部门及管理用户、数据移交">基础管理</a></li>
    			<?
    				}
    				else
    				{
    			?>
    			<li class="topmenuli"><a href="user_mody_pwd.php" style="color:#FBF8D5;" title="修改密码等">个人设置</a></li>
					<?
							}
					?>    			
    			<li class="topmenuli156"><a href="meddic_add.php" style="color:#FBF8D5;" title="专业MEDDIS商业机会、项目成功率分析">专业MEDDIC销售分析</a></li>
    		</ul>
   	  </div>
    	</td>
    <td align="center" class="out"><a href="desktop_manage.php" style="color:#ff8;">桌面</a> | <a href="../userinfo/help.php" target="frmright" style="color:#ff8;">帮助</a> | <a href="user_exit.php" style="color:#ff8;">退出</a> | <a href="http://www.mindarea.net" target="_blnak" style="color:#ff8;">官网</a>
</td>
  </tr>
</table>

