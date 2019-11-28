<script type="text/Javascript">
	function cc(){
		var x = window.open("lookup/cc3.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
</script>
			<h1 class="page-header">MSKK
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Matrik Sasaran Kerja Karyawan - Tahun <?=$tahun_aktif?></h4>
			    </div>
			    <div class="panel-body">
				
			<?php
			// if(!isset($_GET['opt'])){
				// echo'<a href="?page=srkk&opt=tambah" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>  Input Target Bulanan</a><p></p>';
			// }
				
			if(isset($_REQUEST['lock'])){
				$bln	= mysql_real_escape_string($_GET['bulan']);
				mysql_query("UPDATE mskk SET `lock`='1' WHERE bulan='$bln'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Kunci.
                    </div>";
			}if(isset($_REQUEST['unlock'])){
				$bln	= mysql_real_escape_string($_GET['bulan']);
				mysql_query("UPDATE mskk SET `lock`='0' WHERE bulan='$bln' ");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Kunci data telah dibuka.
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
			if($_SESSION['level']==1){
				$disabled ="";
			}elseif($_SESSION['level']==4){
				$disabled ="disabled";
			}elseif($_SESSION['level']==5){
				$disabled ="disabled";
			}else{
				$disabled ="";
			}
			
				@$getUnit	= mysql_real_escape_string(dc($_POST['unit']));
				@$getBulan	= mysql_real_escape_string(dc($_POST['bulan']));
				$idunit		= mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='$getUnit' "));
				echo"<form method='POST' action='page.php?page=mskk' id='formku'>
						<input type='hidden' name='page' value='mskk'>
						<input type='hidden' name='opt' value='cari'>
						<div class='form-group  col-lg-12 row'>
							<div class='form-group  col-lg-3'>
								<select name='bulan' class='form-control required'>
									<option value=''>Pilih Bulan</option>";
										for($i=1;$i<=12;$i++){
											echo"<option value='".ec($i)."'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
										}
							echo"</select>
							</div>
							<div class='form-group  col-lg-3'>
								<select name='unit' class='form-control' $disabled>
									<option value=''>Pilih Unit</option>";
										$qunit = mysql_query("SELECT * FROM mskko WHERE id !='1.6' AND id != '4' order by id");
										while($unit=mysql_fetch_array($qunit)){
											echo"<option value='".ec($unit['CostCenter'])."' ";if($unit['CostCenter']==$getUnit){echo"selected";} echo">$unit[uraian]</option>";
										}
							echo"</select>
							</div>
							<div class='form-group  col-lg-4'>
								<input type='submit' value='Pilih' class='btn btn-primary'>";
								if($_SESSION['level']==1){
									if(isset($_POST['opt'])){
										$jmlData= mysql_fetch_array(mysql_query("SELECT COUNT(*) as data FROM mskk WHERE bulan='$getBulan' "));
										$lock 	= mysql_fetch_array(mysql_query("SELECT COUNT(`lock`) as `lock` FROM mskk WHERE `lock`='1' AND bulan='$getBulan'"));
										if($jmlData['data']==$lock['lock']){
											echo" <a href='?page=mskk&unlock=1&bulan=$getBulan' class='btn btn-danger'><i class='fa fa-unlock'></i> Unlock</a>";
										}else{
											echo" <a href='?page=mskk&lock=2&bulan=$getBulan' class='btn btn-success'><i class='fa fa-lock'></i> Lock</a>";
										}
									}
								}
								if($_SESSION['level']==1 AND isset($_POST['opt'])){
									echo" <a href='page/mod_mskk/aksi_mskk_unit.php?tahun=$tahun_aktif&id=".ec($idunit['id'])."&unit=".ec($getUnit)."&bulan=".ec($getBulan)."&opt=tambah' class='btn btn btn-success'><i class='fa fa-refresh'></i>  Generate Unit</a>";
								}								
							echo"
							</div>
							
						</div>
					</form>";
					// echo"<a type='submit' value='Pilih' class='btn btn-primary'>Lock</a>";
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
							$tahun = $tahun_aktif;
							$no=1;
							
							if($_SESSION['level']==1){
								if(isset($_POST['opt'])){
									$where2 = "WHERE m_karyawan.dept='$getUnit'";
								}
							}else{
								if($_SESSION['level']==5){
									$where ="WHERE m_karyawan.dept='$_SESSION[cc]' AND m_karyawan.regno='$_SESSION[nik]'";
									// $where ="WHERE m_karyawan.dept='$_SESSION[cc]' ";
								}elseif($_SESSION['level']==4){
									$where ="WHERE m_karyawan.dept='$_SESSION[cc]'";
								}else{
									$where ="";
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
																$where $where2
																ORDER BY m_karyawan.regno");
							
							while($r=mysql_fetch_array($query)){
								$cek = mysql_num_rows(mysql_query("SELECT nik FROM mskk WHERE nik='$r[regno]' AND bulan='$getBulan' "));
								if($cek < 1){
									$disabled ="disabled";
								}else{
									$disabled ="";
								}
								if(isset($_POST['opt'])){
								echo"
									<tr>
										<td>$no</td>
										<td>$r[regno]</td>
										<td>$r[name]</td>
										<td>$r[posdesc]</td>
										<td>$r[uraian]</td>
										<td>
											<a target='_blank' href='?page=detail_mskk&id=".ec($r['regno'])."-".ec($getBulan)."&lvl=$r[level]' class='btn btn-sm btn-primary' ><i class='fa fa-file'></i>  MSKK</a>
											<a target='_blank' href='print/print_mskk.php?id=".ec($r['regno'])."-".ec($getBulan)."&lvl=$r[level]' class='btn btn-sm btn-primary' $disabled><i class='fa fa-print'></i>  Cetak</a>
										</td>
									</tr>";
								}
								$no++;
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>