<h1 class="page-header">Data Anggota TOP
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Tunjangan Operasional Proyek</h4>
	</div>
	<div class="panel-body">
		<div class='col-lg-12'>
			<?php
				$IdProyek	= mysql_real_escape_string(dc($_GET['idp']));
				$getTahun	= mysql_real_escape_string(dc($_GET['tahun']));
				$getBulan	= mysql_real_escape_string(dc($_GET['bulan']));
				$cc			= mysql_real_escape_string(dc($_GET['cc']));
				
				$DetProyek	= mysql_fetch_array(mysql_query("SELECT * FROM proyek where id_proyek='$IdProyek'"));
				$CostCenter = mysql_fetch_array(mysql_query("SELECT CostCenter, uraian FROM mskko where CostCenter = '$cc' "));
					
				
				
			//====================== NOTIFKASI ==========================//	
				
				if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM anggota WHERE id_anggota='".dc($_GET['delete'])."'");
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
			<?
				if($getInsert==1){
				echo"
					<a href='?page=anggota&opt=tambah&idp=".ec($IdProyek)."&cc=".ec($cc)."&tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' class='btn btn-primary'><i class='fa fa-plus'> Anggota</i></a> 
					
					";
				}
			?>
			<br>
			<br>
			<table id="example1" class="table table-bordered table-striped table-hover"  >
				<thead>
					<th>No.</th>
					<th>NIK</th>
					<th>Nama Anggota</th>
					<th>Jabatan Proyek</th>
					<th>Hari Kerja</th>
					<th>SLA</th>
					<th>Aksi</th>
				</thead>
				<tbody>
					<?php
						$no=1;
						// $query = mysql_query("SELECT * FROM anggota where id_proyek='$IdProyek' AND tahun='$getTahun' AND bulan='$getBulan' AND cc='$cc' order by nik ASC ");
						
						$query = mysql_query("SELECT * FROM anggota INNER JOIN  user ON anggota.nik = user.nik 
											WHERE anggota.id_proyek='$IdProyek' 
											AND anggota.tahun='$getTahun' 
											AND anggota.bulan='$getBulan' 
											AND anggota.cc='$cc' 
											ORDER BY anggota.jabatan DESC");
						
						while($r=mysql_fetch_array($query)){							
							
							echo"
								<tr> 
									<td align='center'>$no</td>
									<td align='center'>$r[nik]</td>
									<td>$r[name]</td>
									<td>$r[jabatan] ($r[ket_jabatan])</td>
									<td>$r[hk]</td>
									<td>$r[sla]</td>
									<td align='center'>";
										
										if($getDelete==1){
											echo"<a href='?page=anggota_proyek&delete=".ec($r['id_anggota'])."&idp=".ec($r['id_proyek'])."&tahun=".ec($getTahun)."&cc=".ec($r['cc'])."&bulan=".ec($r['bulan'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
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