<?php
include"../../config/koneksi.php";

	$jum = count($_POST['id_pencapaian']);
	for($i=0; $i<$jum; $i++){
		$id_pencapaian		= mysql_real_escape_string($_POST['id_pencapaian'][$i]);
		$progress 			= mysql_real_escape_string($_POST['progress'][$i]);
		$progress_lama 		= mysql_real_escape_string($_POST['progress_lama'][$i]);
		
		mysql_query("UPDATE pencapaian SET 	id_pencapaian	='$id_pencapaian',
											progress		='$progress',
											progress_lama	='$progress_lama',
											status			='1'
									WHERE 	id_pencapaian='$id_pencapaian'");
	}
	header('Location: ../../page.php?page=penilaian_kerja&succes=1');
?>