<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
// include"../../config/fungsi_name.php";
// include"../../config/fungsi_timeline.php";

	
	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	
			$jml2		= count($_POST['id_budaya']);
			//$pm			= $_POST['pm'];
			for($i=0; $i<$jml2; $i++){						
				//$id					= $_POST['id'][$i];
				$nik				= $_POST['nik'][$i];
				$pm					= $_POST['pm'][$i];
				$tahun				= $_POST['tahun'][$i];
				$jabatan			= $_POST['jabatan'][$i];	
				$divisi				= $_POST['divisi'][$i];
				$id_budaya			= $_POST['id_budaya'][$i];
				$nilai 				= $_POST['nilai'][$i];			
				
					$query = mysql_query("REPLACE `nilai_budaya`  SET 
																	
																	`nik`						= '$nik',
																	`tahun`						= '$tahun',
																	`pm`						= '$pm',
																	`jabatan`					= '$jabatan',
																	`divisi`					= '$divisi',
																	`id_budaya`					= '$id_budaya',
																	`nilai`						= '$nilai'");
					
				
				
			}
		header('Location: ../../page.php?page=penilaian_skk&succes=1');
		//  echo $query  ;
		//  echo $nik;
		
	
?>