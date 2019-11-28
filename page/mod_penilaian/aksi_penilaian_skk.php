<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
// include"../../config/fungsi_name.php";
// include"../../config/fungsi_timeline.php";

	
	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	
			$jml2		= count($_POST['id_penilaian']);
			$penilai	= $_POST['penilai'];
			for($i=0; $i<$jml2; $i++){
				$hasil				= $_POST['hasil'][$i];			
				$nik				= $_POST['nik'][$i];			
				$id_penilaian		= $_POST['id_penilaian'][$i];
				$penilai			= $_POST['penilai'][$i];
				$rencana_kerja		= $_POST['rencana_kerja'][$i];
				$target				= $_POST['target'][$i];
				$bobot				= $_POST['bobot'][$i];
				$satuan				= $_POST['satuan'][$i];
				$query = mysql_query("UPDATE `penilaian_kerja`  SET `hasil`						= '$hasil',
																	`rencana_kerja`				= '$rencana_kerja',
																	`target`					= '$target',
																	`bobot`						= '$bobot',
																	`satuan`					= '$satuan',
																	`penilai`					= '$penilai'
																WHERE id_penilaian				= '$id_penilaian'");
			}
		header('Location: ../../page.php?page=penilaian_skk&succes=1');
		// echo($query);
		
	
?>