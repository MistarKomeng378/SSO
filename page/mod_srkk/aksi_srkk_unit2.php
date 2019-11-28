<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";

	$getUnit		= mysql_real_escape_string(dc($_GET['unit']));
	$id				= mysql_real_escape_string(dc($_GET['id']));
	$thSRKK	= mysql_real_escape_string($_GET['tahun']);
	$queryKaryawan	= mysql_query("SELECT nik,`level` FROM user WHERE  grup_id='$id' ");
	while($r=mysql_fetch_array($queryKaryawan)){
		if($r['level']!=4){
			// echo"$r[nik]<br>";
			mysql_query("DELETE FROM srkk_bulanan WHERE nik='$r[nik]' AND tahun='$thSRKK'");
			mysql_query("UPDATE srkk SET nilai='0', bobot='0' WHERE nik='$r[nik]' AND tahun='$thSRKK'");
			
			// mysql_query("DELETE FROM srkk_bulanan WHERE cc='$getUnit' AND nik='$r[nik]'");
			$querySRKK = mysql_query("SELECT srkk.nik, srkk.id_gca,srkk.id_srko, wbs.`level` FROM srkk INNER JOIN wbs ON srkk.id_gca = wbs.id WHERE srkk.nik='$r[nik]'  AND srkk.tahun='$thSRKK' ORDER BY srkk.id_gca");
			while($r2=mysql_fetch_array($querySRKK)){
				// echo"->$r2[id_gca]<br>";
				// mysql_query("DELETE FROM srkk_bulanan WHERE cc='$getUnit' AND nik='$r[nik]'");
				$satuan = mysql_fetch_array(mysql_query("SELECT satuan FROM srko WHERE id_srko='$r2[id_srko]' AND tahun='$thSRKK'"));
				$lv1 = mysql_query("SELECT id,pic,cc_id FROM wbs WHERE parentId='$r2[id_gca]'  AND tahun='$thSRKK'");
				
					$wk0		= mysql_query("SELECT DISTINCT bulan FROM waktu_kerja2 WHERE id_gca='$r2[id_gca]' AND tahun='$thSRKK'");
					while($w0=mysql_fetch_array($wk0)){
						$durasi0	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$w0[bulan]' AND tahun='$thSRKK'"));
						$dur0		= mysql_fetch_array(mysql_query("SELECT target FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$w0[bulan]' AND tahun='$thSRKK'"));
						$totalTarget0= $durasi0['jum']+$dur0['target'];
						mysql_query("REPLACE INTO srkk_bulanan(`nik`, `id_gca`, `cc`, `bulan`, `tahun`, `target`, `satuan`) VALUES('$r[nik]','$r2[id_gca]','$getUnit','$w0[bulan]','$thSRKK','$totalTarget0','$satuan[satuan]')");
						// echo"LV0 $w0[bulan] $durasi0[jum]<br>";
					}
					
				while($r3=mysql_fetch_array($lv1)){
					if($r3['pic']==$r['nik']){
						$wk		= mysql_query("SELECT DISTINCT bulan FROM waktu_kerja2 WHERE id_gca='$r3[id]' AND tahun='$thSRKK'");
						while($w=mysql_fetch_array($wk)){
							$durasi1	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r3[id]' AND nik='$r[nik]' AND bulan='$w[bulan]' AND tahun='$thSRKK'"));
							$dur1		= mysql_fetch_array(mysql_query("SELECT target FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$w[bulan]'  AND tahun='$thSRKK'"));
							$totalTarget1= $durasi1['jum']+$dur1['target'];
							mysql_query("REPLACE INTO srkk_bulanan(`nik`, `id_gca`, `cc`, `bulan`, `tahun`, `target`, `satuan`) VALUES('$r[nik]','$r2[id_gca]','$r3[cc_id]','$w[bulan]','$thSRKK','$totalTarget1','$satuan[satuan]')");
							// echo"$w[bulan] $durasi1[jum]<br>";
						}
						$sd1	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r3[id]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
						// echo"-->$r3[id] = $sd1[jum]<br>";
					}
					$lv2 = mysql_query("SELECT id,pic,cc_id FROM wbs WHERE parentId='$r3[id]' AND tahun='$thSRKK'");
					while($r4=mysql_fetch_array($lv2)){
						if($r4['pic']==$r['nik']){
							$wk2		= mysql_query("SELECT DISTINCT bulan FROM waktu_kerja2 WHERE id_gca='$r4[id]'  AND tahun='$thSRKK'");
							while($w2=mysql_fetch_array($wk2)){
								$durasi2	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r4[id]' AND nik='$r[nik]' AND bulan='$w2[bulan]' AND tahun='$thSRKK'"));
								$dur2		= mysql_fetch_array(mysql_query("SELECT target FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$w2[bulan]' AND tahun='$thSRKK'"));
								$totalTarget2= $durasi2['jum']+$dur2['target'];
								mysql_query("REPLACE INTO srkk_bulanan(`nik`, `id_gca`, `cc`, `bulan`, `tahun`, `target`, `satuan`) VALUES('$r[nik]','$r2[id_gca]','$r4[cc_id]','$w2[bulan]','$thSRKK','$totalTarget2','$satuan[satuan]')");
								// echo"$w2[bulan] $durasi2[jum]<br>";
							}
							$sd2		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r4[id]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
							// echo"--->$r4[id] = $sd2[jum]<br>";
						}
						$lv3 = mysql_query("SELECT id,pic,cc_id FROM wbs WHERE parentId='$r4[id]' AND tahun='$thSRKK'");
						while($r5=mysql_fetch_array($lv3)){
							if($r5['pic']==$r['nik']){
								$wk3		= mysql_query("SELECT DISTINCT bulan FROM waktu_kerja2 WHERE id_gca='$r5[id]' AND tahun='$thSRKK'");
								while($w3=mysql_fetch_array($wk3)){
									$durasi3	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r5[id]' AND nik='$r[nik]' AND bulan='$w3[bulan]' AND tahun='$thSRKK'"));
									$dur3		= mysql_fetch_array(mysql_query("SELECT target FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$w3[bulan]' AND tahun='$thSRKK'"));
									$totalTarget3= $durasi3['jum']+$dur3['target'];
									mysql_query("REPLACE INTO srkk_bulanan(`nik`, `id_gca`, `cc`, `bulan`, `tahun`, `target`, `satuan`) VALUES('$r[nik]','$r2[id_gca]','$r5[cc_id]','$w3[bulan]','$thSRKK','$totalTarget3','$satuan[satuan]')");
									// echo"$w3[bulan] $durasi3[jum]<br>";
								}
								$sd3		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r5[id]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
								// echo"---->$r5[id] = $sd3[jum]<br>";
							}
							$lv4 = mysql_query("SELECT id,pic,cc_id FROM wbs WHERE parentId='$r5[id]' AND tahun='$thSRKK'");
							while($r6=mysql_fetch_array($lv4)){
								if($r6['pic']==$r['nik']){
									$wk4		= mysql_query("SELECT DISTINCT bulan FROM waktu_kerja2 WHERE id_gca='$r6[id]' AND tahun='$thSRKK'");
									while($w4=mysql_fetch_array($wk4)){
										$durasi4	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r6[id]' AND nik='$r[nik]' AND bulan='$w4[bulan]' AND tahun='$thSRKK'"));
										$dur4		= mysql_fetch_array(mysql_query("SELECT target FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$w4[bulan]' AND tahun='$thSRKK'"));
										$totalTarget4= $durasi4['jum']+$dur4['target'];
										mysql_query("REPLACE INTO srkk_bulanan(`nik`, `id_gca`, `cc`, `bulan`, `tahun`, `target`, `satuan`) VALUES('$r[nik]','$r2[id_gca]','$r6[cc_id]','$w4[bulan]','$thSRKK','$totalTarget4','$satuan[satuan]')");
										// echo"$w4[bulan] $durasi4[jum]<br>";
									}
									$sd4		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r6[id]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
									// echo"----->$r6[id] = $sd4[jum]<br>";
								}
								$lv5 = mysql_query("SELECT id,pic,cc_id FROM wbs WHERE parentId='$r6[id]' AND tahun='$thSRKK'");
								while($r7=mysql_fetch_array($lv5)){
									if($r7['pic']==$r['nik']){
										$wk5		= mysql_query("SELECT DISTINCT bulan FROM waktu_kerja2 WHERE id_gca='$r7[id]' AND tahun='$thSRKK'");
										while($w5=mysql_fetch_array($wk5)){
											$durasi5	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r7[id]' AND nik='$r[nik]' AND bulan='$w5[bulan]' AND tahun='$thSRKK'"));
											$dur5		= mysql_fetch_array(mysql_query("SELECT target FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$w5[bulan]' AND tahun='$thSRKK'"));
											$totalTarget5= $durasi5['jum']+$dur5['target'];
											mysql_query("REPLACE INTO srkk_bulanan(`nik`, `id_gca`, `cc`, `bulan`, `tahun`, `target`, `satuan`) VALUES('$r[nik]','$r2[id_gca]','$r7[cc_id]','$w5[bulan]','$thSRKK','$totalTarget5','$satuan[satuan]')");
											// echo"$w5[bulan] $durasi5[jum]<br>";
										}
										$sd5		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r7[id]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
										// echo"------>$r7[id] = $sd5[jum]<br>";
									}
									$lv6 = mysql_query("SELECT id,pic,cc_id FROM wbs WHERE parentId='$r7[id]' AND tahun='$thSRKK'");
									while($r8=mysql_fetch_array($lv6)){
										if($r8['pic']==$r['nik']){
											$wk6		= mysql_query("SELECT DISTINCT bulan FROM waktu_kerja2 WHERE id_gca='$r8[id]' AND tahun='$thSRKK'");
											while($w6=mysql_fetch_array($wk6)){
												$durasi6	= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r8[id]' AND nik='$r[nik]' AND bulan='$w6[bulan]' AND tahun='$thSRKK'"));
												$dur6		= mysql_fetch_array(mysql_query("SELECT target FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$w6[bulan]' AND tahun='$thSRKK'"));
												$totalTarget6= $durasi6['jum']+$dur6['target'];
												mysql_query("REPLACE INTO srkk_bulanan(`nik`, `id_gca`, `cc`, `bulan`, `tahun`, `target`, `satuan`) VALUES('$r[nik]','$r2[id_gca]','$r8[cc_id]','$w6[bulan]','$thSRKK','$totalTarget6','$satuan[satuan]')");
												// echo"$w6[bulan] $durasi6[jum]<br>";
											}
											$sd6		= mysql_fetch_array(mysql_query("SELECT SUM(total_hari) as jum FROM waktu_kerja2 WHERE id_gca='$r8[id]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
											// echo"------->$r8[id] = $sd6[jum]<br>";
										}
									}
								}
							}
						}
					}
				}
				// echo"==========================================================================================================<br>";
			}
			$querySRKK2 = mysql_query("SELECT srkk.nik, srkk.id_gca,srkk.id_srko,srkk.rutin, wbs.`level` FROM srkk INNER JOIN wbs ON srkk.id_gca = wbs.id WHERE srkk.nik='$r[nik]' AND srkk.tahun='$thSRKK'ORDER BY srkk.id_gca");
			while($sr=mysql_fetch_array($querySRKK2)){
				$jmlTarget 	= mysql_fetch_array(mysql_query("SELECT SUM(target) as nilai FROM srkk_bulanan WHERE nik='$r[nik]' AND id_gca='$sr[id_gca]' AND tahun='$thSRKK'"));				
				$jmlNilai 	= mysql_fetch_array(mysql_query("SELECT SUM(target) as jml FROM srkk_bulanan WHERE nik='$r[nik]' AND tahun='$thSRKK' "));				
				mysql_query("UPDATE srkk SET nilai='$jmlTarget[nilai]' WHERE nik='$r[nik]' AND id_gca='$sr[id_gca]' AND tahun='$thSRKK'");
				@$bobot 		= ($jmlTarget['nilai']*75)/$jmlNilai['jml'];
				mysql_query("UPDATE srkk SET bobot='$bobot' WHERE nik='$r[nik]' AND id_gca='$sr[id_gca]' AND tahun='$thSRKK'");
				
				// echo"$sr[id_gca]<br>";
				$tbln = mysql_query("SELECT * FROM srkk_bulanan WHERE nik='$r[nik]' AND id_gca='$sr[id_gca]' AND tahun='$thSRKK'");
				while($bln=mysql_fetch_array($tbln)){
					$jenisAktf = mysql_fetch_array(mysql_query("SELECT jenisAktf FROM wbs WHERE id='$sr[id_gca]' AND tahun='$thSRKK'"));
					@$prosen = $bln['target']*100/$jmlTarget['nilai'];
					if($prosen!=0 AND $jenisAktf['jenisAktf']==1){
						$prosen = 100;
					}else{
						$prosen = $prosen;
					}
					mysql_query("UPDATE srkk_bulanan SET prosen='$prosen' WHERE `nik`='$r[nik]' AND `id_gca`='$sr[id_gca]' AND `bulan`='$bln[bulan]' AND tahun='$thSRKK'");
					// echo"$bln[target] -> $prosen<br>";
				}
				// echo"Total = $jmlTarget[nilai]<br>";
			}
		}		
	}
	// mysql_query("DELETE FROM srkk WHERE nik=''");
	header('Location: ../../page.php?page=data_srkk&succes=1');
?>