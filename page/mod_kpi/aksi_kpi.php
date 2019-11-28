<?php
include"../../config/koneksi.php";

$no_urut	= mysql_real_escape_string($_POST['no_urut']);
$id			= mysql_real_escape_string($_POST['id']);
$kpi		= mysql_real_escape_string($_POST['kpi']);
$definisi	= mysql_real_escape_string($_POST['definisi']);
$tahun		= mysql_real_escape_string(date('Y'));
if($_GET['opt']=="edit"){
	$query = mysql_query("UPDATE `kpi`	SET 	`no_urut`	='$no_urut',
												`id_kpi`	='$id' ,
												`kpi`		='$kpi' ,
												`definisi`	='$definisi' 
										WHERE 	`no_urut`	='$no_urut'");
	
}elseif($_GET['opt']=="tambah"){	
	$query = mysql_query("INSERT INTO `kpi` SET 	`no_urut`		='$no_urut',
													`id_kpi`		='$id',
													`kpi`			='$kpi',
													`definisi`		='$definisi',
													`tahun`			='$tahun'");

}

     header('Location: ../../page.php?page=katalog_kpi&succes=1');

?>