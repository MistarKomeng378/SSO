<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";

	$getUnit		= mysql_real_escape_string(dc($_GET['unit']));
	$id				= mysql_real_escape_string(dc($_GET['id']));
	$tahun_aktif	= mysql_real_escape_string($_GET['tahun']);
	$queryKaryawan	= mysql_query("SELECT nik,level FROM user WHERE  grup_id='$id' ");
	while($r=mysql_fetch_array($queryKaryawan)){
		if($r['level']!=4){
			// echo"$r[nik]<br>";
			$querySRKK = mysql_query("SELECT srkk.id_gca,srkk.id_srko FROM srkk WHERE nik='$r[nik]' ORDER BY id_gca");
			$querySRKK2 = mysql_query("SELECT srkk.id_gca,srkk.id_srko FROM srkk WHERE nik='$r[nik]' ORDER BY id_gca");
			while($r2=mysql_fetch_array($querySRKK)){
				mysql_query("DELETE FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND tahun='$tahun_aktif' ");
				$target = mysql_fetch_array(mysql_query("SELECT satuan FROM srko WHERE id_srko='$r2[id_srko]'"));
				// echo"->$r2[id_gca]<br>";
				for($b=1;$b<=12;$b++){
					$qId1	= mysql_query("SELECT DISTINCT id FROM wbs WHERE parentId='$r2[id_gca]' AND tahun='$tahun_aktif'");
					while($d1=mysql_fetch_array($qId1)){
						$durasi1	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$tahun_aktif'"));
						$sd1		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$r2[id_gca]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
						// echo" $b -1->$d1[id]->$r2[id_gca]->$r2[id_srko] $durasi1[jum] $sd1[jum]<br>";
						
						$qId2	= mysql_query("SELECT DISTINCT id FROM wbs WHERE  parentId='$d1[id]' AND tahun='$tahun_aktif'");
						$cek1 = mysql_num_rows($qId2);
						if($cek1==0){
							$jml_durasi	= $sd1['jum'];
							if($jml_durasi==0){
								$durasi 	= 0;
							}else{
								$durasi		= ($durasi1['jum'])*100/$jml_durasi;
							}
						}
						while($d2=mysql_fetch_array($qId2)){
							$durasi2	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d1[id]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$tahun_aktif'"));
							$sd2		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d1[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
							// echo" $b -2->$d2[id]->$r2[id_gca]->$r2[id_srko] $durasi2[jum] $sd2[jum]<br>";
							
							$qId3	= mysql_query("SELECT DISTINCT id FROM wbs WHERE  parentId='$d2[id]' AND tahun='$tahun_aktif'");
							$cek2 = mysql_num_rows($qId3);
							if($cek2==0){
								$jml_durasi	= $sd1['jum']+$sd2['jum'];
								if($jml_durasi==0){
									$durasi 	= 0;
								}else{
									$durasi		= ($durasi1['jum']+$durasi2['jum'])*100/$jml_durasi;
								}
							}
							while($d3=mysql_fetch_array($qId3)){
								$durasi3	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d2[id]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$tahun_aktif'"));
								$sd3		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d2[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
								// echo" $b -3->$d3[id]->$r2[id_gca]->$r2[id_srko] $durasi3[jum] $sd3[jum]<br>";
								
								$qId4	= mysql_query("SELECT DISTINCT id FROM wbs WHERE  parentId='$d3[id]' AND tahun='$tahun_aktif'");
								$cek3 = mysql_num_rows($qId4);
								if($cek3==0){
									$jml_durasi	= $sd1['jum']+$sd2['jum']+$sd3['jum'];
									if($jml_durasi==0){
										$durasi 	= 0;
									}else{
										$durasi		= ($durasi1['jum']+$durasi2['jum']+$durasi3['jum'])*100/$jml_durasi;
									}									
								}								
								// while($d4=mysql_fetch_array($qId4)){
									// $durasi4	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d3[id]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$tahun_aktif'"));
									// $sd4		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d3[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
									// echo" $b -4->$d4[id]->$r2[id_gca]->$r2[id_srko] $durasi4[jum] $sd4[jum]<br>";
									
									// $qId5	= mysql_query("SELECT DISTINCT id FROM wbs WHERE  parentId='$d4[id]' AND tahun='$tahun_aktif'");
									// $cek4 = mysql_num_rows($qId5);
									// if($cek4==0){
										// $jml_durasi	= $sd1['jum']+$sd2['jum']+$sd3['jum']+$sd4['jum'];
										// if($jml_durasi==0){
											// $durasi 	= 0;
										// }else{
											// $durasi		= ($durasi1['jum']+$durasi2['jum']+$durasi3['jum']+$durasi4['jum'])*100/$jml_durasi;
										// }										
									// }
									// while($d5=mysql_fetch_array($qId5)){
										// $durasi5	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d4[id]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$tahun_aktif'"));
										// $sd5		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d4[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
										// echo" $b -5->$d5[id]->$r2[id_gca]->$r2[id_srko] $durasi5[jum] $sd5[jum]<br>";
										
										// $qId6	= mysql_query("SELECT DISTINCT id FROM wbs WHERE  parentId='$d5[id]' AND tahun='$tahun_aktif'");
										// $cek5 = mysql_num_rows($qId6);
										// if($cek5==0){
											// $jml_durasi	= $sd1['jum']+$sd2['jum']+$sd3['jum']+$sd4['jum']+$sd5['jum'];
											// if($jml_durasi==0){
												// $durasi 	= 0;
											// }else{
												// $durasi		= ($durasi1['jum']+$durasi2['jum']+$durasi3['jum']+$durasi4['jum']+$durasi5['jum'])*100/$jml_durasi;
											// }											
										// }
										// while($d6=mysql_fetch_array($qId6)){
											// $durasi6	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d5[id]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$tahun_aktif'"));
											// $sd6		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d5[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
											// echo" $b -6->$d6[id]->$r2[id_gca]->$r2[id_srko] $durasi6[jum] $sd6[jum]<br>";
											
											// $qId7	= mysql_query("SELECT DISTINCT id FROM wbs WHERE  parentId='$d6[id]' AND tahun='$tahun_aktif'");
											// $cek6 = mysql_num_rows($qId7);
											// if($cek6==0){
												// $jml_durasi	= $sd1['jum']+$sd2['jum']+$sd3['jum']+$sd4['jum']+$sd5['jum']+$sd6['jum'];
												// if($jml_durasi==0){
													// $durasi 	= 0;
												// }else{
													// $durasi		= ($durasi1['jum']+$durasi2['jum']+$durasi3['jum']+$durasi4['jum']+$durasi5['jum']+$durasi6['jum'])*100/$jml_durasi;
												// }												
											// }
											// while($d7=mysql_fetch_array($qId7)){
												// $durasi7	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d6[id]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$tahun_aktif'"));
												// $sd7		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE parentId='$d6[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
												// echo" $b -7->$d7[id]->$r2[id_gca]->$r2[id_srko] $durasi7[jum] $sd7[jum]<br>";
												
												// $qId8	= mysql_query("SELECT DISTINCT id FROM wbs WHERE  parentId='$d7[id]' AND tahun='$tahun_aktif'");
												// $cek7 = mysql_num_rows($qId8);
												// if($cek7==0){
													// $jml_durasi	= $sd1['jum']+$sd2['jum']+$sd3['jum']+$sd4['jum']+$sd5['jum']+$sd6['jum']+$sd7['jum'];
													// if($jml_durasi==0){
														// $durasi 	= 0;
													// }else{
														// $durasi		= ($durasi1['jum']+$durasi2['jum']+$durasi3['jum']+$durasi4['jum']+$durasi5['jum']+$durasi6['jum']+$durasi7['jum'])*100/$jml_durasi;
													// }												
												// }
											// }
										// }
									// }
								// }
							}
						}
					}
					// $jml_durasi	= $sd1['jum']+$sd2['jum']+$sd3['jum']+$sd4['jum']+$sd5['jum']+$sd6['jum'];
					// $jml_durasi	= $sd1['jum']+$sd2['jum']+$sd3['jum'];
					// $durasi		= ($durasi1['jum']+$durasi2['jum']+$durasi3['jum']+$durasi4['jum']+$durasi5['jum']+$durasi6['jum'])*100/$jml_durasi;
					// $durasi		= ($durasi1['jum']+$durasi2['jum']+$durasi3['jum'])*100/$jml_durasi;
					mysql_query("REPLACE INTO srkk_bulanan(`nik`, `id_gca`, `bulan`, `target`, `satuan`) VALUES('$r[nik]','$r2[id_gca]','$b','$durasi','$target[satuan]')");
					// echo"$b-".$durasi." $jml_durasi > ($durasi1[jum]+$durasi2[jum]+$durasi3[jum]+$durasi4[jum]+$durasi5[jum]+$durasi6[jum]+$durasi7[jum])*100/($sd1[jum]+$sd2[jum]+$sd3[jum]+$sd4[jum]+$sd5[jum]+$sd6[jum]+$sd7[jum])<br>";
				}
				// echo"$jml_durasi	<br>";
				mysql_query("UPDATE srkk SET nilai='$jml_durasi' WHERE id_srko='$r2[id_srko]' AND id_gca='$r2[id_gca]' AND nik='$r[nik]' AND tahun='$tahun_aktif'");
				
			}
			while($r3=mysql_fetch_array($querySRKK2)){
				$jmlDurasi 	= mysql_fetch_array(mysql_query("SELECT SUM(nilai) as durasi FROM srkk WHERE nik='$r[nik]' AND tahun='$tahun_aktif' "));
				$nilai 		= mysql_fetch_array(mysql_query("SELECT * FROM srkk WHERE nik='$r[nik]' AND tahun='$tahun_aktif' AND id_gca='$r3[id_gca]'"));
				if($jmlDurasi['durasi']==0){
					$bobot=0;
				}else{
					$bobot		= ($nilai['nilai']*75)/$jmlDurasi['durasi'];
				}
				mysql_query("UPDATE srkk SET bobot='$bobot' WHERE id_srko='$r3[id_srko]' AND id_gca='$r3[id_gca]' AND nik='$r[nik]' AND tahun='$tahun_aktif'");
				// echo"---------------------->($bobot) $jmlDurasi[durasi] $nilai[nilai]<br>";
			}
			
		}
	}
	mysql_query("DELETE FROM srkk WHERE nik=''");
	header('Location: ../../page.php?page=data_srkk&succes=1');
?>