<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_timeline.php";

	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	// $id_pencapaian		= mysql_real_escape_string($_POST['id_pencapaian']);
	$nik				= mysql_real_escape_string($_POST['nik']);
	@$jo_gca 			= mysql_real_escape_string($_POST['jo_gca']);
	$ex					= explode("-",$_POST['tgl']);
	$tgl_aktifitas		= $ex[2]."-".$ex[1]."-".$ex[0];
	$jam_mulai			= mysql_real_escape_string($_POST['jam_mulai']);
	$aktifitas			= mysql_real_escape_string($_POST['aktifitas']);
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
	$faktor				= mysql_real_escape_string(strtoupper($_POST['faktor']));
	$sts_shift			= mysql_real_escape_string($_POST['sts_shift']);
	@$jam_shift			= mysql_real_escape_string($_POST['jam_shift']);

	@$fileName = $_FILES['lampiran']['name'];     
	@$tmpName  = $_FILES['lampiran']['tmp_name']; 
	@$fileSize = $_FILES['lampiran']['size'];
	@$fileType = $_FILES['lampiran']['type'];
	@$folder		= "../../upload/$fileName";

	if(!empty($jo_gca)){
		$cek_progress = mysql_fetch_array(mysql_query("SELECT a.id, a.jenisAktf,
									ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=a.id AND `status`='1')),'') as maxpro
									FROM
									wbs a
									WHERE a.id='$jo_gca'"));
	}
	
