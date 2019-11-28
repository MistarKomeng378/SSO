<?php
$getBulan	= mysql_real_escape_string($_POST['bulan']);
$getTahun	= mysql_real_escape_string($_POST['tahun']) ;
?>

			<h1 class="page-header">Target KPI
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			        </div>
			        <h4 class="panel-title">Key Performance Indicators & Target Bulan <?=bulan($getBulan)?> Tahun <?=$tahun_aktif?></h4>
			    </div>
			    <div class="panel-body">
<?php
			if(isset($_REQUEST['delete'])){
				// mysql_query("DELETE FROM srko WHERE id_srko='$_GET[id_srko]'");
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
			if($getInsert==1){
				echo"
					<a href='?page=form_kpku_kpi&opt=rkap&act=tambah' class='btn btn-sm btn-primary' title='Input Target RKAP' ><i class='fa fa-plus'></i> Input Target RKAP</a>
					<a href='?page=form_kpku_kpi&opt=perspektif&act=tambah' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i> Tambah Perspektif</a>
					<a href='?page=form_target_kpi' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i> Input Realisasi</a>
				<hr>";
			}
			echo"<form method='POST' action='page.php?page=target_kpi' id='formku'>
				<div class='form-group  col-lg-12 row'>
					<div class='form-group  col-lg-2'>
						<input type='hidden' name='page' value='target_kpi'>
						<input type='hidden' name='opt' value='cari'>
						<select name='bulan' class='form-control required'>
							<option value=''>Pilih Bulan</option>";
									for($i=1;$i<=12;$i++){
										echo"<option value='$i'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
									}
					echo"</select>
					</div>
					<div class='form-group  col-lg-1'>
						<input type='text' name='tahun' class='form-control required' value='".date("Y")."' placeholder='Tahun'>
					</div>
					<div class='form-group  col-lg-1'>
						<input type='submit' value='Pilih' class='btn btn-primary'>
					</div>";
					if(isset($_POST['opt'])){
						echo"
						<div class='form-group  col-lg-3'>
							<a target='_blank' href='print/print_target_kpi_excel.php?id=".ec($getBulan)."-".ec($getTahun)."' class='btn btn-success'><i class='fa fa-download'></i> Download</a>
						</div>";
					}
					echo"
				</div>
			</form>";
			// <table id="example1" class="table table-bordered table-striped table-hover">
		?>
			<h4><b>KEY PERFORMANCE INDICATORS & TARGET-TARGETNYA</b></h4>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="5%" rowspan="2">No</th>
						<th rowspan="2">PERSPEKTIF & KPI KPKU</th>
						<th rowspan="2">BOBOT</th>
						<th rowspan="2">SATUAN</th>
						<th rowspan="2">TARGET TAHUNAN</th>
						<th colspan="2">REALISASI</th>
						<th colspan="2">PENCAPAIAN</th>
						<th rowspan="2"></th>
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
				if(isset($_POST['opt'])){
					$query = mysql_query("SELECT * FROM kpku_perspektif WHERE tahun='$getTahun' ");
					while($r=mysql_fetch_array($query)){
					echo"<tr>
							<td colspan='7'><b>$r[id_perspektif] $r[perspektif]</b></td>
							<td  colspan='2'>";
								if($getInsert==1){
									echo"<a href='?page=form_kpku_kpi&opt=kpi_kpku&act=tambah&idp=".ec($r['id_perspektif'])."' class='btn btn-xs btn-primary' title='Tambah KPI KPKU' ><i class='fa fa-plus'></i> Tambah KPI KPKU</a>";
								}
						echo"</td>
							<td></td>
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
								<td>$r2[bobot]</td>
								<td>$r2[satuan]</td>
								<td>$r2[target_tahun]</td>
								<td>$target[realisasi_bulan]</td>
								<td>$total</td>
								<td>".desimal3($target['pencapaian'])." %</td>
								<td>".desimal3($nilai)." %</td>
								<td><a href='?page=chart_kpi&id=".ec($r2['id_kpi'])."-".ec($r['tahun'])."' target='_blank' class='btn btn-xs btn-warning' title='Chart View' ><i class='fa fa-bar-chart'></i> </a></td>
							</tr>";
						}
					}
				}
				?>
				</tbody>
			</table>
			<hr>
			<?php
				if($getInsert==1){
					echo"
						<a href='?page=form_kpku_kpi&opt=kpi_kpku2&act=tambah' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i> Tambah KPI KPKU</a>
					<hr>";
				}
			?>
			<h4><b>SASARAN KINERJA LAINNYA</b></h4>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="5%" rowspan="2">No</th>
						<th rowspan="2">PERSPEKTIF & KPI KPKU</th>
						<th rowspan="2">SATUAN</th>
						<th rowspan="2">TARGET TAHUNAN</th>
						<th colspan="2">REALISASI</th>
						<th colspan="2">PENCAPAIAN</th>
						<th rowspan="2"></th>
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
				if(isset($_POST['opt'])){
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
								<td>$r[satuan]</td>
								<td>$r[target_tahun]</td>
								<td>$target[realisasi_bulan]</td>
								<td>$total</td>
								<td>".desimal3($target['pencapaian'])." %</td>
								<td>".desimal3($nilai)." %</td>
								<td><a href='?page=chart_kpi&id=".ec($r['id_kpi'])."-".ec($r['tahun'])."-".ec($getBulan)."' target='_blank' class='btn btn-xs btn-warning' title='Chart View' ><i class='fa fa-bar-chart'></i> </a></td>
							</tr>";
					}
				}
				?>
				</tbody>
			</table>
		</div>
	</div>