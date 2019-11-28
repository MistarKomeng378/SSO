<?php
	function serialize_ke_string($serial)
	{
		$hasil = unserialize($serial);
		return implode(', ', $hasil);
	}
	
	
	$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
	$getUnit	= dc($_GET['unit']);
	$tahun_srko = $_COOKIE['tahun_srko'];
	$idtahun_srko = $_COOKIE['idtahun_srko'];
	$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".date('Y')."'"));
	// $ay  = date('Y');
	// $Thnow = date('Y', strtotime('-1 year', strtotime($ay)));
	// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".$Thnow."'"));
	if($_COOKIE['tahun_srko']==""){
		$tahun_srko 	= $thn['tahun'];
		$idtahun_srko 	= $thn['id_tahun'];
	}else{
		$tahun_srko 	= $_COOKIE['tahun_srko'];
		$idtahun_srko	= $_COOKIE['idtahun_srko'];
	}

?>
<style>
/*    css disini*/
 
    .mytable th{
        background-color: #ccd9ff
    }
</style>
			<h1 class="page-header">Data SRKO
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Data SRKO</h4>
			    </div>
			    <div class="panel-body">
				
			<?php
			if($getInsert==1){
				echo"				
					<div class='col-lg-8'>
						<a href='?page=form_srko&opt=tambah&cc=$_GET[unit]' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah SRKO</a>
						<a href='?page=import_srko' class='btn btn-primary'><i class='fa fa-upload'></i> Import SRKO</a>
						<a href='?page=import_to_gca' class='btn btn-primary'><i class='fa fa-upload'></i> Import To GCA</a> 
						<a href='print/print_data_srko.php?id=".ec($unit['CostCenter'])."-".ec($tahun_srko)."' target='_blank' class='btn btn-success'><i class='fa fa-print' ></i> Cetak Excel</a> 						
					</div>
					
					<div class='col-lg-4'>					
					<form method='POST' action='page/mod_srko/aksi_tahun.php'>
						<div class='col-lg-6'>
							<select name='tahun' class='form-control'>
								<option value=''>-Pilih Tahun-</option>";
								$qtahun = mysql_query("SELECT * FROM tahun");
								while($t=mysql_fetch_array($qtahun)){
									echo"<option value='$t[id_tahun]'"; if($idtahun_srko==$t['id_tahun']){echo"selected";} echo">$t[tahun]</option>";
								}
							echo"</select>
						</div>
						<div class='col-lg-2'>
							<button type='submit' name='simpan' value='simpan' class='btn btn-primary'>Submit</button>
						</div>
					</form>
					</div>";
			}
			?>
						
			<table width="100%">
				<tr>
					<td width="30%"><img src="assets/img/logo.jpg" width="80%"></td>
					<td width="40%" align="center">
						<br>
						<br>
						<br>
						<br>
						<br>
						<h3><b>SASARAN/RENCANA KERJA TAHUN <?=$tahun_srko;?></b></h3>
						<?php
							if(isset($_GET['unit'])){
								$nama_unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".dc($_GET['unit'])."'"));
								echo "<h4><b>".strtoupper($nama_unit['uraian'])."</b></h4>";
							}else{
								echo"<h4><b>PERUSAHAAN</b></h4>";
							}
						?>
					</td>
					
					<td width="30%" align="left">
						<form method="GET" action="<?=$_SERVER['PHP_SELF']?>">
							<div class="form-group  col-lg-12 row">
							
								<div class="form-group  col-lg-2">
									<a href='?page=data_srko_full&unit=<?=ec($getUnit)?>' class='btn btn-primary' title="Lihat SRKO selengkpanya"><i class='fa fa-table'></i></a>
								</div>
							
								<div class="form-group  col-lg-8">
								
									<input type="hidden" name="page" value="data_srko">
									<select name="unit" class="form-control">
										<option value="">Pilih Unit</option>
										<?php
											$qunit = mysql_query("SELECT * FROM mskko WHERE id !='1.6' AND id!='4' AND id!='1.5' order by id");
											while($unit=mysql_fetch_array($qunit)){
												echo"<option value='".ec($unit['CostCenter'])."'"; if(dc($_GET['unit'])==$unit['CostCenter']){echo"selected";} echo" >$unit[uraian]</option>";
											}
										?>
									</select>
								</div>
								<div class="form-group  col-lg-2">
									<input type="submit" value="Pilih" class="btn btn-primary">
								</div>
							</div>
						</form>
					</td>
				</tr>
			</table>
			<hr>
			<?php
			
			if(isset($_REQUEST['delete'])){
				$getId	= dc($_GET['delete']);
				mysql_query("DELETE FROM srko WHERE id_srko='$getId'");
				mysql_query("DELETE FROM wbs WHERE id_srko='$getId'");
				// $idDelete		= mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id_srko='$getId' "));
				// $parentIdDelete	= mysql_fetch_array(mysql_query("SELECT id FROM wbs WHERE id='$idDelete[parentId]' "));
				// mysql_query("DELETE FROM wbs WHERE id='$idDelete[id]'");
				// mysql_query("DELETE FROM wbs WHERE id='$parentIdDelete[id]'");
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
		<div class="table-responsive">
			<table id="example1" class="table table-bordered table-striped table-hover" >
				<thead>
					<th>NO.</th>
					<?php 
					// if(!isset($_GET['unit'])){
						// echo"<th>PERSPEKTIF</th>";
						// }elseif($getUnit=="M1000"){
							// echo"<th>PERSPEKTIF</th>";
							// }elseif($getUnit=="M1300"){
								// echo"<th>PERSPEKTIF</th>";}?>
					<!--<th>KPM</th>-->
					<th>KPI</th>
					<th>BOBOT(%)</th>
					<th>SATUAN</th>
					<th>TARGET</th>
					<th>RENCANA KERJA</th>
					<th width="8%"></th>
				</thead>
				<tbody>
					<?php
						
						if(isset($_GET['unit'])){
							$query = mysql_query("SELECT DISTINCT srko.id_srko,
													kpi.kpi,
													kpi.definisi,
													srko.perspektif,
													srko.id_srko,
													srko.CostCenter,
													srko.tahun,
													srko.kpm,
													srko.id_kpi,
													srko.bobot,
													srko.satuan,
													srko.target,
													srko.rencana_kerja,
													srko.jenis_pencapaian,
													srko.pic,
													srko.integrasi
													FROM
													srko
													INNER JOIN kpi ON kpi.id_kpi = srko.id_kpi
													WHERE srko.CostCenter='$getUnit' AND srko.tahun='$tahun_srko' AND kpi.tahun='$tahun_srko'
													ORDER BY srko.id_srko, srko.id_kpi ASC
													");
						}else{
							$query = mysql_query("SELECT DISTINCT srko.id_srko,
													kpi.kpi,
													kpi.definisi,
													srko.perspektif,
													srko.id_srko,
													srko.CostCenter,
													srko.tahun,
													srko.kpm,
													srko.id_kpi,
													srko.bobot,
													srko.satuan,
													srko.target,
													srko.rencana_kerja,
													srko.jenis_pencapaian,
													srko.pic,
													srko.integrasi
													FROM
													srko
													INNER JOIN kpi ON kpi.id_kpi = srko.id_kpi
													WHERE srko.CostCenter='M1000' AND srko.tahun='$tahun_srko' AND kpi.tahun='$tahun_srko'
													ORDER BY srko.id_srko ASC
													");
						}
											
						
						$i=1;
						while($r=mysql_fetch_array($query)){
							// if($r['jenis_pencapaian']==1){
								// $simbol ="<i class='fa fa-plus'></i>";
							// }elseif($r['jenis_pencapaian']==2){
								// $simbol ="<i class='fa fa-minus'></i>";
							// }else{
								// echo " ";
							// }		
							echo"
								<tr>
									<td>$i</td>";
									// if(!isset($_GET['unit'])){
										// echo"<td>$r[perspektif]</td>";
										// }elseif($getUnit=="M1000"){
											// echo"<td>$r[perspektif]</td>";
											// }elseif($getUnit=="M1300"){
												// echo"<td>$r[perspektif]</td>";}
									//echo"<td>$r[kpm]</td>									
																	
									echo"
									<td>$r[kpi]</td>
									<td align='center'>$r[bobot]</td>
									<td align='center'>$r[satuan]</td>
									<td align='center'>$r[target]</td>
									<td>$r[rencana_kerja]</td>
									<td>";
										if(isset($_GET['unit'])){
											if($getEdit==1){
												echo"<a href='?page=form_srko&opt=edit&id=".ec($r['id_srko'])."&cc=".ec($getUnit)."' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a> &nbsp;"; 
											}if($getDelete==1){
												echo"<a href='?page=data_srko&delete=".ec($r['id_srko'])."&cc=".ec($getUnit)."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
											}
										}else{
											if($getEdit==1){
												echo"<a href='?page=form_srko&opt=edit&id=".ec($r['id_srko'])."' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a> &nbsp;";
											}if($getDelete==1){
												echo"<a href='?page=data_srko&delete=".ec($r['id_srko'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
											}
										}
								echo"</td>
								</tr>
							";
							$i++;
						}
					?>
				</tbody>
			</table>
		</div>
		</div>
	</div>