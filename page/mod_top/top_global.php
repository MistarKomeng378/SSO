<?
	
	$IdProyek	= mysql_real_escape_string(dc($_GET['idp']));
	$getTahun	= mysql_real_escape_string(dc($_GET['tahun']));
	$getBulan	= mysql_real_escape_string(dc($_GET['bulan']));
	$cc			= mysql_real_escape_string(dc($_GET['cc']));
	
	$DetProyek	= mysql_fetch_array(mysql_query("SELECT * FROM proyek where id_proyek='$IdProyek'"));
	$CostCenter = mysql_fetch_array(mysql_query("SELECT CostCenter, uraian FROM mskko where CostCenter = '$cc' "));


?>


<h1 class="page-header">Perhitungan TOP Gabungan 
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Perhitungan TOP Gabungan</h4>
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
			<h4 align="center"> Perhitungan Tunjangan Operasional Proyek </h4> 
			<h4 align="center">	Bulan <?=bulan($getBulan)?> Tahun <?=$getTahun?> </h4>
			
			
			<table>
				<tr>
					<td>
					<?
						echo"
							<a href='print/print_top_global.php?tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> PDF</a> ";
					?>
					</td>
				</tr>
			</table>
			<br>
			
			
				<table id="example1" class="table table-bordered table-striped table-hover" >
					<thead>
						<th>No.</th>
						<th>Kode Proyek</th>
						<th>Nama Proyek - Anggota</th>
						<th>Total TOP</th>
					</thead>
					<tbody>
						<?php
							$no=1;
							
							$query = mysql_query("SELECT * FROM proyek where tahun='$getTahun' AND bulan='$getBulan' order by nama_proyek ASC");					
							while($pro=mysql_fetch_array($query)){													
								echo"
									<tr> 
										<td align='center'>$no</td>
										<td>$pro[kode_proyek]</td>
										<td><b><u>$pro[nama_proyek]</u></b>";
											$all_top = 0;
											$h = mysql_query("SELECT * FROM anggota  INNER JOIN user ON anggota.nik = user.nik  
											WHERE id_proyek='$pro[id_proyek]' order by jabatan DESC");
											$xz = 1;
											while($P=mysql_fetch_array($h)){
												
												//Kompensasi Kebutuhan Komunikasi Yang Lebih Intensif
												if($P['jabatan']=="Project Manager"){
													$Ls = 150000;
													
												}elseif($P['jabatan']=="PMO"){
													$Ls = 100000;
													
												}elseif($P['jabatan']=="Lead/Site Manager/CO PM"){
													$Ls = 100000;
													
												}else{
													$Ls = 50000;
												}
												
												//Komunikasi Jika Lebih dari satu proyek
												if($P['aktif']==0){
													$Ls=0;
												}
												
												//Resiko Kerja
												$res = mysql_fetch_array(mysql_query("SELECT * FROM tbl_resiko where id='$pro[resiko_kerja]'"));
												if($pro['resiko_kerja']==$res['id']){
													$Resiko = $res['harga'];								
												}	
																								
												//Jarak Extra (liter)
												$jarak = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jarak where id='$pro[jarak_proyek]'"));
												
												//Harga Premium/liter/hari
												//$prem = 7000;
												if($pro['jarak_proyek']==$jarak['id']){
													$jarlok = $jarak['harga'];
												}
												
												// Jika Kerja Kurang dari 10 HK								
												if($P['hk'] < 10){
													$Resiko 	= 0;
													$Ls			= 0;
													$jarlok		= 0;
													$angka_sla	= 0;
													
												}else{
													
													$angka_sla	= 200000;
												}
												
												// Ketidak-nyamanan
												$Tn = $P['hk'] * $Resiko;
												
												//Total Harga Jarak
												$total_jarak = $P['hk'] * $jarlok;
																				
												// Penilaian TIM Proyek							
												$sla = $Ls + $Tn + $total_jarak;
																				
												//Jumlah Total Keseluruhan SLA
												$all_sla = mysql_fetch_array(mysql_query("SELECT SUM(sla) as jum_sla from anggota where id_proyek='$pro[id_proyek]' AND tahun='$getTahun' AND bulan ='$getBulan'"));
												
												//Total Nilai (Rp.) Keseluruhan Rp. 200.000/orang
												$all_nominal = mysql_fetch_array(mysql_query("SELECT COUNT(nik) as jum_nik from anggota where id_proyek='$pro[id_proyek]' AND tahun='$getTahun' AND bulan ='$getBulan'"));
												
												$nilai_rupiah = $all_nominal['jum_nik'] * 200000;
												
												//Total Nilai SLA 
												$nilai_sla = $P['sla'] / $all_sla['jum_sla'] * $nilai_rupiah ;
												
												//Total TOP /orang								
												$total_top = $sla + $nilai_sla ;
												
												// $all_top[]	= $total_top;
												$all_top		+= $total_top;
												
												echo"
													<br>&nbsp;
														$xz. $P[nik] - $P[name]
												";
												$xz++;
												
											}
											$sum_top = $all_top;
										echo"
										</td>
										<td><b><u>".rupiah($sum_top)."</u></b>";

											$d = mysql_query("SELECT * FROM anggota  WHERE id_proyek='$pro[id_proyek]' order by jabatan DESC");
											$xy = 1;
											while($rin=mysql_fetch_array($d)){
												//Kompensasi Kebutuhan Komunikasi Yang Lebih Intensif
												if($rin['jabatan']=="Project Manager"){
													$Ls = 150000;
													
												}elseif($rin['jabatan']=="PMO"){
													$Ls = 100000;
													
												}else{
													$Ls = 50000;
												}
												//Komunikasi Jika Lebih dari satu proyek
												if($rin['aktif']==0){
													$Ls=0;
												}
												
												//Resiko Kerja
												$res = mysql_fetch_array(mysql_query("SELECT * FROM tbl_resiko where id='$pro[resiko_kerja]'"));
												if($pro['resiko_kerja']==$res['id']){
													$Resiko = $res['harga'];								
												}	
																								
												//Jarak Extra (liter)
												$jarak = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jarak where id='$pro[jarak_proyek]'"));
												
												//Harga Premium/liter/hari
												//$prem = 7000;
												if($pro['jarak_proyek']==$jarak['id']){
													$jarlok = $jarak['harga'];
												}
												
												// Jika Kerja Kurang dari 10 HK								
												if($rin['hk'] < 10){
													$Resiko 	= 0;
													$Ls			= 0;
													$jarlok		= 0;
													$angka_sla	= 0;
													
												}else{
													
													$angka_sla	= 200000;
												}
												
												// Ketidak-nyamanan
												$Tn = $rin['hk'] * $Resiko;
												
												//Total Harga Jarak
												$total_jarak = $rin['hk'] * $jarlok;
																				
												// Penilaian TIM Proyek							
												$sla = $Ls + $Tn + $total_jarak;
																				
												//Jumlah Total Keseluruhan SLA
												$all_sla = mysql_fetch_array(mysql_query("SELECT SUM(sla) as jum_sla from anggota where id_proyek='$pro[id_proyek]' AND tahun='$getTahun' AND bulan ='$getBulan'"));
												
												//Total Nilai (Rp.) Keseluruhan Rp. 200.000/orang
												$all_nominal = mysql_fetch_array(mysql_query("SELECT COUNT(nik) as jum_nik from anggota where id_proyek='$pro[id_proyek]' AND tahun='$getTahun' AND bulan ='$getBulan'"));
												
												$nilai_rupiah = $all_nominal['jum_nik'] * $angka_sla;
												
												//Total Nilai SLA 
												$nilai_sla = @($rin['sla'] / $all_sla['jum_sla'] * $nilai_rupiah) ;
												
												//Total TOP /orang								
												$total_top = $sla + $nilai_sla ;
												
												
												echo"
													<br>&nbsp;
														$xy. ".rupiah($total_top)."
												";
												$xy++;
											}
										echo"
										</td>
							
									</tr>
								
								";	
							$no++;
							}
							
						?>
					</tbody>
				</table>
		</div>
	</div>
</div>