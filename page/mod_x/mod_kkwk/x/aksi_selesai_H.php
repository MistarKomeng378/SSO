<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$id_pencapaian		= mysql_real_escape_string($_POST['id_pencapaian']);
	$nik				= mysql_real_escape_string($_POST['nik']);
	$jo_gca				= mysql_real_escape_string($_POST['jo_gca']);
	@$ket				= mysql_real_escape_string($_POST['ket']);
	$tgl_a				= mysql_real_escape_string($_POST['tgl_a']);
	$tgl_akhir			= date("Y-m-d");
	$status_shift		= mysql_real_escape_string($_POST['status_shift']);
	$jam_mulai			= mysql_real_escape_string($_POST['jam_mulai']);
	$jam_akhir			= mysql_real_escape_string($_POST['jam_akhir']);
	@$h_aktifitas		= mysql_real_escape_string($_POST['h_aktifitas']);
	@$progress			= mysql_real_escape_string($_POST['progress']);
	@$lastProgress		= mysql_real_escape_string($_POST['last_progress']);
	$nilai				= mysql_real_escape_string($_GET['nilai']);


			if($nilai=="H"){
				$aprove = 3;
			}else{
				if($progress==100){
					$aprove = 1;
					mysql_query("UPDATE pencapaian SET aprove='$aprove' WHERE id_pencapaian='$id_pencapaian' AND nik='$nik'");
				}else{
					$aprove = 0;
				}
			}
			
			
			function datediff($tgl1, $tgl2){
				$tgl1 = strtotime($tgl1);
				$tgl2 = strtotime($tgl2);
				$diff_secs = abs($tgl1 - $tgl2);
				$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
				$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
				return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
			}
			$tgl1	= date("$tgl_a $jam_mulai");
			$tgl2 	= date("Y-m-d H:i:s");
			$a 		= datediff($tgl1, $tgl2);
			// echo"$tgl1 - $tgl2 <br>";
			// echo"$a[days] hari $a[hours] jam $a[minutes] menit";

			mysql_query("UPDATE `pencapaian`	SET 	`id_pencapaian`		='$id_pencapaian' ,
																`tgl_akhir`			='$tgl_akhir' ,
																`jam_akhir`			='$jam_akhir' ,
																`total_jam`			='$a[days]' ,
																`total_menit`		='$a[hours]' ,
																`hasil_akhir`		='$h_aktifitas' ,
																`progress`			='$progress' ,
																`file`				='$fileName' ,
																`ket`				='$ket',
																`status_nilai`		='$nilai',
																`status`			='1',
																`aprove`			='$aprove'
														WHERE 	`id_pencapaian`		='$id_pencapaian' AND nik='$nik'");
			if($nilai=="H"){
				$hasil			= mysql_real_escape_string($_POST['hasil']);
				$satuan			= mysql_real_escape_string($_POST['satuan']);
				mysql_query("REPLACE INTO pencapaian_hasil(`id_hasil`, `id_pencapaian`, `nik`, `hasil`, `satuan`)
									VALUES ('','$id_pencapaian','$nik','$hasil','$satuan')");
			}
			// move_uploaded_file($tmpName,$folder);
			header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
		
?>