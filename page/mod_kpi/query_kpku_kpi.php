<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

if($_GET['opt']=="perspektif"){
	$id_perspektif 	= mysql_real_escape_string($_POST['id_perspektif']);
	$perspektif 	= mysql_real_escape_string($_POST['perspektif']);
	$tahun 			= mysql_real_escape_string($_POST['tahun']);
	
	if($_GET['act']=="tambah"){
		mysql_query("INSERT INTO kpku_perspektif(`id_perspektif`,`tahun`,`perspektif`) VALUES
					('$id_perspektif','$tahun','$perspektif') ");
	}elseif($_GET['act']=="edit"){
		mysql_query("UPDATE kpku_perspektif SET `id_perspektif`	='$id_perspektif',
												`tahun`			='$tahun',
												`perspektif`	='$perspektif' 
										WHERE `id_perspektif`	='$id_perspektif'");
	}
	header("location:../../page.php?page=form_kpku_kpi&opt=$_GET[opt]&act=tambah&succes=1");
}elseif($_GET['opt']=="kpi_kpku"){
	$id_kpi		 	= mysql_real_escape_string($_POST['id_kpi']);
	$id_perspektif 	= mysql_real_escape_string($_POST['id_perspektif']);
	$id_srko	 	= mysql_real_escape_string($_POST['id_srko']);
	$kpi		 	= mysql_real_escape_string($_POST['kpi']);
	$tahun 			= mysql_real_escape_string($_POST['tahun']);
	$bobot 			= mysql_real_escape_string($_POST['bobot']);
	$satuan 		= mysql_real_escape_string($_POST['satuan']);
	$t_tahunan 		= mysql_real_escape_string($_POST['t_tahunan']);
	$rumus	 		= mysql_real_escape_string($_POST['rumus']);
	$perhitungan 	= mysql_real_escape_string($_POST['perhitungan']);
	$scale 			= mysql_real_escape_string($_POST['s_awal']).":".mysql_real_escape_string($_POST['s_akhir']).":".mysql_real_escape_string($_POST['rentang']);
	$rkap 			= mysql_real_escape_string($_POST['rkap']);
	$real 			= mysql_real_escape_string($_POST['real']);
	$rkap_kom 		= mysql_real_escape_string($_POST['rkap_kom']);
	$real_kom 		= mysql_real_escape_string($_POST['real_kom']);
	$real_pro 		= mysql_real_escape_string($_POST['real_pro']);
	$kom_pro 		= mysql_real_escape_string($_POST['kom_pro']);
	$trkap 			= mysql_real_escape_string($_POST['trkap']);
	$treal 			= mysql_real_escape_string($_POST['treal']);
	$trkap_kom 		= mysql_real_escape_string($_POST['trkap_kom']);
	$treal_kom 		= mysql_real_escape_string($_POST['treal_kom']);
	$treal_pro 		= mysql_real_escape_string($_POST['treal_pro']);
	$tkom_pro 		= mysql_real_escape_string($_POST['tkom_pro']);
	
	if($_GET['act']=="tambah"){
		mysql_query("INSERT INTO `kpku_kpi`(`id_kpi`,`id_srko`,`id_perspektif`, `tahun`, `kpi`, `bobot`, `satuan`, `target_tahun`, `rumus`, `perhitungan`,`v_rkap`, `v_real`, `v_rkap_kom`, `v_real_kom`, `v_prosen_real`, `v_prosen_kom`,`t_rkap`, `t_real`, `t_rkap_kom`, `t_real_kom`, `t_prosen_real`, `t_prosen_kom`, `scale`) VALUES 
											('$id_kpi','$id_srko','$id_perspektif','$tahun','$kpi','$bobot','$satuan','$t_tahunan','$rumus','$perhitungan','$rkap','$real','$rkap_kom','$real_kom','$real_pro','$kom_pro','$trkap','$treal','$trkap_kom','$treal_kom','$treal_pro','$tkom_pro','$scale') ");
	}elseif($_GET['act']=="edit"){
		mysql_query("UPDATE kpku_kpi SET 	`id_kpi`		='$id_kpi',
											`id_srko`		='$id_srko',
											`tahun`			='$tahun',
											`id_perspektif`	='$id_perspektif',
											`kpi`			='$kpi',
											`bobot`			='$bobot',
											`satuan`		='$satuan',
											`target_tahun`	='$t_tahunan',
											`rumus`			='$rumus',
											`perhitungan`	='$perhitungan',
											`v_rkap`		='$rkap',
											`v_real`		='$real',
											`v_rkap_kom`	='$rkap_kom',
											`v_real_kom`	='$real_kom',
											`v_prosen_real`	='$real_pro',
											`v_prosen_kom`	='$kom_pro',
											`t_rkap`		='$trkap',
											`t_real`		='$treal',
											`t_rkap_kom`	='$trkap_kom',
											`t_real_kom`	='$treal_kom',
											`t_prosen_real`	='$treal_pro',
											`t_prosen_kom`	='$tkom_pro',
											`scale`			='$scale'
										WHERE `id_kpi`		='$id_kpi'");
	}
	header("location:../../page.php?page=form_kpku_kpi&opt=$_GET[opt]&act=tambah&idp=".ec($id_perspektif)."&succes=1");
}elseif($_GET['opt']=="kpi_kpku2"){
	$id_kpi		 	= mysql_real_escape_string($_POST['id_kpi']);
	$id_srko	 	= mysql_real_escape_string($_POST['id_srko']);
	$kpi		 	= mysql_real_escape_string($_POST['kpi']);
	$tahun 			= mysql_real_escape_string($_POST['tahun']);
	$satuan 		= mysql_real_escape_string($_POST['satuan']);
	$t_tahunan 		= mysql_real_escape_string($_POST['t_tahunan']);
	$rumus	 		= mysql_real_escape_string($_POST['rumus']);
	$perhitungan 	= mysql_real_escape_string($_POST['perhitungan']);
	$scale 			= mysql_real_escape_string($_POST['s_awal']).":".mysql_real_escape_string($_POST['s_akhir']).":".mysql_real_escape_string($_POST['rentang']);
	$rkap 			= mysql_real_escape_string($_POST['rkap']);
	$real 			= mysql_real_escape_string($_POST['real']);
	$rkap_kom 		= mysql_real_escape_string($_POST['rkap_kom']);
	$real_kom 		= mysql_real_escape_string($_POST['real_kom']);
	$real_pro 		= mysql_real_escape_string($_POST['real_pro']);
	$kom_pro 		= mysql_real_escape_string($_POST['kom_pro']);
	$trkap 			= mysql_real_escape_string($_POST['trkap']);
	$treal 			= mysql_real_escape_string($_POST['treal']);
	$trkap_kom 		= mysql_real_escape_string($_POST['trkap_kom']);
	$treal_kom 		= mysql_real_escape_string($_POST['treal_kom']);
	$treal_pro 		= mysql_real_escape_string($_POST['treal_pro']);
	$tkom_pro 		= mysql_real_escape_string($_POST['tkom_pro']);
	
	if($_GET['act']=="tambah"){
		mysql_query("INSERT INTO `kpku_kpi`(`id_kpi`,`id_srko`, `tahun`, `kpi`, `satuan`, `target_tahun`, `rumus`, `perhitungan`,`v_rkap`, `v_real`, `v_rkap_kom`, `v_real_kom`, `v_prosen_real`, `v_prosen_kom`,`t_rkap`, `t_real`, `t_rkap_kom`, `t_real_kom`, `t_prosen_real`, `t_prosen_kom`, `scale`) VALUES 
											('$id_kpi','$id_srko','$tahun','$kpi','$satuan','$t_tahunan','$rumus','$perhitungan','$rkap','$real','$rkap_kom','$real_kom','$real_pro','$kom_pro','$trkap','$treal','$trkap_kom','$treal_kom','$treal_pro','$tkom_pro','$scale') ");
	}elseif($_GET['act']=="edit"){
		mysql_query("UPDATE kpku_kpi SET 	`id_kpi`		='$id_kpi',
											`id_srko`		='$id_srko',
											`tahun`			='$tahun',
											`kpi`			='$kpi',
											`satuan`		='$satuan',
											`target_tahun`	='$t_tahunan', 
											`rumus`			='$rumus', 
											`perhitungan`	='$perhitungan',
											`v_rkap`		='$rkap',
											`v_real`		='$real',
											`v_rkap_kom`	='$rkap_kom',
											`v_real_kom`	='$real_kom',
											`v_prosen_real`	='$real_pro',
											`v_prosen_kom`	='$kom_pro',
											`t_rkap`		='$trkap',
											`t_real`		='$treal',
											`t_rkap_kom`	='$trkap_kom',
											`t_real_kom`	='$treal_kom',
											`t_prosen_real`	='$treal_pro',
											`t_prosen_kom`	='$tkom_pro',
											`scale`			='$scale'
										WHERE `id_kpi`		='$id_kpi'");
	}
	header("location:../../page.php?page=form_kpku_kpi&opt=$_GET[opt]&tahun=".ec($tahun)."&act=tambah&succes=1");
}elseif($_GET['opt']=="rkap"){	
	$tahun 			= mysql_real_escape_string($_POST['tahun']);
	
	
	$jum = count($_POST['id_kpi']);
	for($i=0;$i<=$jum;$i++){
		@$id_kpi		= mysql_real_escape_string($_POST['id_kpi'][$i]);
		@$id_perspektif = mysql_real_escape_string($_POST['id_perspektif'][$i]);
		@$rkap			= mysql_real_escape_string($_POST['rkap'][$i]);	
		@$satuan 		= mysql_real_escape_string($_POST['satuan'][$i]);
		$bulan 			= mysql_real_escape_string($_POST['bulan'][$i]);
		
		mysql_query("REPLACE INTO target_rkap (`id_kpi`, `id_perspektif`, `bulan`, `tahun`, `satuan`, `target_rkap`) VALUES
					('$id_kpi','$id_perspektif','$bulan','$tahun','$satuan','$rkap')");
		
		// echo"$id_kpi > $id_perspektif > $bulan > $tahun >$rkap <br>";
	}
	$jum2 = count($_POST['id_kpi2']);
	for($i=0;$i<=$jum2;$i++){
		@$id_kpi2	= mysql_real_escape_string($_POST['id_kpi2'][$i]);
		@$rkap2		= mysql_real_escape_string($_POST['rkap2'][$i]);
		@$satuan2	= mysql_real_escape_string($_POST['satuan2'][$i]);
		@$bulan 		= mysql_real_escape_string($_POST['bulan2'][$i]);
		
		mysql_query("REPLACE INTO target_rkap (`id_kpi`, `id_perspektif`, `bulan`, `tahun`, `satuan`, `target_rkap`) VALUES
					('$id_kpi2','0','$bulan','$tahun','$satuan2','$rkap2')");
					
		// echo"$id_kpi2 > $bulan > $tahun > $rkap2 >$jum2<br>";
	}
	
	header("location:../../page.php?page=form_kpku_kpi&opt=$_GET[opt]&act=tambah&succes=1");
}

?>