<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

$cc 		= mysql_real_escape_string($_POST['cc']);
$tahun		= mysql_real_escape_string($_POST['tahun']);
// $id_srko 	= mysql_real_escape_string($_POST['id_srko']);

$jml	= count($_POST['target']);
for($i=0; $i<$jml; $i++){
	$target		= $_POST['target'][$i];
	$bulan 		= $_POST['bulan'][$i];
	$id_srko 	= $_POST['id_srko'][$i];
	@$id_target 	= $_POST['id_target'][$i];
	mysql_query("REPLACE INTO `target_srko` SET `id_target`	='$id_target',
												`id_srko`	='$id_srko',
												`cc`		='$cc',
												`target`	='$target',
												`bulan`		='$bulan',
												`tahun`		='$tahun' ");
}
header("location:../../page.php?page=data_target_srko&unit=".ec($cc)."&succes=1");
?>