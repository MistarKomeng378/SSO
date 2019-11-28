<?php
include"../../config/koneksi.php";

	$level = mysql_real_escape_string($_POST['level']);

	mysql_query("DELETE FROM role_menu WHERE level='$level'");
	mysql_query("DELETE FROM role_menu_temp WHERE level='$level'");
	mysql_query("DELETE FROM role_permission WHERE level='$level'");
	mysql_query("DELETE FROM role_permission_temp WHERE level='$level'");
	
	$jum1 = count($_POST['id_menu']);
	for($i=0; $i<$jum1; $i++){
		$id_menu = $_POST['id_menu'][$i];
		mysql_query("INSERT INTO role_menu_temp SET level='$level', id_menu='$id_menu'");
	}
	
	$jum2 = count($_POST['permission']);
	for($sp=0; $sp<$jum2; $sp++){
		$ex = explode("-",$_POST['permission'][$sp]);
		$id_permission 	= $ex[1];
		$id_menu 		= $ex[0];
		mysql_query("INSERT INTO role_permission_temp SET level='$level', id_menu='$id_menu', id_permission='$id_permission' ");
	}
	
	$getNik	= mysql_query("SELECT DISTINCT nik FROM user WHERE level='$level'");
	while($r=mysql_fetch_array($getNik)){
		for($i=0; $i<$jum1; $i++){
			$id_menu = $_POST['id_menu'][$i];
			mysql_query("INSERT INTO role_menu SET nik='$r[nik]', level='$level', id_menu='$id_menu'");
		}
		for($sp=0; $sp<$jum2; $sp++){
			$ex = explode("-",$_POST['permission'][$sp]);
			$id_permission 	= $ex[1];
			$id_menu 		= $ex[0];
			mysql_query("INSERT INTO role_permission SET nik='$r[nik]', level='$level', id_menu='$id_menu', id_permission='$id_permission' ");
		}
	}
	
	header("location:../../page.php?page=privileges_lv&set=$level&succes=1");
		
?>