if(empty($jo_gca) AND $faktor=="A"){
	echo"<SCRIPT language='javascript'>alert('Aktifitas dan Faktor Kontribusi Tidak Sesuai !!');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
}else{
if($faktor!="A" AND $faktor!="B" AND $faktor!="C" AND $faktor!="D"){
	echo"<SCRIPT language='javascript'>alert('Faktor Kontribusi Salah, Pilih A, B, C, atau D !!');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
}else{
	if(is_numeric($faktor)){
		echo"<SCRIPT language='javascript'>alert('Faktor Kontribusi Salah, tidak boleh berbentuk angka !!');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
	}else{
		$cekKKWK = mysql_num_rows(mysql_query("SELECT status FROM pencapaian WHERE nik='$nik' AND status='0' "));
		if($cekKKWK >= 1){
			echo"<SCRIPT language='javascript'>alert('Hanya bisa menjalankan 1 aktifitas');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
		}else{
			
			if(!empty($_POST['jo_gca'])){
				$gca			= mysql_fetch_array(mysql_query("SELECT hasil_akhir FROM wbs WHERE id='$jo_gca' "));
				if($gca['hasil_akhir']==""){
					$status_nilai	= "P";
				}else{
					$status_nilai	= $gca['hasil_akhir'];
				}
			}else{
				$status_nilai 	="P";
				$getID			= mysql_fetch_array(mysql_query("SELECT max(id_pencapaian) as id FROM pencapaian "));
				$id				= $getID['id'] + 1;
				$jo_gca 		= $id;
			}
			if($_GET['opt']=="edit"){
				// $query = mysql_query("UPDATE `pencapaian`	SET 	`id_pencapaian`		='$id_pencapaian' ,
																	// `nik`				='$nik' ,
																	// `jo_gca`			='$jo_gca' ,
																	// `tgl_aktifitas`		='$tgl_aktifitas' ,
																	// `jam_mulai`			='$jam_mulai' ,
																	// `jam_akhir`			='$jam_akhir' ,
																	// `total_jam`			='$jam' ,
																	// `aktifitas`			='$aktifitas' ,
																	// `hasil_akhir`		='$h_aktifitas' ,
																	// `laporan`			='$laporan' ,
																	// `cc`				='$cc' ,
																	// `faktor_k`			='$faktor' ,
																	// `progress`			='$progress' ,
																	// `file`				='$fileName' ,
																	// `ket`				='$ket',
																	// `status`			='0'
															// WHERE 	`id_pencapaian`		='$id_pencapaian'");
				
			}elseif($_GET['opt']=="tambah"){
				if($cek_progress['maxpro']==100 OR $cek_progress['jenisAktf']==2){
					echo"<SCRIPT language='javascript'>alert('Tidak dapat menjalankan KKWK, Progress GCA sudah 100% ...!!');document.location='../../page.php?page=form_kkwk&opt=tambah'</SCRIPT>";
				}else{
					$query = mysql_query("INSERT INTO `pencapaian`	SET `id_pencapaian`		='' ,
																		`nik`				='$nik' ,
																		`jo_gca`			='$jo_gca' ,
																		`tgl_aktifitas`		='$tgl_aktifitas' ,
																		`jam_mulai`			='$jam_mulai' ,
																		`aktifitas`			='$aktifitas' ,
																		`laporan`			='$laporan' ,
																		`cc`				='$cc' ,
																		`uraian`			='$uraian' ,
																		`faktor_k`			='$faktor' ,
																		`status_nilai`		='$status_nilai',
																		`status_shift`		='$sts_shift',
																		`jam_shift`			='$jam_shift',
																		`status`			='0'");
					timeline($nik,"tambah","pembuatan KKWK pada jam $jam_mulai dengan ID_GCA $jo_gca -> $aktifitas");
					header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
				}
			}elseif($_GET['opt']=="tambah2"){
				if($cek_progress['maxpro']==100 OR $cek_progress['jenisAktf']==2){
					echo"<SCRIPT language='javascript'>alert('Tidak dapat menjalankan KKWK, Progress GCA sudah 100% ...!!');document.location='../../page.php?page=form_kkwk&opt=tambah'</SCRIPT>";
				}else{
					$query = mysql_query("INSERT INTO `pencapaian`	SET `id_pencapaian`		='' ,
																		`nik`				='$nik' ,
																		`jo_gca`			='$jo_gca' ,
																		`tgl_aktifitas`		='$tgl_aktifitas' ,
																		`jam_mulai`			='$jam_mulai' ,
																		`aktifitas`			='$aktifitas' ,
																		`laporan`			='$laporan' ,
																		`cc`				='$cc' ,
																		`uraian`			='$uraian' ,
																		`faktor_k`			='$faktor' ,
																		`status_nilai`		='$status_nilai',
																		`status_shift`		='$sts_shift',
																		`jam_shift`			='$jam_shift',
																		`status`			='0'");
					timeline($nik,"tambah","pembuatan KKWK pada jam $jam_mulai dengan ID_GCA $jo_gca -> $aktifitas");
					header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
				}
			}elseif($_GET['opt']=="tambah3"){
				if($cek_progress['maxpro']==100 OR $cek_progress['jenisAktf']==2){
					echo"<SCRIPT language='javascript'>alert('Tidak dapat menjalankan KKWK, Progress GCA sudah 100% ...!!');document.location='../../page.php?page=form_kkwk&opt=tambah'</SCRIPT>";
				}else{
					$query = mysql_query("INSERT INTO `pencapaian`	SET `id_pencapaian`		='' ,
																		`nik`				='$nik' ,
																		`jo_gca`			='$jo_gca' ,
																		`tgl_aktifitas`		='$tgl_aktifitas' ,
																		`jam_mulai`			='$jam_mulai' ,
																		`aktifitas`			='$aktifitas' ,
																		`laporan`			='$laporan' ,
																		`cc`				='$cc' ,
																		`uraian`			='$uraian' ,
																		`faktor_k`			='$faktor' ,
																		`status_nilai`		='$status_nilai',
																		`status_shift`		='$sts_shift',
																		`jam_shift`			='$jam_shift',
																		`status`			='0'");
					timeline($nik,"tambah","pembuatan KKWK pada jam $jam_mulai dengan ID_GCA $jo_gca -> $aktifitas");
					header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
				}
			}
				
		}
	}
}
}
?>