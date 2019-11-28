<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

$mysql_host 		= "localhost";
$mysql_database 	= "kinerja";
$mysql_user 		= "root";
$mysql_password 	= "";
$conn 				= mysql_connect($mysql_host,$mysql_user,$mysql_password);
mysql_select_db($mysql_database,$conn) or die(include "../index.php");



?>