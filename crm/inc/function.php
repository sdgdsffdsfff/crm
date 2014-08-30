<? 

function getCustomerCount($industry="1"){
	global $db;
	$category_arr = $db->getOneRow(get_sql( "SELECT count(*) as c FROM {pre}customer WHERE managerid='" . $_SESSION['username'] . "' and industry='" . $industry . "'" ));
	return $category_arr['c']; 
}
function getCustomerCount2($industry="0",$username,$ismanager="false"){
	global $db;
	$username = empty($username) ? $_SESSION['username'] : $username; 
	if($ismanager =="false"){
		$sqlstr =  "SELECT count(*) as c FROM {pre}customer WHERE managerid in ('" . $username . "')";
	} else{
		$userid=getUseridByName($username); 
		$sqlstr =  "SELECT count(*) as c FROM {pre}customer WHERE managerid in ( '" . $username."'". getsubmanager($userid) . ")"  ;	
	}	
	if($industry!="0" && $industry!=""){
		$sqlstr  = $sqlstr  . "  and  industry='" . $industry . "' ";
	}
	//echo $sqlstr;
	$category_arr = $db->getOneRow(get_sql($sqlstr));	 
	return $category_arr['c']; 
}

function getServicesCount($industry="1",$username,$ismanager="false"){
	global $db;
	$username = empty($username) ? $_SESSION['username'] : $username; 
	if($ismanager =="false"){
		$sqlstr =  "SELECT count(*) as c FROM {pre}Services WHERE userid in ('" . $username . "') and isdel=0 and remindTime!='0000-00-00' and type='" . $industry . "'"  ;
	} else{
		$userid=getUseridByName($username); 
		$sqlstr =  "SELECT count(*) as c FROM {pre}Services WHERE userid in ( '" . $username."'". getsubmanager($userid) . ") and isdel=0 and remindTime!='0000-00-00' and type='" . $industry . "'"  ;	
	}	
	$category_arr = $db->getOneRow(get_sql($sqlstr));	 
	return $category_arr['c']; 
}

