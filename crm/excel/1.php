<?php  
session_start();
include_once '../session.php'; 
include_once '../inc/const.php';
header( "Cache-Control: public" );
header( "Pragma: public" );
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=客户池.csv");
header('Content-Type:APPLICATION/OCTET-STREAM');
$s = getvar("s");
echo $s;
    ?>