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
		<h4 class="panel-title">Jumlah Hari Kerja</h4>
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
			<h4 align="center"> Data Jumlah Hari Kerja Karyawan </h4> 
			<h4 align="center">	Bulan <?=bulan($getBulan)?> Tahun <?=$getTahun?> </h4>
			
			
			<table>
				<tr>
					<td>
					<?
						// echo"
							// <a href='print/print_top_global.php?tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> PDF</a> ";
					?>
					</td>
				</tr>
			</table>
			<br>
			
			
				<table id="example1" class="table table-bordered table-striped table-hover" >
					<thead>
						<th>No.</th>
						<th>NIK</th>
						<th>Nama Anggota</th>
						<th>Jumlah Hari Kerja</th>
						<th>Ket</th>
						
					</thead>
					<tbody>
						<?php
							$no=1;
							
							$query = mysql_query("SELECT DISTINCT(nik) FROM anggota WHERE tahun='$getTahun' AND bulan='$getBulan' order by hk DESC");					
							while($pro=mysql_fetch_array($query)){
								$us 	= mysql_fetch_array(mysql_query("SELECT name FROM user where nik='$pro[nik]'"));
								$hk 	= mysql_fetch_array(mysql_query("SELECT SUM(hk) as h_kerja FROM anggota where nik='$pro[nik]' AND tahun='$getTahun' AND bulan='$getBulan'"));
								$hari_kerja	= mysql_fetch_array(mysql_query("SELECT * FROM jam_bulanan where tahun='$getTahun' AND bulan='$getBulan'"));
								
								if($hk['h_kerja'] > $hari_kerja['hari_kerja']){
									$ket = "Melebihi Max Hari Kerja";
									
								}
								echo"
									<tr> 
										<td align='center'>$no</td>
										<td>$pro[nik]</td>
										<td>$us[name]</td>
										<td>$hk[h_kerja]</td>
										<td>$ket</td>
									</tr>
								
								";	
							$no++;
							}
							
						?>
					</tbody>
				</table>
				<? 
					$harikerja = mysql_fetch_array(mysql_query("SELECT * FROM jam_bulanan where tahun='$getTahun' AND bulan='$getBulan'"));
				?>
				<hr>
				<p> Jumlah Hari Kerja pada bulan <b><?=bulan($getBulan) ?></b> Tahun <b><?=$getTahun?></b> adalah <b><?=$harikerja['hari_kerja']?></b> Hari</p>
		</div>
	</div>
</div>