<?php
$mysql_host = "localhost";
$mysql_database = "db_cakrawala";
$mysql_user = "root";
$mysql_password = "";
$conn = mysql_connect($mysql_host,$mysql_user,$mysql_password);
mysql_select_db($mysql_database,$conn) or die(include "../indexx.htm");
?>