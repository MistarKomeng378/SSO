<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	
	$nik		= $_POST['nik'];
	$penilai	= $_POST['penilai'];
	$val_prog	= $_POST['val_progress'];
	$opt		= $_GET['opt'];
	$cc			= $_GET['cc'];
	$tgl_note	= date("Y-m-d");
	$tgl_aprove	= date("Y-m-d H:i:s");
	
	$count = count($val_prog)-1;
	// echo"$count";
	$no = 1;
	for($i=0;$i<=$count;$i++){
		@$aprove	= $_POST['aprove_'.$no];
		@$val_prog	= $_POST['val_progress'][$i];
		@$note		= $_POST['note'][$i];
		@$gca		= $_POST['gca'][$i];
		@$id		= $_POST['id'][$i];
		$cekId				= mysql_fetch_array(mysql_query("SELECT max(id_pencapaian) as maxid FROM pencapaian WHERE jo_gca='$gca' "));
		// echo"$aprove<br>";
		// echo"$val_prog<br>";
		// echo"$note<br>";
		// echo"$gca<br>";
		// echo"$id<br>";
		
		if(empty($aprove)){
			// echo"Kosong<br>";
		}else{
			// echo"Ada<br>";
			if($aprove == 2){
				mysql_query("UPDATE pencapaian SET 	jo_gca			='$gca',
													aprove			='2',
													tgl_aprove		='$tgl_aprove'
											WHERE 	id_pencapaian	='$id' ");
											
				mysql_query("INSERT INTO note_kinerja 	SET nik				='$nik',
															id_pencapaian	='$id',
															jo_gca			='$gca',
															note			='$note',
															tgl_note		='$tgl_note',
															penilai			='$penilai',
															notif			='success'
															");
			}elseif($aprove == 4){
				mysql_query("UPDATE pencapaian SET 	jo_gca			='$gca',
													progress		='$val_prog',
													aprove			='4',
													tgl_aprove		='$tgl_aprove'
											WHERE 	id_pencapaian	='$id' ");
				if($id == $cekId['maxid']){
					mysql_query("UPDATE wbs SET `prog-b`='$val_prog',`prog-l`='$val_prog' WHERE id='$gca' AND pic='$nik'");
				}							
				mysql_query("INSERT INTO note_kinerja 	SET nik				='$nik',
															id_pencapaian	='$id',
															jo_gca			='$gca',
															note			='$note',
															tgl_note		='$tgl_note',
															penilai			='$penilai',
															notif			='danger'
															");
			}
		}
		
		
		$no++;
	}
	
	// header('Location: ../../page.php?page=penilaian_kerja&opt=detail_aktifitas&id='.ec($cc).'-'.ec($nik).'-1&succes=1');
	header('Location: ../../page.php?page=penilaian_kerja');
	
?>