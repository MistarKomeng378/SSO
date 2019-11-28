<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

$bulan			= mysql_real_escape_string($_POST['bulan']);
$tahun			= mysql_real_escape_string($_POST['tahun']);

$jml	= count($_POST['id_kpi']);
for($i=0; $i<$jml; $i++){
	$id_kpi 		= mysql_real_escape_string($_POST['id_kpi'][$i]);
	$id_perspektif 	= mysql_real_escape_string($_POST['id_perspektif'][$i]);
	$realisasi 		= mysql_real_escape_string($_POST['realisasi'][$i]);
	$bobot	 		= mysql_real_escape_string($_POST['bobot'][$i]);
	$satuan 		= mysql_real_escape_string($_POST['satuan'][$i]);
	$target 		= mysql_real_escape_string($_POST['target'][$i]);
	$analisa 		= mysql_real_escape_string($_POST['analisa'][$i]);
	$solusi 		= mysql_real_escape_string($_POST['solusi'][$i]);
	
	$data			= mysql_fetch_array(mysql_query("SELECT rumus,perhitungan FROM kpku_kpi WHERE id_kpi='$id_kpi' "));
	$rumus			= $data['rumus'];
	$perhitungan	= $data['perhitungan'];
	
	if($rumus==1){
		if($target==0 AND $realisasi>0){
			$hasil = 100;
		}elseif($target>0 AND $realisasi<=0){
			$hasil = 0;
		}elseif($target==0 AND $realisasi<=0){
			$hasil = 0;
		}else{
			$hasil = ($realisasi/$target)*100;
		}										
	}elseif($rumus==2){
		if($target==0 AND $realisasi>0){
			$hasil = 100;
		}elseif($target>0 AND $realisasi<=0){
			$hasil = 0;
		}elseif($target==0 AND $realisasi<=0){
			$hasil = 0;
		}else{
			$hasil = (($target - ($realisasi-$target)) / $target) * 100;
		}
	}else{
		$hasil = 0;
	}
	if($hasil <= 0){
		$nilai=0;
	}elseif($hasil > 0){
		if($hasil>120){
			$nilai=120;
		}else{
			$nilai=$hasil;
		}										
	}else{
		$nilai="";
	}
	$rkap = mysql_fetch_array(mysql_query("SELECT target_rkap FROM target_rkap WHERE id_kpi='$id_kpi' AND bulan='$bulan' AND tahun='$tahun' "));
	if($bulan==1){
		$kom_rkap = $rkap['target_rkap'];
		$kom_real = $realisasi;
		
		@$prosen_real 	= ($realisasi / $rkap['target_rkap']) * 100;
		@$prosen_kom 	= ($kom_real / $kom_rkap) * 100;	
	}else{
		$bulan2 	= $bulan - 1;
		$rkap2 		= mysql_fetch_array(mysql_query("SELECT kom_rkap FROM kpku_kpi_target WHERE id_kpi='$id_kpi' AND bulan='$bulan2' AND tahun='$tahun' "));
		$kom_rkap 	= $rkap2['kom_rkap']+$rkap['target_rkap'];
		$real 		= mysql_fetch_array(mysql_query("SELECT kom_real FROM kpku_kpi_target WHERE id_kpi='$id_kpi' AND bulan='$bulan2' AND tahun='$tahun' "));
		$kom_real 	= $realisasi+$real['kom_real'];
		
		@$prosen_real 	= ($realisasi / $rkap['target_rkap']) * 100;
		@$prosen_kom 	= ($kom_real / $kom_rkap) * 100;
	}
	
	// echo"$id_kpi-$tahun-$bulan-$id_perspektif-$realisasi - $target > $kom_rkap > $kom_real = ($rumus)$nilai<br>";
	// echo"$id_kpi-$tahun-$bulan-$bulan2 - $rkap2[kom_rkap]+$rkap[target_rkap] = $kom_rkap<br>";
	
	mysql_query("REPLACE INTO `kpku_kpi_target` (`bulan`, `tahun`, `id_kpi`, `id_perspektif`, `realisasi_bulan`, `pencapaian`, `analisa`, `usulan_solusi`, `kom_rkap`, `kom_real`, `prosen_real`, `prosen_kom`)
	VALUES ('$bulan','$tahun','$id_kpi','$id_perspektif','$realisasi','$nilai','$analisa','$solusi','$kom_rkap','$kom_real','$prosen_real','$prosen_kom') ");
}

$jml2	= count($_POST['id_kpi2']);
for($i=0; $i<$jml2; $i++){
	$id_kpi2 		= mysql_real_escape_string($_POST['id_kpi2'][$i]);
	$realisasi2 	= mysql_real_escape_string($_POST['realisasi2'][$i]);
	$satuan 		= mysql_real_escape_string($_POST['satuan2'][$i]);
	$target 		= mysql_real_escape_string($_POST['target2'][$i]);
	$analisa2 		= mysql_real_escape_string($_POST['analisa2'][$i]);
	$solusi2 		= mysql_real_escape_string($_POST['solusi2'][$i]);
	
	$data			= mysql_fetch_array(mysql_query("SELECT rumus,perhitungan FROM kpku_kpi WHERE id_kpi='$id_kpi2' "));
	$rumus			= $data['rumus'];
	$perhitungan	= $data['perhitungan'];
	
	if($rumus==1){
		if($target==0 AND $realisasi2>0){
			$hasil = 100;
		}elseif($target>0 AND $realisasi2<=0){
			$hasil = 0;
		}elseif($target==0 AND $realisasi2<=0){
			$hasil = 0;
		}else{
			$hasil = ($realisasi2/$target)*100;
		}										
	}elseif($rumus==2){
		if($target==0 AND $realisasi2>0){
			$hasil = 100;
		}elseif($target>0 AND $realisasi2<=0){
			$hasil = 0;
		}elseif($target==0 AND $realisasi2<=0){
			$hasil = 0;
		}else{
			$hasil = (($target - ($realisasi2-$target)) / $target) * 100;
		}
	}else{
		$hasil = 0;
	}
	if($hasil <= 0){
		$nilai=0;
	}elseif($hasil > 0){
		if($hasil>120){
			$nilai=120;
		}else{
			$nilai=$hasil;
		}										
	}else{
		$nilai="";
	}
	$rkap = mysql_fetch_array(mysql_query("SELECT target_rkap FROM target_rkap WHERE id_kpi='$id_kpi2' AND bulan='$bulan' AND tahun='$tahun' "));
	if($bulan==1){
		$kom_rkap = $rkap['target_rkap'];
		$kom_real = $realisasi2;
		
		@$prosen_real 	= ($realisasi2 / $rkap['target_rkap']) * 100;
		@$prosen_kom 	= ($kom_real / $kom_rkap) * 100;
	}else{
		$bulan2 	= $bulan - 1;
		$rkap2 		= mysql_fetch_array(mysql_query("SELECT kom_rkap FROM kpku_kpi_target WHERE id_kpi='$id_kpi2' AND bulan='$bulan2' AND tahun='$tahun' "));
		$kom_rkap 	= $rkap2['kom_rkap']+$rkap['target_rkap'];
		$real 		= mysql_fetch_array(mysql_query("SELECT kom_real FROM kpku_kpi_target WHERE id_kpi='$id_kpi2' AND bulan='$bulan2' AND tahun='$tahun' "));
		$kom_real 	= $realisasi2+$real['kom_real'];
		
		@$prosen_real 	= ($realisasi2 / $rkap['target_rkap']) * 100;
		@$prosen_kom 	= ($kom_real / $kom_rkap) * 100;
	}
	
	// echo"$id_kpi2-$tahun-$bulan--$realisasi2-$satuan-$target = $nilai /$kom_rkap/$kom_real<br>";
	// echo"$id_kpi2-$tahun-$bulan-$bulan2 - $rkap2[kom_rkap]+$rkap[target_rkap] = $kom_rkap<br>";
	
	mysql_query("REPLACE INTO `kpku_kpi_target` (`bulan`, `tahun`, `id_kpi`, `realisasi_bulan`, `pencapaian`, `analisa`, `usulan_solusi`, `kom_rkap`, `kom_real`, `prosen_real`, `prosen_kom`)
	VALUES ('$bulan','$tahun','$id_kpi2','$realisasi2','$nilai','$analisa2','$solusi2','$kom_rkap','$kom_real','$prosen_real','$prosen_kom')	");
}
header("location:../../page.php?page=target_kpi&succes=1");
?>