<script type="text/Javascript">
	function srko(){
		var x = window.open("lookup/srko.php?id=<?=ec($tahun_aktif)?>", "srko", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
</script>

		<h1 class="page-header"><?php if($_GET['opt']=="perspektif"){echo"Form Prespektif";}elseif($_GET['opt']=="kpi_kpku"){echo"Form KPI KPKU ";}elseif($_GET['opt']=="kpi_kpku2"){echo"Form KPI KPKU ";}elseif($_GET['opt']=="rkap"){echo"Form Target RKAP ";} ?>
			<small><?=$_SESSION['nm_level']?></small>
		</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title"><?php if($_GET['opt']=="perspektif"){echo"Form Prespektif";}elseif($_GET['opt']=="kpi_kpku"){echo"Form KPI KPKU ";}elseif($_GET['opt']=="kpi_kpku2"){echo"Form KPI KPKU ";}elseif($_GET['opt']=="rkap"){echo"Form Target RKAP ";} ?></h4>
		</div>
		<div class="panel-body">
		
		<?php
		
		
		
		
		if($_GET['opt']=="perspektif"){
			if(isset($_REQUEST['delete'])){
			mysql_query("DELETE FROM kpku_perspektif WHERE id_perspektif='".mysql_real_escape_string(dc($_GET['delete']))."' ");
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
			if($_GET['act']=="tambah"){
				$id 		= mysql_fetch_array(mysql_query("SELECT MAX(id_perspektif) as id FROM kpku_perspektif "));
				$kode		= $id['id'] +1; 
				$ex			= explode(".",$id['id']);
				$kd1		= $ex[0];
				$kd2		= $ex[1]+1;
				$id_baru	= $kd1.".".$kd2;
				$tahun		= $tahun_aktif;
				$perspektif	= "";
			}elseif($_GET['act']=="edit"){
				// $id_baru 	= mysql_real_escape_string(dc($_GET['id']));
				$kode		= mysql_real_escape_string(dc($_GET['id']));
				$edit		= mysql_fetch_array(mysql_query("SELECT * FROM kpku_perspektif WHERE id_perspektif='$kode' "));
				$tahun		= $edit['tahun'];
				$perspektif	= $edit['perspektif'];
			}
			if($getInsert==1){
			echo"
				<form method='POST' action='page/mod_kpi/query_kpku_kpi.php?opt=perspektif&act=$_GET[act]' id='formku'>
					<div class='form-group  col-lg-12 row'>
						<div class='form-group  col-lg-2'>
							<input type='text' name='id_perspektif' class='form-control required' value='$kode' placeholder='Id Prespektif'>
						</div>
						<div class='form-group  col-lg-6'>
							<input type='text' name='perspektif' class='form-control required' value='$perspektif' placeholder='Prespektif'>
						</div>
						<div class='form-group  col-lg-1'>
							<input type='text' name='tahun' class='form-control required' value='".$tahun."' placeholder='Tahun'>
						</div>
						<div class='form-group  col-lg-3'>
							<input type='submit' value='Simpan' name='Simpan' class='btn btn-primary'>
						</div>
					</div>
				</form>";
			}
			echo"
				<table class='table table-bordered table-striped table-hover' id='example2'>
				<thead>
					<tr>
						<th width='5%'>NO.</th>
						<th>TAHUN</th>
						<th>ID PERSPEKTIF</th>
						<th>PERSPEKTIF</th>
						<th></th>
					</tr>
				</thead>
				<tbody>";
				$no=1;
				$query = mysql_query("SELECT * FROM kpku_perspektif ");
				while($r=mysql_fetch_array($query)){
					echo"<tr>
							<td>$no</td> 
							<td>$r[tahun]</td> 
							<td>$r[id_perspektif]</td> 
							<td>$r[perspektif]</td>
							<td>";
								if($getEdit==1){
									echo" <a href='?page=form_kpku_kpi&opt=perspektif&act=edit&id=".ec($r['id_perspektif'])."' class='btn btn-xs btn-success' title='Edit Prespektif' ><i class='fa fa-pencil'></i></a>";
								}if($getDelete==1){
									echo" <a href='?page=form_kpku_kpi&opt=perspektif&act=tambah&delete=".ec($r['id_perspektif'])."' class='btn btn-xs btn-danger' title='Hapus Prespektif' ><i class='fa fa-trash'></i></a>";
								}
						echo"</td>
						</tr>";
					$no++;
				}
			echo"</tbody>
			</table>";
		}elseif($_GET['opt']=="kpi_kpku"){
			if(isset($_REQUEST['delete'])){
			mysql_query("DELETE FROM kpku_kpi WHERE id_kpi='".mysql_real_escape_string(dc($_GET['delete']))."' ");
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
			// $getid	= mysql_real_escape_string($_GET['idp']);
			$getid	= mysql_real_escape_string(dc($_GET['idp']));
			if($_GET['act']=="tambah"){
				// $id 		= mysql_fetch_array(mysql_query("SELECT MAX(id_kpi) as id FROM kpku_kpi WHERE id_perspektif='$getid'"));
				$id 		= mysql_fetch_array(mysql_query("SELECT MAX(id_kpi) as id FROM kpku_kpi"));
				$kode		= $id['id'] +1; 
				$ex			= explode("-",$id['id']);
				$kd1		= $ex[0];
				$kd2		= $ex[1]+1;
				$id_baru	= $kd1."-".$kd2;
				$tahun		= date("Y");
				$id_srko	= "";
				$kpi		= "";
				$bobot		= "";
				$satuan		= "";
				$t_tahunan	= "";
				$rumus		= "";
				$perhitungan= "";
			}elseif($_GET['act']=="edit"){
				// $id_baru 	= mysql_real_escape_string(dc($_GET['id']));
				$kode		= mysql_real_escape_string(dc($_GET['id']));
				$edit		= mysql_fetch_array(mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='$getid' AND id_kpi='$kode' "));
				$tahun		= $edit['tahun'];
				$id_srko	= $edit['id_srko'];
				$kpi		= $edit['kpi'];
				$bobot		= $edit['bobot'];
				$satuan		= $edit['satuan'];
				$t_tahunan	= $edit['target_tahun'];
				$rumus		= $edit['rumus'];
				$perhitungan= $edit['perhitungan'];
				$rkap		= $edit['v_rkap'];
				$real		= $edit['v_real'];
				$rkap_kom	= $edit['v_rkap_kom'];
				$real_kom	= $edit['v_real_kom'];
				$real_pro	= $edit['v_prosen_real'];
				$kom_pro	= $edit['v_prosen_kom'];
				$trkap		= $edit['t_rkap'];
				$treal		= $edit['t_real'];
				$trkap_kom	= $edit['t_rkap_kom'];
				$treal_kom	= $edit['t_real_kom'];
				$treal_pro	= $edit['t_prosen_real'];
				$tkom_pro	= $edit['t_prosen_kom'];
				$ex			= explode(":",$edit['scale']);
				$awal		= $ex[0];
				$akhir		= $ex[1];
				$rentang	= $ex[2];
			}
			if($getInsert==1){
			echo"
				<form method='POST' action='page/mod_kpi/query_kpku_kpi.php?opt=kpi_kpku&act=$_GET[act]' id='formku'>
					<div class='form-group  col-lg-6'>
						<div class='form-group  col-lg-4'>
							<label>Id KPI</label>
							<input type='text' name='id_kpi' class='form-control required' value='$kode' placeholder='Id KPI'>
							<input type='hidden' name='id_perspektif' class='form-control required' value='$getid' placeholder='Id KPI'>
						</div>
						<div class='form-group  col-lg-4'>
							<label>Id SRKO</label>
							<div class='input-group input-group'>
								<input type='text' name='id_srko' class='form-control' value='$id_srko' id='id_srko' placeholder='Id SRKO' readonly>
								<span class='input-group-btn'>
									<i class='glyphicon glyphicon-search btn btn-primary btn-flat edit-record' onclick='srko()'></i>
								</span>
							</div>
						</div>
						<div class='form-group  col-lg-4'>
							<label>Tahun</label>
							<input type='text' name='tahun' class='form-control required' value='".$tahun."' placeholder='Tahun'>
						</div>
						<div class='form-group  col-lg-12'>
							<label>KPI</label>
							<input type='text' name='kpi' class='form-control required' value='$kpi' placeholder='KPI'>
						</div>						
					</div>
					<div class='form-group  col-lg-6'>
						<div class='form-group  col-lg-4'>
							<label>Bobot</label>
							<input type='text' name='bobot' class='form-control required' value='".$bobot."' placeholder='Bobot'>
						</div>
						<div class='form-group  col-lg-4'>
							<label>Satuan</label>
							<input type='text' name='satuan' class='form-control required' value='".$satuan."' placeholder='Satuan'>
						</div>
						<div class='form-group  col-lg-4'>
							<label>Target Tahunan</label>
							<input type='text' name='t_tahunan' class='form-control required' value='".$t_tahunan."' placeholder='Target Tahunan'>
						</div>
						
						<div class='form-group  col-lg-6'>
							<label>Rumus</label>
							<select name='rumus' class='form-control '>
								<option value=''>-Jenis Rumus-</option>
								<option value='1'"; if($rumus==1){echo"selected";} echo">Positif</option>
								<option value='2'"; if($rumus==2){echo"selected";} echo">Negatif</option>
							</select>
						</div>
						<div class='form-group  col-lg-6'>
							<label>Perhitungan</label>
								<select name='perhitungan' class='form-control '>
									<option value='' >-Jenis Perhitungan-</option>
									<option value='1'"; if($perhitungan==1){echo"selected";} echo">Bulan Terakhir</option>
									<option value='2'"; if($perhitungan==2){echo"selected";} echo">Komulatif</option>
									<option value='3'"; if($perhitungan==3){echo"selected";} echo">Rata-rata</option>
								</select>
						</div>
					</div>					
					<div class='form-group  col-lg-12'>
						<div class='form-group  col-lg-2'>
							<label>Skala Awal</label><br>
								<input type='text' name='s_awal' value='$awal' class='form-control '>
						</div>
						<div class='form-group  col-lg-2'>
							<label>Skala Akhir</label><br>
								<input type='text' name='s_akhir' value='$akhir' class='form-control '>
						</div>
						<div class='form-group  col-lg-2'>
							<label>Rentang Skala</label><br>
								<input type='text' name='rentang' value='$rentang' class='form-control '>
						</div>
						<div class='form-group  col-lg-12'>
							<h6><b>Grafik yang ditampilkan</b></h6>
						</div>
						<div class='form-group  col-lg-2'>
							<label>RKAP</label><br>
								<input type='radio' name='rkap' value='1'";if($rkap==1){echo"checked";} echo"> Ya
								<input type='radio' name='rkap' value='0'";if($rkap==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>Realisasi</label><br>
								<input type='radio' name='real' value='1'";if($real==1){echo"checked";} echo"> Ya
								<input type='radio' name='real' value='0'";if($real==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>RKAP Komulatif</label><br>
								<input type='radio' name='rkap_kom' value='1'";if($rkap_kom==1){echo"checked";} echo"> Ya
								<input type='radio' name='rkap_kom' value='0'";if($rkap_kom==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>Realisasi Komulatif</label><br>
								<input type='radio' name='real_kom' value='1'";if($real_kom==1){echo"checked";} echo"> Ya
								<input type='radio' name='real_kom' value='0'";if($real_kom==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>% Realisasi</label><br>
								<input type='radio' name='real_pro' value='1'";if($real_pro==1){echo"checked";} echo"> Ya
								<input type='radio' name='real_pro' value='0'";if($real_pro==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>% Komulatif</label><br>
								<input type='radio' name='kom_pro' value='1'";if($kom_pro==1){echo"checked";} echo"> Ya
								<input type='radio' name='kom_pro' value='0'";if($kom_pro==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-12'>
							<h6><b>Tabel yang ditampilkan</b></h6>
						</div>
						<div class='form-group  col-lg-2'>
							<label>RKAP</label><br>
								<input type='radio' name='trkap' value='1'";if($trkap==1){echo"checked";} echo"> Ya
								<input type='radio' name='trkap' value='0'";if($trkap==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>Realisasi</label><br>
								<input type='radio' name='treal' value='1'";if($treal==1){echo"checked";} echo"> Ya
								<input type='radio' name='treal' value='0'";if($treal==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>RKAP Komulatif</label><br>
								<input type='radio' name='trkap_kom' value='1'";if($trkap_kom==1){echo"checked";} echo"> Ya
								<input type='radio' name='trkap_kom' value='0'";if($trkap_kom==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>Realisasi Komulatif</label><br>
								<input type='radio' name='treal_kom' value='1'";if($treal_kom==1){echo"checked";} echo"> Ya
								<input type='radio' name='treal_kom' value='0'";if($treal_kom==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>% Realisasi</label><br>
								<input type='radio' name='treal_pro' value='1'";if($treal_pro==1){echo"checked";} echo"> Ya
								<input type='radio' name='treal_pro' value='0'";if($treal_pro==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>% Komulatif</label><br>
								<input type='radio' name='tkom_pro' value='1'";if($tkom_pro==1){echo"checked";} echo"> Ya
								<input type='radio' name='tkom_pro' value='0'";if($tkom_pro==0){echo"checked";} echo"> Tidak
						</div>					
					</div>
					<div class='form-group  col-lg-12'>
						<label></label>
						<input type='submit' value='Simpan' name='Simpan' class='btn btn-primary'>
					</div>
				</form>";
			}
			echo"
				<table class='table table-bordered table-striped table-hover' id='example2'>
				<thead>
					<tr>
						<th width='5%'>NO.</th>
						<th>TAHUN</th>
						<th>ID KPI</th>
						<th>ID PERSPEKTIF</th>
						<th>KPI</th>
						<th>BOBOT</th>
						<th>SATUAN</th>
						<th>TARGET TAHUNAN</th>
						<th>RUMUS</th>
						<th>PERHITUNGAN</th>
						<th></th>
					</tr>
				</thead>
				<tbody>";
				$no=1;
				$query = mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='$getid' ");
				while($r=mysql_fetch_array($query)){
					if($r['rumus']==1){
						$rumus = "Positif";
					}else{
						$rumus = "Negatif";
					}
					if($r['perhitungan']==1){
						$perhitungan = "Bulan Terakhir";
					}elseif($r['perhitungan']==2){
						$perhitungan = "Komulatif";
					}elseif($r['perhitungan']==3){
						$perhitungan = "Rata-rata";
					}
					echo"<tr>
							<td>$no</td> 
							<td>$r[tahun]</td> 
							<td>$r[id_kpi]</td> 
							<td>$r[id_perspektif]</td> 
							<td>$r[kpi]</td>
							<td>$r[bobot]</td>
							<td>$r[satuan]</td>
							<td>$r[target_tahun]</td>
							<td>$rumus</td>
							<td>$perhitungan</td>
							<td>";
								if($getEdit==1){
									echo" <a href='?page=form_kpku_kpi&opt=kpi_kpku&act=edit&idp=".ec($getid)."&id=".ec($r['id_kpi'])."' class='btn btn-xs btn-success' title='Edit Prespektif' ><i class='fa fa-pencil'></i></a>";
								}if($getDelete==1){
									echo" <a href='?page=form_kpku_kpi&opt=kpi_kpku&act=tambah&idp=".ec($getid)."&delete=".ec($r['id_kpi'])."' class='btn btn-xs btn-danger' title='Hapus Prespektif' ><i class='fa fa-trash'></i></a>";
								}
						echo"</td>
						</tr>";
					$no++;
				}
			echo"</tbody>
			</table>";
		}elseif($_GET['opt']=="kpi_kpku2"){
			if(isset($_REQUEST['delete'])){
			mysql_query("DELETE FROM kpku_kpi WHERE id_kpi='".mysql_real_escape_string(dc($_GET['delete']))."' ");
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
			
			if($_GET['act']=="tambah"){
				$tahun		= date("Y");
				// $id 		= mysql_fetch_array(mysql_query("SELECT MAX(id_kpi) as id FROM kpku_kpi WHERE id_perspektif='' AND tahun='$tahun'"));
				$id 		= mysql_fetch_array(mysql_query("SELECT MAX(id_kpi) as id FROM kpku_kpi"));
				$dp			= date("y");
				$kode		= $id['id'] +1; 
				// $ex			= explode(".",$id['id']);
				// $kd1		= $ex[0];
				// $kd2		= $ex[1]+1;
				// $id_baru	= $dp.".".$kd2;
				$id_srko	= "";
				$kpi		= "";
				$satuan		= "";
				$t_tahunan	= "";
				$rumus		= "";
				$perhitungan= "";
			}elseif($_GET['act']=="edit"){
				$id_baru 	= mysql_real_escape_string(dc($_GET['id']));
				$edit		= mysql_fetch_array(mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='' AND id_kpi='$id_baru' "));
				$tahun		= $edit['tahun'];
				$id_srko	= $edit['id_srko'];
				$kpi		= $edit['kpi'];
				$satuan		= $edit['satuan'];
				$t_tahunan	= $edit['target_tahun'];
				$rumus		= $edit['rumus'];
				$perhitungan= $edit['perhitungan'];
				$rkap		= $edit['v_rkap'];
				$real		= $edit['v_real'];
				$rkap_kom	= $edit['v_rkap_kom'];
				$real_kom	= $edit['v_real_kom'];
				$real_pro	= $edit['v_prosen_real'];
				$kom_pro	= $edit['v_prosen_kom'];
				$trkap		= $edit['t_rkap'];
				$treal		= $edit['t_real'];
				$trkap_kom	= $edit['t_rkap_kom'];
				$treal_kom	= $edit['t_real_kom'];
				$treal_pro	= $edit['t_prosen_real'];
				$tkom_pro	= $edit['t_prosen_kom'];
				$ex			= explode(":",$edit['scale']);
				$awal		= $ex[0];
				$akhir		= $ex[1];
				$rentang	= $ex[2];
				
			}
			
			// Ini Untuk KPI KPKU
			if($getInsert==1){
			echo"
				<form method='POST' action='page/mod_kpi/query_kpku_kpi.php?opt=kpi_kpku2&act=$_GET[act]' id='formku'>
					<div class='form-group  col-lg-6'>
						<div class='form-group  col-lg-4'>
							<label>Id KPI</label>
							<input type='text' name='id_kpi' class='form-control required' value='$kode' placeholder='Id KPI'>
							<input type='hidden' name='id_perspektif' class='form-control required' value='$getid' placeholder='Id Perspektif'>
						</div>
						<div class='form-group  col-lg-4'>
							<label>Id SRKO</label>
							<div class='input-group input-group'>
								<input type='text' name='id_srko' class='form-control' value='$id_srko' id='id_srko' placeholder='Id SRKO' readonly>
								<span class='input-group-btn'>
									<i class='glyphicon glyphicon-search btn btn-primary btn-flat edit-record' onclick='srko()'></i>
								</span>
							</div>
						</div>
						<div class='form-group  col-lg-4'>
							<label>Tahun</label>
							<input type='text' name='tahun' class='form-control required' value='".$tahun."' placeholder='Tahun'>
						</div>
						<div class='form-group  col-lg-12'>
							<label>KPI</label>
							<input type='text' name='kpi' class='form-control required' value='$kpi' placeholder='KPI'>
						</div>						
					</div>
					<div class='form-group  col-lg-6'>
						<div class='form-group  col-lg-4'>
							<label>Bobot</label>
							<input type='text' name='bobot' class='form-control required' value='".$bobot."' placeholder='Bobot'>
						</div>
						<div class='form-group  col-lg-4'>
							<label>Satuan</label>
							<input type='text' name='satuan' class='form-control required' value='".$satuan."' placeholder='Satuan'>
						</div>
						<div class='form-group  col-lg-4'>
							<label>Target Tahunan</label>
							<input type='text' name='t_tahunan' class='form-control required' value='".$t_tahunan."' placeholder='Target Tahunan'>
						</div>
						
						<div class='form-group  col-lg-6'>
							<label>Rumus</label>
							<select name='rumus' class='form-control '>
								<option value=''>-Jenis Rumus-</option>
								<option value='1'"; if($rumus==1){echo"selected";} echo">Positif</option>
								<option value='2'"; if($rumus==2){echo"selected";} echo">Negatif</option>
							</select>
						</div>
						<div class='form-group  col-lg-6'>
							<label>Perhitungan</label>
								<select name='perhitungan' class='form-control '>
									<option value='' >-Jenis Perhitungan-</option>
									<option value='1'"; if($perhitungan==1){echo"selected";} echo">Bulan Terakhir</option>
									<option value='2'"; if($perhitungan==2){echo"selected";} echo">Komulatif</option>
									<option value='3'"; if($perhitungan==3){echo"selected";} echo">Rata-rata</option>
								</select>
						</div>
					</div>					
					<div class='form-group  col-lg-12'>
						<div class='form-group  col-lg-2'>
							<label>Skala Awal</label><br>
								<input type='text' name='s_awal' value='$awal' class='form-control '>
						</div>
						<div class='form-group  col-lg-2'>
							<label>Skala Akhir</label><br>
								<input type='text' name='s_akhir' value='$akhir' class='form-control '>
						</div>
						<div class='form-group  col-lg-2'>
							<label>Rentang Skala</label><br>
								<input type='text' name='rentang' value='$rentang' class='form-control '>
						</div>
						<div class='form-group  col-lg-12'>
							<h6><b>Grafik yang ditampilkan</b></h6>
						</div>
						<div class='form-group  col-lg-2'>
							<label>RKAP</label><br>
								<input type='radio' name='rkap' value='1'";if($rkap==1){echo"checked";} echo"> Ya
								<input type='radio' name='rkap' value='0'";if($rkap==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>Realisasi</label><br>
								<input type='radio' name='real' value='1'";if($real==1){echo"checked";} echo"> Ya
								<input type='radio' name='real' value='0'";if($real==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>RKAP Komulatif</label><br>
								<input type='radio' name='rkap_kom' value='1'";if($rkap_kom==1){echo"checked";} echo"> Ya
								<input type='radio' name='rkap_kom' value='0'";if($rkap_kom==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>Realisasi Komulatif</label><br>
								<input type='radio' name='real_kom' value='1'";if($real_kom==1){echo"checked";} echo"> Ya
								<input type='radio' name='real_kom' value='0'";if($real_kom==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>% Realisasi</label><br>
								<input type='radio' name='real_pro' value='1'";if($real_pro==1){echo"checked";} echo"> Ya
								<input type='radio' name='real_pro' value='0'";if($real_pro==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>% Komulatif</label><br>
								<input type='radio' name='kom_pro' value='1'";if($kom_pro==1){echo"checked";} echo"> Ya
								<input type='radio' name='kom_pro' value='0'";if($kom_pro==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-12'>
							<h6><b>Tabel yang ditampilkan</b></h6>
						</div>
						<div class='form-group  col-lg-2'>
							<label>RKAP</label><br>
								<input type='radio' name='trkap' value='1'";if($trkap==1){echo"checked";} echo"> Ya
								<input type='radio' name='trkap' value='0'";if($trkap==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>Realisasi</label><br>
								<input type='radio' name='treal' value='1'";if($treal==1){echo"checked";} echo"> Ya
								<input type='radio' name='treal' value='0'";if($treal==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>RKAP Komulatif</label><br>
								<input type='radio' name='trkap_kom' value='1'";if($trkap_kom==1){echo"checked";} echo"> Ya
								<input type='radio' name='trkap_kom' value='0'";if($trkap_kom==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>Realisasi Komulatif</label><br>
								<input type='radio' name='treal_kom' value='1'";if($treal_kom==1){echo"checked";} echo"> Ya
								<input type='radio' name='treal_kom' value='0'";if($treal_kom==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>% Realisasi</label><br>
								<input type='radio' name='treal_pro' value='1'";if($treal_pro==1){echo"checked";} echo"> Ya
								<input type='radio' name='treal_pro' value='0'";if($treal_pro==0){echo"checked";} echo"> Tidak
						</div>
						<div class='form-group  col-lg-2'>
							<label>% Komulatif</label><br>
								<input type='radio' name='tkom_pro' value='1'";if($tkom_pro==1){echo"checked";} echo"> Ya
								<input type='radio' name='tkom_pro' value='0'";if($tkom_pro==0){echo"checked";} echo"> Tidak
						</div>					
					</div>
					<div class='form-group  col-lg-12'>
						<label></label>
						<input type='submit' value='Simpan' name='Simpan' class='btn btn-primary'>
					</div>
				</form>";
			}
				
			echo"
				<table class='table table-bordered table-striped table-hover' id='example2'>
				<thead>
					<tr>
						<th width='5%'>NO.</th>
						<th>TAHUN</th>
						<th>ID KPI</th>
						<th>KPI</th>
						<th>SATUAN</th>
						<th>TARGET TAHUNAN</th>
						<th>RUMUS</th>
						<th>PERHITUNGAN</th>
						<th></th>
					</tr>
				</thead>
				<tbody>";
				$tahun = dc($_GET['tahun']);
				$no=1;
				$query = mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='' AND Tahun='$tahun' ");
				while($r=mysql_fetch_array($query)){
					if($r['rumus']==1){
						$rumus = "Positif";
					}else{
						$rumus = "Negatif";
					}
					if($r['perhitungan']==1){
						$perhitungan = "Bulan Terakhir";
					}elseif($r['perhitungan']==2){
						$perhitungan = "Komulatif";
					}elseif($r['perhitungan']==3){
						$perhitungan = "Rata-rata";
					}
					echo"<tr>
							<td>$no</td> 
							<td>$r[tahun]</td> 
							<td>$r[id_kpi]</td> 
							<td>$r[kpi]</td>
							<td>$r[satuan]</td>
							<td>$r[target_tahun]</td>
							<td>$rumus</td>
							<td>$perhitungan</td>
							<td>";
								if($getEdit==1){
									echo" <a href='?page=form_kpku_kpi&opt=kpi_kpku2&act=edit&id=".ec($r['id_kpi'])."' class='btn btn-xs btn-success' title='Edit Prespektif' ><i class='fa fa-pencil'></i></a>";
								}if($getDelete==1){
									echo" <a href='?page=form_kpku_kpi&opt=kpi_kpku2&tahun=".ec($tahun)."&act=tambah&delete=".ec($r['id_kpi'])."' class='btn btn-xs btn-danger' title='Hapus Prespektif' ><i class='fa fa-trash'></i></a>";
								}
						echo"</td>
						</tr>";
					$no++;
				}
			echo"</tbody>
			</table>";
		}elseif($_GET['opt']=="rkap"){
			// if(isset($_REQUEST['delete'])){
			// mysql_query("DELETE FROM kpku_kpi WHERE id_kpi='".mysql_real_escape_string(dc($_GET['delete']))."' ");
			// echo"<div class='alert alert-danger alert-dismissable'>
					// <i class='fa fa-check'></i>
						// <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// <b>Succes!</b> Data Berhasil Dihapus.
				// </div>";
			// }
			// if(isset($_REQUEST['succes'])){
				// echo"<div class='alert alert-success alert-dismissable'>
						// <i class='fa fa-check'></i>
							// <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						// <b>Succes!</b> Data Berhasil Disimpan.
					// </div>";
			// }
			
			if($_GET['act']=="tambah"){
				$getId		= mysql_real_escape_string(dc($_GET['idp']));
				$id 		= mysql_fetch_array(mysql_query("SELECT MAX(id_rkap) as id FROM target_rkap"));
				$id_baru	= $id['id']+1;
				$tahun		= date("Y");
				$kpi		= "";
				$satuan		= "";
				$t_tahunan	= "";
			}elseif($_GET['act']=="edit"){
				$id_baru 	= mysql_real_escape_string(dc($_GET['id']));
				$edit		= mysql_fetch_array(mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='' AND id_kpi='$id_baru' "));
				$tahun		= $edit['tahun'];
				$kpi		= $edit['kpi'];
				$satuan		= $edit['satuan'];
				$t_tahunan	= $edit['target_tahun'];
			}
			if($getInsert==1){
		// echo"<form method='POST' action='page.php?page=form_kpku_kpi&opt=rkap&act=tambah' id='formku'>
				// <div class='form-group  col-lg-12 row'>
					// <div class='form-group  col-lg-2'>
						// <input type='hidden' name='page' value='form_kpku_kpi'>
						// <input type='hidden' name='opt' value='rkap'>
						// <select name='bulan' class='form-control required'>
							// <option value=''>Pilih Bulan</option>";
									// for($i=1;$i<=12;$i++){
										// echo"<option value='$i'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
									// }
					// echo"</select>
					// </div>
					// <div class='form-group  col-lg-1'>
						// <input type='text' name='tahun' class='form-control required' value='".date("Y")."' placeholder='Tahun'>
					// </div>
					// <div class='form-group  col-lg-3'>
						// <input type='submit' value='Pilih' class='btn btn-primary'>
					// </div>
				// </div>
			// </form>";
		?>
		<form method='POST' action='page/mod_kpi/query_kpku_kpi.php?opt=rkap&act=<?=$_GET['act']?>' id='formku'>
			<h4><b>KEY PERFORMANCE INDICATORS & TARGET-TARGETNYA</b></h4>
			<table width="100%" border="1" cellpadding="3">
				<thead>
					<tr align="center">
						<td width="5%" rowspan="2"><b>No</b></td>
						<td rowspan="2"><b>PERSPEKTIF & KPI KPKU</b></td>
						<td rowspan="2"><b>BOBOT</b></td>
						<td rowspan="2"><b>SATUAN</b></td>
						<td rowspan="2"><b>TARGET TAHUNAN</b></td>
						<td colspan="12"><b>BULAN</b></td>
					</tr>
					<tr align="center">
						<?php
						for($i=1;$i<=12;$i++){
							echo"<td><b>".bulan($i)."</b></td>";
						}
						?>
					</tr>
				</thead>
				<tbody>
				<?php
				// if(isset($_POST['opt'])){
					$query = mysql_query("SELECT * FROM kpku_perspektif WHERE tahun='$tahun' Order by id_perspektif ASC ");
					// $query = mysql_query("SELECT * FROM kpku_perspektif ");
					while($r=mysql_fetch_array($query)){
					echo"<tr>
							<td colspan='17'><b>$r[id_perspektif] $r[perspektif]</b></td>
						</tr>";
						$query2 = mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='$r[id_perspektif]' ");
						while($r2=mysql_fetch_array($query2)){							
						echo"
							<input type='hidden' name='tahun' value='$tahun_aktif' class='form-control'>
							<tr>
								<td align='center'>$r2[id_kpi] </td>
								<td>$r2[kpi] </td>
								<td align='center'>$r2[bobot]</td>
								<td align='center'>$r2[satuan]</td>
								<td align='center'>$r2[target_tahun]</td>";
								for($i=1;$i<=12;$i++){
									$target = mysql_fetch_array(mysql_query("SELECT target_rkap FROM target_rkap WHERE id_kpi='$r2[id_kpi]' 
																		AND id_perspektif='$r[id_perspektif]' 
																		AND bulan='$i' 
																		AND tahun='$tahun_aktif' "));
									echo"<td>
										<input type='hidden' name='satuan[]' value='$r2[satuan]' class='form-control'>
										<input type='hidden' name='id_kpi[]' value='$r2[id_kpi]' class='form-control'>
										<input type='hidden' name='id_perspektif[]' value='$r2[id_perspektif]' class='form-control'>
										<input type='hidden' name='bulan[]' value='$i' class='form-control'>
										<input type='text' name='rkap[]' value='$target[target_rkap]' class='form-control'>
									</td>";
								}
							echo"
							</tr>";
						}
					}
				// }
				?>
				</tbody>
			</table>
			<hr>
			<h4><b>SASARAN KINERJA LAINNYA</b></h4>
			<table width="100%" border="1" cellpadding="3">
				<thead>
					<tr align="center">
						<td width="5%" rowspan="2"><b>No</b></td>
						<td rowspan="2"><b>PERSPEKTIF & KPI KPKU</b></td>
						<td rowspan="2"><b>SATUAN</b></td>
						<td rowspan="2"><b>TARGET TAHUNAN</b></td>
						<td colspan="12"><b>BULAN</b></td>
					</tr>
					<tr align="center">
						<?php
						for($i=1;$i<=12;$i++){
							echo"<td><b>".bulan($i)."</b></td>";
						}
						?>
					</tr>
				</thead>
				<tbody>
				<?php
				// if(isset($_POST['opt'])){
					$query = mysql_query("SELECT * FROM kpku_kpi WHERE id_perspektif='' AND tahun='$tahun_aktif'");
					while($r=mysql_fetch_array($query)){						
						echo"
							
							<input type='hidden' name='tahun' value='$tahun_aktif' class='form-control'>
							<tr>
								<td align='center'>$r[id_kpi]</td>
								<td>$r[kpi]</td>
								<td align='center'>$r[satuan]</td>
								<td align='center'>$r[target_tahun]</td>";
								for($i=1;$i<=12;$i++){
									$target = mysql_fetch_array(mysql_query("SELECT target_rkap FROM target_rkap WHERE id_kpi='$r[id_kpi]'
																		AND bulan='$i' 
																		AND tahun='$tahun_aktif' "));
									echo"<td>
										<input type='hidden' name='satuan2[]' value='$r[satuan]' class='form-control'>
										<input type='hidden' name='id_kpi2[]' value='$r[id_kpi]' class='form-control'>
										<input type='hidden' name='bulan2[]' value='$i' class='form-control'>
										<input type='text' name='rkap2[]' value='$target[target_rkap]' class='form-control'>
									</td>";
								}
							echo"
							</tr>";
					}
				// }
				?>
				</tbody>
			</table>
			<hr>
			<div class='form-group  col-lg-3'>
				<input type='submit' value='Simpan' name="Simpan" class='btn btn-primary'>
			</div>
		</form>
		<?php
			}
		}
		?>
		</div>
	</div>