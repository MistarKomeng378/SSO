<?php 
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/fungsi_rupiah.php";
    include "../config/fungsi_bulan.php";
    include "../config/fungsi_name.php";
    include "../config/encript.php";
    include "../config/fungsi_timeline.php";
	
	$ex			= explode("-",$_GET['id']);
	$getCC		= mysql_real_escape_string(dc($ex[0]));
	$getBulan	= mysql_real_escape_string(dc($ex[1]));
	$getTahun	= mysql_real_escape_string(dc($ex[2]));
	$unit		= mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='$getCC' "));
	timeline($_SESSION['nik'],"download","Telah melakukan download Progress Sasaran/Rencana Kerja Organisasi (SRKO) ".$unit['uraian']." Bulan ".bulan($getBulan)." Tahun $getTahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Target_progress_SRKO_".$unit['uraian']."_".$getTahun.".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>
			<h4><b>Sasaran/Rencana Kerja Organisasi (SRKO) : <?=$unit['uraian']?> 
				<br>s/d Bulan <?=bulan($getBulan)?>
				<br>Tahun <?=$getTahun?>
			</b>
			</h4>
			<table border="1" cellpadding='3'>
				<thead>
					<tr align='center' bgcolor='#b3d9ff'>
						<td rowspan='2'><b>No.</b></td>
						<td rowspan='2'><b>ID.</b></td>
						<td rowspan='2'><b>Sasaran/Rencana Kerja</b></td>
						<td rowspan='2'><b>Bobot</b></td>
						<td rowspan='2'><b>Target Tahunan</b></td>
						<td colspan='3'><b>Bulan Ini</b></td>
						<td colspan='3'><b>S/d Bulan Ini</b></td>
					</tr>
					<tr bgcolor='#b3d9ff'>
						<td><b>Target</b></td>
						<td><b>Realisasi</b></td>
						<td><b>Pencapaian</b></td>
						<td><b>Target</b></td>
						<td><b>Realisasi</b></td>
						<td><b>Pencapaian</b></td>		
					</tr>								
				</thead>
				<tbody>
				<?php
						$no=1;
						$tbobot = 0;
						$query = mysql_query("SELECT DISTINCT id_srko,rencana_kerja,bobot,target,satuan FROM srko WHERE CostCenter='$getCC' AND tahun='$getTahun' order by id_srko");
						while($r=mysql_fetch_array($query)){
							$target = mysql_fetch_array(mysql_query("SELECT target FROM target_srko WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
							$prog 	= mysql_fetch_array(mysql_query("SELECT pencapaian,realisasi,jenis_resume,jenis_pencapaian FROM progress_srko WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
							$jrbul	= mysql_fetch_array(mysql_query("SELECT COUNT(realisasi) as bln FROM progress_srko WHERE tahun='$getTahun' AND id_srko='$r[id_srko]' AND realisasi!=''"));
							if($prog['jenis_resume']==1){
								$jr1 		= mysql_fetch_array(mysql_query("SELECT target FROM progress_srko WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr1['target']);
								$tt 		= $jr1['target'];
								$jr11 		= mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr11['realisasi']);
								$rea	 	= $jr11['realisasi'];
							}elseif($prog['jenis_resume']==2){
								$jr2 		= mysql_fetch_array(mysql_query("SELECT SUM(target) as sumtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr2['sumtarget']);
								$tt 		= $jr2['sumtarget'];
								$jr22 		= mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as sumrealisasi FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr22['sumrealisasi']);
								$rea 		= $jr22['sumrealisasi'];
							}elseif($prog['jenis_resume']==3){
								$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr3['avgtarget']);
								$tt 		= $jr3['avgtarget'];
								$jr33 		= mysql_fetch_array(mysql_query("SELECT AVG(realisasi) as avgrealisasi FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr33['avgrealisasi']);
								$rea 		= $jr33['avgrealisasi'];
							}elseif($prog['jenis_resume']==4){
								$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr3['avgtarget']);
								$tt 		= $jr3['avgtarget'];
								
								$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100;
								$realisasi 	= desimal3($tpm);
								$rea 		= $tpm;
							}
							if($prog['jenis_pencapaian']==1){
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = ($rea/$tt)*100;
								}										
							}elseif($prog['jenis_pencapaian']==2){
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = (($tt - ($rea-$tt)) / $tt) * 100;
								}
							}elseif($prog['jenis_pencapaian']==3){
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = ($rea/$tt)*100;
								}
							}
							if($hasil <= 0){
								$pencapaian=0;
							}elseif($hasil > 0){
								if($hasil>120){
									$pencapaian=120;
								}else{
									$pencapaian=desimal3($hasil);
								}
							}
							if($pencapaian < 100){
								$fc1="red";
							}else{
								$fc1="";
							}
							if($prog['pencapaian'] < 100){
								$fc2="red";
							}else{
								$fc2="";
							}
							$jmlKet = mysql_num_rows(mysql_query("SELECT id_ket FROM ket_progress_srko WHERE id_srko='$r[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' "));
							echo"
							<tr>
								<td align='center'>$no</td>
								<td align='center'>$r[id_srko]</td>
								<td>$r[rencana_kerja]</td>
								<td align='center'>$r[bobot]</td>
								<td align='center'>$r[target] $r[satuan]</td>
								<td align='center' bgcolor='#99ff99' title='Target - Bulanan'>$target[target]</td>
								<td align='center' bgcolor='#99ff99' title='Realisasi - Bulanan'>
									";
										if($prog['jenis_pencapaian']==3){
											echo desimal3($prog['realisasi']);
										}else{
											echo"$prog[realisasi]";
										}								
									echo"
								</td>
								<td align='center' bgcolor='#99ff99' title='Pencapaian - Bulanan'><span style=\"color:$fc2\">".desimal3($prog['pencapaian'])." %</span></td>
								<td align='center' bgcolor='#99ccff' title='Target - s/d Bulan Berjalan'>$tot_target</td>
								<td align='center' bgcolor='#99ccff' title='Realisasi - s/d Bulan Berjalan'>";
									if($prog['jenis_pencapaian']==3){
										echo desimal3($realisasi);
									}else{
										echo"$realisasi";
									}
								echo"</td>
								<td align='center' bgcolor='#99ccff' title='Pencapaian - s/d Bulan Berjalan'><span style=\"color:$fc1\">$pencapaian %</span></td>
							</tr>
							";
							$no++;
							$tbobot +=$r['bobot'];
						}
						echo"
							<tr>
								<td colspan='3'></td>
								<td align='center'>$tbobot</td>
								<td  colspan='7'></td>
							</tr>
						";
				?>
				</tbody>
			</table>
		