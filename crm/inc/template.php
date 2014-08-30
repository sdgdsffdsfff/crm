<?php

class cls_tpl {


		//自定义模板类
		function tpl_main($act,$id,$cid,$sitepath,$p){
			//$stime=microtime(true); //获取程序开始执行的时间
			$tpl_addr = $this->get_tpl($act);
			$temp = $this->load_tpl($tpl_addr);
			$temp = $this->get_include_file($temp);
			$temp = $this->get_sys_tag($temp,$id,$cid);
			$temp = $this->get_list_tag($temp,$id,$cid,$p);
			$temp = $this->get_url_path($temp);
			$temp = $this->get_sort_tag($temp,$id,$cid);
			$temp = $this->get_title_tag($temp,$id);
			$temp = $this->get_sitepath($temp,$act,$id,$cid);
			if ($id != ""){
				$temp = $this->get_content_content($temp,$id);
				$temp = $this->get_prv_next($temp,$id);
			}
			echo $temp;
			//$etime=microtime(true);//获取程序执行结束的时间
			//$total=$etime-$stime;   //计算差值
			//echo "<br />$total times";
		}
		
		
		//获取要处理的模板
		function get_tpl($act){
			if ($act != "") {
				$temp = $GLOBALS[templatedir].$act.$GLOBALS[rewriteext];
			}else{
				$temp = $GLOBALS[templatedir].$GLOBALS[indextemplate];
			}
			return $temp;
		}
		//载入模板
		function load_tpl($tpl_addr){
			$filetemplate=$tpl_addr;//模板路径
			$file=fopen($filetemplate,'rb');
			$temp=fread($file,filesize($filetemplate));
			return $temp;
		}
		//处理包含文件
		function get_include_file($temp){
			preg_match_all('/<!--#include\sfile=\"(.*?)\"-->/',$temp,$include_tag);
				$include_tagmax=count($include_tag[0]);
				//echo $include_tagmax;
				for($x=0;$x<$include_tagmax;$x++){
					$include_file=$this->load_tpl($GLOBALS[templatedir].$include_tag[1][$x]);
					$temp=str_replace($include_tag[0][$x],$include_file,$temp);
				}
			return $temp;
		}
		//处理系统单标签
		function get_sys_tag($temp,$id,$cid){
			if (!empty($id)){
				$title_temp = $this->get_content_row($id,'title') .$GLOBALS[titlepathsplit]. $this->getclass($this->getclassid($id)) .$GLOBALS[titlepathsplit]. $GLOBALS[sitename];
				$keywords_temp = ($this->get_class_row($this->getclassid($id),'ckeywords') !== "")? $this->get_class_row($this->getclassid($id),'ckeywords') : $GLOBALS[keywords];
				$description_temp = "这是关于".$this->get_content_row($id,'title')."的页面";
				
			}elseif($cid != ""){
				$title_temp = $this->getclass($cid) .$GLOBALS[titlepathsplit]. $GLOBALS[sitename];
				$keywords_temp = ($this->get_class_row($cid,'ckeywords') !== "")? $this->get_class_row($cid,'ckeywords') : $GLOBALS[keywords];
				$description_temp = ($this->get_class_row($cid,'cdescription') !=="")?$this->get_class_row($cid,'cdescription') : $GLOBALS[description];
			}else{
				$title_temp = $GLOBALS[keywords].' - '.$GLOBALS[sitename];
				$keywords_temp = $GLOBALS[keywords];
				$description_temp = $GLOBALS[description];
			}
			preg_match_all('/{sys\.(.*?)}/',$temp,$sys_tag);
			$sys_tagmax = count($sys_tag[0]);
			for($s=0;$s<$sys_tagmax;$s++){
				switch($sys_tag[1][$s]){
					case "title": $temp_str = $title_temp;break;
					case "keywords": $temp_str = $keywords_temp;break;
					case "description": $temp_str = $description_temp;break;
					case "indexname": $temp_str = $GLOBALS[indexname];break;
					default: $temp_str = $GLOBALS[$sys_tag[1][$s]];break;
				}
				$temp = str_replace($sys_tag[0][$s],$temp_str,$temp);
			}
			return $temp;
		}
		//处理列表标签
		function get_list_tag($temp,$id,$cid,$p){
			preg_match_all('/<luocms([\s\S]*?)>([\s\S]*?)<\/luocms>/',$temp,$list_tag);
			$list_tagmax=count($list_tag[0]);
			//echo $list_tagmax;
			for ($l=0;$l<$list_tagmax;$l++){
				$attr = $list_tag[1][$l];
				$code = $list_tag[0][$l]; 
				preg_match_all('/([A-Za-z]{3,})=([\'|\"])(.*?)(\2)/',$attr,$codelist);
				$tempcodeMax=count($codelist[0]);
				$l_src='content';$l_cid='';$l_num=10;$l_type=''; // 属性变量清空
				for ($j=0;$j<$tempcodeMax;$j++){
					$attrName=strtolower($codelist[1][$j]); // 属性名称
					$attrValue=strtolower($codelist[3][$j]); // 属性对应值
					switch($attrName){ // 属性赋值
						case "src":$l_src=$attrValue;break;
						case "cid":$l_cid=$attrValue;break;
						case "fid":$l_fid=$attrValue;break;
						case "num":$l_num=$attrValue;break; // 需要判断是否有效数量，是才赋值
						case "type":$l_type=$attrValue;break;
						case "iscommend":$l_iscommend=$attrValue;break;
					}
				}
				// 根据根据各属性的值生成相应的SQL语句
				$sql_limit="LIMIT 0,$l_num";
				if ($l_type=='list'){
					$l_num_start=($p-1)*$l_num;
					$sql_limit="LIMIT $l_num_start,$l_num";
				}
				$sql_order="ORDER BY id desc";
				
				switch($l_src){
					case "class":
						$sql_table='{pre}class';
						$sql_field='id,fid,son,sons,name,style,title_u,title_bold,title_em';
						$sql_order="ORDER BY id asc";
						break;
					case "content":
						$sql_table='{pre}content';
						$sql_field='id,title,content,style,cid,title_bold,title_em,title_u,state,picture,dateline,count';
						break;
					case "booklist":
						$sql_table='{pre}booklist';
						$sql_field="id,name,email,content,replay,replaytime,state";
						break;
					case "link":
						$sql_table='{pre}link';
						$sql_field='id,name,url,content,addtime,state';
						break;
					case "tags":
						$sql_table='';
						$sql_field='';
						break;	
				}
				//$sql="SELECT * FROM luo_$l_src";
				switch($l_type){
					case "picture":
						$sql_where="ispicture=1";
						break;
					case "hot":
						if (!empty($cid)){
							$sql_where="cid in ($cid)";
						}else{
							$sql_where="";
						}
						$sql_order="ORDER BY count desc";
						break;
					case "top":
						if(!empty($l_iscommend)){
							if (!empty($cid)){
								$sql_where="iscommend=$l_iscommend and cid in ($cid)";
							}else{
								$sql_where="iscommend=$l_iscommend";
							}
						}else{
							if (!empty($cid)){
								$sql_where="iscommend = 2 or (iscommend = 1 and cid in ($cid))";
							}else{
								$sql_where="iscommend > 0";
							}
						}
						$sql_order="ORDER BY iscommend desc,count desc,id desc";
						break;
					case "list":
						$sql_where="";
						$sql_order="ORDER BY rank asc,id desc";
						break;
					case "menu":
						$sql_where="rank>=0 and fid=0";
						$sql_order="ORDER BY id asc";
						break;
					case "booklist":
						$sql_where = "state=1";
						break;
				}
				
				// cid 处理（and）
				//echo $id;
				if (strlen($l_fid)>0) {
					if (strlen($sql_where)>0){$sql_where=' and '.$sql_where;}
					$sql_where='fid in ('.$l_fid.')'.$sql_where;
					
				}
				if (strlen($l_cid)>0) {
					if (strlen($sql_where)>0){$sql_where=' and '.$sql_where;}
					$sql_where='cid in ('.$l_cid.')'.$sql_where;
					
				}
				if ($l_type=='list'){
					if (strlen($sql_where)>0){$sql_where=' and '.$sql_where;}
					if (isset($cid)){
						$sql_where='cid in ('.get_sons($GLOBALS[cid]).')'.$sql_where;
					}
				}
				if ($l_src=='link'){
					if (strlen($sql_where)>0){$sql_where=' and '.$sql_where;}
					$sql_where='state = 1'.$sql_where;
				}
				if ($l_src=='booklist'){
					if (strlen($sql_where)>0){$sql_where=' and '.$sql_where;}
					$sql_where='state = 1'.$sql_where;
				}
				// WHERE 关键字是否需要加上
				if (strlen($sql_where)>0){$sql_where=' WHERE '.$sql_where;}
				$sqlstr=$this->get_sql("SELECT $sql_field FROM $sql_table $sql_where $sql_order $sql_limit");
				
				//echo $sqlstr."<br>";
				$sql_field="";
				$sql_table="";
				$sql_where="";
				$sql_order="";
				$sql_limit="";
				//替换数据
				$temp=str_replace($code,$this->getdata($sqlstr,$code),$temp);
				//替换分页标签
				$url = (empty($cid)) ? 'index' : $this->get_tpl_name($cid,'template').'-'.$cid;
				$cid_temp = (empty($cid)) ? '' : get_sons($cid);
				$var_pagelist=pagelist($cid_temp,$l_num,$url,$p);
				$temp=str_replace('{pagelist}',$var_pagelist,$temp);
				$var_gbook_pagelist=gbook_pagelist($cid_temp,$l_num,$url,$p);
				$temp=str_replace('{gbookpagelist}',$var_gbook_pagelist,$temp);
				//清空临时变量
				$l_src="";
				$l_cid="";
				$l_fid="";
				$l_num="";
				$l_type="";
			}
			return $temp;
		}
		
