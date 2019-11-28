<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

$id					= $_POST['id'];
$id_proyek			= $_POST['id_proyek'];
$unit 				= $_POST['cc'];
$tahun				= $_POST['tahun'];
$bulan				= $_POST['bulan'];
// $nik 				= $_POST['nik'];
// $nama				= $_POST['nama_'];
// $jabatan			= $_POST['jabatan_'];


// $kode_keuangan		= mysql_real_escape_string($_POST['kode_keuangan']);
// $bulan				= mysql_real_escape_string($_POST['bulan']);
// $lokasi_proyek		= mysql_real_escape_string($_POST['lokasi_proyek']);
// $nama_proyek		= mysql_real_escape_string($_POST['nama_proyek']);
// $jarak_proyek		= mysql_real_escape_string($_POST['jarak_proyek']);
// $resiko_kerja	= mysql_real_escape_string($_POST['resiko_kerja']);


//////////////////////////////////////////// EDIT ////////////////////////////////////////
if($_GET['opt']=="edit"){
	mysql_query("UPDATE `anggota` SET 		`nama_proyek`		='$nama_proyek',
											`cc`				='$unit',
											`kode_keuangan`		='$kode_keuangan',
											`bulan`				='$bulan',
											`tahun`				='$tahun',
											`lokasi_proyek`		='$lokasi_proyek',
											`jarak_proyek`		='$jarak_proyek',
											`resiko_kerja`		='$resiko_kerja',
									  WHERE `id_proyek`			='$id_proyek'");
	
	
	
////////////////////////////////////////// TAMBAH  ///////////////////////////////////////////////
}elseif($_GET['opt']=="tambah"){
	
			$j_anggota = mysql_fetch_array(mysql_query("SELECT COUNT(nik) as jum_anggota FROM anggota where nik='$r[nik]'"));
			if($j_anggota['jum_anggota']>1){
				$akf=1;
			}else{
				$akf=0;
			}
	
		for($x=1;$x<=$_POST['test'];$x++){	
			$j_anggota = mysql_fetch_array(mysql_query("SELECT COUNT(nik) as jum_anggota FROM anggota where nik='".$_POST['nik'.$x]."'"));
			if($j_anggota['jum_anggota']>=1){
				$akf=0;
			}else{
				$akf=1;
			}
			
			$nik		= $_POST['nik'.$x];
			$nama		= $_POST['nama_'.$x];
			$jabatan	= $_POST['jabatan'.$x];
			$ket_jab	= $_POST['ket'.$x];
			$hari		= $_POST['hk'.$x];
			$sla		= $_POST['sla'.$x];
			$aktif		= $akf;
			
			
			// echo " $x -> $nik -> $nama -> $jabatan ->$unit -> $id_proyek <br> ";
			
			mysql_query("INSERT `anggota`	SET `nik`				='$nik',
												`jabatan`			='$jabatan',
												`ket_jabatan`		='$ket_jab',
												`cc`				='$unit',
												`id_proyek`			='$id_proyek',
												`bulan`				='$bulan',
												`hk`				='$hari',
												`sla`				='$sla',
												`tahun`				='$tahun',
												`aktif`				='$aktif'
												");
		}
}

	
header('Location: ../../page.php?page=anggota_proyek&idp='.ec($id_proyek).'&cc='.ec($unit).'&tahun='.ec($tahun).'&bulan='.ec($bulan).'&succes=1');
?>