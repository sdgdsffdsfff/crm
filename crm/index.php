<?php
//require_once 'session.php';
require_once 'inc/const.php';

?>
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
<META NAME="Keywords" CONTENT="" />
<META NAME="Description" CONTENT="" />
<TITLE><?php echo $GLOBALS[sitename];?></TITLE>
<link rel="stylesheet" href="Images/CssAdmin.css">
<SCRIPT language=JavaScript>
function switchSysBar()
{
   if (switchPoint.innerText==3)
   {
      switchPoint.innerText=4
      document.all("frameTitle").style.display="none"
   }
   else
   {
      switchPoint.innerText=3
      document.all("frameTitle").style.display=""
   }
}
</SCRIPT>
<link href="css/admin_css.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY scroll="no" topmargin="0" bottom="0" leftmargin="0" rightmargin="0">
<TABLE height="100%" cellSpacing="0" cellPadding="0" border="0" width="100%">
  
  <TR>
    <TD width="200" height="100%" rowspan="2" align="middle" id="frameTitle" >
    <IFRAME 
      style="Z-INDEX:2; VISIBILITY:inherit; WIDTH:200; HEIGHT:100%" 
      name="leftFrame" id="leftFrame"  marginWidth="0" marginHeight="0"
      src="SysLeft.php" frameBorder="0" noResize scrolling="no">	</IFRAME>
	</TD>
    <TD width="10" height="100%" rowspan="2" align="center" bgcolor="#333333" onClick="switchSysBar()">
	<FONT style="FONT-SIZE: 10px; CURSOR: hand; COLOR: #ffffff; FONT-FAMILY: Webdings">
	  <SPAN id="switchPoint">3</SPAN>	</FONT>	</TD>

    <TD height="100%">
	<iframe 
      style="Z-INDEX:4; VISIBILITY:inherit; WIDTH:100%; HEIGHT:100%"
	  name="mainFrame" id="mainFrame" marginwidth="16" marginheight="16"
	  src="customer/customer_workload.php" frameborder="0" noresize scrolling="yes">
	</iframe>
	</TD>
  </TR>
  
</TABLE>
</BODY>
</HTML>