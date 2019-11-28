<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
// include"../../config/fungsi_name.php";
// include"../../config/fungsi_timeline.php";

	
	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	
				$id_penilaian		= $_POST['id_penilaian'];
				$nik				= $_POST['nik'];
				$jabatan			= $_POST['jabatan'];
				$divisi				= $_POST['divisi'];
				$rencana_kerja		= $_POST['rencana_kerja'];
				$target				= $_POST['target'];
				$satuan				= $_POST['satuan'];
				$bobot				= $_POST['bobot'];
				$tahun				= $_POST['tahun'];
				$pm					= $_POST['pm'];
	// if($_POST['total'] > 75){
		// header('Location: ../../page.php?page=form_penilaian_karyawan&failed2&opt=tambah');
	// }else{
		if($_GET['opt']=="edit"){		
			mysql_query("UPDATE penilaian_kerja  SET 
															id_penilaian		= '$id_penilaian',
															nik					= '$nik',
															jabatan				= '$jabatan',
															divisi				= '$divisi',
															rencana_kerja		= '$rencana_kerja',
															target				= '$target',
															satuan				= '$satuan',
															bobot				= '$bobot',
															pm					= '$pm',
															tahun				= '$tahun'
													WHERE id_penilaian			= '$id_penilaian' ");													
													
			
		}elseif($_GET['opt']=="tambah"){		
				mysql_query("INSERT penilaian_kerja SET 
															
															id_penilaian		= '',
															nik					= '$nik',
															jabatan				= '$jabatan',
															divisi				= '$divisi',
															rencana_kerja		= '$rencana_kerja',
															target				= '$target',
															satuan				= '$satuan',
															bobot				= '$bobot',
															pm					= '$pm',
															tahun				= '$tahun'");
			
		}	
		header('Location: ../../page.php?page=data_penilaian_karyawan&succes=1');
		
	
	
?>