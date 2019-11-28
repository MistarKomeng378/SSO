<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";

	$getUnit	= mysql_real_escape_string(dc($_GET['unit']));
	$getId		= mysql_real_escape_string(dc($_GET['id']));
	$getTahun	= mysql_real_escape_string($_GET['tahun']);
	$getLvl		= mysql_real_escape_string($_GET['lvl']);
	$getKepala	= mysql_real_escape_string(dc($_GET['nik']));
	$getBulan	= mysql_real_escape_string(dc($_GET['bulan']));
	
	$query = mysql_query("SELECT * FROM srkk WHERE tahun='$getTahun' AND nik='$getKepala'");
	while($r=mysql_fetch_array($query)){
		$prog = mysql_fetch_array(mysql_query("SELECT * FROM progress_srko WHERE id_srko='$r[id_srko]' AND cc='$r[cc]' AND bulan='$getBulan' AND tahun='$getTahun'"));
		// echo"$r[id_gca]<br>";
		
		if($prog['pencapaian']==0){
			$score = 0;
		}elseif($prog['pencapaian'] > 0 && $prog['pencapaian'] <= 20.99){
			$score = 1;
		}elseif($prog['pencapaian'] > 21 && $prog['pencapaian'] <= 40.99){
			$score = 2;
		}elseif($prog['pencapaian'] > 41 && $prog['pencapaian'] <= 50.99){
			$score = 3;
		}elseif($prog['pencapaian'] > 51 && $prog['pencapaian'] <= 60.99){
			$score = 4;
		}elseif($prog['pencapaian'] > 61 && $prog['pencapaian'] <= 70.99){
			$score = 5;
		}elseif($prog['pencapaian'] > 71 && $prog['pencapaian'] <= 80.99){
			$score = 6;
		}elseif($prog['pencapaian'] > 81 && $prog['pencapaian'] <= 90.99){
			$score = 7;
		}elseif($prog['pencapaian'] > 91 && $prog['pencapaian'] <= 100.99){
			$score = 8;
		}elseif($prog['pencapaian'] > 101 && $prog['pencapaian'] <= 110.99){
			$score = 9;
		}elseif($prog['pencapaian'] > 111){
			$score = 10;
		}
					
		mysql_query("REPLACE INTO mskk (`nik`, `id_gca`, `bulan`, `tahun`, `bobotA`, `target`, `realisasi`, `pencapaian`, `score`) 
		VALUES ('$getKepala','$r[id_gca]','$getBulan','$getTahun','$r[bobot]','$prog[target]','$prog[realisasi]','$prog[pencapaian]','$score')");
	}
	mysql_query("DELETE FROM mskk WHERE nik='$getKepala' AND bulan='$getBulan' AND tahun='$getTahun' AND (target='0' OR target='') AND (realisasi='0' OR realisasi='') ");
	$tbobot = mysql_fetch_array(mysql_query("SELECT SUM(bobotA) as bobot FROM mskk WHERE tahun='$getTahun' AND nik='$getKepala' AND bulan='$getBulan' "));
	$query2 = mysql_query("SELECT * FROM mskk WHERE tahun='$getTahun' AND nik='$getKepala' AND bulan='$getBulan' ");
	while($r=mysql_fetch_array($query2)){
		$bobot = ($r['bobotA']/$tbobot['bobot'])*75;
		$bxs	= $bobot * $r['score'];
		// echo"$r[id_gca] - $tbobot[bobot] <br>";
		mysql_query("UPDATE mskk SET bobot='$bobot',bxs='$bxs' 
		WHERE  nik='$getKepala' AND id_gca='$r[id_gca]' AND bulan='$getBulan' AND tahun='$getTahun'");
	}				
	
	header('Location: ../../page.php?page=detail_mskk&id='.ec($getKepala).'-'.ec($getBulan).'-'.ec($getTahun).'&lvl='.$getLvl.'&succes=1');
?>