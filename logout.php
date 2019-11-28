<?php
session_start();
include"config/koneksi.php";
include"config/fungsi_name.php";
include"config/fungsi_timeline.php";

$timelogout	= date("Y-m-d H:i:s");
timeline("$_SESSION[nik]","logout","Telah logout pada jam $timelogout");

session_destroy();
header("location: index.php");
?>