		//获取列表数据
		function getdata($sqlstr,$code){
			global $db;
			$sort_list=$db->getlist($sqlstr);
				foreach($sort_list as $list){
				preg_match_all('/<luocms([\s\S]*?)>([\s\S]*?)<\/luocms>/',$code,$block_list);
					$hreftemp = $block_list[2][0];
					$formtemp = $block_list[1][0];
					$hreftempnew=$hreftemp;
					preg_match_all('/src=(\")(.*?)(\")/',$formtemp,$srclist);//得到是哪个表的内容
					$src_temp=$srclist[2][0];
					preg_match_all('/src=(\")(.*?)(\")/',$hreftemp,$srclist);//要生成的缩略图的部分
					$s_pic_temp=$srclist[2][0];
					//echo $s_pic_temp;
					preg_match_all('/\[(.*?)\swidth=(\'|\")(.*?)(\'|\")\sheight=(\'|\")(.*?)(\'|\")\]/',$s_pic_temp,$picturex);//生成缩略图并替换标签
					
								$pxMax = count($picturex[0]);
								//echo $pxMax;
								for ($p=0;$p<$pxMax;$p++){
									$pp=$picturex[1][$p];
									//echo $picturex[0][$p];
									$ppw=$picturex[3][$p];
									$pph=$picturex[6][$p];
									$p_picture = $this->get_content_row($list['id'],'picture');
									if (!empty($ppw) && !empty($pph)){
										$img_ext = strrchr($p_picture,'.');
										$p_smallpic = substr($p_picture,0,strlen($p_picture)-strlen($img_ext))."_s".$img_ext;
										if (!file_exists($p_smallpic)) {
											$temp = new CreatMiniature();
											$temp -> SetVar($p_picture,$img_ext);
											$temp -> BackFill('./'.$p_smallpic,$ppw,$pph,"255","255","255");
										}
										$temp_img = "../".$p_smallpic;
									}else{
										$temp_img = "../".$p_picture;
									}
									//echo $picturex[0][$p];
									$hreftempnew=str_replace($picturex[0][$p],$temp_img,$hreftempnew);
								}
					preg_match_all('/\[luo\.(.*?)\]/',$hreftemp,$tName);//处理截取字符标签[luo.cotnent len='180']
					$tArrMax = count($tName[0]);
					for ($k=0;$k<$tArrMax;$k++){
						$t1 = strtolower($tName[0][$k]);// 属性名称[luo.title]
						$t2 = strtolower($tName[1][$k]);//字段名title
						preg_match_all('/(.*?)x\slen=(\'|\")(.*?)(\'|\")/',$t2,$titlex);
						$txArrMax = count($titlex[0]);
						for ($w=0;$w<$txArrMax;$w++){
							$ttr=$titlex[1][$w];
							$tx=$titlex[0][$w];
							$txx="[luo.".$tx."]";
							$len=$titlex[3][$w];
							$temp_c_value = get_html_replace($list[$ttr]);
							$temp_sub_str = utf_substr(htmlspecialchars(strip_tags(stripslashes($temp_c_value))),$len);
							$temp_sub_str_ext = strlen($list[$ttr])>$len ? $temp_sub_str."..." : $temp_sub_str;
							$hreftempnew=str_replace($txx,$temp_sub_str_ext,$hreftempnew);
						}
						switch($t2){//替换内容标签[luo.*]
							case "url"://链接
								switch($src_temp){//根据当前表名用不同的链接地址
									case "content"://内容表
										$urltemp=$this->get_tpl_name($this->getclassid($list['id']),'templateview')."_".$list['id'].$GLOBALS[rewriteext];
										$hreftempnew=str_replace($t1,$urltemp,$hreftempnew);
										break;
									case "link"://友情链接表
										$urltemp=$list['url'];
										$hreftempnew=str_replace($t1,$urltemp,$hreftempnew);
										break;
								}
								break;
							case "classurl"://导航类别中地址
								$urltemp=$this->get_tpl_name($list['id'],'template')."-".$list['id'].$GLOBALS[rewriteext];
								$hreftempnew=str_replace($t1,$urltemp,$hreftempnew);
								break;
							case "content"://内容
								$hreftempnew=str_replace($t1,strip_tags(stripslashes($list[$t2])),$hreftempnew);
								break;
							case "contentc"://显示单条内容时不用去除样式
								$hreftempnew=str_replace($t1,stripslashes($list["content"]),$hreftempnew);
								break;
							case "title"://标题
								$title = getstyle("content",$list['id'],$list['title']);
								$hreftempnew=str_replace($t1,$title,$hreftempnew);
								break;
							case "picture"://原始大小图片
								$hreftempnew=str_replace($t1,'../'.$this->get_content_row($list['id'],'picture'),$hreftempnew);
								break;
							case "replay"://留言板的回复
								$temp_replay = empty($list['replay']) ? "" : "<div class='reply'><div class='gly'><b>管理员回复：</b>".$list['replaytime']."</div><div class='gly_content'>".$list['replay']."</div></div>";
								$hreftempnew = str_replace($t1,$temp_replay,$hreftempnew);
								break;
							default://其它，直接显示字段所对应的内容[luo.name]等
								$hreftempnew=str_replace($t1,$list[$t2],$hreftempnew);
								break;
						}
					}
					$str_temp .= $hreftempnew;
				}
			return $str_temp;
		}
		//将相对路径修改成绝对路径
		function get_url_path($temp){
			$temp_url_path = "/<(link href=|img src=|input src=|script src=)\"(.*?)\"(.*?)>/";
			preg_match_all($temp_url_path,$temp,$url_tag);
			$url_tagmax = count($url_tag[0]);
			
			for($u=0;$u<$url_tagmax;$u++){			
				$inner = $url_tag[2][$u];
				$isuppic = substr($inner,0,13);
				if($isuppic == "{luo.picture}"){
					$replace_temp = "<".$url_tag[1][$u]."\"".$GLOBALS[httpurl].$GLOBALS[installdir].$inner."\"".$url_tag[3][$u].">";
				}else{
					$replace_temp = "<".$url_tag[1][$u]."\"".$GLOBALS[httpurl].$GLOBALS[installdir].$GLOBALS[templatedir].$inner."\"".$url_tag[3][$u].">";
				}
				$temp = str_replace($url_tag[0][$u],$replace_temp,$temp);
			}
			return $temp;
		}
		//处理类别单标签
		function get_sort_tag($temp,$id,$cid){
			if ($cid == "" & $id ==""){
				$sort_name_temp = $GLOBALS[indexname];
			}else{
				$sort_name_temp = ($cid != "")? $this->getclass($cid) :  $this->getclass( $this->getclassid($id));
			}
			$temp=str_replace('{classname}',$sort_name_temp,$temp);
			return $temp;
		}
		//处理单页面标题名称
		function get_title_tag($temp,$id){
			if (!empty($id)){
				$title_name_temp = $this->get_content_row($id,'title');
			}
			$temp=str_replace('{titlename}',$title_name_temp,$temp);
			return $temp;
		}
		//根据CID获取类别名称
		function getclass($cid){
			global $db;
			$list = $db->getOneRow($this->get_sql("select name from {pre}class where id = " . $cid));
			return  $list['name'];
		}
		//根据ID获取类别CID
		function getclassid($id){
			global $db;
			$list = $db->getOneRow($this->get_sql("select cid from {pre}content where id = " . $id));
			return $list['cid'];
		}
		//根据ID获取文章对应字段str
		function get_content_row($id,$str){
			global $db;
			$list = $db->getOneRow($this->get_sql("select * from {pre}content where id = " . $id));
			return $list[$str];
		}
		//根据CID获取类别对应字段str
		function get_class_row($cid,$str){
			global $db;
			$list = $db->getOneRow($this->get_sql("select * from {pre}class where id = " . $cid));
			return $list[$str];
		}
		//处理Sitepath标签
		function get_sitepath($temp,$act,$id,$cid){
			$sitepath="您现在的位置是：";
			if(!empty($id)){
				$sitepath .= "<a href='./'>".$GLOBALS[indexname]."</a>" . $GLOBALS[sitepathsplit] . $this->get_fid_name($id);
			}elseif(!empty($cid)){
				$sitepath.="<a href='./'>".$GLOBALS[indexname]."</a>". $GLOBALS[sitepathsplit] . $this->get_fid($this->get_class_row($cid,"fid")). "<a href='".$this->get_tpl_name($cid,'template')."-".$cid.$GLOBALS[rewriteext]."'>".$this->getclass($cid)."</a>";
				
			}else{
				$sitepath.="<a href='./'>".$GLOBALS[indexname]."</a>";
			}
			$temp=str_replace('{sitepath}',$sitepath,$temp);
			return $temp;
		}
		//处理内容页内容标签
		function get_content_content($temp,$id){
			global $db;
			addcount($id);
			$list = $db->getOneRow($this->get_sql("select * from {pre}content where id = " . $id));
			//$content = $list['content'];
			preg_match_all('/{luo\.(.*?)}/',$temp,$contentx);
				$cxArrMax = count($contentx[0]);
				for ($c=0;$c<$cxArrMax;$c++){
					$temp = str_replace($contentx[0][$c],stripslashes($list[$contentx[1][$c]]),$temp);
				}
			return $temp;
		}
		//处理上一条下一条信息标签
		function get_prv_next($temp,$id){
			global $db;
			$list = $db->getOneRow($this->get_sql("select * from {pre}content where id < " . $id ." and cid = " . $this->getclassid($id) . " order by id desc"));
			if (strlen($list['title']) > 0) {
				$temp_str .= "上一条：<a href=view_".$list['id'].".html>".$list['title']."</a><br>";
			}else{
				$temp_str .= "上一条：没有了<br>";
			}
			$list1 = $db->getOneRow($this->get_sql("select * from {pre}content where id > " . $id ."  and cid = " . $this->getclassid($id) . " order by id asc"));
			if (strlen($list1['title']) > 0) {
				$temp_str .= "下一条：<a href=view_".$list1['id'].".html>".$list1['title']."</a><br>";
			}else{
				$temp_str .= "下一条：没有了<br>";
			}
			$temp = str_replace('{prv_next}',$temp_str,$temp);
			return $temp;
		}
		//处理sql标签中的{pre}
		function get_sql($sql_str){
			$sql_temp = str_replace('{pre}',$GLOBALS[databasePrefix],$sql_str);
			return $sql_temp;
		}
		//获取模板栏目模板名称，没有后缀.html
		function get_tpl_name($cid,$str){
			$temp = $this->get_class_row($cid,$str);
			$tpl_list_temp = substr($temp,0,(strlen($temp)-strlen($GLOBALS[rewriteext])));
			return $tpl_list_temp;
		}
		//递归获取路径中的上级栏目
		function get_fid_name($id){			
			$temp_str = "<a href='".$this->get_tpl_name($this->getclassid($id),'template')."-".$this->getclassid($id).$GLOBALS[rewriteext]."'>".$this->getclass($this->getclassid($id))."</a>";
			$temp_fid = $this->get_class_row($this->getclassid($id),"fid");
			$temp_str = $this->get_fid($temp_fid).$temp_str;
			return $temp_str;
		}
		function get_fid($fid){
				$temp_s = "";
				if($fid > 0){
					$temp_s .= "<a href='".$this->get_tpl_name($fid,'template')."-".$fid.$GLOBALS[rewriteext]."'>".$this->getclass($fid)."</a>".$GLOBALS[sitepathsplit];
					$this->get_fid($this->get_class_row($fid,'fid'));
				}
				//$temp_str .= $temp_s;
			return $temp_s;
		}
}
?>