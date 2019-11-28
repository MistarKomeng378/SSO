<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

$id_srko 		= mysql_real_escape_string($_POST['id_srko']);
$cc 			= mysql_real_escape_string($_POST['cc']);
$bulan			= mysql_real_escape_string($_POST['bulan']);
$tahun			= mysql_real_escape_string($_POST['tahun']);


if($_GET['opt']=="hasil"){
	$id_ket					= mysql_real_escape_string($_POST['id_ket']);
	$keterangan_progress	= mysql_real_escape_string($_POST['keterangan_progress']);
	$analisa_masalah		= mysql_real_escape_string($_POST['analisa_masalah']);
	$rencana_perbaikan		= mysql_real_escape_string($_POST['rencana_perbaikan']);
	
	if($_GET['act']=="input"){
		mysql_query("INSERT INTO `keterangan_progress` SET 	`id_ket`				='$id_ket',
															`id_srko`				='$id_srko',
															`cc`					='$cc',
															`bulan`					='$bulan',
															`tahun`					='$tahun',
															`keterangan_progress`	='$keterangan_progress',
															`analisa_masalah`		='$analisa_masalah',
															`rencana_perbaikan`		='$rencana_perbaikan'
												");
		
		
	}elseif($_GET['act']=="edit"){
		mysql_query("UPDATE `keterangan_progress` SET 	`id_srko`				='$id_srko',
														`cc`					='$cc',
														`bulan`					='$bulan',
														`tahun`					='$tahun',
														`keterangan_progress`	='$keterangan_progress',
														`analisa_masalah`		='$analisa_masalah',
														`rencana_perbaikan`		='$rencana_perbaikan'
												WHERE	`id_ket`				='$id_ket'
												");
		
		
		
	}

header("location:../../page.php?page=ket_progress&unit=".ec($id_srko)."-".ec($cc)."-".ec($bulan)."-".ec($id_ket)."-".ec($tahun)."&opt=view");	
	
}
?>