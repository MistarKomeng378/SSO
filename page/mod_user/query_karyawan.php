<?php
include"../../config/koneksi.php";

$table 		="user";
$nik 		= mysql_real_escape_string($_POST['nik']);
$name 		= mysql_real_escape_string($_POST['name']);
$ex 		= explode("-",$_POST['unit']);
$grup_id 	= mysql_real_escape_string($ex[0]);
$cc		 	= mysql_real_escape_string($ex[1]);
$jab 		= mysql_real_escape_string($_POST['jab']);
$unit 		= mysql_real_escape_string($_POST['unit']);
$email 		= mysql_real_escape_string($_POST['email']);
$level 		= mysql_real_escape_string($_POST['level']);
$password 	= mysql_real_escape_string(md5($_POST['password']));
$create		= date("Y-m-d H:i:s");
$update		= date("Y-m-d H:i:s");

// echo "$first-$last-$email-$password";

	if($_GET['opt']=="edit"){
		
			mysql_query("UPDATE user SET 	`nik`			='".$nik."',
											`name`			='".$name."',
											`email`			='".$email."',
											`password`		='".$password."',
											`cc`			='".$cc."',
											`grup_id`		='$grup_id',
											`level`			='$level',
											`date_update`	='$update'
									WHERE	`nik`			='".$nik."' ");
			
		////////////////////////////////////////////////////////////////////////////							
			$cekRole	= mysql_query("SELECT * FROM role_menu_temp WHERE level='$level' ");
			while($r=mysql_fetch_array($cekRole)){
				mysql_query("REPLACE INTO role_menu VALUES ('$nik','$level','$r[id_menu]')");
			}
		//////////////////////////////////////////////////////////////////////
			$cekPermission	= mysql_query("SELECT * FROM role_permission_temp WHERE level='$level' ");
			while($r=mysql_fetch_array($cekPermission)){
				mysql_query("REPLACE INTO role_permission VALUES ('$nik','$level','$r[id_menu]','$r[id_permission]')");
			}
		////////////////////////////////////////////////////////////////////////////	
			header("location:../../page.php?page=manage_user&succes=1");
	}elseif($_GET['opt']=="simpan"){
		$cek = mysql_num_rows(mysql_query("SELECT * FROM user WHERE nik='$nik'"));
		if($cek >= 1){
			header("location:../../page.php?page=manage_user&failed=1");
		}else{
				mysql_query("INSERT INTO m_karyawan SET `regno`		= '".$nik."',
														`name`		= '".$name."',
														`poscode`	= '$jab',
														`dept`		= '$cc',
														`email`		= '$email',
														`status`	= '0'
														");
				mysql_query("INSERT INTO user SET 	`nik`			='".$nik."',
													`name`			='".$name."',
													`email`			='".$email."',
													`password`		='".$password."',
													`cc`			= '$cc',
													`grup_id`		='$grup_id',
													`level`			='$level',
													`date_reg`		='$create',
													`date_update`	='$update'
													");
		////////////////////////////////////////////////////////////////////////////							
			$cekRole	= mysql_query("SELECT * FROM role_menu_temp WHERE level='$level' ");
			while($r=mysql_fetch_array($cekRole)){
				mysql_query("INSERT INTO role_menu VALUES ('$nik','$level','$r[id_menu]')");
			}
		////////////////////////////////////////////////////////////////////////////
			$cekPermission	= mysql_query("SELECT * FROM role_permission_temp WHERE level='$level' ");
			while($r=mysql_fetch_array($cekPermission)){
				mysql_query("INSERT INTO role_permission VALUES ('$nik','$level','$r[id_menu]','$r[id_permission]')");
			}
		////////////////////////////////////////////////////////////////////////////	
				header("location:../../page.php?page=data_karyawan&succes=1");
		}	
	}
?>