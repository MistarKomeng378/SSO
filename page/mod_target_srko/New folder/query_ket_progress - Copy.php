<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

@$id_srko 		= mysql_real_escape_string($_POST['id_srko']);
@$cc 			= mysql_real_escape_string($_POST['cc']);
@$bulan			= mysql_real_escape_string($_POST['bulan']);
@$tahun			= mysql_real_escape_string($_POST['tahun']);

if($_GET['opt']=="analisa"){
	$id_ket			= mysql_real_escape_string($_POST['id_ket']);
	$ket			= mysql_real_escape_string($_POST['ket']);
	$what			= mysql_real_escape_string($_POST['what']);
	$when			= mysql_real_escape_string($_POST['when']);
	$where			= mysql_real_escape_string($_POST['where']);
	$who			= mysql_real_escape_string($_POST['who']);
	$why			= mysql_real_escape_string($_POST['why']);
	$how			= mysql_real_escape_string($_POST['how']);
	$how_much		= mysql_real_escape_string($_POST['how_much']);
	$time			= mysql_real_escape_string($_POST['time']);
	$place			= mysql_real_escape_string($_POST['place']);
	$organization	= mysql_real_escape_string($_POST['organization']);
	
	if($_GET['act']=="input"){
		mysql_query("INSERT INTO `ket_progress_srko` SET 	`id_ket`			='$id_ket',
															`id_srko`			='$id_srko',
															`cc`				='$cc',
															`bulan`				='$bulan',
															`tahun`				='$tahun',
															`ket_progress`		='$ket',
															`what`				='$what',
															`who`				='$who',
															`when`				='$when',
															`where`				='$where',
															`why`				='$why',
															`how`				='$how',
															`how_much`			='$how_much',
															`time`				='$time',
															`place`				='$place',
															`organization`		='$organization'
												");
		header("location:../../page.php?page=ket_progress&unit=".ec($id_srko)."-".ec($cc)."-".ec($bulan)."-".ec($id_ket)."-".ec($tahun)."&act=".$_GET['act']."&opt=hasil");
	}elseif($_GET['act']=="edit"){
		mysql_query("UPDATE `ket_progress_srko` SET 	`id_srko` 			='$id_srko',
														`cc` 				='$cc',
														`bulan` 			='$bulan',
														`tahun` 			='$tahun',
														`ket_progress`		='$ket',
														`what`				='$what',
														`who`				='$who',
														`when`				='$when',
														`where`				='$where',
														`why`				='$why',
														`how`				='$how',
														`how_much`			='$how_much',
														`time`				='$time',
														`place`				='$place',
														`organization`		='$organization'
												WHERE	`id_ket`			='$id_ket' AND cc='$cc' AND id_srko='$id_srko' AND bulan='$bulan' AND tahun='$tahun'
												");
		// header("location:../../page.php?page=dashboard");
		header("location:../../page.php?page=ket_progress&unit=".ec($id_srko)."-".ec($cc)."-".ec($bulan)."-".ec($id_ket)."-".ec($tahun)."&opt=view");
	}

	
}elseif($_GET['opt']=="hasil"){
	$id_ket			= mysql_real_escape_string($_POST['id_ket']);
	$hasil			= mysql_real_escape_string($_POST['editor']);
	mysql_query("UPDATE `ket_progress_srko` SET 	`hasil_analisa`		='$hasil'
											WHERE	`id_ket`='$id_ket' AND cc='$cc' AND id_srko='$id_srko' AND bulan='$bulan' AND tahun='$tahun'
											");
	// header("location:../../page.php?page=dashboard");
	header("location:../../page.php?page=ket_progress&unit=".ec($id_srko)."-".ec($cc)."-".ec($bulan)."-".ec($id_ket)."-".ec($tahun)."&opt=view");
}elseif($_GET['opt']=="recycle"){
	$ex			= explode("-",$_GET['id']);
	$getID		= mysql_real_escape_string(dc($ex[0]));
	$getCC		= mysql_real_escape_string(dc($ex[1]));
	$getBulan	= mysql_real_escape_string(dc($ex[2]));
	$getTahun	= mysql_real_escape_string(dc($ex[3]));
	$idKet		= mysql_real_escape_string(dc($ex[4]));
	$newBulan	= $getBulan+1;
	
	$id_ket = mysql_fetch_array(mysql_query("select MAX(id_ket) as idKet from ket_progress_srko "));
	$kode_lama = substr($id_ket['idKet'],2,6);
	$kode_lama = (int) $kode_lama + 1;
	$kode_baru = date("y").sprintf('%06s',$kode_lama);
	
	// echo"$getID<br>";
	// echo"$getCC<br>";
	// echo"$getBulan<br>";
	// echo"$newBulan<br>";
	// echo"$getTahun<br>";
	$qket = mysql_query("SELECT * FROM ket_progress_srko WHERE id_srko='$getID' AND cc='$getCC' AND bulan='$getBulan' AND tahun='$getTahun' AND id_ket='$idKet'");
	while($r=mysql_fetch_array($qket)){
		$id_ket			= mysql_real_escape_string($kode_baru);
		$ket			= mysql_real_escape_string($r['ket_progress']);
		$what			= mysql_real_escape_string($r['what']);
		$when			= mysql_real_escape_string($r['when']);
		$where			= mysql_real_escape_string($r['where']);
		$who			= mysql_real_escape_string($r['who']);
		$why			= mysql_real_escape_string($r['why']);
		$how			= mysql_real_escape_string($r['how']);
		$how_much		= mysql_real_escape_string($r['how_much']);
		$time			= mysql_real_escape_string($r['time']);
		$place			= mysql_real_escape_string($r['place']);
		$organization	= mysql_real_escape_string($r['organization']);	
		$hasil_analisa	= mysql_real_escape_string($r['hasil_analisa']);	
		
		mysql_query("INSERT INTO `ket_progress_srko` SET 	`id_ket`			='$id_ket',
															`id_srko`			='$getID',
															`cc`				='$getCC',
															`bulan`				='$newBulan',
															`tahun`				='$getTahun',
															`ket_progress`		='$ket',
															`what`				='$what',
															`who`				='$who',
															`when`				='$when',
															`where`				='$where',
															`why`				='$why',
															`how`				='$how',
															`how_much`			='$how_much',
															`time`				='$time',
															`place`				='$place',
															`organization`		='$organization',
															`hasil_analisa`		='$hasil_analisa'
												");
		$kode_baru++;
	}

	header("location:../../page.php?page=ket_progress&unit=".ec($getID)."-".ec($getCC)."-".ec($newBulan)."-".ec($id_ket)."-".ec($getTahun)."&opt=view");
}
?>