<h1 class="page-header">Tunjangan Operasional Proyek (TOP)
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
				
				$getBulan	= mysql_real_escape_string($_POST['bulan']);
				$getTahun	= mysql_real_escape_string($_POST['tahun']) ;
				if(isset($_POST['tahun'])){
					$ThnTop = $getTahun;
				}else{
					$ThnTop = date("Y");
				}
				
			//====================== NOTIFKASI ==========================//	
				
				if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM proyek WHERE id_proyek='".dc($_GET['delete'])."'");
				mysql_query("DELETE FROM anggota WHERE id_proyek='".dc($_GET['delete'])."'");
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
				
			//============================================ START FORM =================================================//	
				
				echo"
				
					<form method='POST' action='page.php?page=data_top' id='formku'>
						<div class='form-group  col-lg-10 row'>
							<div class='form-group  col-lg-2'>
								<input type='hidden' name='page' value='data_top'>
								<input type='hidden' name='opt' value='cari'>
								<select name='bulan' class='form-control required'>
									<option value=''>Pilih Bulan</option>";
											for($i=1;$i<=12;$i++){
												echo"<option value='$i'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
											}
							echo"</select>
							</div>
							<div class='form-group  col-lg-2'>
								<select name='tahun' class='form-control '>
										<option value=''>Pilih Tahun</option>";
											$qsbdth = mysql_query("SELECT * FROM tahun");
											while($r=mysql_fetch_array($qsbdth)){
												echo"<option value='$r[tahun]'"; if($ThnTop==$r['tahun']){echo"selected";} echo">$r[tahun]</option>";
											}
							echo"</select>
							</div>
							<div class='form-group  col-lg-1'>
								<input type='submit' value='Pilih' class='btn btn-primary'>
							</div>
						</div>
					</form>
				
				";
				
				if($getInsert==1){
					echo"
					<table border='0' align='right'>
						<tr>
							<td>
								<a href='?page=form_top&opt=tambah&bulan=".ec($getBulan)."' class='btn btn-success'><i class='fa fa-plus'></i> Proyek</a>
							</td>
							<td>&nbsp;
								<a href='?page=topglobal&tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' target='_blank' class='btn btn-danger'><i class='fa fa-print'></i> PDF</a>
							</td>
							<td>&nbsp;
								<a href='?page=hari_kerja&tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' target='_blank' class='btn btn-primary'><i class='fa fa-file-text-o'></i> Hari Kerja</a>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
					
					";
				}
			?>
			
		</div>
		<br>
		<br>
		<br>
		<div class='col-lg-12'>
			<table id="example1" class="table table-bordered table-striped table-hover"  >
				<thead>
					<th>No.</th>
					<th>Kode Proyek</th>
					<th>Nama Proyek</th>
					<th>Lokasi Proyek</th>
					<th>Cost Center</th>
					<th>Tahun</th>
					<th width="8%">Anggota</th>
					<th width="8%">TOP</th>
					<th width="8%">Aksi</th>
					
				</thead>
				<tbody>
					<?php
						$no=1;
						$query = mysql_query("SELECT * FROM proyek where tahun='$getTahun' AND bulan='$getBulan'");
						while($r=mysql_fetch_array($query)){
							$unit = mysql_fetch_array(mysql_query("SELECT CostCenter, uraian FROM mskko where CostCenter = '$r[cc]' "));
							echo"
								<tr> 
									<td>$no</td>
									<td>$r[kode_proyek]</td>
									<td>$r[nama_proyek]</td>
									<td>$r[lokasi_proyek]</td>
									<td>$unit[uraian]</td>
									<td>$r[tahun]</td>
									<td align='center'>
									
										<a href='?page=anggota_proyek&idp=".ec($r['id_proyek'])."&cc=".ec($r['cc'])."&tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' class='btn btn-xs btn-success'><i class='fa fa-users'></i></a> 
									
									</td>
									<td align='center'>
										<a href='?page=top&idp=".ec($r['id_proyek'])."&cc=".ec($r['cc'])."&tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' class='btn btn-xs btn-warning'><i class='fa fa-book'></i></a> 
									
									</td>
									<td align='center'>";
										
										if($getEdit==1){
											echo"<a href='?page=form_top&opt=edit&id=".ec($r['id_proyek'])."&tahun=".ec($getTahun)."&bulan=".ec($getBulan)."' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a> ";
										}if($getDelete==1){
											echo"<a href='?page=data_top&delete=".ec($r['id_proyek'])."&tahun=".ec($getTahun)."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
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