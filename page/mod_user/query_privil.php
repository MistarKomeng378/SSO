<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

	set_time_limit(3600); 
	$nik = mysql_real_escape_string($_POST['nik']);
	$level = mysql_real_escape_string($_POST['level']);

	mysql_query("DELETE FROM role_menu WHERE nik='$nik' AND level='$level'");
	mysql_query("DELETE FROM role_permission WHERE nik='$nik' AND level='$level'");
	
	$jum1 = count($_POST['id_menu']);
	for($i=0; $i<$jum1; $i++){
		$id_menu = $_POST['id_menu'][$i];
		mysql_query("INSERT INTO role_menu SET nik='$nik', level='$level', id_menu='$id_menu'");
	}
	
	$jum2 = count($_POST['permission']);
	for($sp=0; $sp<$jum2; $sp++){
		$ex = explode("-",$_POST['permission'][$sp]);
		$id_permission 	= $ex[1];
		$id_menu 		= $ex[0];
		mysql_query("INSERT INTO role_permission SET nik='$nik', level='$level', id_menu='$id_menu', id_permission='$id_permission' ");
	}
	
	header("location:../../page.php?page=privileges&set=".ec($nik)."&succes=1");
		
?>