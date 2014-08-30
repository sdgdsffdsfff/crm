<?php
//模板管理类

class tpl_manage {
	
	var $maindir;   //模板路径
	var $dirl;  //当前模板路径上一级
	var $dirr;  
	var $file;  //当前路径下的文件
	var $furl;  //当前文件的完事路径
	var $sysdir; //系统路径
	
	//设置变量及初始化   
    function setdirvar($sysdir,$tempdir,$tempfile,$tempfolder){
		$this->sysdir = $sysdir;  			 //系统目录
		$this->maindir = $sysdir.$tempdir;	 //模板目录
		$this->tempfile = $tempfile;		 //当前文件
		$this->tempfolder = $tempfolder;	 //当前文件夹
		if(strlen(dirname ( $this->maindir ) . '/') < strlen($sysdir)){
			$this->dirl = $sysdir;
		}else{
			$this->dirl = dirname ( $this->maindir ) . '/';
		}
		if(!empty($this->tempfile)){
			$this->maindir .= $this->tempfile;
		}elseif(!empty($this->tempfolder)){
			$this->maindir .= $this->tempfolder;
		}else{
			$this->maindir .= "";
		}
		$this->viewdir($this->maindir);
	}
	//打开目标文件或者目录时
	function viewdir($temp_dir){
		if(is_file($temp_dir)){
			$file_template=$temp_dir;//模板路径
			$file_content=fopen($file_template,'rb');
			$str_temp=fread($file_content,filesize($file_template));
			$this->template_file($str_temp);
		}
		if(is_dir($temp_dir)){
			if ($dh = opendir($temp_dir)) {
				while (($file = readdir($dh)) !== false) {
					if ($file != "." && $file != "..") {
						$array_file[] = $file;
					}
				}
				closedir($dh);
			}
			foreach ($array_file as $filename){
				if(is_file($temp_dir."/".$filename)){
					$filepicarray = array("png","jsp","asa","bat","bat","rm","mp3","pdf","wma","rmvb","asp","html","shtml","php","css","txt","gif","jpeg","jpg","bmp","swf","mdb","doc","xls","rar","zip","exe","xml","xsl","vbs");
					$ext=strrpos($filename, ".");   
					if ($ext) $fileext=substr($filename, $ext+1, strlen($filename) - $ext); 
					if(in_array($fileext,$filepicarray)) {
						$filepic = $fileext;
					}else{
						$filepic = "file";
					}
					if(in_array($fileext,array("php","html","htm"))){
						$fileurl = "template_manage.php?filename=$filename";
					}else{
						$fileurl = "#";
					}
					
				}else{
					$filepic = "folder";
					$fileurl = "template_manage.php?foldername=$filename";
				}
				
				$str_temp .= "<div style=\"width:120px;float:left;margin:20px 20px 0 20px;\"><div style='width:120px;height:120px;border:1px solid #ccc;text-align:center;float:left;'><a href=\"".$fileurl."\" title=\"".$filename."\"><img src=\"".$this->sysdir."inc/images/".$filepic.".gif\" style=\"margin-top:30px;\" border=\"0\"></a></div><div style=\"width:120px;float:left;text-align:center;line-height:30px;\"><a href=\"#\" title=\"".$filename."\">".$filename."</a></div></div>";
			}
			$this->template_folder($str_temp);
		}
	}
	//浏览的目标为文件时
	function template_file($value){
		$str_temp = "<form name=\"temp_mod\" action=\"template_manage.php?act=tmod&filename=".$this->tempfile."\" method=\"post\"><tr bgcolor=\"#ffffff\"><td colspan=\"4\"  valign=\"middle\"><textarea name=\"file_content\" id=\"file_content\" cols=\"100\" rows=\"25\" style=\"width:98%\">".stripslashes($value) ."</textarea></td></tr><tr bgcolor=\"#ffffff\"><td colspan=\"4\"  valign=\"middle\" align=\"center\"><input type=\"submit\" name=\"button\" id=\"button\" value=\"修改\" />&nbsp;&nbsp;<input type=\"button\" name=\"button\" id=\"button1\" value=\"返回\" onclick=\"javascript:window.history.back();\" /></td></tr></form>";
		echo $str_temp;
	}
	//浏览的目标为文件夹时
	function template_folder($value){
		$str_temp = "<tr bgcolor=\"#ffffff\"><td colspan=\"4\"  valign=\"middle\">".$value ."</td></tr>";
		echo $str_temp;
	}
	
}
?>