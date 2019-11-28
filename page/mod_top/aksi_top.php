<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

$id_proyek			= mysql_real_escape_string($_POST['id_proyek']);
$unit 				= mysql_real_escape_string($_POST['unit']);
//$kode_keuangan		= mysql_real_escape_string($_POST['kode_keuangan']);
$kode_proyek		= mysql_real_escape_string($_POST['kode_proyek']);
$bulan				= mysql_real_escape_string($_POST['bulan']);
$tahun				= mysql_real_escape_string($_POST['tahun']);
$lokasi_proyek		= mysql_real_escape_string($_POST['lokasi_proyek']);
$nama_proyek		= mysql_real_escape_string($_POST['nama_proyek']);
$jarak_proyek		= mysql_real_escape_string($_POST['jarak_proyek']);
$resiko_kerja	= mysql_real_escape_string($_POST['resiko_kerja']);


//////////////////////////////////////////// EDIT ////////////////////////////////////////
if($_GET['opt']=="edit"){
	mysql_query("UPDATE `proyek` SET 		`nama_proyek`		='$nama_proyek',
											`cc`				='$unit',
											`kode_proyek`		='$kode_proyek',
											`bulan`				='$bulan',
											`tahun`				='$tahun',
											`lokasi_proyek`		='$lokasi_proyek',
											`jarak_proyek`		='$jarak_proyek',
											`resiko_kerja`		='$resiko_kerja',
									  WHERE `id_proyek`			='$id_proyek'");
	
	
	
////////////////////////////////////////// TAMBAH  ///////////////////////////////////////////////
}elseif($_GET['opt']=="tambah"){
		
		mysql_query("INSERT INTO `proyek`	SET `nama_proyek`	='$nama_proyek',
											`cc`				='$unit',
											`kode_proyek`		='$kode_proyek',
											`bulan`				='$bulan',
											`tahun`				='$tahun',
											`lokasi_proyek`		='$lokasi_proyek',
											`jarak_proyek`		='$jarak_proyek',
											`resiko_kerja`		='$resiko_kerja'");
		
	
}

	
 header('Location: ../../page.php?page=data_top&bulan='.$bulan.'&succes=1');
?>