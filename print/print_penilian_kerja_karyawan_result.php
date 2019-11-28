<?php 
error_reporting(E_ALL);
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
	$getTahun	= mysql_real_escape_string(dc($ex[1]));
	$unit		= mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='$getCC' "));
	
	timeline($_SESSION['nik'],"download","Telah melakukan download file Progress SRKO $unit[uraian] Tahun $getTahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Pengisian Penilaian Sasaran Kerja Karyawan ".$unit['uraian']."_".$getTahun.".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>			

			
			<h4 align="center"><b>Pengisian Penilaian Sasaran Kerja Karyawan Tahun <?=$getTahun?></b></h4>			
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center' bgcolor="#b3d9ff">
						<td width="35" height="30" valign="center"><b>No.</b></td>
						<td width="100"><b>NIK</b></td>
						<td width="350"><b>Nama Karyawan </b></td>
						<td width="150"><b>Unit </b></td>
						<td width="110"><b>Target</b></td>
						<td width="75"><b>Nilai</b></td>
						<td width="150"><b>Penilai</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
						
						$no=1;
						if(isset($unit['CostCenter'])){
							$query = mysql_query("SELECT * FROM user where cc='$getCC' AND level !='4'");
						}else{						
							$query = mysql_query("SELECT * FROM user where level !='2' AND level !='3' AND level !='4' order by cc ASC ");
						}
						while($r=mysql_fetch_array($query)){
							$cc= mysql_fetch_array(mysql_query("select * from mskko where CostCenter='".$r['cc']."'"));
						
							$skk= mysql_fetch_array(mysql_query("select * from penilaian_kerja where nik='".$r['nik']."' AND tahun='".$getTahun."'"));
							if($skk['target']==''){
								$sk = "?";
							}else{
								$sk = "Sudah DiInput";
							}
							
							//===========================================================================//
							$jumlah_nilai1 = 0;
							$jum_bot1 = 0;
							$sql = mysql_query("SELECT * FROM penilaian_kerja where nik='".$r['nik']."' AND tahun='$getTahun'");
							while($r1=mysql_fetch_array($sql)){
								
								
								$pencapaian_2 	= @(($r1['hasil'] / $r1['target'])*100);
								if($pencapaian_2 > 120){
									$pencapaian1 = 120;
								}else{
									$pencapaian1 = $pencapaian_2;
								}
								
								if($r1['satuan']=="Hr" && $r1['hasil']!==null){
									if($r1['hasil'] < $r1['target']){
										$pencapaian1 = 120;
									}else{
										$pencapaian1 = @(($r1['target'] / $r1['hasil'])*100);
									}
								}
								
								if($r1['hasil']<=70){
									$skor1 =($pencapaian1/70)*4.5;								
								}elseif($r1['hasil']<=90){
									$skor1 = 4.5+(($pencapaian1-70)/20)*2;
								}elseif($r1['hasil']<=100){
									$skor1 =6.5+(($pencapaian1-90)/10)*2;
								}elseif($r1['hasil']>100){
									$skor1 = 8.5+(($pencapaian1-100)/20)*1.5;
								}
								
								$sum_bobot_kar_1		= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot FROM penilaian_kerja where nik='".$r['nik']."' AND tahun='$getTahun'"));	
								$bot_kar_1			= @(($r1['bobot'] / $sum_bobot_kar_1['sum_bobot'])*75);
								$jum_bot1 			+= $bot_kar_1;	// Simbol +(plus) untuk penjumlahan berulang 
								
								$nilai1				= $bot_kar_1 * $skor1;
								$jumlah_nilai1		+= $nilai1;	 
							}
							
							$jumlah_total_nilai1 	 = $jumlah_nilai1;	
							$jumlah_bobot	 		 = $jum_bot1;	
							$penilai = mysql_fetch_array(mysql_query("SELECT DISTINCT pm from penilaian_kerja where nik='".$r['nik']."' AND tahun='$getTahun'"));
							$nm_penilai = mysql_fetch_array(mysql_query("SELECT * from user where nik='".$penilai['pm']."'"));
							
							
							echo"
							<tr>
								<td align='center'>$no</td>
								<td align='center'>'$r[nik]</td>
								<td >$r[name]</td>
								<td align='center'>$cc[uraian]</td>
								<td align='center'>$sk</td>
								<td>".desimal($jumlah_total_nilai1)."</td>
								<td>$nm_penilai[name]</td>
							</tr>
							";
						$no++;
						}
				?>
				</tbody>
				
				
			</table>
		