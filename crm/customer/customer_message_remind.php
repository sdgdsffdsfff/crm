<?php
session_start();
require_once '../session.php';

echo "<script>alert('此功能不对免费版开放');location.href='../SysMain.php';</script>";

?>