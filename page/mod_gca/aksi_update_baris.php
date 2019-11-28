<?php
session_start();
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_timeline.php";

	$nik			= mysql_real_escape_string($_POST['nik']);
	$bulan			= mysql_real_escape_string($_POST['bulan']);
	$tahun			= mysql_real_escape_string($_POST['tahun']);
	$jam_awal		= mysql_real_escape_string($_POST['jam_awal']);
	$set_jam		= mysql_real_escape_string($_POST['set_jam']);
	$baris			= mysql_real_escape_string($_POST['baris']);
	$lastDay 		= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
	
	timeline($_SESSION['nik'],"edit","Telah melakukan update GCA Load milik ".name($nik)." untuk bulan ".bulan($bulan)." tahun $tahun  ");
	
	$i=1;
	$query_gca		= mysql_query("SELECT id_gca FROM waktu_kerja2 WHERE bulan='$bulan' AND tahun='$tahun' AND nik='$nik' ");
	while($r=mysql_fetch_array($query_gca)){
		if($i==$baris){
			// echo"$i. $r[id_gca]<br>";
			$jumlahHari = 0;
			for($tgl=1;$tgl<=$lastDay;$tgl++){
				$jam = mysql_fetch_array(mysql_query("SELECT `$tgl` FROM waktu_kerja2 WHERE bulan='$bulan' AND tahun='$tahun' AND nik='$nik' AND id_gca='$r[id_gca]'"));
				if($jam_awal==$jam[$tgl]){
					// echo"$tgl ($jam[$tgl])-";
					mysql_query("UPDATE waktu_kerja2 SET `$tgl`='$set_jam' WHERE bulan='$bulan' AND tahun='$tahun' AND nik='$nik' AND id_gca='$r[id_gca]'");
				}
				
				$jam_kerja = mysql_fetch_array(mysql_query("SELECT `$tgl` FROM waktu_kerja2 WHERE bulan='$bulan' AND tahun='$tahun' AND nik='$nik' AND id_gca='$r[id_gca]' "));
				if($jam_kerja[$tgl] > 0){
					$hari_kerja = 1;
				}else{
					$hari_kerja = 0;
				}
				$jumlahHari += $hari_kerja;				
			}
			$durasi	= mysql_fetch_array(mysql_query("SELECT SUM(`1`)+SUM(`2`)+SUM(`3`)+SUM(`4`)+SUM(`5`)+SUM(`6`)+SUM(`7`)+SUM(`8`)+SUM(`9`)+SUM(`10`)+
					SUM(`11`)+SUM(`12`)+SUM(`13`)+SUM(`14`)+SUM(`15`)+SUM(`16`)+SUM(`17`)+SUM(`18`)+SUM(`19`)+SUM(`20`)+
					SUM(`21`)+SUM(`22`)+SUM(`23`)+SUM(`24`)+SUM(`25`)+SUM(`26`)+SUM(`27`)+SUM(`28`)+SUM(`29`)+SUM(`30`)+
					SUM(`31`) as jum FROM waktu_kerja2 
					WHERE id_gca='$r[id_gca]' AND bulan='$bulan' AND tahun='$tahun' AND nik='$nik' "));
			// echo"$durasi[jum]";
			mysql_query("UPDATE waktu_kerja2 SET total_jam='$durasi[jum]',total_hari='$jumlahHari' WHERE `id_gca`='$r[id_gca]' AND nik='$nik' AND bulan='$bulan' AND tahun='$tahun'");
			
			$durasi2	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r[id_gca]' AND nik='$nik' AND tahun='$tahun'"));
			mysql_query("UPDATE wbs SET durasi='$durasi2[jum]' WHERE id='$r[id_gca]'");
			$jumlahHari = 0;
		}
		$i++;
	}
	header("Location: ../../page.php?page=update_gca_load&id=".ec($nik)."-".ec($bulan)."-".ec($tahun)."&succes=1");
	
?>