function getCategoryRadio($tablename,$select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->getList (get_sql( "SELECT * FROM {pre}$tablename WHERE 1=1 order by rank" ));
	 
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$fid = $category ['fid'];
		$name = $category ['name'];
		$selected = $select_id==$id?'checked':'';
		echo "<input type=\"radio\" name=\"" . $tablename . "\" id='". $name ."'value=\"".$id."\" ".$selected."><label for=\"" . $name . "\">" . $name."</label>\n";
		//getCategorySelect ($tablename,$select_id, $id, $level );
	} 
}
//获取下拉菜单类别
function getCategorySelect($tablename,$select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->getList (get_sql( "SELECT * FROM {pre}$tablename WHERE fid = " . $id . " order by rank" ));
	for($lev = 0; $lev < $level * 2 - 1; $lev ++) {
		$level_nbsp .= "&nbsp;";
	}
	if ($level++)
		$level_nbsp .= "┝";
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$fid = $category ['fid'];
		$name = $category ['name'];
		$selected = $select_id==$id?'selected':'';
		echo "<option value=\"".$id."\" ".$selected.">".$level_nbsp . " " . $name."</option>\n";
		getCategorySelect ($tablename,$select_id, $id, $level );
	} 
}
function getCategoryName($typename,$select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->getOneRow(get_sql( "SELECT * FROM {pre}dic WHERE type = '" . $typename . "' and code='" . $select_id . "'" ));
	return $category_arr['name']; 
}
function getCategoryRemark($typename,$select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->getOneRow(get_sql( "SELECT * FROM {pre}dic WHERE type = '" . $typename . "' and code='" . $select_id . "'" ));
	return $category_arr['remark']; 
}
function getCategorySelect2($typename,$select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->getList (get_sql( "SELECT * FROM {pre}dic WHERE type = '" . $typename . "' order by sort" ));
	for($lev = 0; $lev < $level * 2 - 1; $lev ++) {
		$level_nbsp .= "&nbsp;";
	}
	if ($level++)
		$level_nbsp .= "┝";
	foreach ( $category_arr as $category ) {
		$id = $category ['code'];
		$fid = $category ['fid'];
		$name = $category ['name'];
		$selected = $select_id==$id?'selected':'';
		echo "<option value=\"".$id."\" ".$selected.">".$level_nbsp . " " . $name."</option>\n";
		//getCategorySelect2 ($typename,$select_id, $id, $level );
	} 
}
function getsubmanager($mId=0){
	global $db;
	if($mId=="")$mId=0;
	$sqlstr=get_sql("select id,username from {pre}manager where pid=".$mId." order by id desc"); 
	//echo $sqlstr;
	//exit;
	$s_list = $db->getlist($sqlstr); 
	$tabStr ="";
	foreach ($s_list as $vo){	
		$tabStr = $tabStr .",'". $vo['username']."'";
		$tabStr = $tabStr . getsubmanager($vo['id']);
	}
	return $tabStr;
}
function genServices($pid,$id){
	global $db;
	$sqlstr=get_sql("select * from {pre}services where isdel=0 and pid=".$pid." order by id desc"); 
	$s_list = $db->getlist($sqlstr); 
	$tabStr ="";
	foreach ($s_list as $vo){	
		$i=$i+1;
		$remindTime=$vo['remindTime'];
		$dateline=$vo['dateline']; 
		
		$tabStr = $tabStr .'<div style="margin:5px 5px 5px 25px;align:left;border:1px solid #9cafdc"><table width="100%" border=0px cellpadding="0" cellspacing="0"><tr bgcolor="#f5f5f5">';
		$tabStr = $tabStr .'<td  align="left" height=27px valign="middle">'. getRealnamebyName($vo['userid']) .'在 '. $dateline.'回复了';
		if("0000-00-00"!=$remindTime){  
			$tabStr = $tabStr . "，提醒下次联系时间：".$remindTime;
		}
		if($vo['filename']!=""){
			$tabStr = $tabStr .'　<a href="download.php?filename='.$vo['filename'].'&orgfilename='.$vo['orgfilename'].'"><img src="../images/paperclip.png" width=15px heigh=16px border="0" title="下载这个附件['.$vo['orgfilename'].']"/></a>';
		}
		$tabStr = $tabStr .'　<a onclick="movemsgform(\''.$vo['id'].'\')" href="#customer_action.php?tab=1&act=mod&pid='. $vo['id'].'&id='.$id .'"><img src="../images/repeat.png" width=15px heigh=16px border="0" title="回复这个跟进"/></a>';  
		$tabStr = $tabStr .'　<a href="customer_ok.php?act=delService&sid='.$vo['id'].'&id='.$id.'" onClick="javascript:return confirm(\'确实要删除吗?\')"><img src="../images/remove.png" width=15px heigh=16px border="0" title="删除这个跟进"/></a></div></td>';
		$tabStr = $tabStr .'</tr>';
		$tabStr = $tabStr .'<tr bgcolor="#f5f5f5">';
		$tabStr = $tabStr .'<td> <div align="left">'.$vo['name'].'</div>';
	 	$tabStr = $tabStr . genServices($vo['id'],$id);
		$tabStr = $tabStr .'</td>';
		$tabStr = $tabStr .'</tr></table></div>';
	}
	return $tabStr;
}
//根据CID获取类别名称
function getclass($cid){
	global $db;
	$list = $db->getOneRow(get_sql("select * from {pre}class where id = " . $cid));
	return  $list['name'];
}
//获取文章状态
function getstate($state){
	$temp = $state==0?'<span font=blue></span>':'<span font=red></span>';
	echo $temp;
}
//获取标题样式
function getstyle($tablename,$id,$content){
	global $db;
	$temp="";
	$list = $db->getOneRow(get_sql("select style,title_bold,title_em,title_u from {pre}$tablename where id = " . $id));
	$temp = $content;
	if (strlen($list['style'])>0){$temp = "<font color=". $list['style'] .">". $temp ."</font>"; }
	if (strlen($list['title_bold'])>0){$temp = "<b>". $temp ."</b>"; }
	if (strlen($list['title_em'])>0){$temp = "<em>". $temp ."</em>";}
	if (strlen($list['title_u'])>0){$temp = "<u>". $temp ."</u>"; }
	return $temp;
}

//获取传递参数
function getvar($var){
	$result = isset($_GET[$var])?$_GET[$var]:$_POST[$var];
	$result = addslashes(trim($result));
	return $result;
}

//后台用分页
function page($sqlstr,$pagesize,$url,$page){
	global $db;
	$p = $page;
	$p = empty($page)?1:$page;
	$totle_nums=$db->getRowsNum($sqlstr);
	$page_nums=ceil($totle_nums/$pagesize);
	$pre_page=($page-1)<1?1:$page-1;
	$next_page=($page+1)>$page_nums?$page_nums:$page+1;
	$var_temp= '<div class=page><span><strong>'.$p.'/'.$page_nums.'</strong></span>　<!--a href='.$url.'=1><<</a--><a href='.$url.'='.$pre_page.'>上页</a>　';
	$i=($pre_page < 3)?1:$pre_page -3;
	$pages=($next_page+3<$page_nums)?$next_page+3:$page_nums;
	for(;$i<$pages+1;$i++){
		if($p==$i){
			$var_temp.= ' <a href='.$url.'='.$i.' class=in>'.$i.'</a>';
		}else{
			$var_temp.= ' <a href='.$url.'='.$i.'>'.$i.'</a>';
		}
	}
	$var_temp.= '　<a href='.$url.'='.$next_page.'>下页</a><!--<a href='.$url.'='.$page_nums.'>>></a--></div>';
	echo $var_temp;
}

