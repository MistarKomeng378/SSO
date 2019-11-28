<?php
include"../../config/koneksi.php";

$tahun 		= $_POST['tahun'];
$jum1= count($_POST['aktivitas_div']);
	for($i=0; $i<$jum1; $i++){
		$id 		= $_POST['id_div'][$i];
		$parent 	= $_POST['parentId_div'][$i];
		$aktivitas 	= $_POST['aktivitas_div'][$i];
		$cc 		= $_POST['cc_div'][$i];
		$pic 		= $_POST['pic_div'][$i];
		
		mysql_query("REPLACE INTO wbs(`id`, `parentId`, `aktivitas`, `pic`, `cc`, `cc_id`, `tahun`,`lock`,`level`,`jenisGCA`,`icon`,`tgl_isi`) VALUES 
						('$id','$parent','$aktivitas','$pic','$cc','$cc','$tahun','1','2','1','assets/img/folder.png',NOW() )");
	}
$jum2= count($_POST['aktivitas_kpm']);
	for($i=0; $i<$jum2; $i++){
		//$id 		= $_POST['id_kpm'][$i];
		$parent 	= $_POST['parentId_kpm'][$i];
		//$aktivitas 	= $_POST['aktivitas_kpm'][$i];
		$cc 		= $_POST['cc_kpm'][$i];
		$pic 		= $_POST['pic_kpm'][$i];
		$id_kpi 	= $_POST['kpi_kpm'][$i];
		$hasil_akhir= $_POST['hasil_akhir_kpm'][$i];
		mysql_query("REPLACE INTO wbs(`id`, `parentId`, `aktivitas`, `pic`, `cc`, `cc_id`, `tahun`, `kode_kpi`, `hasil_akhir`,`lock`,`level`,`jenisGCA`,`icon`,`tgl_isi`) VALUES 
						('$id','$parent','$aktivitas','$pic','$cc','$cc','$tahun','$id_kpi','$hasil_akhir','1','3','1','assets/img/folder.png',NOW() )");
	}
$jum3= count($_POST['aktivitas_rk']);
	for($i=0; $i<$jum3; $i++){
		$id 		= $_POST['id_rk'][$i];
		$parent 	= $_POST['parentId_rk'][$i];
		$aktivitas 	= $_POST['aktivitas_rk'][$i];
		$cc 		= $_POST['cc_rk'][$i];
		$id_kpi 	= $_POST['kpi_rk'][$i];
		$hasil_akhir = $_POST['hasil_akhir_rk'][$i];
		$id_srko	= $_POST['srko_rk'][$i];
		$pic 		= $_POST['pic_rk'][$i];
		mysql_query("REPLACE INTO wbs(`id`, `parentId`, `aktivitas`, `pic`, `id_srko`, `cc`, `cc_id`, `tahun`, `kode_kpi`, `hasil_akhir`,`level`,`jenisGCA`,`icon`,`tgl_isi`) VALUES 
						('$id','$parent','$aktivitas','$pic','$id_srko','$cc','$cc','$tahun','$id_kpi','$hasil_akhir','4','2','assets/img/file.png',NOW() )");
	}
header('Location: ../../page.php?page=data_srko&succes=1');
?>