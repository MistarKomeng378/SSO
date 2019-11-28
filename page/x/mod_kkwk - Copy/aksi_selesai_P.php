<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_timeline.php";

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
	@$progresst			= mysql_real_escape_string($_POST['progresst']);
	$nilai				= mysql_real_escape_string($_GET['nilai']);
	
	
if(!is_numeric($progress)){
	echo"<SCRIPT language='javascript'>alert('Progress yang anda inputkan bukan angka');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
}else{
	if($progress > 100){
		echo"<SCRIPT language='javascript'>alert('Progress Tidak Boleh Lebih Dari 100 %');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
	}else{
		if($progress==100){
			$aprove = 1;
			mysql_query("UPDATE pencapaian SET aprove='$aprove' WHERE id_pencapaian='$id_pencapaian' AND nik='$nik'");
		}else{
			$aprove = 0;
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
		
		@$file 		= $_FILES['lampiran'];
		@$info		= pathinfo($file['name']);
		@$name 		= $info['filename'];
		@$ext2 		= $info['extension'];
		@$fileName	= $_FILES['lampiran']['name'];  
		@$type 		= $_FILES['lampiran']['type'];
		@$size 		= $_FILES['lampiran']['size'];
		@$temp 		= $_FILES['lampiran']['tmp_name'];
		$dir 		= "../../upload/";
		$date		= date("ymdHis");
		@$newName 	= $name.'('.$date.').'.$ext2;
		
		
		$maxsize = 1024 * (1024*5) ;
		$valid_ext 	= array('jpg','jpeg','png','doc','docx','xls','xlsx','pdf','rar','zip','ppt','pptx');
		$ext = strtolower(end(explode('.', $_FILES['lampiran']['name'])));
			
		if(empty($fileName)){
			// if($progress==100){
				// $progress = 99;
			// }else{
				// $progress = $progress;
			// }
			mysql_query("UPDATE `pencapaian`	SET 	`id_pencapaian`		='$id_pencapaian' ,
														`tgl_akhir`			='$tgl_akhir' ,
														`jam_akhir`			='$jam_akhir' ,
														`total_jam`			='$a[hours]' ,
														`total_menit`		='$a[minutes]' ,
														`hasil_akhir`		='$h_aktifitas' ,
														`progress`			='$progress' ,
														`progress_lama`		='$progresst' ,
														`status_nilai`		='$nilai',
														`status`			='1',
														`aprove`			='$aprove'
												WHERE 	`id_pencapaian`		='$id_pencapaian' AND nik='$nik'");
			
			$realisasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM pencapaian WHERE jo_gca='$jo_gca' AND nik='$nik' "));
			timeline($nik,"edit","penyelesasian KKWK pada aktifitas dengan id_kkwk $id_pencapaian dan hasil aktifitas $h_aktifitas dengan progress $progress");
			mysql_query("UPDATE wbs SET realisasi='$realisasi[jum]',`prog-b`='$progress',`prog-l`='$progress' WHERE id='$jo_gca' AND pic='$nik'");
			
			header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
		}else{
			if($fileName == ".htaccess"){
				echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..??');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
			}else{
				if($fileType == "php"){
					echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..??');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
				}else{
					// if (file_exists($folder)) {
						// echo"<SCRIPT language='javascript'>alert('Maaf file yang anda upload sudah ada ..!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
					// }else{
						if($size <= $maxsize ){	
							if(in_array($ext, $valid_ext)){
								mysql_query("UPDATE `pencapaian`	SET 	`id_pencapaian`		='$id_pencapaian' ,
																			`tgl_akhir`			='$tgl_akhir' ,
																			`jam_akhir`			='$jam_akhir' ,
																			`total_jam`			='$a[hours]' ,
																			`total_menit`		='$a[minutes]' ,
																			`hasil_akhir`		='$h_aktifitas' ,
																			`progress`			='$progress' ,
																			`progress_lama`		='$progresst' ,
																			`file`				='$newName' ,
																			`type`				='$type' ,
																			`size`				='$size' ,
																			`ket`				='$ket',
																			`status_nilai`		='$nilai',
																			`status`			='1',
																			`aprove`			='$aprove'
																	WHERE 	`id_pencapaian`		='$id_pencapaian' AND nik='$nik'");
																	
									$realisasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM pencapaian WHERE jo_gca='$jo_gca' AND nik='$nik' "));
									mysql_query("UPDATE wbs SET realisasi='$realisasi[jum]',`prog-b`='$progress',`prog-l`='$progress' WHERE id='$jo_gca' AND pic='$nik'");
									
									move_uploaded_file($temp,$dir.$newName);
									timeline($nik,"edit","penyelesasian KKWK pada aktifitas dengan id_kkwk $id_pencapaian dan hasil aktifitas $h_aktifitas dengan progress $progress");
									header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
							}else{
								echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..!!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
							}
						}else{
							echo"<SCRIPT language='javascript'>alert('Maaf file yang anda upload terlalu besar, maksimal 5 Mb ..!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
						}
					// }
				}
			}
		}
	}
}
?>