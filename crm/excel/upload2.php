<?php
session_start(); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
 <body>
<form action="" enctype="multipart/form-data" method="post" 
name="uploadfile">上传文件：<input type="file" name="upfile" /><br> 
<input type="submit" value="上传" /><a href="导入客户模版.xls"> 下载Excel客户模版</a> </form> 
<?php 
require_once '../inc/const.php'; 
//print_r($_FILES["upfile"]); 
if(is_uploaded_file($_FILES['upfile']['tmp_name'])){ 
$upfile=$_FILES["upfile"]; 
//获取数组里面的值 
$name=$upfile["name"];//上传文件的文件名 
$type=$upfile["type"];//上传文件的类型 
$size=$upfile["size"];//上传文件的大小  
$tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径 
//判断是否为图片 
//echo $type;
switch ($type){  
case 'application/vnd.ms-excel':$okType=true; 
break; 
case 'text/plain':$okType=true; 
break; 
case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':$okType=true; 
break; 
} 
}
if($okType){   
//把上传的临时文件移动到up目录下面 
$path_parts = pathinfo(__FILE__); 
$path = $path_parts["dirname"] ;
$destination=$path."/upload/".$name;  

move_uploaded_file($tmp_name, $destination); 

echo "文件上传成功啦！";  

set_include_path(get_include_path() . PATH_SEPARATOR . './lib/');
setlocale(LC_ALL, 'zh_CN'); 
date_default_timezone_set('Asia/shanghai');
/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';


//$inputFileName = $destination;
//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
//$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
define('EXCEL_EXTENSION_2003', "xls");
define('EXCEL_EXTENSION_2007', "xlsx"); 

$objWriteExcel=new PHPExcel();

if(getExtendFileName($destination) == EXCEL_EXTENSION_2003)
{
    $inputFileType  = 'Excel5';
    $reader = PHPExcel_IOFactory::createReader($inputFileType); 
    $objWriter=new PHPExcel_Writer_Excel5($objWriteExcel);
}
else if(getExtendFileName($destination) == EXCEL_EXTENSION_2007)
{
    $inputFileType  = 'Excel2007';
    $reader = PHPExcel_IOFactory::createReader($inputFileType); 
    $objWriter=new PHPExcel_Writer_Excel2007($objWriteExcel);//用于2007格式
    
}else if(getExtendFileName($destination) == 'txt')
{
    $inputFileType  = 'CSV';
     $reader = PHPExcel_IOFactory::createReader($inputFileType); 
     $reader->setDelimiter("\t");
     $objWriter->setOffice2003Compatibility(true);
}

$reader->setReadDataOnly(true); 


$objPHPExcel = $reader->load($destination);
echo '<hr />'; 
$objWorksheet = $objPHPExcel->getActiveSheet();

$highestRow = $objWorksheet->getHighestRow();  
$highestColumn = $objWorksheet->getHighestColumn();
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

//定位数据库的重要数据
  $companyName = "";
  $name = ""; 
  $tel = ""; 
  $mobile = "";
  $email ="";
  $address ="";
  $remark="";
  $url="";
  
  $okcount=0;
  $faultcount=0;
 
for ($row = 2; $row <= $highestRow; $row++) {  
     
    //$ID = (string)$objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
    $companyName = (string)$objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
    $name = (string)$objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
    $tel = (string)$objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
    $mobile = (string)$objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
    $email = (string)$objWorksheet->getCellByColumnAndRow(4, $row)->getValue();    
    $qq = (string)$objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
    $addr = (string)$objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
    $remark = (string)$objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
    $url = (string)$objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
    
	  $companyName =escape($companyName);
	  $name = escape($name); 
	  $address =escape($address);
	  $remark=escape($remark);
	  $url=escape($url);
  
    
    
    if(checkMobile($tel)=="3"){
    	$tel="";
    }
    if(checkMobile($mobile)=="3"){
    	$mobile="";
    }
    
    ///把电话，手机的位置放好了
    if(checkMobile($tel)=="1"){
    	$mobile=$tel;
    	$tel="";
    }
    if(checkMobile($mobile)=="2"){
    	$tel=$mobile;
    	$mobile="";
    }
    
    if(checkemail($email)=="3"){
    	$email="";
    }
    
    
    $isvalid=true;
    $errmsg="";
    if(trim($companyName)==""){//公司名字
    	$errmsg= $errmsg . "公司名字不能为空;";
    	$isvalid=false;
    }
    
    //三个多不是的话，就不要导入
    if(checkMobile($phone)=="3" && checkMobile($mobile)=="3" && checkemail($email)=="3"){
    	$errmsg= $errmsg . "电话和手机和电子邮件三者不能为空;";
    	$isvalid=false;
    }
    
    
    $sql = get_sql("select id from {pre}pool where companyName='".$companyName."'");
	$rows = $db->getRowsNum($sql);
	if($rows>0){
		
		$errmsg= $errmsg . "公司名字存在了;";	
		$isvalid=false;	
		
		$data=$db->getonerow($sql);
		
		//更新电话等信息
		$record = array(    	
		'companyName'	=>$companyName,
		'name'		=>$name,
		'addr'		=>$addr, 
		'tel'		=>$tel,
		'mobile'	=>$mobile, 
		'email'		=>$email,
		'qq'		=>$qq, 
		'url'		=>$url,
		'remark'	=>$remark,
		'createTime' =>date('Y-m-d h-m-s') 
		);
		
		$db->update($GLOBALS[databasePrefix].'pool',$record,'id='.$data["id"]);
		
	}
	
	if(trim($email)!=""){
		$sql = get_sql("select id from {pre}pool where email='".$email."'");
		$rows = $db->getRowsNum($sql);
		if($rows>0){
			$errmsg= $errmsg . "电子邮件已经存在了";	
			$isvalid=false;	
		}
	}
	
	if(trim($mobile)!=""){
		$sql = get_sql("select id from {pre}pool where mobile='".$mobile."'");
		$rows = $db->getRowsNum($sql);
		if($rows>0){
			$errmsg= $errmsg . "手机号码存在了";	
			$isvalid=false;	
		}
	}
    
    if($isvalid){
    	$record = array(    	
		'companyName'	=>$companyName,
		'name'		=>$name,
		'addr'		=>$addr, 
		'tel'		=>$tel,
		'mobile'	=>$mobile, 
		'email'		=>$email,
		'qq'		=>$qq, 
		'url'		=>$url,
		'remark'	=>$remark,
		'createTime' =>date('Y-m-d h-m-s') 
		);
		
		$id = $db->insert($GLOBALS[databasePrefix].'pool',$record);
		$okcount=$okcount+1;
	 
    }else{
    	echo $row.".[".$companyName."]没有导入成功！>>>".$errmsg."<br>";
    	$faultcount=$faultcount+1;
    }    
 }

echo "恭喜您,成功导入客户数量【".$okcount."】失败数量【".$faultcount."】";
 
   
}
//echo checkemail("qxinfo@gmail.com.cn");  
// echo checkMobile("0512-63636654");
// echo checkMobile("63636654");    
//  echo checkMobile("021 63636654");
function checkemail($str){
	
	$pattern = "/[a-zA-Z0-9_-]*@[a-zA-Z0-9_-]*+\.[a-zA-Z0-9._-]*$/";
     if (preg_match($pattern,$str)){
     	return "1";
     }else{
     	return "3";
     }
}
function checkMobile($str){
	 $str=trim($str);
     $pattern = "/1[3458]{1}\d{9}$/";
     if (preg_match($pattern,$str))
     {
          Return 1;
     }elseif(preg_match("/[1234567890-]{7,12}$/",$str)){
     	  Return 2;
     }else{
     	  
         Return 3;
     }
}
function getExtendFileName($file_name) {
 
    $extend = pathinfo($file_name);
    $extend = strtolower($extend["extension"]);
    return $extend;
}
function excelTime($date, $time = false) {  
    if(function_exists('GregorianToJD')){  
        if (is_numeric( $date )) {  
        $jd = GregorianToJD( 1, 1, 1970 );  
        $gregorian = JDToGregorian( $jd + intval ( $date ) - 25569 );  
        $date = explode( '/', $gregorian );  
        $date_str = str_pad( $date [2], 4, '0', STR_PAD_LEFT )  
        ."-". str_pad( $date [0], 2, '0', STR_PAD_LEFT )  
        ."-". str_pad( $date [1], 2, '0', STR_PAD_LEFT )  
        . ($time ? " 00:00:00" : '');  
        return $date_str;  
        }  
    }else{  
        $date=$date>25568?$date+1:25569;  
        /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/  
        $ofs=(70 * 365 + 17+2) * 86400;  
        $date = date("Y-m-d",($date * 86400) - $ofs).($time ? " 00:00:00" : '');  
    }  
  return $date;  
}   

function escape($sql_str) {
	    $search = array( "'", ';','(',')'); 
	    $replace = array("‘","；",'（','）');
	    return str_replace($search, $replace, $sql_str);
	}

?>