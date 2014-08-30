<?php
header('Content-type:text/json');
session_start();
include_once '../session.php'; 
include_once '../inc/const.php';
$page 			= getvar("page") ? getvar("page") : 1;
$page_size 		= 20;
$sqlstr="select id,companyName,name,tel,mobile,mobiletime,mobilecount,qq,email,emailcount,emailtime,url,remark from {pre}pool where 1=1 ";
$code=getvar("code");
$field=getvar("field");
if($code!=""){
	if($field=="all"){
		$sqlstr = $sqlstr . " and (companyName like '%" . $code . "%' or tel like '%" . $code . "%' or mobile like '%" . $code . "%' or email like '%" . $code . "%' )";
	}else{
		$sqlstr = $sqlstr . " and " . $field . " like '%" .$code . "%'";
	}
}
$sqlstr = $sqlstr . " order by id asc";
$sqlstr = get_sql($sqlstr);
//echo $sqlstr ;
$penson_list = $db->selectLimit ( $sqlstr, $page_size, ($page - 1) * $page_size );
$total_nums = $db->getRowsNum ( $sqlstr );
foreach($penson_list as $vo){
	$output[]=$vo;
} 
if($total_nums==0){
	$output[0]="{id:0,companyName:没有数据}";
	$total_nums=1;
}
$rst['total']=$total_nums;
$rst['rows']=$output;
print(json_encode($rst));
?>
