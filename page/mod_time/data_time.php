<link href="assets/css/datepicker2.css" rel="stylesheet" id="theme" />

<h1 class="page-header">Manage Time
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Manage Tahun Kerja</h4>
	</div>
	<div class="panel-body">
			<?php
			
			if(isset($_REQUEST['delete'])){
				$id_tahun = mysql_real_escape_string(dc($_GET['delete']));
				mysql_query("DELETE FROM tahun WHERE id_tahun='$id_tahun'");
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
                        <i class='fa fa-remove'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Failed!</b> Terjadi Kesalahan.
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
		<div class="form-group  col-lg-6">
			<table id="example1" class="table table-bordered table-striped table-hover" >
				<thead>
					<th>No.</th>
					<th>Tahun</th>
					<th>Status</th>
					<th></th>
				</thead>
				<tbody>
					<?php
						$query = mysql_query("SELECT * FROM tahun ORDER BY id_tahun");
						$i=1;
						while($r=mysql_fetch_array($query)){
							if($r['status']==1){
								$status="<a disabled href='' class='btn-xs btn-primary btn-flat'><i class='fa fa-check' ></i></a>";
							}else{
								$status="<a href='page/mod_time/aksi_time.php?opt=status&act=tahun&id=".ec($r['id_tahun'])."-".ec($r['status'])."' title='Aktifkan Tahun' class='btn-xs btn-danger btn-flat' ><i class='fa fa-times'></i></a>";
							}
							
							echo"
								<tr>
									<td>$i</td>
									<td>$r[tahun]</td>
									<td>$status</td>
									<td>
										<a href='?page=time&opt=edit&id=".ec($r['id_tahun'])."' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a>
										<a href='?page=time&delete=".ec($r['id_tahun'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>
									</td>
								</tr>
							";
							$i++;
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="form-group  col-lg-6">
			<?php
			if($_GET['opt']=="edit"){
				$eid_tahun 	= mysql_real_escape_string(dc($_GET['id']));
				$edit 		= mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE id_tahun='$eid_tahun' "));
				$etahun		= $edit['tahun'];
			}else{
				$eid_tahun 	="";
				$etahun 	="";
			}
			?>
			<form method="POST" action="page/mod_time/aksi_time.php?act=tahun&opt=<?=$_GET['opt']?>" id="formku" enctype="multipart/form-data">
				<div class="col-lg-12">
					<label for="tahun">Tahun</label>						
					<input type="hidden" name="id_tahun" value="<?=$eid_tahun?>" class="form-control">
					<input type="text" name="tahun" value="<?=$etahun?>" class="form-control required">
				</div>
				<div class="form-group  col-lg-12">
				<hr>
					<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Manage Libur Nasional</h4>
	</div>
	<div class="panel-body">
			<?php
			
			if(isset($_REQUEST['deletel'])){
				$id_libur = mysql_real_escape_string(dc($_GET['deletel']));
				mysql_query("DELETE FROM libur_nasional WHERE id_libur='$id_libur'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Dihapus.
                    </div>";
			}
			if(isset($_REQUEST['succes-l'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Disimpan.
                    </div>";
			}
			if(isset($_REQUEST['failed-l'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-remove'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Failed!</b> Terjadi Kesalahan.
                    </div>";
			}
			if(isset($_REQUEST['succes2-l'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
		?>
		<div class="form-group  col-lg-8">
			<table id="example2" class="table table-bordered table-striped table-hover" >
				<thead>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Keterangan</th>
					<th></th>
				</thead>
				<tbody>
					<?php
						$query = mysql_query("SELECT * FROM libur_nasional ORDER BY id_libur DESC");
						$i=1;
						while($r=mysql_fetch_array($query)){
							echo"
								<tr>
									<td>$i</td>
									<td>$r[tanggal]</td>
									<td>$r[keterangan]</td>
									<td>
										<a href='?page=time&opt=edit&idl=".ec($r['id_libur'])."' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a>
										<a href='?page=time&deletel=".ec($r['id_libur'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>
									</td>
								</tr>
							";
							$i++;
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="form-group  col-lg-4">
			<?php
			if($_GET['opt']=="edit"){
				$id_libur 		= mysql_real_escape_string(dc($_GET['idl']));
				$edit 			= mysql_fetch_array(mysql_query("SELECT * FROM libur_nasional WHERE id_libur='$id_libur' "));
				$tanggal_libur	= $edit['tanggal'];
				$keterangan		= $edit['keterangan'];
			}else{
				$id_libur 		="";
				$tanggal_libur 	="";
				$keterangan 	="";
			}
			?>
			<form method="POST" action="page/mod_time/aksi_time.php?act=libnas&opt=<?=$_GET['opt']?>" id="formku2" enctype="multipart/form-data">
				<div class="col-lg-12">
					<label for="tanggal">Tanggal Libur</label>						
					<input type="hidden" name="id_libur" value="<?=$id_libur?>" class="form-control">
					<input type="text" name="tanggal_libur" value="<?=$tanggal_libur?>" class="form-control required" id="dpicker"><br>
					<label for="keterangan">Keterangan</label>						
					<textarea name="keterangan" class="form-control required"><?=$keterangan?></textarea>
				</div>
				<div class="form-group  col-lg-12">
				<hr>
					<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Manage Jumlah Hari dan Jumlah Jam Kerja</h4>
	</div>
	<div class="panel-body">
			<?php
			
			if(isset($_REQUEST['succes-bl'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Disimpan.
                    </div>";
			}
		?>
		<div class="form-group  col-lg-8">
			<table id="example2" class="table table-bordered table-striped table-hover" >
				<thead>
					<th>No.</th>
					<th>Bulan</th>
					<th>Tahun</th>
					<th>Hari Kerja</th>
					<th>Jam Kerja</th>
				</thead>
				<tbody>
					<?php
						$query = mysql_query("SELECT * FROM jam_bulanan WHERE tahun='$tahun_aktif'ORDER BY tahun,bulan ASC");
						$i=1;
						while($r=mysql_fetch_array($query)){
							echo"
								<tr>
									<td align='center'>$i</td>
									<td>".bulan($r['bulan'])."</td>
									<td align='center'>$r[tahun]</td>
									<td align='center'>$r[hari_kerja]</td>
									<td align='center'>$r[jam_bulanan]</td>
								</tr>
							";
							$i++;
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="form-group  col-lg-4">
			<a href="?page=time&opt=generate" class="btn btn-success"><i class="fa fa-refresh"></i> Generate Tahun <?=$tahun_aktif?></a>
			<?php
			if($_GET['opt']=="generate"){
					mysql_query("DELETE FROM `jam_bulanan` WHERE tahun='$tahun_aktif' ");
					$start    = new DateTime("$tahun_aktif-01-01");
					$start->modify('first day of this month');
					$end      = new DateTime("$tahun_aktif-12-01");
					$end->modify('first day of next month');
					$interval = DateInterval::createFromDateString('1 month');
					$period   = new DatePeriod($start, $interval, $end);
					$b=1;
					foreach ($period as $dt) {
						$year 		= $dt->format("Y");
						$month 		= $dt->format("m");
						$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$month,$year);
						
						$i		= 0;
						$x     	= 0;
						$endz   = 1;
						
						$mulai		="$year-$month-01";
						$akhir		="$year-$month-$lastDay";
						$date1 		= date_create($mulai);
						$s 			= strtotime($mulai);
						$e 			= strtotime($akhir);
						$diff 		= ($e-$s)/86400;
						for($k=0;$k<=$diff;$k++){  
							$tgl_kerja = date_format($date1,"Y-m-d");
							
							$ex		= explode("-",$tgl_kerja);
							$tahun	= $ex[0]; 
							$bulan	= $ex[1]; 
							$hari	= $ex[2];
							
							if(date("D",mktime (0,0,0,$month,$hari,$year)) == "Sun") {
								
							}elseif(date("D",mktime (0,0,0,$month,$hari,$year)) == "Sat") {
								 
							}
							else{
								$liburaNas 		= mysql_fetch_array(mysql_query("SELECT * FROM libur_nasional WHERE date_format( tanggal, '%d %m %Y' ) = '$hari $bulan $tahun'"));
								if($liburaNas['tanggal'] == $tgl_kerja){
								}else{
									$x += $endz-$i;
								}
							}
							date_add($date1, date_interval_create_from_date_string('1 days'));
						}
						
						$jumHariKerja 	= $x ;
						$jumJamKerja	= $jumHariKerja * 8;
						
						mysql_query("INSERT INTO `jam_bulanan` SET 	`id`			='' ,
																	`bulan`			='$month', 
																	`hari_kerja`	='$x',
																	`jam_bulanan`	='$jumJamKerja',
																	`tahun`			='$year'
									");
						$b++;	
					}
				header('Location:?page=time&succes-bl=1');
			}
			?>
		</div>
	</div>
</div>
<script src="assets/js/bootstrap-datepicker2.js"></script>
	<script>
	 $('#dpicker').datepicker({
	 format: 'yyyy-mm-dd',
	 autoclose: true,
	 todayHighlight: false
	 })
	</script>