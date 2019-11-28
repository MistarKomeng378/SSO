<?php
$getBulan	= mysql_real_escape_string($_POST['bulan']);
$getTahun	= mysql_real_escape_string($_POST['tahun']) ;
?>

			<h1 class="page-header">Form Target KPI
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			        </div>
			        <h4 class="panel-title">Form Key Performance Indicators & Target Bulan <?=bulan($getBulan)?> Tahun <?=$tahun_aktif?></h4>
			    </div>
			    <div class="panel-body">
		<?php
			
		echo"<form method='POST' action='page.php?page=form_target_kpi' id='formku'>
				<div class='form-group  col-lg-12 row'>
					<div class='form-group  col-lg-2'>
						<input type='hidden' name='page' value='form_target_kpi'>
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
					<div class='form-group  col-lg-3'>
						<input type='submit' value='Pilih' class='btn btn-primary'>
					</div>
				</div>
			</form>";
		?>
		<form method='POST' action='page/mod_kpi/query_target_kpi.php' id='formku'>
			<h4><b>KEY PERFORMANCE INDICATORS & TARGET-TARGETNYA</b></h4>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="5%" >No</th>
						<th >PERSPEKTIF & KPI KPKU</th>
						<th >BOBOT</th>
						<th >SATUAN</th>
						<th >TARGET TAHUNAN</th>
						<th >REALISASI BULAN INI</th>
						<th >ANALISA BULAN INI</th>
						<th >USULAN SOLUSI</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($_POST['opt'])){
					$query = mysql_query("SELECT * FROM kpku_perspektif ");
					while($r=mysql_fetch_array($query)){
					echo"<tr>
							<td colspan='8'><b>$r[id_perspektif] $r[perspektif]</b></td>
						</tr>";
						$query2 = mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='$r[id_perspektif]' ");
						while($r2=mysql_fetch_array($query2)){
							$ket = mysql_fetch_array(mysql_query("SELECT usulan_solusi,analisa FROM kpku_kpi_target WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_kpi='$r2[id_kpi]'"));
							if(!empty($r2['id_srko'])){
								$target =mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko WHERE id_srko='$r2[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun'"));
								$targets = $target['realisasi'];
								$readon	= "readonly";
							}else{
								$target = mysql_fetch_array(mysql_query("SELECT * FROM kpku_kpi_target WHERE id_kpi='$r2[id_kpi]'
																			AND bulan='$getBulan' 
																			AND tahun='$getTahun' "));
								$targets = $target['realisasi_bulan'];
								$readon	= "";
							}
						echo"
							<input type='hidden' name='id_kpi[]' value='$r2[id_kpi]' class='form-control'>
							<input type='hidden' name='id_perspektif[]' value='$r2[id_perspektif]' class='form-control'>
							<input type='hidden' name='bulan' value='$getBulan' class='form-control'>
							<input type='hidden' name='tahun' value='$getTahun' class='form-control'>
							<tr>
								<td>$r2[id_kpi] </td>
								<td>$r2[kpi] </td>
								<td>$r2[bobot]<input type='hidden' name='bobot[]' value='$r2[bobot]' class='form-control'></td>
								<td>$r2[satuan]<input type='hidden' name='satuan[]' value='$r2[satuan]' class='form-control'></td>
								<td>$r2[target_tahun]<input type='hidden' name='target[]' value='$r2[target_tahun]' class='form-control'></td>
								<td><input type='text' name='realisasi[]' value='$targets'class='form-control' $readon></td>
								<td><textarea name='analisa[]' class='form-control' >$ket[analisa]</textarea></td>
								<td><textarea name='solusi[]' class='form-control' >$ket[usulan_solusi]</textarea></td>
							</tr>";
						}
					}
				}
				?>
				</tbody>
			</table>
			<hr>
			<h4><b>SASARAN KINERJA LAINNYA</b></h4>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="5%" >No</th>
						<th >PERSPEKTIF & KPI KPKU</th>
						<th >SATUAN</th>
						<th >TARGET TAHUNAN</th>
						<th >REALISASI BULAN INI</th>
						<th >ANALISA BULAN INI</th>
						<th >USULAN SOLUSI</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($_POST['opt'])){
					$query = mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='' AND tahun='$getTahun'");
					while($r=mysql_fetch_array($query)){
						$ket = mysql_fetch_array(mysql_query("SELECT usulan_solusi,analisa FROM kpku_kpi_target WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_kpi='$r[id_kpi]'"));
						if(!empty($r['id_srko'])){
							$target =mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko WHERE id_srko='$r[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun'"));
							$targets2 = $target['realisasi'];
							$readon	= "readonly";
						}else{
							$target = mysql_fetch_array(mysql_query("SELECT * FROM kpku_kpi_target WHERE id_kpi='$r[id_kpi]'
																		AND bulan='$getBulan' 
																		AND tahun='$getTahun' "));
							$targets2 = $target['realisasi_bulan'];
							$readon	= "";
						}
						echo"
							<input type='hidden' name='id_kpi2[]' value='$r[id_kpi]' class='form-control'>
							<input type='hidden' name='bulan' value='$getBulan' class='form-control'>
							<input type='hidden' name='tahun' value='$getTahun' class='form-control'>
							<tr>
								<td>$r[id_kpi]</td>
								<td>$r[kpi]</td>
								<td>$r[satuan]<input type='hidden' name='satuan2[]' value='$r[satuan]' class='form-control'></td>
								<td>$r[target_tahun]<input type='hidden' name='target2[]' value='$r[target_tahun]' class='form-control'></td>
								<td><input type='text' name='realisasi2[]' value='$targets2'class='form-control' $readon></td>
								<td><textarea name='analisa2[]' class='form-control' >$ket[analisa]</textarea></td>
								<td><textarea name='solusi2[]' class='form-control' >$ket[usulan_solusi]</textarea></td>
							</tr>";
					}
				}
				?>
				</tbody>
			</table>
			<div class='form-group  col-lg-3'>
				<input type='submit' value='Simpan' name="Simpan" class='btn btn-primary'>
			</div>
		</form>
		</div>
	</div>