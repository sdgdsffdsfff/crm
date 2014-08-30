<?
require_once('../lib07/auto_load.php');


					$smallsql = "select * from smallclass order by id asc";
				  $smallres=$obj->exec($smallsql);
				  $smallallrows=$obj->num_rows($smallres);
				  $smallclass=$obj->fetch($smallres);	
?>

<script language = "JavaScript">
var onecount;
subcat = new Array();
        <?
        $count = 0;
        for ($i=0;$i<$smallallrows;$i++)
        {
        ?>
subcat[<?=$count;?>] = new Array("-<?=trim($smallclass[$i]['smallclassname']);?>-","<?= trim($smallclass[$i]['bigclasscode'])."|".trim($smallclass[$i]['bigclassname']);?>","<?= trim($smallclass[$i]['smallclasscode'])."|".trim($smallclass[$i]['smallclassname']);?>");
        <?
        $count++;
      		}
        ?>
onecount=<?=$count;?>;

function changelocation(locationid)
    {
    document.myform.smallclassname.length = 1;
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid)
            {
                document.myform.smallclassname.options[document.myform.smallclassname.length] = new Option(subcat[i][0], subcat[i][2]);
            }
        }
    }
</script>


            
        <?
				  $classql="select * from bigclass order by classid asc";
				  $objbig=$obj->exec($classql);
				  $allrows=$obj->num_rows($objbig);
				  $bigclass=$obj->fetch($objbig);
				  
//				  echo $bigclass[0]['id']."--".$bigclass[0]['bigclassname'];        
        if ($allrows>0)
        {
        ?>
                    <select name="bigclassname" onChange="changelocation(document.myform.bigclassname.options[document.myform.bigclassname.selectedIndex].value)" size="1">
                      <?
										   
										    for ($i=0;$i<$allrows;$i++)
										    {
										    	 $selclass=$bigclass[$i]['classname'];
											?>
                      <option value="<?=trim($bigclass[$i]['classcode'])."|".trim($bigclass[$i]['classname']);?>">-<?=trim($bigclass[$i]['classname']);?>-</option>
       <?
      										
      										}
      										$selclass=$bigclass[0]['classname'];
      									
				}
			?>
                    </select>
<?	       
					$smsql="select * from smallclass where bigclassname='" . $selclass . "'";
				  $objsmall=$obj->exec($smsql);
				  $smrows=$obj->num_rows($objsmall);
				  $smclass=$obj->fetch($objsmall);
?>            
                    
  							<select name="smallclassname">
                      <option value="" selected>-—°‘Ò–°¿‡-</option>
                      <?

				  		
			if ($smrows>0)
			{
			?>
                      <? 
                      for ($i=0;$i<$smrows;$i++)
                      {
											?>
                      <option value="<?=trim($smclass[$i]['smallclasscode'])."|".trim($smclass[$i]['smallclassname']);?>">-<?=$smclass[$i]['smallclassname'];?>-</option>
                      <?
												}
			}
			?>

                    </select>
							      