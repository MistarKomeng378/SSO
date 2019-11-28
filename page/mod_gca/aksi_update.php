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
	$lastDay 		= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
	
	mysql_query("DELETE FROM waktu_kerja2 WHERE nik='$nik' AND bulan='$bulan' AND tahun='$tahun' ");
	timeline($_SESSION['nik'],"edit","Telah melakukan update GCA Load milik ".name($nik)." untuk bulan ".bulan($bulan)." tahun $tahun  ");
	
	$jum = count($_POST['id_gca1']);
	for($i=0; $i<$jum; $i++){
		$id_gca			= mysql_real_escape_string($_POST['id_gca1'][$i]);
		$wbs			= mysql_fetch_array(mysql_query("SELECT parentId,cc_id FROM wbs WHERE id='$id_gca'"));
		
		
		mysql_query("INSERT INTO waktu_kerja2(`nik`,`id_gca`,`parentId`,`cc`,`bulan`,`tahun`) VALUES('$nik','$id_gca','$wbs[parentId]','$wbs[cc_id]','$bulan','$tahun') ");
		
		// echo"$id_gca<br>";
		$d=1;
		for ($tgl=0;$tgl<$lastDay;$tgl++){
			$tgl_kerja 		= mysql_real_escape_string($_POST['tgl_kerja'][$tgl]);
			$jam_kerja		= mysql_real_escape_string($_POST['jam_kerja_'.$d.'-'.$id_gca]);
			
			if($jam_kerja==""){
				$delLibur = mysql_fetch_array(mysql_query("SELECT count(tanggal) as count FROM libur_nasional WHERE date_format( tanggal,'%e %c %Y' ) = '$d $bulan $tahun' "));
				if($delLibur['count'] > 0 ){
					$jam_kerja = "";
				}else{
					$jam_kerja = 0;
				}				
			}else{
				$jam_kerja = $jam_kerja;
			}
			$ex		= explode("-",$tgl_kerja);
			$hari	= $ex[2];
			
			// echo"$tgl_kerja/ ";
			
			if(date("D",mktime (0,0,0,$bulan,$hari,$tahun)) == "Sun") {
				
			}elseif(date("D",mktime (0,0,0,$bulan,$hari,$tahun)) == "Sat") {
				
			}else{
				mysql_query("UPDATE waktu_kerja2 SET  `$d`='$jam_kerja' WHERE `nik`='$nik' AND `id_gca`='$id_gca' AND bulan='$bulan' AND tahun='$tahun'");
			}
			$d++;
			$tot_durasi += $jam_kerja;
			
			if($jam_kerja > 0){
				$hari_kerja = 1;
			}else{
				$hari_kerja = 0;
			}
			$jumlahHari += $hari_kerja;
		}		
		// echo"<br>";
		mysql_query("UPDATE waktu_kerja2 SET total_jam='$tot_durasi',total_hari='$jumlahHari' WHERE `nik`='$nik' AND `id_gca`='$id_gca' AND bulan='$bulan' AND tahun='$tahun'");
		$durasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$id_gca' AND nik='$nik' AND tahun='$tahun'"));
		mysql_query("UPDATE wbs SET durasi='$durasi[jum]' WHERE id='$id_gca'");
		$tot_durasi=0;
		$jumlahHari = 0;
	}
	header("Location: ../../page.php?page=gca_load_detail&id=".ec($nik)."-".ec($bulan)."-".ec($tahun)."&succes=1");
	
?>