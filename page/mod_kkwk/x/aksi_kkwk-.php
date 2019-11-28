<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_timeline.php";
include"../../config/fungsi_validasi_jam.php";

	$id_pencapaian		= mysql_real_escape_string($_POST['id_pencapaian']);
	$nik				= mysql_real_escape_string($_POST['nik']);
	@$jo_gca 			= mysql_real_escape_string($_POST['jo_gca']);
	
	$sts_shift			= mysql_real_escape_string($_POST['sts_shift']);
	@$jam_shift			= mysql_real_escape_string($_POST['jam_shift']);
	
	$tmulai				= dc($_POST['tmulai']);
	$jmulai				= $_POST['jmulai'];
	
	$tgl_m				= date('Y-m-d', strtotime($tmulai));
	$jam_m				= date('H:i:s', strtotime($jmulai));
	$jam_m2				= date('H:i', strtotime($jmulai));
	
	$tselesai			= dc($_POST['tmulai']);
	$jselesai			= $_POST['jselesai'];
	
	$tgl_s				= date('Y-m-d', strtotime($tselesai));
	$jam_s				= date('H:i:s', strtotime($jselesai));
	
	$aktifitas			= mysql_real_escape_string($_POST['aktifitas']);
	$hasil				= mysql_real_escape_string($_POST['hasil']);
	$progress			= mysql_real_escape_string($_POST['progress']);
	$laporan			= mysql_real_escape_string($_POST['lapor']);
	$cc					= mysql_real_escape_string($_POST['cc']);
	if(empty($_POST['uraian'])){
		$ur = mysql_query("SELECT uraian FROM pencapaian WHERE cc='$cc'");
		$cekur = mysql_num_rows($ur);
		if($cekur == 0){
			$ur2 = mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$cc'");
			$cekur2 = mysql_num_rows($ur2);
			if($cekur2 == 0){
				$mysql_host2 		= "10.0.1.233";
				$mysql_database2 	= "epm";
				$mysql_user2 		= "root123";
				$mysql_password2 	= "sso123";
				@$conn2 = mysql_connect($mysql_host2,$mysql_user2,$mysql_password2);
				@mysql_select_db($mysql_database2,$conn2);
				$ur3 = mysql_query("SELECT uraian FROM pro_kontrak WHERE cc='$cc' ");
				$urr3		= mysql_fetch_array($ur3);	
				$uraian		= mysql_real_escape_string($urr3['uraian']);
				include"../../config/koneksi.php";
			}else{
				$urr2		= mysql_fetch_array($ur2);	
				$uraian		= mysql_real_escape_string($urr2['uraian']);
			}			
		}else{
			$urr		= mysql_fetch_array($ur);	
			$uraian		= mysql_real_escape_string($urr['uraian']);
		}
	}else{
		$uraian			= mysql_real_escape_string($_POST['uraian']);
	}	
	$faktor				= mysql_real_escape_string($_POST['faktor']);
	$ket				= mysql_real_escape_string($_POST['ket']);
	
	$now		= date("Y-m-d");
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
	
	if(!empty($jo_gca)){
		$cek_progress = mysql_fetch_array(mysql_query("SELECT a.id, a.jenisAktf,
									ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=a.id AND `status`='1')),'') as maxpro
									FROM
									wbs a
									WHERE a.id='$jo_gca'"));
	}
	
	$maxsize = 1024 * (1024*5) ;
	$valid_ext 	= array('jpg','jpeg','png','doc','docx','xls','xlsx','pdf','rar','zip','ppt','pptx');
	$ext = strtolower(end(explode('.', $_FILES['lampiran']['name'])));
	
	if(!empty($_POST['jo_gca'])){
		$gca			= mysql_fetch_array(mysql_query("SELECT hasil_akhir FROM wbs WHERE id='$jo_gca' "));
		$status_nilai	= $gca['hasil_akhir'];
	}else{
		$status_nilai 	="P";
		$getID			= mysql_fetch_array(mysql_query("SELECT max(id_pencapaian) as id FROM pencapaian "));
		$id				= $getID['id'] + 1;
		$jo_gca 		= $id;
	}
	
	if($progress==100){
		$aprove = 1;
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
			$tgl1	= date("$tgl_m $jam_m");
			$tgl2 	= date("$tgl_s $jam_s");
			$a 		= datediff($tgl1, $tgl2);
	
	
	$cekJam 	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total FROM pencapaian WHERE tgl_aktifitas='$tgl_m' AND nik='$nik' "));	
	$overtime	= $cekJam['total']+$a['hours'];	
	$minJam 	= mysql_fetch_array(mysql_query("SELECT min(jam_mulai) as minJam FROM pencapaian WHERE tgl_aktifitas='$tgl_m' AND nik='$nik'"));
	$maxJam 	= mysql_fetch_array(mysql_query("SELECT max(jam_akhir) as  maxJam FROM pencapaian WHERE tgl_aktifitas='$tgl_m' AND nik='$nik'"));
	$valJam 	= cekJam($jam_m2,$maxJam['maxJam'],$minJam['minJam']);
	
	if(empty($_POST['jo_gca']) AND $faktor=="A"){
		echo"<SCRIPT language='javascript'>alert('Aktifitas dan Faktor Kontribusi Tidak Sesuai !!');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
	}else{
		if($faktor!="A" AND $faktor!="B"){
			echo"<SCRIPT language='javascript'>alert('Faktor Kontribusi Salah, Pilih A atau B!!');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
		}else{
			if(is_numeric($faktor)){
				echo"<SCRIPT language='javascript'>alert('Faktor Kontribusi Salah, tidak boleh berbentuk angka !!');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
			}else{
	/////////////////////////////////////////////////////////////////////////////////////////
	if($jam_m > $jam_s){
		echo"<SCRIPT language='javascript'>alert('Jam Mulai tidak boleh lebih besar dari Jam Selesai..!!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
	}else{
		// if($valJam == 1){
			// echo"<SCRIPT language='javascript'>alert('Jam yang anda input sudah terisi aktifitas');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
		// }else{
			if($overtime > 24){
				echo"<SCRIPT language='javascript'>alert('Total Jam yang anda input melebihi ketentuan');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
			}else{
				if($a['hours'] > 16){
					echo"<SCRIPT language='javascript'>alert('Total Jam yang anda input melebihi ketentuan');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
				}else{
					
				if(empty($fileName)){
					if($cek_progress['maxpro']==100 AND $cek_progress['jenisAktf']==2){
						echo"<SCRIPT language='javascript'>alert('KKWK tidak dapat digunakan, Progress GCA sudah 100% ...!!');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
					}else{
						mysql_query("INSERT INTO `pencapaian` SET 	`id_pencapaian`	='',
																		`nik`			='$nik',
																		`jo_gca`		='$jo_gca',
																		`tgl_aktifitas`	='$tgl_m',
																		`jam_mulai`		='$jam_m',
																		`tgl_akhir`		='$tgl_s',
																		`jam_akhir`		='$jam_s',
																		`total_jam`		='$a[hours]',
																		`total_menit`	='$a[minutes]',
																		`aktifitas`		='$aktifitas',
																		`hasil_akhir`	='$hasil',
																		`laporan`		='$laporan',
																		`cc`			='$cc',
																		`uraian`		='$uraian',
																		`faktor_k`		='$faktor',
																		`progress`		='$progress',
																		`status_nilai`	='$status_nilai',
																		`status_shift`	='$sts_shift',
																		`jam_shift`		='$jam_shift',
																		`status`		='1',
																		`status_dispen`	='1',
																		`alasan`		='$alasan',
																		`aprove`		='$aprove'");
						$realisasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM pencapaian WHERE jo_gca='$jo_gca' AND nik='$nik' "));
						mysql_query("UPDATE wbs SET realisasi='$realisasi[jum]',`prog-b`='$progress',`prog-l`='$progress' WHERE id='$jo_gca' AND pic='$nik'");
						timeline($nik,"tambah","pembuatan KKWK pada jam $jam_m dengan ID_GCA $jo_gca -> $aktifitas");
						header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
					}
				}else{
						if($fileName == ".htaccess"){
							echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..??');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
						}else{
							if($fileType == "php"){
								echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..??');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
							}else{
									if($size <= $maxsize ){	
										if(in_array($ext, $valid_ext)){
											if($cek_progress['maxpro']==100 AND $cek_progress['jenisAktf']==2){
												echo"<SCRIPT language='javascript'>alert('KKWK tidak dapat digunakan, Progress GCA sudah 100% ...!!');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
											}else{
												mysql_query("INSERT INTO `pencapaian` SET 	`id_pencapaian`	='',
																			`nik`			='$nik',
																			`jo_gca`		='$jo_gca',
																			`tgl_aktifitas`	='$tgl_m',
																			`jam_mulai`		='$jam_m',
																			`tgl_akhir`		='$tgl_s',
																			`jam_akhir`		='$jam_s',
																			`total_jam`		='$a[hours]',
																			`total_menit`	='$a[minutes]',
																			`aktifitas`		='$aktifitas',
																			`hasil_akhir`	='$hasil',
																			`laporan`		='$laporan',
																			`cc`			='$cc',
																			`uraian`		='$uraian',
																			`faktor_k`		='$faktor',
																			`progress`		='$progress',
																			`file`			='$newName' ,
																			`type`			='$type' ,
																			`size`			='$size' ,
																			`ket`			='$ket',
																			`status_nilai`	='$status_nilai',
																			`status_shift`	='$sts_shift',
																			`jam_shift`		='$jam_shift',
																			`status`		='1',
																			`alasan`		='$alasan',
																			`aprove`		='$aprove'");
												$realisasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM pencapaian WHERE jo_gca='$jo_gca' AND nik='$nik' "));
												mysql_query("UPDATE wbs SET realisasi='$realisasi[jum]',`prog-b`='$progress',`prog-l`='$progress' WHERE id='$jo_gca' AND pic='$nik'");
												move_uploaded_file($temp,$dir.$newName);
												timeline($nik,"tambah","pembuatan KKWK pada jam $jam_m dengan ID_GCA $jo_gca -> $aktifitas");
												header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
											}
											}else{
												echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..!!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
											}
									}else{
										echo"<SCRIPT language='javascript'>alert('Maaf file yang anda upload terlalu besar, maksimal 5 Mb ..!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
									}
							}
						}
					}
				}
			}
		// }
	}
/////////////////////////////////////////////////////////////////////////////////////////
			}
		}
	}
?>