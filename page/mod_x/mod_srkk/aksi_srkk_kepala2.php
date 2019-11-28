<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";

	$getUnit	= mysql_real_escape_string(dc($_GET['unit']));
	$getId		= mysql_real_escape_string(dc($_GET['id']));
	$tahun		= mysql_real_escape_string($_GET['tahun']);
	$getKepala	= mysql_real_escape_string(dc($_GET['nik']));
	mysql_query("DELETE FROM srkk WHERE nik='$getKepala' AND tahun='$tahun' ");
	$query = mysql_query("SELECT id,aktivitas,id_srko FROM wbs WHERE tahun='$tahun' AND cc_id='$getUnit' AND `level`='4' ");
	while($r=mysql_fetch_array($query)){
		$bobotSatuan	= mysql_fetch_array(mysql_query("SELECT * FROM srko WHERE tahun='$tahun' AND CostCenter='$getUnit' AND id_srko='$r[id_srko]'"));
		$bobotTotal		= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as bobot FROM srko WHERE tahun='$tahun' AND CostCenter='$getUnit' "));
		$konversi		= ($bobotSatuan['bobot']*75)/100;
		
		mysql_query("REPLACE INTO srkk SET 	`nik`		= '$getKepala',
											`id_srko`	= '$r[id_srko]',
											`id_gca`	= '$r[id]',
											`cc`		= '$getUnit',
											`tahun`		= '$tahun',
											`nilai`		= '',
											`bobot`		= '$konversi'
											");
	}
	header('Location: ../../page.php?page=detail_srkk&nik='.ec($getKepala).'&lvl=4&succes=1');
?>