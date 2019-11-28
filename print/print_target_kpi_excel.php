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
	$getBulan	= mysql_real_escape_string(dc($ex[0]));
	$getTahun	= mysql_real_escape_string(dc($ex[1]));
	
	timeline($_SESSION['nik'],"download","Telah melakukan download Target KPI Bulan $getBulan Tahun $getTahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Target_KPI_".bulan($getBulan).".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>
			<h4><b>KEY PERFORMANCE INDICATORS & TARGET-TARGETNYA</b></h4>
			<h4><b>BULAN <?=strtoupper(bulan($getBulan))?> TAHUN <?=$getTahun?></b></h4>
			<table border="1" cellpadding='3'>
				<thead>
					<tr>
						<th width="5%" rowspan="2">No</th>
						<th rowspan="2">PERSPEKTIF & KPI KPKU</th>
						<th rowspan="2">BOBOT</th>
						<th rowspan="2">SATUAN</th>
						<th rowspan="2">TARGET TAHUNAN</th>
						<th colspan="2">REALISASI</th>
						<th colspan="2">PENCAPAIAN</th>
					</tr>
					<tr>
						<th>BULAN INI</th>
						<th>S.D BULAN INI</th>
						<th>BULAN INI</th>
						<th>S.D BULAN INI</th>
					</tr>
				</thead>
				<tbody>
				<?php
				// if(isset($_POST['opt'])){
					$query = mysql_query("SELECT * FROM kpku_perspektif WHERE tahun='$getTahun' ");
					while($r=mysql_fetch_array($query)){
					echo"<tr>
							<td colspan='7'><b>$r[id_perspektif] $r[perspektif]</b></td>
							<td  colspan='2'>";
								// if($getInsert==1){
									// echo"<a href='?page=form_kpku_kpi&opt=kpi_kpku&act=tambah&idp=".ec($r['id_perspektif'])."' class='btn btn-xs btn-primary' title='Tambah KPI KPKU' ><i class='fa fa-plus'></i> Tambah KPI KPKU</a>";
								// }
						echo"</td>
						</tr>";
						$query2 = mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='$r[id_perspektif]' AND tahun='$getTahun' ");
						while($r2=mysql_fetch_array($query2)){
							$target = mysql_fetch_array(mysql_query("SELECT * FROM kpku_kpi_target WHERE id_kpi='$r2[id_kpi]' 
																		AND id_perspektif='$r[id_perspektif]' 
																		AND bulan='$getBulan' 
																		AND tahun='$getTahun' "));
																		
							if($r2['perhitungan']==1){
								$jr1 = mysql_fetch_array(mysql_query("SELECT realisasi_bulan FROM kpku_kpi_target WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_kpi='$r2[id_kpi]'"));
								$total = desimal3($jr1['realisasi_bulan']);
							}elseif($r2['perhitungan']==2){
								$jr2 = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_bulan) as sum FROM kpku_kpi_target WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_kpi='$r2[id_kpi]'"));
								$total = desimal3($jr2['sum']);
							}elseif($r2['perhitungan']==3){								
								$jr3 = mysql_fetch_array(mysql_query("SELECT AVG(realisasi_bulan) as avg FROM kpku_kpi_target WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_kpi='$r2[id_kpi]'"));
								$total = desimal3($jr3['avg']);
							}else{
								$total="";
							}
							
							if($r2['rumus']==1){
								if($r2['target_tahun']==0 AND $total>0){
									$hasil = 100;
								}elseif($r2['target_tahun']>0 AND $total<=0){
									$hasil = 0;
								}elseif($r2['target_tahun']==0 AND $total<=0){
									$hasil = 0;
								}else{
									$hasil = ($total/$r2['target_tahun'])*100;
								}										
							}elseif($r2['rumus']==2){
								if($r2['target_tahun']==0 AND $total>0){
									$hasil = 100;
								}elseif($r2['target_tahun']>0 AND $total<=0){
									$hasil = 0;
								}elseif($r2['target_tahun']==0 AND $total<=0){
									$hasil = 0;
								}else{
									$hasil = (($r2['target_tahun'] - ($total-$r2['target_tahun'])) / $r2['target_tahun']) * 100;
								}
							}else{
								$hasil = 0;
							}
							if($hasil <= 0){
								$nilai=0;
							}elseif($hasil > 0){
								if($hasil>120){
									$nilai=120;
								}else{
									$nilai=$hasil;
								}										
							}else{
								$nilai="";
							}
							
						echo"<tr>
								<td>$r2[id_kpi]</td>
								<td>$r2[kpi]</td>
								<td align='center'>$r2[bobot]</td>
								<td align='center'>$r2[satuan]</td>
								<td align='center'>$r2[target_tahun]</td>
								<td align='center'>$target[realisasi_bulan]</td>
								<td align='center'>$total</td>
								<td align='center'>".desimal3($target['pencapaian'])." %</td>
								<td align='center'>".desimal3($nilai)." %</td>
							</tr>";
						}
					}
				// }
				?>
				</tbody>
			</table>
			<br>
			<br>
			<h4><b>SASARAN KINERJA LAINNYA</b></h4>
			<table border="1" cellpadding='3'>
				<thead>
					<tr>
						<th width="5%" rowspan="2">No</th>
						<th rowspan="2">PERSPEKTIF & KPI KPKU</th>
						<th rowspan="2">SATUAN</th>
						<th rowspan="2">TARGET TAHUNAN</th>
						<th colspan="2">REALISASI</th>
						<th colspan="2">PENCAPAIAN</th>
					</tr>
					<tr>
						<th>BULAN INI</th>
						<th>S.D BULAN INI</th>
						<th>BULAN INI</th>
						<th>S.D BULAN INI</th>
					</tr>
				</thead>
				<tbody>
				<?php
				// if(isset($_POST['opt'])){
					$query = mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='' AND tahun='$getTahun'");
					while($r=mysql_fetch_array($query)){
						$target = mysql_fetch_array(mysql_query("SELECT * FROM kpku_kpi_target WHERE id_kpi='$r[id_kpi]'
																		AND bulan='$getBulan' 
																		AND tahun='$getTahun' "));
						
						if($r['perhitungan']==1){
							$jr1 = mysql_fetch_array(mysql_query("SELECT realisasi_bulan FROM kpku_kpi_target WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_kpi='$r[id_kpi]'"));
							$total = desimal3($jr1['realisasi_bulan']);
						}elseif($r['perhitungan']==2){
							$jr2 = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_bulan) as sum FROM kpku_kpi_target WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_kpi='$r[id_kpi]'"));
							$total = desimal3($jr2['sum']);
						}elseif($r['perhitungan']==3){
							$jr3 = mysql_fetch_array(mysql_query("SELECT AVG(realisasi_bulan) as avg FROM kpku_kpi_target WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_kpi='$r[id_kpi]'"));
							$total = desimal3($jr3['avg']);
						}else{
							$total="";
						}
							if($r['rumus']==1){
								if($r['target_tahun']==0 AND $total>0){
									$hasil = 100;
								}elseif($r['target_tahun']>0 AND $total<=0){
									$hasil = 0;
								}elseif($r['target_tahun']==0 AND $total<=0){
									$hasil = 0;
								}else{
									$hasil = ($total/$r['target_tahun'])*100;
								}										
							}elseif($r['rumus']==2){
								if($r['target_tahun']==0 AND $total>0){
									$hasil = 100;
								}elseif($r['target_tahun']>0 AND $total<=0){
									$hasil = 0;
								}elseif($r['target_tahun']==0 AND $total<=0){
									$hasil = 0;
								}else{
									$hasil = (($r['target_tahun'] - ($total-$r['target_tahun'])) / $r['target_tahun']) * 100;
								}
							}else{
								$hasil = 0;
							}
							if($hasil <= 0){
								$nilai=0;
							}elseif($hasil > 0){
								if($hasil>120){
									$nilai=120;
								}else{
									$nilai=$hasil;
								}										
							}else{
								$nilai="";
							}
						echo"<tr>
								<td>$r[id_kpi]</td>
								<td>$r[kpi]</td>
								<td align='center'>$r[satuan]</td>
								<td align='center'>$r[target_tahun]</td>
								<td align='center'>$target[realisasi_bulan]</td>
								<td align='center'>$total</td>
								<td align='center'>".desimal3($target['pencapaian'])." %</td>
								<td align='center'>".desimal3($nilai)." %</td>
							</tr>";
					}
				// }
				?>
				</tbody>
			</table>
		