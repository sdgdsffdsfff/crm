 

<table width="100%" height="13%" border="0" class="allhead" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="74%" height="50%" class="websitename">&nbsp;&nbsp;<?=$global_websitename;?></td>
    <td width="26%" align="center" valign="top" ><table class="topdh"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="247" align="center" style="color:#ff0;">&nbsp;
          	<?
          	if ($_SESSION["userdlname"]<>"") echo "��ǰ�û���".$_SESSION["username"];
          	?>
          	
          	</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="50%" valign="bottom" >
    	<div id="topmenu">
    		<ul id="topmenuul">
    			
    			<li class="topmenuli"  style="color:#FBF8D5;"><a href="client_manage.php" style="color:#FBF8D5;" title="�ͻ����Ϲ���">�ͻ�����</a></li>
    			<li class="topmenuli"><a href="market_manage.php" style="color:#FBF8D5;" title="�����г����Ϣ">�г��</a></li>
    			<li class="topmenuli"><a href="chance_manage.php" style="color:#FBF8D5;" title="�̻�����Ŀ����">�̻�����</a> </li>
    			<li class="topmenuli"><a href="calendar_manage.php" style="color:#FBF8D5;" title="�����ճ�">�ճ̹���</a></li>
    			<?
    			if (trim($_SESSION["userdlname"])=="admin")
    			{
    			?>
    			<li class="topmenuli"><a href="user_manage.php" style="color:#FBF8D5;" title="�����ż������û��������ƽ�">��������</a></li>
    			<?
    				}
    				else
    				{
    			?>
    			<li class="topmenuli"><a href="user_mody_pwd.php" style="color:#FBF8D5;" title="�޸������">��������</a></li>
					<?
							}
					?>    			
    			<li class="topmenuli156"><a href="meddic_add.php" style="color:#FBF8D5;" title="רҵMEDDIS��ҵ���ᡢ��Ŀ�ɹ��ʷ���">רҵMEDDIC���۷���</a></li>
    		</ul>
   	  </div>
    	</td>
    <td align="center" class="out"><a href="desktop_manage.php" style="color:#ff8;">����</a> | <a href="../userinfo/help.php" target="frmright" style="color:#ff8;">����</a> | <a href="user_exit.php" style="color:#ff8;">�˳�</a> | <a href="http://www.mindarea.net" target="_blnak" style="color:#ff8;">����</a>
</td>
  </tr>
</table>