function mpage($sqlstr,$pagesize,$url,$page){
	global $db;
	//$p = $page;
	$p = empty($page)?1:$page;
	$totle_nums=$db->getRowsNum($sqlstr);
	$page_nums=ceil($totle_nums/$pagesize);
	$pre_page=($page-1)<1?1:$page-1;
	$next_page=($page+1)>$page_nums?$page_nums:$page+1;
	$var_temp= '<div class=page><span><a href='.$url.'='.$pre_page.'>上一页</a>　<strong>'.$p.'/'.$page_nums.'/'.$totle_nums.'</strong></span>　';
	//for($i=1;$i<$page_nums+1;$i++){
	//	if($p==$i){
	//		$var_temp.= '　'.$i.'';
	//	}else{
	//		$var_temp.= '　<a href='.$url.'='.$i.'>'.$i.'</a>';
	//	}
	//}
	$var_temp.= '<a href='.$url.'='.$next_page.'>下一页</a></div>';
	echo $var_temp;
}



//处理SQL中表名前缀{pre}
function get_sql($sql_str){
	$sql_temp = str_replace('{pre}',$GLOBALS[databasePrefix],$sql_str);
	return $sql_temp;
}
//获取栏目深度
function get_depth($fid){
	global $db;
	$list = $db->getonerow(get_sql("select * from {pre}class where id = ".$fid));
	$temp = ($fid == '0') ? 0 : $list['depth'];
	return $temp;
}
//返回所有子节点 1，2，3，
function get_sons($cid){
	global $db;
	$list = $db->getonerow(get_sql("select sons from {pre}class where id=".$cid));
	$temp = empty($list['sons']) ? $cid : $list['sons'];
	return $temp;
}
//递归，更新上级目录中的son字段
function get_update_sons($fid,$id){
	global $db;
	$temp_id = $id;
	if ($fid > 0) {
		$list = $db->getonerow(get_sql("select id,sons,fid from {pre}class where id=".$fid));
		$temp = empty($list['sons']) ? $id : $list['sons'].','.$temp_id;
		mysql_query(get_sql("update {pre}class set sons='". $temp ."' where id=".$fid));
		get_update_sons($list['fid'],$temp_id);
	}
}
//根据ID获取FID
function get_fid($id){
	global $db;
	$list = $db->getonerow(get_sql("select fid from {pre}class where id=".$id));
	return $list['fid'];
}
//判断是不是超级管理员/系统管理员
function get_supermanager($id){
	global $db;
	$id=empty($id)?0:$id;
	$list = $db->getonerow(get_sql("select username from {pre}manager where id=".$id));
	if (!empty($list['username'])){
		return $list['username'];
	}
}
function getUserIDbyName($username){
	global $db;	 
	$list = $db->getonerow(get_sql("select id from {pre}manager where username='".$username."'"));
	if (!empty($list['id'])){
		$id=$list['id'] ;
		$id=empty($id)?0:$id;
		return $id;
	}
}
function getRealnamebyName($username){
	global $db;	 
	$list = $db->getonerow(get_sql("select usermenu from {pre}manager where username='".$username."'"));
	if (!empty($list['usermenu'])){
		$usermenu=$list['usermenu'] ; 
		return $usermenu;
	}else{
		return $username ;
	}
}
//getip
function get_userip(){
	$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
	$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"]; 
	return $user_IP;
}
//截取字符
function utf_substr($str,$len){
	for($i=0;$i<$len;$i++){
		$temp_str=substr($str,0,1);
		if(ord($temp_str) > 127){
			$i++;
			if($i<$len){
				$new_str[]=substr($str,0,3);
				$str=substr($str,3);
			}
		}else{
			$new_str[]=substr($str,0,1);
			$str=substr($str,1);
		}
	}
	return join($new_str);
}
//保存远程图片到本地
function get_remote_img($str){
	define ( ROOT , dirname ( dirname ( dirname ( $_SERVER['SCRIPT_FILENAME'] ) ) ) . '/' );
	$body = stripslashes(stripslashes($str));
	$img_array = array();
	preg_match_all("/(src|SRC)=[\"|'| ]{0,}(http:\/\/(.*)\.(gif|jpg|jpeg|bmp|png))/isU",$body,$img_array);
	$img_array = array_unique($img_array[2]);
	set_time_limit(0);
	$imgUrl = "upload/".strftime("%Y%m%d",time());
	$imgPath = ROOT.$imgUrl;
	$milliSecond = strftime("%H%M%S",time());
	if(!is_dir($imgPath)) @mkdir($imgPath,0777);
	foreach($img_array as $key =>$value)
	{
			$value = trim($value);
			$get_file = @file_get_contents($value);
			$rndFileName = $imgPath."/".$milliSecond.$key.".".substr($value,-3,3);
			$fileurl = $imgUrl."/".$milliSecond.$key.".".substr($value,-3,3);
			if($get_file)
			{
					$fp = @fopen($rndFileName,"w");
					@fwrite($fp,$get_file);
					@fclose($fp);
			}
			$body = ereg_replace($value,$fileurl,$body);
	}
	$body = addslashes($body);
	return $body;
}
//替换HTML字符，用于htmlspecialchars之后出现的&ldquo;&rdquo;&lsquo;&rsquo;&nbsp;等
function get_html_replace($str){
	preg_match_all("/&(.*?);/",$str,$str_array);
	$str_array = array_unique($str_array[0]);
	foreach($str_array as $key => $value){
		$str = str_replace($value,"",$str);
	}
	return $str;
}
//把内容的空格替换成“_”下划线
function get_nbsp($str){
	$temp = str_replace(" ","_",trim($str));
	return $temp;
}
//获取指定表的指定字段
function get_table_row($tablename,$id,$str){
	global $db;
	$sql = get_sql("select id,$str from {pre}$tablename where id=".$id);
	$list = $db->getonerow($sql);
	return $list[$str];
}
function getLastServices($fid){
	global $db;
	$sql = get_sql("select name,dateline,userid from {pre}services where isdel=0 and fid=".$fid." order by id desc limit 1");
	$list = $db->getonerow($sql);
	
	return "<a href='customer_action.php?act=mod&id=".$fid."&tab=1' title='".$list['name']."'>".utf_substr($list['name'],20)."</a><BR>".$list['dateline']."/".getRealnamebyName($list["userid"]);
}
//获取服务复选框列表
function get_services_list($checkbox_name,$act,$services){
	global $db;
	$sql = get_sql("select id,fid,name,rank from {pre}services order by id");
	$s_list = $db->getlist($sql);
	foreach($s_list as $key=>$list){
		if($list['fid'] == 0){$temp = $temp."<br>";}
		$key = $key+1;
		if(isset($services) || strlen($services)>2 || $services > 0 ){
			$temp_services = get_services_id($services);
			$s_array = split(",",$temp_services);
			if(in_array($list['id'],$s_array)){
				$temp .= "<input type=\"checkbox\" name=\"".$checkbox_name."[]\" id=\"service".$checkbox_name."\" value=\"".$key."\" onclick=\"".$act."(".$key.");\" checked=\"checked\" />".$list['name'];
			}else{
				$temp .= "<input type=\"checkbox\" name=\"".$checkbox_name."[]\" id=\"service".$checkbox_name."\" value=\"".$key."\" onclick=\"".$act."(".$key.");\" />".$list['name'];
			}
		}else{
			$temp .= "<input type=\"checkbox\" name=\"".$checkbox_name."[]\" id=\"service".$checkbox_name."\" value=\"".$key."\" onclick=\"".$act."(".$key.");\" />".$list['name'];
		}
	}
	$temp = substr($temp,4,strlen($temp));
	return $temp;
}
//获取服务内容,用于客户列表中
function get_customer_services($str){
	$str_array = split("\|",$str);	
	//if(count(str_array)>1){
	foreach($str_array as $str_list){
		//echo "AAAA".$str ;
		$str_list_array = split(",",$str_list);
		$temp_str = get_table_row("services",$str_list_array[0],"name");
		$temp = empty($temp) ? $temp_str : $temp.",".$temp_str;
	}
	//}
	return $temp;
}
//获取服务内容,用于客户信息修改中
function get_services_id($str){
	$str_array = split("\|",$str);
	foreach($str_array as $str_list){
		$str_list_array = split(",",$str_list);
		//$temp_str = get_table_row("services",$str_list_array[0],"name");
		$temp = empty($temp) ? $str_list_array[0] : $temp.",".$str_list_array[0];
	}
	return $temp;
}
//获取服务内容里的指定字段，主要是查询时间
function get_services_row($service,$row,$id){
	$str_array = split("\|",$service);
	foreach($str_array as $str_list){
		$str_list_array = split(",",$str_list);
		if($str_list_array[0] == $id){
			return $str_list_array[$row];
		}
	}
}
//获取服务里面的服务名，开始时间，结束时间
?>
