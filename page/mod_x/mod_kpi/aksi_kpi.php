<?php
include"../../config/koneksi.php";

$id			= mysql_real_escape_string($_POST['id']);
$kpi		= mysql_real_escape_string($_POST['kpi']);
$definisi	= mysql_real_escape_string($_POST['definisi']);
if($_GET['opt']=="edit"){
	$query = mysql_query("UPDATE `kpi`	SET 	`id_kpi`	='$id' ,
												`kpi`		='$kpi' ,
												`definisi`	='$definisi' 
										WHERE 	`id_kpi`	='$id'");
	
}elseif($_GET['opt']=="tambah"){	
	$query = mysql_query("INSERT INTO `kpi` SET 	`id_kpi`		='$id',
													`kpi`			='$kpi',
													`definisi`		='$definisi'");

}

     header('Location: ../../page.php?page=katalog_kpi&succes=1');

?>