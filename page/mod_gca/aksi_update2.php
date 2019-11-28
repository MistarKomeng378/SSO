<?php
// session_start();

include"../../config/koneksi.php";
// include"../../config/fungsi_bulan.php";
// include"../../config/fungsi_name.php";
// include"../../config/fungsi_timeline.php";

		$clear_array 	= array_unique($_POST['bulan2']);
		$countBulan		= count($clear_array);	
		$bln			= array_values($clear_array);
		for($b=0;$b<$countBulan;$b++){
			
			$bulan		= $bln[$b];
			$tahun		= mysql_real_escape_string($_POST['tahun2'][$b]);
			$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
			$clear_nik	= array_unique($_POST['pic']);
			$clearNik	= array_values($clear_nik);
			$countNik	= count($clear_nik);
				for($i=0; $i<$countNik; $i++){
					$nik		= $clearNik[$i];
					$id_gca	= count($_POST['id_gca1']);
					
					$clear_gca	 	= array_unique($_POST['id_gca1']);
					$countGCA		= count($clear_gca)/$countNik;	
					$jmlGca			= array_values($clear_gca);
					// timeline($_SESSION['nik'],"edit","Telah melakukan update GCA Load milik ".name($nik)." untuk bulan ".bulan($bulan)." tahun $tahun  ");
					
					for($g=0; $g<$countGCA; $g++){
						$id_gca			= mysql_real_escape_string($_POST['id_gca1'][$g]);
						$d=1;
						
						for ($tgl=0;$tgl<$lastDay;$tgl++){
							@$jam_kerja		= mysql_real_escape_string($_POST['jam_kerja_'.$d.'-'.$bulan.'-'.$id_gca]);
							mysql_query("UPDATE waktu_kerja2 SET  `$d`='$jam_kerja' WHERE `nik`='$nik' AND `id_gca`='$id_gca' AND bulan='$bulan' AND tahun='$tahun'");
							$d++;
							if($jam_kerja > 0){
								$hari = 1;
							}else{
								$hari = 0;
							}
							$jumlahHari += $hari;
						}
						
							$durasi	= mysql_fetch_array(mysql_query("SELECT SUM(`1`)+SUM(`2`)+SUM(`3`)+SUM(`4`)+SUM(`5`)+SUM(`6`)+SUM(`7`)+SUM(`8`)+SUM(`9`)+SUM(`10`)+
										SUM(`11`)+SUM(`12`)+SUM(`13`)+SUM(`14`)+SUM(`15`)+SUM(`16`)+SUM(`17`)+SUM(`18`)+SUM(`19`)+SUM(`20`)+
										SUM(`21`)+SUM(`22`)+SUM(`23`)+SUM(`24`)+SUM(`25`)+SUM(`26`)+SUM(`27`)+SUM(`28`)+SUM(`29`)+SUM(`30`)+
										SUM(`31`)+SUM(`32`) as jum FROM waktu_kerja2 WHERE id_gca='$id_gca' AND bulan='$bulan' AND tahun='$tahun' AND nik='$nik' "));
							mysql_query("UPDATE waktu_kerja2 SET total_jam='$durasi[jum]',total_hari='$jumlahHari' WHERE `id_gca`='$id_gca' AND nik='$nik' AND bulan='$bulan' AND tahun='$tahun'");
							
							$durasi2	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$id_gca' AND nik='$nik' AND tahun='$tahun'"));
							mysql_query("UPDATE wbs SET durasi='$durasi2[jum]' WHERE id='$id_gca'");
							$jumlahHari = 0;
					}
				}
		}
		header("Location: ../../page.php?page=data_gca&succes=1");
?>