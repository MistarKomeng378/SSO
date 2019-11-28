<script type="text/Javascript">
	function cc(){
		var x = window.open("lookup/cc3.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
</script>
<?php
@$getTahun	= mysql_real_escape_string(dc($_POST['tahun']));
if(isset($_POST['tahun'])){
	$thSRKK = $getTahun;
}else{
	$thSRKK = $tahun_aktif;
}
?>

<h1 class="page-header">SRKK
	<small><?=$_SESSION['nm_level']?></small>
</h1>
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Sasaran Rencana Kerja Karyawan - Tahun <?=$thSRKK?></h4>
	</div>
	<div class="panel-body">
				
			<?php
			if(isset($_REQUEST['delete'])){
				// $getId	= dc($_GET['delete']);
				// mysql_query("DELETE FROM srko WHERE id_srko='$getId'");
				// mysql_query("DELETE FROM wbs WHERE id_srko='$getId'");
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
	<div class="form-group col-lg-12 ">
		<?php
			if($_SESSION['level']==1 OR $_SESSION['level']==2 OR $_SESSION['level']==3){
				@$getUnit	= mysql_real_escape_string(dc($_POST['unit']));
				echo"<form method='POST' action='page.php?page=srkk' id='formku'>
						<input type='hidden' name='page' value='srkk'>
						<input type='hidden' name='opt' value='cari'>
						<div class='form-group  col-lg-12 row'>
							<div class='form-group  col-lg-2'>
								<select name='tahun' class='form-control '>
									<option value=''>Pilih Tahun</option>";
										$qsbdth = mysql_query("SELECT * FROM tahun");
										while($r=mysql_fetch_array($qsbdth)){
											echo"<option value='".ec($r['tahun'])."'"; if($thSRKK==$r['tahun']){echo"selected";} echo">$r[tahun]</option>";
										}
							echo"</select>
							</div>
							<div class='form-group  col-lg-3'>
								<select name='unit' class='form-control'>
									<option value=''>Pilih Unit</option>";
										$qunit = mysql_query("SELECT * FROM mskko WHERE id !='1.6' AND id != '4' order by id");
										while($unit=mysql_fetch_array($qunit)){
											echo"<option value='".ec($unit['CostCenter'])."' ";if($unit['CostCenter']==$getUnit ){echo"selected";} echo">$unit[uraian]</option>";
										}
							echo"</select>
							</div>
							<div class='form-group  col-lg-3'>
								<input type='submit' value='Pilih' class='btn btn-primary'>
							</div>
						</div>
					</form>";
			}
		?>
		</div>
		<div class="form-group col-lg-12 ">
			<div class="table-responsive">
				<table id="example1" class="table table-striped table-bordered table-hover nowrap mytable" width="100%">
					<thead>
						<tr>
							<th>No.</th>
							<th>NIK</th>
							<th>NAMA</th>
							<th>JABATAN</th>
							<th>DIVISI</th>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php
							
							$no=1;
							
							if($_SESSION['level']==1){
								if(isset($_POST['opt'])){
									$and2 = "AND m_karyawan.dept='$getUnit' AND m_karyawan.status='0'";
								}
							}else{
								if($_SESSION['level']==5){
									$and ="AND m_karyawan.dept='$_SESSION[cc]' AND m_karyawan.regno='$_SESSION[nik]' AND m_karyawan.status='0'";
								}elseif($_SESSION['level']==4){
									$and ="AND m_karyawan.dept='$_SESSION[cc]' AND m_karyawan.status='0' ";
								}else{
									$and ="AND m_karyawan.status='0'";
								}
							}
							$query = mysql_query("SELECT	m_jabatan.posdesc,
																m_karyawan.regno,
																m_karyawan.`name`,
																m_karyawan.poscode,
																m_karyawan.email,
																mskko.uraian,
																mskko.CostCenter,
																m_jabatan.poscode,
																`user`.`level`															
														FROM
																m_karyawan
																LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																LEFT JOIN `user` ON `user`.nik = m_karyawan.regno
																WHERE m_karyawan.status='0'
																$and $and2
																ORDER BY m_karyawan.regno");
							
							while($r=mysql_fetch_array($query)){
								$cek = mysql_num_rows(mysql_query("SELECT nik FROM srkk WHERE nik='$r[regno]' AND tahun='$thSRKK' "));
								if($cek < 1){
									$disabled ="disabled";
								}else{
									$disabled ="";
								}
								echo"
									<tr>
										<td>$no</td>
										<td>$r[regno]</td>
										<td>$r[name]</td>
										<td>$r[posdesc]</td>
										<td>$r[uraian]</td>
										<td>
											<a href='?page=detail_srkk&id=".ec($r['regno'])."-".ec($thSRKK)."&lvl=$r[level]' class='btn btn-sm btn-primary' ><i class='fa fa-file'></i>  SRKK</a>
											<a target='_blank' href='print/print_srkk.php?id=".ec($r['regno'])."-".ec($thSRKK)."&lvl=$r[level]' class='btn btn-sm btn-primary' $disabled><i class='fa fa-print' ></i> Cetak</a>
										</td>
									</tr>";
								$no++;
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>