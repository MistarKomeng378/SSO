<?
	
	$IdProyek	= mysql_real_escape_string(dc($_GET['idp']));
	$getTahun	= mysql_real_escape_string(dc($_GET['tahun']));
	$getBulan	= mysql_real_escape_string(dc($_GET['bulan']));
	$cc			= mysql_real_escape_string(dc($_GET['cc']));
	
	$DetProyek	= mysql_fetch_array(mysql_query("SELECT * FROM proyek where id_proyek='$IdProyek'"));
	$CostCenter = mysql_fetch_array(mysql_query("SELECT CostCenter, uraian FROM mskko where CostCenter = '$cc' "));


?>


<h1 class="page-header">Perhitungan TOP
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Perhitungan TOP <?=$DetProyek['nama_proyek']?></h4>
	</div>
	<div class="panel-body">
		<div class='col-lg-12'>
			<?php
				
					
				
				
			//====================== NOTIFKASI ==========================//	
				
				if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM anggota WHERE id='".dc($_GET['delete'])."'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Dihapus.
                    </div>";
				}
				if(isset($_REQUEST['succes'])){
					echo"<div class='alert alert-success alert-dismissable'>
							<i class='fa fa-check'></i>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<b>Succes!</b> Data Berhasil Disimpan.
						</div>";
				}
				if(isset($_REQUEST['failed'])){
					echo"<div class='alert alert-danger alert-dismissable'>
							<i class='fa fa-check'></i>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<b>Succes!</b> Gagal, Terjadi Kesalahan.
						</div>";
				}
				if(isset($_REQUEST['succes2'])){
					echo"<div class='alert alert-success alert-dismissable'>
							<i class='fa fa-check'></i>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<b>Succes!</b> Status telah berubah.
						</div>";
				}
				
				
			?>
			
		</div>
		
		<div class='col-lg-12'>
		
			<table border="0"> 
				<tr> 
					<td width="5%">Kode Proyek</td>
					<td width="1%" align="center">:</td>
					<td width="30%"><?=$DetProyek['kode_proyek']?></td>
				</tr>
				<tr> 
					<td width="5%">Nama Proyek</td>
					<td width="1%" align="center">:</td>
					<td width="30%"><?=$DetProyek['nama_proyek']?></td>
				</tr>
				<tr> 
					<td>Lokasi Proyek</td>
					<td align="center">:</td>
					<td><?=$DetProyek['lokasi_proyek']?></td>
				</tr>
				<tr> 
					<td>Cost Center</td>
					<td align="center">:</td>
					<td><?=$CostCenter['uraian']?></td>
				</tr>
				<tr> 
					<td>Tahun</td>
					<td align="center">:</td>
					<td><?=$DetProyek['tahun']?></td>
				</tr>
				<tr> 
					<td>Bulan</td>
					<td align="center">:</td>
					<td><?=bulan($DetProyek['bulan'])?></td>
				</tr>
			</table>
			<br>
			<table>
				<tr>
					<td>
					<?
						echo"
							<a href='print/print_top.php?idp=".ec($IdProyek)."&CostCenter=".ec($cc)."&tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> PDF</a> ";
					?>
					</td>
				</tr>
			</table>
			<br>
			
			<div class="table-responsive">
				<table id="example1" class="table table-bordered table-striped table-hover" >
					<thead>
						<th>No.</th>
						<th>NIK</th>
						<th>Nama Anggota</th>
						<th>Jabatan Proyek</th>
						<th>Jumlah hari Kerja</th>
						<th>Rp. Extra Transport (ltr)</th>
						<th>Harga Premium/Hari</th>
						<th>Lumpsum RP/Bulan</th>
						<th>Rp. tidak nyaman</th>
						<th>Kompensasi Tranportasi Ekstra ke Lokasi Proyek</th>
						<th>Kompensasi Kebutuhan Komunikasi yang lebih Intensif</th>
						<th>Kompensasi Akibat Ketidak-nyamanan diarea kerja</th>
						<th>Penilaian Tim Proyek</th>
						<th>Total Tunjangan Operasional Proyek (Rp.)</th>
						<th>SLA</th>
						<th>Total Nilai SLA (Rp.)</th>
						<th>Total Tunjangan Operasional Proyek (Rp.) dan SLA</th>
					</thead>
					<tbody>
						<?php
							$no=1;
							$all_top = 0;
							$query = mysql_query("SELECT * FROM anggota INNER JOIN  user ON anggota.nik = user.nik 
												WHERE anggota.id_proyek='$IdProyek' 
												AND anggota.tahun='$getTahun' 
												AND anggota.bulan='$getBulan' 
												AND anggota.cc='$cc' 
												ORDER BY anggota.jabatan DESC");
							
							while($r=mysql_fetch_array($query)){
								//Kompensasi Kebutuhan Komunikasi Yang Lebih Intensif
								if($r['jabatan']=="Project Manager"){
									$Ls = 150000;
									
								}elseif($r['jabatan']=="PMO"){
									$Ls = 100000;
									
								}elseif($r['jabatan']=="Lead/Site Manager/CO PM"){
									$Ls = 100000;
									
								}else{
									$Ls = 50000;
								}
								
								//Komunikasi Jika Lebih dari satu proyek
								if($r['aktif']==0){
									$Ls=0;
								}
																								
								//Kompensasi Akibat Ketidak-nyamanan di Area Kerja
								$proyek = mysql_fetch_array(mysql_query("SELECT * FROM proyek where id_proyek='$IdProyek'"));
								
								$res = mysql_fetch_array(mysql_query("SELECT * FROM tbl_resiko where id='$proyek[resiko_kerja]'"));
								if($proyek['resiko_kerja']==$res['id']){
									$Resiko = $res['harga'];								
								}						
									
								//Jarak Extra (liter)
								$jarak = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jarak where id='$proyek[jarak_proyek]'"));
								
								//Harga Premium/liter/hari
								//$prem = 7000;
								if($proyek['jarak_proyek']==$jarak['id']){
									$jarlok = $jarak['harga'];
								}
								// Jika Kerja Kurang dari 10 HK								
								if($r['hk'] < 10){
									$Resiko 	= 0;
									$Ls			= 0;
									$jarlok		= 0;
									$angka_sla	= 0;
									
								}else{
									$angka_sla	= 200000;
								}
								
								// Ketidak-nyamanan
								$Tn = $r['hk'] * $Resiko;
								
								//Total Harga Jarak
								$total_jarak = $r['hk'] * $jarlok;
								
																
								// Penilaian TIM Proyek							
								$sla = $Ls + $Tn + $total_jarak;
								
																
								//Jumlah Total Keseluruhan SLA
								$all_sla = mysql_fetch_array(mysql_query("SELECT SUM(sla) as jum_sla from anggota where id_proyek='$IdProyek' AND tahun='$getTahun' AND bulan ='$getBulan'"));
								
								
								//Total Nilai (Rp.) Keseluruhan Rp. 200.000/orang
								$all_nominal = mysql_fetch_array(mysql_query("SELECT COUNT(nik) as jum_nik from anggota where id_proyek='$IdProyek' AND tahun='$getTahun' AND bulan ='$getBulan'"));
								
								$nilai_rupiah = $all_nominal['jum_nik'] * $angka_sla;
								
								
								//Total Nilai SLA 
								$nilai_sla = @(($r['sla'] / $all_sla['jum_sla']) * $nilai_rupiah) ;
								
								
								//Total TOP /orang								
								$total_top = $sla + $nilai_sla ;
								
								$all_top	+= $total_top;
								// $all_top[]	= $total_top;
								
								
																
								echo"
									<tr> 
										<td align='center'>$no</td>
										<td align='center'>$r[nik]</td>
										<td>$r[name]</td>
										<td>$r[jabatan] ($r[ket_jabatan])</td>
										<td>$r[hk]</td>
										<td>".desimal($jarak['liter'])."</td>
										<td>".desimal($jarlok)."</td>
										<td>".desimal($Ls)."</td>
										<td>".desimal($Resiko)."</td>
										<td>".desimal($total_jarak)."</td>
										<td>".desimal($Ls)."</td>
										<td>".desimal($Tn)."</td>
										<td>$r[sla]</td>
										<td>".desimal($sla)."</td>
										<td>$r[sla]</td>
										<td>".desimal($nilai_sla)."</td>
										<td>".desimal($total_top)."</td>
									</tr>
								
								";	
							$no++;
							}							
							// $sum_top = array_sum($all_top);
							$sum_top = $all_top;
						?>
					</tbody>
				</table>
			</div>
			<br>
			<table width="100%" border="0">
				<tr> 
					<td align="right"><h5>Jumlah Tunjangan Operasional Proyek</h5></td>
					<td width="5%">&nbsp;</td>
					<td width="12%" align="right"><h5><?=rupiah($sum_top)?></h5></td>
				</tr> 
			</table>
			<br>
			
		</div>
	</div>
</div>