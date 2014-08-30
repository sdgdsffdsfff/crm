<html> 
<head> 
	<title>CRM</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="./jquerymobile/jquery.mobile-1.3.2.min.css?v=9">
<script src="./jquerymobile/jquery-1.8.3.min.js"></script>
<script src="./jquerymobile/jquery.mobile-1.3.2.min.js"></script>
</head> 
<body> 
<?php include_once 'inc/const.php'; ?>
	<script type="text/javascript">
	function cm_submit(strurl){
		document.s.action=strurl;
		document.s.submit();
	}	
	</script>
<div data-role="page">

	<div data-role="header" data-position="fixed">
		
		
		<h1>CRM主界面</h1><a data-ajax="false" href="./customer/mcustomer_add.php?industry=<?php echo $industry?>" data-icon="plus">新增客户</a>
	</div><!-- /header -->

	<div data-role="content">	
			
			<div data-role="controlgroup" data-type="vertical" style="margin-top:0px;padding-top:0px;"> 
      <form name="s" id="s" method="post" action="./customer/mcustomer_list.php" style="margin-top:0px;">       	 
    <fieldset data-role="controlgroup" data-type="horizontal">   
				<input type="radio" id="major_comp" name="managerid"  value="all"/>  
				<label for="major_comp">全部</label>  
		  
				<input type="radio" id="major_eng" name="managerid" checked="true" value="my"/>  
				<label for="major_eng">自己</label>   
		</fieldset>
    <input type="search" name="search" id="search" placeholder="搜索内容..."> 
     <!--
  <input type="submit" value="查询" data-icon="search">  
   -->
    </form> 
    </div>     
			
			
					<div data-role="navbar" data-iconpos="left">
            <ul>
                <li>
                    <a href="javascript:cm_submit('customer/mcustomer_time_out.php')" data-transition="fade" data-theme="e" data-icon="star">
                        需要联系客户
                    </a>
                </li>
                
            </ul>
        </div>
		 		  <div data-role="navbar" data-iconpos="left">
            <ul>
                <li>
                    <a href="javascript:cm_submit('customer/mcustomer_list.php?managerid=all')" data-transition="fade" data-theme="" data-icon="">
                        所有客户
                    </a>
                </li>
                 <li>
                    <a href="javascript:cm_submit('customer/mcustomer_list.php?managerid=public')" data-transition="fade" data-theme="" data-icon="">
                        公海客户
                    </a>
                </li>
                <li>
                    <a href="javascript:cm_submit('customer/mcustomer_list.php?managerid=my')" data-transition="fade" data-theme="" data-icon="">
                        我的客户
                    </a>
                </li> 
                <?php                          	
								$category_arr = $db->getList ("SELECT * FROM ".$databasePrefix."industry order by rank" ); 
								foreach ( $category_arr as $category ) { 
									echo "<li><a href=javascript:cm_submit('customer/mcustomer_list.php?industry=".$category['id']."') data-transition='fade' data-theme='' data-icon=''>".$category['name']."<span class='tips'>" . getCustomerCount($category['id']) ."</span></a></li>";															 
								}
								?>
            </ul>
              
        </div>
		 		  
		 		  
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>