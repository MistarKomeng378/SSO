<?php
include"../../config/koneksi.php";

$table 		="user";
$nik 		= mysql_real_escape_string($_POST['nik']);
@$nik_baru	= mysql_real_escape_string($_POST['nik_baru']);
$name 		= mysql_real_escape_string($_POST['name']);
$ex 		= explode("-",$_POST['unit']);
$grup_id 	= mysql_real_escape_string($ex[0]);
$unit 		= mysql_real_escape_string($ex[1]);
$email 		= mysql_real_escape_string($_POST['email']);
$level 		= mysql_real_escape_string($_POST['level']);
$password 	= mysql_real_escape_string(md5($_POST['password']));
$create		= date("Y-m-d H:i:s");
$update		= date("Y-m-d H:i:s");

// echo "$first-$last-$email-$password";

	if($_GET['opt']=="edit"){
		
		$jab 		= mysql_real_escape_string($_POST['jab']);
		
			mysql_query("UPDATE user SET 	`nik`			='".$nik."',
											`name`			='".$name."',
											`email`			='".$email."',
											`password`		='".$password."',
											`grup_id`		='$grup_id',
											`level`			='$level',
											`date_update`	='$update'
									WHERE	`nik`			='".$nik."' ");
									
			mysql_query("UPDATE m_karyawan SET 	`regno`			='".$nik."',
												`name`			='".$name."',
												`poscode`		='".$jab."',
												`dept`			='".$unit."',
												`email`			='".$email."',
												`status`		='0'
									WHERE	`regno`				='".$nik."' ");
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
				mysql_query("INSERT INTO user SET 	`nik`			='".$nik."',
													`name`			='".$name."',
													`email`			='".$email."',
													`password`		='".$password."',
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
	}elseif($_GET['opt']=="nik"){	
	
		mysql_query("UPDATE wbs SET pic='$nik_baru' WHERE pic='$nik'");
		mysql_query("UPDATE waktu_kerja2 SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE pencapaian SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE pencapaian SET laporan='$nik_baru' WHERE laporan='$nik'");
		mysql_query("UPDATE mskk SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE mskk_bulanan SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE srkk SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE srkk_bulanan SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE role_menu SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE role_permission SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE `user` SET nik='$nik_baru' WHERE nik='$nik'");
		mysql_query("UPDATE `m_karyawan` SET regno='$nik_baru' WHERE regno='$nik'");
		mysql_query("UPDATE `note_kinerja` SET nik='$nik_baru' WHERE nik='$nik'");
		
		header("location:../../page.php?page=manage_user&succes=1");
	}
?>