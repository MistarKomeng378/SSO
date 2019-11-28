<?php
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_rupiah.php";
include"../../config/encript.php";

// $getBulan	= mysql_real_escape_string($_POST['bulan']);
// $getTahun	= mysql_real_escape_string($_POST['tahun']) ;

$ex				= explode("-",$_POST['id']);
$getNik			= dc($ex[0]);
$getName		= dc($ex[1]);
$getCc			= dc($ex[2]);
$getThnNow		= dc($ex[3]);
$sql			= mysql_fetch_array(mysql_query("SELECT * FROM penilaian_kerja WHERE nik='$getNik' group by nik")); 
$jabatan		= $sql['jabatan'];
$div= mysql_fetch_array(mysql_query("select * from mskko where CostCenter='".$getCc."'"));

?>	
		
			<div class="panel panel-inverse">
			    <div class="panel-body">
	
					<?php
						$query = mysql_query("SELECT * FROM penilaian_kerja where nik='$getNik' AND tahun='$getThnNow'");						
						$i=1;
						while($r1=mysql_fetch_array($query)){
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
							
							$sum_bobot_kar_1		= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot FROM penilaian_kerja where nik='$getNik' AND tahun='$getThnNow'"));	
							$bot_kar_1			= @(($r1['bobot'] / $sum_bobot_kar_1['sum_bobot'])*75);							
							$jum_bot1[] 		= $bot_kar_1;	
							
							$nilai1				= $bot_kar_1 * $skor1;
							$jumlah_nilai1[]	= $nilai1;							
							$i++;
						}
						$jumlah_total_nilai1 = array_sum($jumlah_nilai1);
					?>	
	
		
		<table border="0" width="100%">
			<tr> 
				<td width="10%">NIK/Nama</td>
				<td>:</td>
				<td><b><?=$getNik?>/<?=name($getNik) ?></b></td>
				<td rowspan="3" align="right">
					<?php
						// echo" <a href='print/print_penilaian_kerja.php?nik=".ec($getNik)."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Cetak</a>";
						
						echo" <a href='print/print_penilaian_kerja.php?nik=".ec($getNik)."&CostCenter=".ec($getCc)."&tahun=".ec($getThnNow)."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Cetak</a>";
						
						
					?> &nbsp;&nbsp;
				</td>
			</tr>
			<tr> 
				<td>Jabatan</td>
				<td>:</td>
				<td><b><?=$jabatan?></b></td>
			</tr>
			<tr> 
				<td>Divisi</td>
				<td>:</td>
				<td><b><?=$div['uraian']?></b></td>
			</tr>
			<tr> 
				<td>Nilai</td>
				<td>:</td>
				<td><b><font size="3"><?=desimal_float($jumlah_total_nilai1)?></font></b></td>
			</tr>
		</table>
		<br>
		
		<table class="table table-bordered table-striped table-hover">
				<thead>
					<th width="10">No.</th>
					<th>Rencana Kerja</th>
					<th width="20">Target</th>
					<th width="20">Bobot</th>
					<th width="20">Hasil</th>
					<th width="20">Pencapaian</th>
					<th width="20">Skor</th>
					<th width="20">Nilai</th>
				</thead>
				<tbody>
					<?php
						$query = mysql_query("SELECT * FROM penilaian_kerja where nik='$getNik' AND tahun='$getThnNow'");						
						$i=1;
						while($r=mysql_fetch_array($query)){
							
							$pencapaian_1 	= ($r['hasil'] / $r['target'])*100;
							if($pencapaian_1 > 120){
								$pencapaian = 120;
							}else{
								$pencapaian = $pencapaian_1;
							}
							
							if($r['satuan']=="Hr"){
								if($r['hasil'] < $r['target']){
									$pencapaian = 120;
								}else{
									$pencapaian = ($r['target'] / $r['hasil'])*100;
								}
							}
														
							if($r['hasil']<=70){
								$skor = ($pencapaian/70)*4.5;								
							}elseif($r['hasil']<=90){
								$skor = 4.5+(($pencapaian-70)/20)*2;
							}elseif($r['hasil']<=100){
								$skor = 6.5+(($pencapaian-90)/10)*2;
							}elseif($r['hasil']>100){
								$skor = 8.5+(($pencapaian-100)/20)*1.5;
							}
							
							$sum_bobot_kar		= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot FROM penilaian_kerja where nik='$getNik' AND tahun='$getThnNow'"));	
							$bot_kar			= ($r['bobot'] / $sum_bobot_kar['sum_bobot'])*75;							
							$jum_bot2[] 		= $bot_kar;	
							$nilai				= $bot_kar * $skor;
							$jumlah_nilai[]		= $nilai;
							
							echo"
								<tr>
									<td align='center'>$i</td>
									<td>$r[rencana_kerja]</td>
									<td align='center'>$r[target]</td>
									<td align='center'>".desimal_float($bot_kar)."</td>
									<td align='center'>".desimal_float($r['hasil'])."</td>
									<td align='center'>".desimal_float($pencapaian)."</td>
									<td align='center'>".desimal_float($skor)."</td>
									<td align='center'>".desimal_float($nilai)."</td>
									
								</tr>
							";
							$i++;
						}
						// $jmlh_bobot = mysql_fetch_array(mysql_query("SELECT SUM(bobot) as jmlh_bobot FROM penilaian_kerja where nik='$getNik'"));
						$jumlah_bobot	 	= array_sum($jum_bot2);	
						$jumlah_total_nilai = array_sum($jumlah_nilai);
					?>	
								<tr>
									<td colspan="2" align="right"><b>TOTAL</b></td>
									<td align="center">&nbsp;</td>
									<td align="center"><b><?=desimal_float($jumlah_bobot) ?></b></td>
									<td align="center" colspan="3">&nbsp;</td>
									<td align="center"><b><?=desimal_float($jumlah_total_nilai); ?></b></td>
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
	
	
