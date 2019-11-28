<?php
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_rupiah.php";
include"../../config/encript.php";

// $getBulan	= mysql_real_escape_string($_POST['bulan']);
// $getTahun	= mysql_real_escape_string($_POST['tahun']) ;
error_reporting(0);
$ex				= explode("-",$_POST['id']);
$getNik			= dc($ex[0]);
$getName		= dc($ex[1]);
$getCc			= dc($ex[2]);
$getTahun		= dc($ex[3]);
$getBulan		= dc($ex[4]);
$kar 			= mysql_fetch_array(mysql_query("select * from m_karyawan where regno ='$getNik'"));  
$jab 			= mysql_fetch_array(mysql_query("select * from m_jabatan where poscode = '".$kar['poscode']."'"));
$div 			= mysql_fetch_array(mysql_query("SELECT * FROM mskko where CostCenter = '".$getCc."'"));
$divisi			= $div['uraian'];
$jabatan		= $jab['posdesc'];


							$query = mysql_query("SELECT DISTINCT id_srko,rencana_kerja,bobot,target,satuan,hasil_akhir FROM srko WHERE CostCenter='$getCc' AND tahun='$getTahun' AND parent_srko='' order by id_srko");							
							while($r=mysql_fetch_array($query)){
								
							$target = mysql_fetch_array(mysql_query("SELECT target FROM target_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
							
							$prog 	= mysql_fetch_array(mysql_query("SELECT pencapaian,realisasi,jenis_resume,jenis_pencapaian FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
							
							$jrbul	= mysql_fetch_array(mysql_query("SELECT COUNT(realisasi) as bln FROM progress_srko_detile WHERE tahun='$getTahun' AND id_srko='$r[id_srko]' AND realisasi!=''"));
							
							if($prog['jenis_resume']==1){  //Bulan Terakhir
								$jr1 		= mysql_fetch_array(mysql_query("SELECT target FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr1['target']);
								$tt 		= $jr1['target'];
								$jr11 		= mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr11['realisasi']);
								$rea	 	= $jr11['realisasi'];
								
							}elseif($prog['jenis_resume']==2){  //Komulatif
								$jr2 		= mysql_fetch_array(mysql_query("SELECT SUM(target) as sumtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr2['sumtarget']);
								$tt 		= $jr2['sumtarget'];
								$jr22 		= mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as sumrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr22['sumrealisasi']);
								$rea 		= $jr22['sumrealisasi'];
								
							}elseif($prog['jenis_resume']==3){  //Rata-Rata
								$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr3['avgtarget']);
								$tt 		= $jr3['avgtarget'];
								$jr33 		= mysql_fetch_array(mysql_query("SELECT AVG(realisasi) as avgrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr33['avgrealisasi']);
								$rea 		= $jr33['avgrealisasi'];
								
							}elseif($prog['jenis_resume']==4){  //Prof. Margin
								$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr3['avgtarget']);
								$tt 		= $jr3['avgtarget'];								
								$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100; 
								$realisasi 	= desimal3($tpm);
								$rea 		= $tpm;
							}
							if($prog['jenis_pencapaian']==1){  //Positif
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = ($rea/$tt)*100;
								}	
								
							}elseif($prog['jenis_pencapaian']==2){  //Negatif
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = (($tt - ($rea-$tt)) / $tt) * 100;
								}
								
							}elseif($prog['jenis_pencapaian']==3){  //Prof. Margin
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
							
							// $jmlKet = mysql_num_rows(mysql_query("SELECT id_ket FROM ket_progress_srko WHERE id_srko='$r[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCc' "));
							
							// Realisasi
							if($prog['jenis_pencapaian']==3){
								$realisasi_hasil =  desimal3($realisasi);
							}else{
								$realisasi_hasil = $realisasi;
							}
							
														
							///////////////////////////////////////////////////////////////////////////////
							//Bobot Kepala Unit
							$sum_bot_kepala	= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot_kep FROM srko where CostCenter='$getCc' AND tahun='$getTahun' "));
							$bot_kep_unit		= ($r['bobot'] / $sum_bot_kepala['sum_bobot_kep'])*75;
							$jum_bot22[] 		= $bot_kep_unit;	
							
							
							$capai = ($realisasi_hasil / $r['target'])*100;							
							if($capai > 120 ){
								$pencapaian = desimal(120);
							}else{
								$pencapaian = desimal3($capai);
							}
							
							
							if($pencapaian<=70){
								$skor = desimal3(($pencapaian/70)*4.5);								
							}elseif($pencapaian<=90){
								$skor = desimal3(4.5+(($pencapaian-70)/20)*2);
							}elseif($pencapaian<=100){
								$skor = desimal3(6.5+(($pencapaian-90)/10)*2);
							}elseif($pencapaian>100){
								$skor = desimal3(8.5+(($pencapaian-100)/20)*1.5);
							}
							
							$nilai				= desimal3($bot_kep_unit * $skor);
							$jum_nilai22[]		= $nilai;	
						}
						
						$jumlah_bobot22	 		= array_sum($jum_bot22);	
						$jumlah_total_nilai22 	= array_sum($jum_nilai22);


?>	
		
	<div class="panel panel-inverse">
		<div class="panel-body">
		<table border="0" width="100%">
			<tr> 
				<td width="10%">NIK/Nama</td>
				<td>:</td>
				<td><b> <?=$getNik?> / <?=$getName ?></b></td>
				<td rowspan="3" align="right">
					<?php
						echo" <a href='print/print_penilaian_kerja_kepala_unit.php?CostCenter=".ec($getCc)."&tahun=".ec($getTahun)."&nik=".ec($getNik)."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Cetak</a>";
					?> &nbsp;&nbsp;
				</td>
			</tr>
			<tr> 
				<td>Jabatan</td>
				<td>:</td>
				<td><b> <?=$jabatan?></b></td>
			</tr>
			<tr> 
				<td>Divisi</td>
				<td>:</td>
				<td><b> <?=$divisi?></b></td>
			</tr>
			<tr> 
				<td>Nilai</td>
				<td>:</td>
				<td><b><font size="3"><?=desimal3($jumlah_total_nilai22)?></font></b></td>
			</tr>
		</table>
		<br>
		
		<table class="table table-bordered table-striped table-hover">
				<thead>
					<th width="10">No.</th>
					<th>Rencana Kerja</th>
					<th width="100">Target</th>
					<th width="20">Bobot</th>
					<th width="20">Hasil</th>
					<th width="20">Pencapaian (%)</th>
					<th width="20">Skor</th>
					<th width="20">Nilai</th>
				</thead>
				<tbody>
					<?php
							$i=1;
							$query = mysql_query("SELECT DISTINCT id_srko,rencana_kerja,bobot,target,satuan,hasil_akhir FROM srko WHERE CostCenter='$getCc' AND tahun='$getTahun' AND parent_srko='' order by id_srko");							
							while($r=mysql_fetch_array($query)){
								
							$target = mysql_fetch_array(mysql_query("SELECT target FROM target_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
							
							$prog 	= mysql_fetch_array(mysql_query("SELECT pencapaian,realisasi,jenis_resume,jenis_pencapaian FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
							
							$jrbul	= mysql_fetch_array(mysql_query("SELECT COUNT(realisasi) as bln FROM progress_srko_detile WHERE tahun='$getTahun' AND id_srko='$r[id_srko]' AND realisasi!=''"));
							
							if($prog['jenis_resume']==1){  //Bulan Terakhir
								$jr1 		= mysql_fetch_array(mysql_query("SELECT target FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr1['target']);
								$tt 		= $jr1['target'];
								$jr11 		= mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr11['realisasi']);
								$rea	 	= $jr11['realisasi'];
								
							}elseif($prog['jenis_resume']==2){  //Komulatif
								$jr2 		= mysql_fetch_array(mysql_query("SELECT SUM(target) as sumtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr2['sumtarget']);
								$tt 		= $jr2['sumtarget'];
								$jr22 		= mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as sumrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr22['sumrealisasi']);
								$rea 		= $jr22['sumrealisasi'];
								
							}elseif($prog['jenis_resume']==3){  //Rata-Rata
								$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr3['avgtarget']);
								$tt 		= $jr3['avgtarget'];
								$jr33 		= mysql_fetch_array(mysql_query("SELECT AVG(realisasi) as avgrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr33['avgrealisasi']);
								$rea 		= $jr33['avgrealisasi'];
								
							}elseif($prog['jenis_resume']==4){  //Prof. Margin
								$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr3['avgtarget']);
								$tt 		= $jr3['avgtarget'];								
								$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100; 
								$realisasi 	= desimal3($tpm);
								$rea 		= $tpm;
							}
							if($prog['jenis_pencapaian']==1){  //Positif
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = ($rea/$tt)*100;
								}	
								
							}elseif($prog['jenis_pencapaian']==2){  //Negatif
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = (($tt - ($rea-$tt)) / $tt) * 100;
								}
								
							}elseif($prog['jenis_pencapaian']==3){  //Prof. Margin
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
							
							// $jmlKet = mysql_num_rows(mysql_query("SELECT id_ket FROM ket_progress_srko WHERE id_srko='$r[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCc' "));
							
							// Realisasi
							if($prog['jenis_pencapaian']==3){
								$realisasi_hasil =  desimal3($realisasi);
							}else{
								$realisasi_hasil = $realisasi;
							}
							
							
							///////////////////////////////////////////////////////////////////////////////
							//Bobot Kepala Unit
							$sum_bot_kepala	= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot_kep FROM srko where CostCenter='$getCc' AND tahun='$getTahun' "));
							$bot_kep_unit		= ($r['bobot'] / $sum_bot_kepala['sum_bobot_kep'])*75;
							$jum_bot2[] 		= $bot_kep_unit;	
							
							
							$capai = ($realisasi_hasil / $r['target'])*100;							
							if($capai > 120 ){
								$pencapaian = desimal(120);
							}else{
								$pencapaian = desimal3($capai);
							}
							
							
							if($pencapaian<=70){
								$skor = desimal3(($pencapaian/70)*4.5);								
							}elseif($pencapaian<=90){
								$skor = desimal3(4.5+(($pencapaian-70)/20)*2);
							}elseif($pencapaian<=100){
								$skor = desimal3(6.5+(($pencapaian-90)/10)*2);
							}elseif($pencapaian>100){
								$skor = desimal3(8.5+(($pencapaian-100)/20)*1.5);
							}
							
							$nilai				= desimal3($bot_kep_unit * $skor);
							$jum_nilai[]		= $nilai;	
							
							echo"
								<tr>
									<td align='center'>$i</td>
									<td>$r[rencana_kerja]</td>
									<td align='left'>$r[target] $r[satuan]</td>
									<td align='center'>$bot_kep_unit</td>
									<td align='center'>$realisasi_hasil</td>
									<td align='center'>$pencapaian</td>
									<td align='center'>$skor</td>
									<td align='center'>$nilai</td>
									
								</tr>
							";
							$i++;
						}
						
						$jumlah_bobot	 	= array_sum($jum_bot2);	
						$jumlah_total_nilai = array_sum($jum_nilai);
					?>	
						<tr>
							<td colspan="2" align="right"><b>TOTAL</b></td>
							<td align="center">&nbsp;</td>
							<td align="center"><b><?=desimal3($jumlah_bobot); ?></b></td>
							<td align="center" colspan="3">&nbsp;</td>
							<td align="center"><b><?=desimal3($jumlah_total_nilai); ?></b></td>
						</tr>	
				</tbody>
			</table>
			<small> Keterangan : <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<b>Bobot yang telah diinput dikonversikan secara otomatis menjadi 75</b> </small>
			<br>
			<br>
			<h6><b>Rumus Perhitungam Skor</b></h6>
			<table border='1' width='100%' align='center')>				
					<tr>
						<td align='center'><b>Dibawah Target &nbsp; (P  0% <u><</u> x <u><</u> 70%)</b></td>
						<td align='center'><b>Mendekati Target &nbsp; (P  70% < x <u><</u> 90%)</b></td>
						<td align='center'><b>Memenuhi Target &nbsp; (P  90% < x <u><</u> 100%)</b></td>
						<td align='center'><b>Melebihi Target &nbsp; (P  100% < x <u><</u> 120%)</b></td>
					</tr>
					<tbody>
						<tr>
							<td align='center'>= (P / 70) x 4,5</td>
							<td align='center'>= 4,5 + (((P - 70)/20) x 2)</td>
							<td align='center'>= 6,5 + (((P - 90)/10) x 2)</td>
							<td align='center'>= 8,5 + (((P - 100)/20) x 1,5)</td>
						</tr>
						
					</tbody>
				</table>
				<small> Keterangan : <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<b>P = Pencapaian / Hasil Kerja (%)</b> </small>
		
		</div>
	</div>
	
	
