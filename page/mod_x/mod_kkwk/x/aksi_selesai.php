<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_timeline.php";

	$id_pencapaian		= mysql_real_escape_string($_POST['id_pencapaian']);
	$nik				= mysql_real_escape_string($_POST['nik']);
	$jo_gca				= mysql_real_escape_string($_POST['jo_gca']);
	@$ket				= mysql_real_escape_string($_POST['ket']);
	$jam_mulai			= mysql_real_escape_string($_POST['jam_mulai']);
	$jam_akhir			= mysql_real_escape_string($_POST['jam_akhir']);
	@$h_aktifitas		= mysql_real_escape_string($_POST['h_aktifitas']);
	@$progress			= mysql_real_escape_string($_POST['progress']);
	@$lastProgress		= mysql_real_escape_string($_POST['last_progress']);
	$nilai				= mysql_real_escape_string($_GET['nilai']);
	
if($progress > 100){
	echo"<SCRIPT language='javascript'>alert('Progress Tidak Boleh Lebih Dari 100 %');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
}else{
	// if($progress <= $lastProgress){
		// echo"<SCRIPT language='javascript'>alert('Progress Tidak Sesuai');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
	// }else{
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
		
		
		$cv_mulai = date("G:i:s", strtotime($jam_mulai));
		$cv_akhir = date("G:i:s", strtotime($jam_akhir));
		$a = strtotime($cv_akhir);
		$b = strtotime($cv_mulai);
		$selisih=$a-$b;  
		// $jam = round((($selisih % 604800)%86400)/3600);
		
		@$fileName = $_FILES['lampiran']['name'];     
		@$tmpName  = $_FILES['lampiran']['tmp_name']; 
		@$fileSize = $_FILES['lampiran']['size'];
		@$fileType = $_FILES['lampiran']['type'];
		@$folder		= "../../upload/$fileName";
		
		$x		= $selisih;
		// $hari	= floor($x / 86400);
		
		$sisa	= $x % 86400;
		$jam	= floor($sisa / 3600);
			
		$sisa	= $sisa % 3600;
		$menit	= floor($sisa / 60);
			
		$sisa	= $sisa % 60;
		$detik	= floor($sisa / 1);
			
		// echo"Hari=$hari<br>";
		// echo"Jam=$jam<br>";
		// echo"Menit=$menit<br>";
		// echo"Detik=$detik<br>";

		mysql_query("UPDATE `pencapaian`	SET 	`id_pencapaian`		='$id_pencapaian' ,
															`jam_akhir`			='$jam_akhir' ,
															`total_jam`			='$jam' ,
															`total_menit`		='$menit' ,
															`hasil_akhir`		='$h_aktifitas' ,
															`progress`			='$progress' ,
															`file`				='$fileName' ,
															`ket`				='$ket',
															`status_nilai`		='$nilai',
															`status`			='1',
															`aprove`			='$aprove'
													WHERE 	`id_pencapaian`		='$id_pencapaian' AND nik='$nik'");
		timeline($nik,"edit","penyelesasian KKWK pada aktifitas dengan id_kkwk $id_pencapaian dan hasil aktifitas $h_aktifitas dengan progress $progress");
		if($nilai=="H"){
			$hasil			= mysql_real_escape_string($_POST['hasil']);
			$satuan			= mysql_real_escape_string($_POST['satuan']);
			mysql_query("REPLACE INTO pencapaian_hasil(`id_hasil`, `id_pencapaian`, `nik`, `hasil`, `satuan`)
								VALUES ('','$id_pencapaian','$nik','$hasil','$satuan')");
		}
		move_uploaded_file($tmpName,$folder);
		header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
	// }
}
?>