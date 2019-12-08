<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
// include"../../config/fungsi_name.php";
// include"../../config/fungsi_timeline.php";

	
	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	
			$jml2		= count($_POST['id_budaya']);
			$nik2		= $_POST['nikcek'];	
			$tahun2		= $_POST['tahuncek'];
			$cek = mysql_fetch_array(mysql_query("SELECT DISTINCT nik FROM nilai_budaya WHERE tahun='$tahun2' AND nik='$nik2'"));		
			for($i=0; $i<$jml2; $i++){						
				//$id					= $_POST['id'][$i];
				$nik				= $_POST['nik'][$i];
				$pm					= $_POST['pm'][$i];
				$tahun				= $_POST['tahun'][$i];
				$jabatan			= $_POST['jabatan'][$i];	
				$divisi				= $_POST['divisi'][$i];
				$id_budaya			= $_POST['id_budaya'][$i];
				$nilai 				= $_POST['nilai'][$i];			
				// $cek = mysql_fetch_array(mysql_query("SELECT nik FROM nilai_budaya WHERE nik='$nik'"));
				
				if($nik==$cek['nik']){
					$query = mysql_query("UPDATE `nilai_budaya`  SET 
																	
																	`nik`						= '$nik',
																	`tahun`						= '$tahun',
																	`pm`						= '$pm',
																	`jabatan`					= '$jabatan',
																	`divisi`					= '$divisi',
																	`id_budaya`					= '$id_budaya',
																	`nilai`						= '$nilai'
															WHERE	`nik`						= '$nik'");

				}else{
					$query = mysql_query("INSERT `nilai_budaya`  SET 
																	
																	`nik`						= '$nik',
																	`tahun`						= '$tahun',
																	`pm`						= '$pm',
																	`jabatan`					= '$jabatan',
																	`divisi`					= '$divisi',
																	`id_budaya`					= '$id_budaya',
																	`nilai`						= '$nilai'");	
				}
								
			}
		header('Location: ../../page.php?page=n_budaya&succes=1');
		
		//echo $query;
		
	
?>