<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";


	$getUnit		= mysql_real_escape_string(dc($_GET['unit']));
	$id				= mysql_real_escape_string(dc($_GET['id']));
	$getBulan		= mysql_real_escape_string(dc($_GET['bulan']));
	$tahun_aktif	= mysql_real_escape_string($_GET['tahun']);
	$queryKaryawan	= mysql_query("SELECT nik,level FROM user WHERE  grup_id='$id'");
	
	while($r=mysql_fetch_array($queryKaryawan)){
		if($r['level']!=4){
			mysql_query("DELETE FROM mskk WHERE nik='$r[nik]' AND bulan='$getBulan' AND tahun='$tahun_aktif' ");
			mysql_query("DELETE FROM mskk_bulanan WHERE nik='$r[nik]' AND bulan='$getBulan' AND tahun='$tahun_aktif' ");
			
			$queryMSKK = mysql_query("SELECT * FROM srkk WHERE  nik='$r[nik]' ");
			while($r2=mysql_fetch_array($queryMSKK)){
				mysql_query("REPLACE INTO mskk (`nik`, `id_gca`, `bulan`, `tahun`)	VALUES('$r[nik]','$r2[id_gca]','$getBulan','$tahun_aktif')");
				
				$lv0 = mysql_query("SELECT id,pic FROM wbs WHERE id='$r2[id_gca]' ");
				while($r0=mysql_fetch_array($lv0)){
					if($r0['pic']==$r['nik']){
						$progress0	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r0[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $tahun_aktif' )"));
						$lprogress0	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r0[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%Y' ) = '$tahun_aktif' AND date_format( tgl_aktifitas,'%c' ) < '$getBulan' )"));
						$durasi0	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r0[id]' AND nik='$r[nik]'  AND tahun='$tahun_aktif'"));
						if($r2['rutin']==1){
							$real_prog0 = $progress0['progress'];
						}else{
							$real_prog0	= $progress0['progress'] - $lprogress0['progress'];
						}
						if($progress0['progress']!=""){
							if($real_prog0 <= 0){
								$real_prog0 = $progress0['progress'];
							}
							mysql_query("REPLACE INTO mskk_bulanan(`nik`, `id_srkk`, `id_gca`, `bulan`, `tahun`, `progress`, `hari`, `real_prog`) VALUES('$r[nik]','$r2[id_gca]','$r0[id]','$getBulan','$tahun_aktif','$progress0[progress]','$durasi0[jum]','$real_prog0')");
						}
						
					}
				}
				
				$lv1 = mysql_query("SELECT id,pic FROM wbs WHERE parentId='$r2[id_gca]' ");
				while($r3=mysql_fetch_array($lv1)){
					if($r3['pic']==$r['nik']){
						$progress1	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r3[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $tahun_aktif' )"));
						$lprogress1	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r3[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%Y' ) = '$tahun_aktif' AND date_format( tgl_aktifitas,'%c' ) < '$getBulan')"));
						$durasi1	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r3[id]' AND nik='$r[nik]'  AND tahun='$tahun_aktif'"));
						if($r2['rutin']==1){
							$real_prog1 = $progress1['progress'];
						}else{
							$real_prog1	= $progress1['progress'] - $lprogress1['progress'];
						}
						if($progress1['progress']!=""){
							if($real_prog1 <= 0){
								$real_prog1 = $progress1['progress'];
							}
							mysql_query("REPLACE INTO mskk_bulanan(`nik`, `id_srkk`, `id_gca`, `bulan`, `tahun`, `progress`, `hari`, `real_prog`) VALUES('$r[nik]','$r2[id_gca]','$r3[id]','$getBulan','$tahun_aktif','$progress1[progress]','$durasi1[jum]','$real_prog1')");
						}
						
					}
					$lv2 = mysql_query("SELECT id,pic FROM wbs WHERE parentId='$r3[id]' ");
					while($r4=mysql_fetch_array($lv2)){
						if($r4['pic']==$r['nik']){
							$progress2	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r4[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $tahun_aktif' )"));
							$lprogress2	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r4[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%Y' ) = '$tahun_aktif' AND date_format( tgl_aktifitas,'%c' ) < '$getBulan' )"));
							$durasi2	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r4[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
							if($r2['rutin']==1){
								$real_prog2 = $progress2['progress'];
							}else{
								$real_prog2	= $progress2['progress'] - $lprogress2['progress'];
							}
							if($progress2['progress']!=""){
								if($real_prog2 <= 0){
									$real_prog2 = $progress2['progress'];
								}
								mysql_query("REPLACE INTO mskk_bulanan(`nik`, `id_srkk`, `id_gca`, `bulan`, `tahun`, `progress`, `hari`, `real_prog`) VALUES('$r[nik]','$r2[id_gca]','$r4[id]','$getBulan','$tahun_aktif','$progress2[progress]','$durasi2[jum]','$real_prog2')");
							}
							
						}
						$lv3 = mysql_query("SELECT id,pic FROM wbs WHERE parentId='$r4[id]' ");
						while($r5=mysql_fetch_array($lv3)){
							if($r5['pic']==$r['nik']){
								$progress3	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r5[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $tahun_aktif' )"));
								$lprogress3	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r5[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%Y' ) = '$tahun_aktif' AND date_format( tgl_aktifitas,'%c' ) < '$getBulan' )"));
								$durasi3	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r5[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
								if($r2['rutin']==1){
									$real_prog3 = $progress3['progress'];
								}else{
									$real_prog3	= $progress3['progress'] - $lprogress3['progress'];
								}
								if($progress3['progress']!=""){
									if($real_prog3 <= 0){
										$real_prog3 = $progress3['progress'];
									}
									mysql_query("REPLACE INTO mskk_bulanan(`nik`, `id_srkk`, `id_gca`, `bulan`, `tahun`, `progress`, `hari`, `real_prog`) VALUES('$r[nik]','$r2[id_gca]','$r5[id]','$getBulan','$tahun_aktif','$progress3[progress]','$durasi3[jum]','$real_prog3')");
								}
								
							}
							$lv4 = mysql_query("SELECT id,pic FROM wbs WHERE parentId='$r5[id]' ");
							while($r6=mysql_fetch_array($lv4)){
								if($r6['pic']==$r['nik']){
									$progress4	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r6[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $tahun_aktif' )"));
									$lprogress4	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r6[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%Y' ) = '$tahun_aktif' AND date_format( tgl_aktifitas,'%c' ) < '$getBulan' )"));
									$durasi4	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r6[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
									if($r2['rutin']==1){
										$real_prog4 = $progress4['progress'];
									}else{
										$real_prog4	= $progress4['progress'] - $lprogress4['progress'];
									}
									if($progress4['progress']!=""){
										if($real_prog4 <= 0){
											$real_prog4 = $progress4['progress'];
										}
										mysql_query("REPLACE INTO mskk_bulanan(`nik`, `id_srkk`, `id_gca`, `bulan`, `tahun`, `progress`, `hari`, `real_prog`) VALUES('$r[nik]','$r2[id_gca]','$r6[id]','$getBulan','$tahun_aktif','$progress4[progress]','$durasi4[jum]','$real_prog4')");
									}
									
								}
								$lv5 = mysql_query("SELECT id,pic FROM wbs WHERE parentId='$r6[id]' ");
								while($r7=mysql_fetch_array($lv5)){
									if($r7['pic']==$r['nik']){
										$progress5	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r7[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $tahun_aktif' )"));
										$lprogress5	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r7[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%Y' ) = '$tahun_aktif' AND date_format( tgl_aktifitas,'%c' ) < '$getBulan' )"));
										$durasi5	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r7[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
										if($r2['rutin']==1){
											$real_prog5 = $progress5['progress'];
										}else{
											$real_prog5	= $progress5['progress'] - $lprogress5['progress'];
										}
										if($progress5['progress']!=""){
											if($real_prog5 <= 0){
												$real_prog5 = $progress5['progress'];
											}
											mysql_query("REPLACE INTO mskk_bulanan(`nik`, `id_srkk`, `id_gca`, `bulan`, `tahun`, `progress`, `hari`, `real_prog`) VALUES('$r[nik]','$r2[id_gca]','$r7[id]','$getBulan','$tahun_aktif','$progress5[progress]','$durasi5[jum]','$real_prog5')");
										}
										
									}
									$lv6 = mysql_query("SELECT id,pic FROM wbs WHERE parentId='$r7[id]' ");
									while($r8=mysql_fetch_array($lv6)){
										if($r8['pic']==$r['nik']){
											$progress6	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r8[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $tahun_aktif' )"));
											$lprogress6	= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=$r8[id] AND `status`='1'  AND date_format( tgl_aktifitas,'%Y' ) = '$tahun_aktif' AND date_format( tgl_aktifitas,'%c' ) < '$getBulan' )"));
											$durasi6	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r8[id]' AND nik='$r[nik]' AND tahun='$tahun_aktif'"));
											if($r2['rutin']==1){
												$real_prog6 = $progress6['progress'];
											}else{
												$real_prog6	= $progress6['progress'] - $lprogress6['progress'];
											}
											if($progress6['progress']!=""){
												if($real_prog6 <= 0){
													$real_prog6 = $progress6['progress'];
												}
												mysql_query("REPLACE INTO mskk_bulanan(`nik`, `id_srkk`, `id_gca`, `bulan`, `tahun`, `progress`, `hari`, `real_prog`) VALUES('$r[nik]','$r2[id_gca]','$r8[id]','$getBulan','$tahun_aktif','$progress6[progress]','$durasi6[jum]','$real_prog6')");
											}
											
										}
									}
								}
							}
						}
					}
				}
				// echo"==========================================================================================================<br>";
				$mskkb			= mysql_query("SELECT * FROM mskk_bulanan WHERE id_srkk='$r2[id_gca]' AND bulan='$getBulan' AND tahun='$tahun_aktif' AND nik='$r[nik]' ");
				$totJam	 		= mysql_fetch_array(mysql_query("SELECT SUM(hari) as hari FROM mskk_bulanan WHERE nik='$r[nik]' AND id_srkk='$r2[id_gca]' AND bulan='$getBulan' AND tahun='$tahun_aktif' "));				
				$nilai	 		= mysql_fetch_array(mysql_query("SELECT nilai FROM srkk WHERE nik='$r[nik]' AND id_gca='$r2[id_gca]' AND tahun='$tahun_aktif' "));				
				$target 		= mysql_fetch_array(mysql_query("SELECT prosen FROM srkk_bulanan WHERE id_gca='$r2[id_gca]' AND bulan='$getBulan' AND nik='$r[nik]' "));
				$treal			= 0;
				$bagi 			= 0;
				while($mskk=mysql_fetch_array($mskkb)){
					if($mskk['progress']!=0  AND $mskk['hari']==0 AND $totJam['hari']==0){
						$real_bulanan = $mskk['real_prog'];
					}else{
						if($r2['rutin']==1){
							$real_bulanan = $mskk['real_prog'];
						}else{
							$real_bulanan = ($mskk['real_prog']*($mskk['hari']/$nilai['nilai']));
						}
					}
					mysql_query("UPDATE mskk_bulanan SET pxb='$real_bulanan' WHERE  nik='$r[nik]' AND id_srkk='$r2[id_gca]' AND id_gca='$mskk[id_gca]' AND bulan='$getBulan' AND tahun='$tahun_aktif'");
					
					$treal += $real_bulanan;
					$bagi++;
				}
					@$treal = $treal/$bagi;
					if($treal>100){
						$treal = 100;
					}else{
						$treal = $treal;
					}					
					
					if($treal > 0  AND $target['prosen']==0){
						$pencapaian = 120;
					}else{
						@$pencapaian = ($treal/$target['prosen'])*100;
					}				
					if($pencapaian==0){
						$score = 0;
					}elseif($pencapaian > 0 && $pencapaian <= 20.99){
						$score = 1;
					}elseif($pencapaian > 21 && $pencapaian <= 40.99){
						$score = 2;
					}elseif($pencapaian > 41 && $pencapaian <= 50.99){
						$score = 3;
					}elseif($pencapaian > 51 && $pencapaian <= 60.99){
						$score = 4;
					}elseif($pencapaian > 61 && $pencapaian <= 70.99){
						$score = 5;
					}elseif($pencapaian > 71 && $pencapaian <= 80.99){
						$score = 6;
					}elseif($pencapaian > 81 && $pencapaian <= 90.99){
						$score = 7;
					}elseif($pencapaian > 91 && $pencapaian <= 100.99){
						$score = 8;
					}elseif($pencapaian > 101 && $pencapaian <= 110.99){
						$score = 9;
					}elseif($pencapaian > 111){
						$score = 10;
					}
					if($pencapaian > 120){
						$pencapaian = 120;
					}
					if($target['prosen'] != 0 OR $treal != 0){
						mysql_query("UPDATE mskk SET target='$target[prosen]',realisasi='$treal',pencapaian='$pencapaian',score='$score' WHERE  nik='$r[nik]' AND id_gca='$r2[id_gca]' AND bulan='$getBulan' AND tahun='$tahun_aktif'");
					}else{
						mysql_query("DELETE FROM mskk WHERE id_gca='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$getBulan' AND tahun='$tahun_aktif' ");
						mysql_query("DELETE FROM mskk_bulanan WHERE id_srkk='$r2[id_gca]' AND nik='$r[nik]' AND bulan='$getBulan' AND tahun='$tahun_aktif' ");
					}
					$treal = 0;
				// echo"==========================================================================================================<br>";
			}
			
			$queryMSKK2 = mysql_query("SELECT * FROM mskk WHERE bulan='$getBulan' AND nik='$r[nik]' AND tahun='$tahun_aktif'");
			while($ms=mysql_fetch_array($queryMSKK2)){
				$bobotA		 	= mysql_fetch_array(mysql_query("SELECT srkk.bobot as bobot FROM srkk INNER JOIN mskk ON mskk.nik = srkk.nik AND mskk.id_gca = srkk.id_gca WHERE mskk.nik='$r[nik]' AND mskk.tahun='$tahun_aktif' AND mskk.bulan='$getBulan' AND mskk.id_gca='$ms[id_gca]'"));				
				$sumbbt		 	= mysql_fetch_array(mysql_query("SELECT SUM(srkk.bobot) as bobot FROM mskk INNER JOIN srkk ON srkk.id_gca = mskk.id_gca WHERE srkk.nik='$r[nik]' AND mskk.nik='$r[nik]' AND srkk.tahun='$tahun_aktif' AND mskk.bulan='$getBulan' "));				
				
				$bobot = ($bobotA['bobot']/$sumbbt['bobot'])*75;
				$bxs	= $bobot * $ms['score'];
				mysql_query("UPDATE mskk SET bobotA='$bobotA[bobot]',bobot='$bobot',bxs='$bxs' WHERE  nik='$r[nik]' AND id_gca='$ms[id_gca]' AND bulan='$getBulan' AND tahun='$tahun_aktif'");
			}
		}		
	}
	mysql_query("DELETE FROM mskk WHERE tahun=''");
	header('Location: ../../page.php?page=mskk&succes=1');
?>