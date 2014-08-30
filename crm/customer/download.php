<?
if( empty($_GET['filename'])|| empty($_GET['orgfilename'])){
     echo   "非法链接，请确定";  
     exit();
}
$file_name=$_GET['filename'];
$OrgFilename=$_GET['orgfilename']; 
$file_dir= "../files/";
if   (!file_exists($file_dir.$file_name))   {   //检查文件是否存在  
  echo   "文件找不到";  
  exit;    
  }   else   {  
$file = fopen($file_dir . $file_name,"r"); // 打开文件
// 输入文件标签
Header("Content-type: application/octet-stream");
Header("Accept-Ranges: bytes");
Header("Accept-Length: ".filesize($file_dir . $file_name));
Header("Content-Disposition: attachment; filename=" . $OrgFilename);
// 输出文件内容
echo fread($file,filesize($file_dir . $file_name));
fclose($file);
exit();
}
?>