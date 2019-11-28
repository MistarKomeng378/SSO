		<h1 class="page-header">Dashboard <small><?=$_SESSION['nm_level']?></small></h1>
			
			
			<div class="row">
				<!--
				<div class="col-md-4 col-sm-6">
					<div class="widget widget-stats bg-green">
						<div class="stats-icon"><i class="fa fa-folder-open fa-lg"></i></div>
						<div class="stats-info">
							<h4>AKTIFITAS BULAN INI</h4>
							<?php
								// $jmlwk = mysql_num_rows(mysql_query("SELECT id_gca FROM waktu_kerja2 WHERE nik='$_SESSION[nik]' AND bulan='".date("m")."' AND tahun='$tahun_aktif'"));
								// echo"<p>$jmlwk Aktifitas</p>";
							?>								
						</div>
						<div class="stats-link">
							<a href='#modal-message' class='gca-detail' data-id='<?php echo"".ec($_SESSION['nik'])."-".ec(date("m"))."-".ec($tahun_aktif)."-".ec($_SESSION['cc'])."";?>' data-toggle='modal'>View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				-->
				<!--////////////////////////====================
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-blue">
						<div class="stats-icon"><i class="fa fa-edit fa-lg"></i></div>
						<div class="stats-info">
							<h4>MSKK BULAN LALU </h4>
							<?php
								
								// $bulanLalu = date("m") - 1;
								// $tahun_MSKK = $tahun_aktif;
								// if($bulanLalu == 0){
									// $bulanLalu = 12;
									// $tahun_MSKK = $tahun_aktif - 1;
								// }
								// $nilaiMSKK = mysql_fetch_array(mysql_query("SELECT SUM(bxs) AS nilai FROM mskk WHERE nik='$_SESSION[nik]' AND bulan='$bulanLalu' AND tahun='$tahun_MSKK' "));
								// echo"<p>".desimal($nilaiMSKK['nilai'])."</p>";
							?>
						</div>
						<div class="stats-link">
							<a href='#modal-mskk' class='show-mskk' data-id='<?=ec($bulanLalu)."-".ec($tahun_MSKK)."-".ec($_SESSION['cc'])."-".ec($_SESSION['nik'])?>' data-toggle='modal'>View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!--
				
				<div class="col-md-4 col-sm-6">
					<div class="widget widget-stats bg-purple">
						<div class="stats-icon"><i class="fa fa-database fa-lg"></i></div>
						<div class="stats-info">
							<h4>JUMLAH GCA TAHUN INI</h4>
							<?php
								$jmlGCA = mysql_num_rows(mysql_query("SELECT id FROM wbs WHERE pic='$_SESSION[nik]' AND tahun='$tahun_aktif' AND jenisGCA='2'"));
								echo"<p>$jmlGCA GCA</p>";
							?>	
						</div>
						<div class="stats-link">
							<a href='#modal-message' class='jml-gca' data-id='<?php echo"".ec($_SESSION['nik'])."-".ec($tahun_aktif)."-".ec($_SESSION['cc'])."";?>' data-toggle='modal'>View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="widget widget-stats bg-red">
						<div class="stats-icon"><i class="fa fa-ban fa-lg"></i></div>
						<div class="stats-info">
							<h4>GCA BELUM DIREALISASIKAN</h4>
							<?php
								$GCAminKKWK = mysql_num_rows(mysql_query("SELECT DISTINCT jo_gca FROM pencapaian INNER JOIN wbs ON wbs.id = pencapaian.jo_gca WHERE nik='$_SESSION[nik]' AND DATE_FORMAT(tgl_aktifitas,'%Y')='$tahun_aktif' "));
								$notREAL	= $jmlGCA - $GCAminKKWK;
								echo"<p>$notREAL GCA</p>";
							?>	
						</div>
						<div class="stats-link">
							<a href='#modal-message' class='gca-noreal' data-id='<?php echo"".ec($_SESSION['nik'])."-".ec($tahun_aktif)."-".ec($_SESSION['cc'])."-".ec($_SESSION['cc'])."";?>' data-toggle='modal'>View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		-->	
			
			
	<div class="row">
		<!--
		<div class='alert alert-success alert-dismissable'>
			<i class='fa fa-check'></i><b> New Update</b>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<ul>
			
				<li>Jika tahun 2017 pengisian kita real time (pagi langsung isi dan jam yang terecord adalah jam saat kita klik submit dan selesai), maka di tahun 2018 ini kita tidak real time, kita bisa mengisikan KKWK (semua aktivitas selama sehari) pada saat aktivitas tersebut selesai pada hari atau jam pulang. Dan apabila hari itu kita lupa mengisi KKWK masih di berikan wktu 3 hari untuk mengisikannya.</li>
				<li>Aktivitas yang Non Rutin apabila diisikan Progressnya 100% maka jika di kemudian hari ingin diambil lagi, tidak dapat diambil karena dianggap sudah selesai. Sedangkan pekerjaan Rutin dapat diambil berulang kali walaupun kita isikan progressnya 100%.</li>
				<li>User harus mengisikan rencana / alokasi jam kerja pada <b>GCA Load</b> terlebih dahulu untuk bisa mengisi KKWK.</li>
				<li>Untuk performa yang maksimal disarankan membersikan <b>Cached</b> pada browser yang digunakan terlebih dahulu.</li>
			
			</ul>
        </div>
		
	<div class="col-md-8">
		<div class="panel panel-inverse" data-sortable-id="index-1">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				</div>
				<h4 class="panel-title">Program Kerja Hari ini</h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table" id="example3">
						<thead>
							<tr>
								<th>No</th>
								<th>Id</th>
								<th>Aktifitas</th>
								<th>Mulai</th>
								<th>Selesai</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								$day	= date("j");
								$month	= date("n");	
								$query = mysql_query("SELECT	waktu_kerja2.nik,
																waktu_kerja2.id_gca,
																waktu_kerja2.`$day`,
																wbs.aktivitas,
																wbs.mulai,
																wbs.hasil_akhir,
																wbs.akhir
																FROM
																waktu_kerja2
																INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca
																WHERE 
																waktu_kerja2.nik='$_SESSION[nik]'
																AND wbs.`pic` ='$_SESSION[nik]'
																AND wbs.`jenisGCA` ='2'
																AND waktu_kerja2.bulan='$month' 
																AND waktu_kerja2.`$day`>='1' 
																AND waktu_kerja2.tahun='$tahun_aktif'
																");
								while($r=mysql_fetch_array($query)){
									echo"
									<tr>
										<td>$no</td>
										<td>$r[id_gca]</td>
										<td>$r[aktivitas]</td>
										<td>$r[mulai]</td>
										<td>$r[akhir]</td>										
										<td>";
										// echo"
											// <a href='?page=form_kkwk&opt=tambah2&id=".ec($r['id_gca'])."' class='btn btn-xs btn-primary' title='Buat KKWK Untuk Program Kerja Ini'><i class='fa fa-pencil'></i></a>";
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
		<div class="panel panel-inverse" data-sortable-id="index-2">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				</div>
				<h4 class="panel-title">Resource</h4>
			</div>
			<div class="panel-body p-t-0">
			<div class="table-responsive">
				<table class="table table-valign-middle m-b-0">
					<thead>
						<tr>	
							<th>File</th>
							<th>Type</th>
							<th>Size</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
						function formatBytes($size, $precision = 2)
						{
							$base = log($size, 1024);
							$suffixes = array('', 'K', 'M', 'G', 'T');   

							return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
						}
						$qrescource = mysql_query("SELECT * FROM resource_file");
						while($r=mysql_fetch_array($qrescource)){
							$ex			= explode(".",$r['file']);
							echo"
							<tr>
								<td>$ex[0]</td>
								<td>$ex[1]</td>
								<td>".formatBytes($r['size'],2)."</td>
								<td><a target='_blank' href='page/mod_dashboard/download.php?id=".ec($r['id_resource'])."'><i class='fa fa-lg fa-download'></i></a></td>
							</tr>
							";
						}
					?>
					</tbody>
				</table>
			</div>
			</div>
		</div>
		
	</div>
	
	<div class="col-md-4">
		<div class="panel panel-inverse" data-sortable-id="index-3">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				</div>
			<h4 class="panel-title">Notifikasi GCA</h4>
			</div>
			<div class="panel-body">
			<div class="table-responsive">
			<table class="table table-valign-middle m-b-0">
					<thead>
						<tr>	
							<th>Bulan</th>
							<th>Hari Kerja</th>
							<th>Total Jam/Bulan</th>
							<th>Jam Kerja</th>
						</tr>
					</thead>
					<tbody>
				<?php
					$jambul = mysql_query("SELECT * FROM jam_bulanan WHERE tahun='$tahun_aktif'");
					while($r=mysql_fetch_array($jambul)){
						$jml_wk = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum_jam FROM waktu_kerja2 WHERE nik='$_SESSION[nik]' AND bulan='$r[bulan]' AND tahun='$r[tahun]'"));
						
						if($jml_wk['jum_jam'] != $r['jam_bulanan']){
							$fontColor="red"; 
						}else{
							$fontColor="black"; 
						}
						echo"
						<tr>
							<td>".bulan($r['bulan'])."</td>
							<td>$r[hari_kerja]</td>
							<td>$r[jam_bulanan]</td>
							<td><a href='#modal-message' class='gca-detail' data-id='".ec($_SESSION['nik'])."-".ec($r['bulan'])."-".ec($r['tahun'])."-".ec($_SESSION['cc'])."' data-toggle='modal'><span style=\"color:$fontColor\"><b>$jml_wk[jum_jam]</b></span></a></td>
						</tr>";
					}
				?>
				</tbody>
			</table>
			</div>
			</div>
		</div>	
	</div>
	-->
</div>
	
<div class="row">
		<div class="col-md-12">
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				</div>
				<h4 class="panel-title">Progress bar</h4>
			</div>
			<div class="panel-body">
				<?php
				
				$getBulanNow	= mysql_real_escape_string(dc($_GET['bulan']));
				$getBulan		= mysql_real_escape_string($_POST['bulan']);
				$getTahunNow	= mysql_real_escape_string(dc($_GET['tahun']));
				$getTahun		= mysql_real_escape_string($_POST['tahun']);
				$getCC			= mysql_real_escape_string($_POST['unit']);
				
				
				
					echo"
				<form method='POST' action='page.php?page=dashboard' id='formku'>
					<div class='form-group  col-lg-12 row'>
						<div class='form-group  col-lg-3'>
							<input type='hidden' name='page' value='grafik'>
							<input type='hidden' name='cari' value='cari'>
							<select name='bulan' class='form-control '>
								<option value=''>Pilih Bulan</option>";
									for($i=1;$i<=12;$i++){
										echo"<option value='$i'"; if($getBulanNow==$i){echo"selected";}elseif($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
									}
						echo"</select>
						</div>
						<div class='form-group  col-lg-2'>
							<select name='tahun' class='form-control '>
								<option value=''>Pilih Tahun</option>";
									$qsbdth = mysql_query("SELECT * FROM tahun");
									while($r=mysql_fetch_array($qsbdth)){
										echo"<option value='$r[tahun]'"; if($getTahunNow==$r['tahun']){echo"selected";}elseif($getTahun==$r['tahun']){echo"selected";} echo">$r[tahun]</option>";
									}
						echo"</select>
						</div>
						<div class='form-group  col-lg-4'>
							<select name='unit' class='form-control'>
								<option value=''>Pilih Unit</option>";
										$qunit = mysql_query("SELECT * FROM mskko WHERE id!='1.6' AND id !='4' order by id");
										while($unit=mysql_fetch_array($qunit)){
											echo"<option value='$unit[CostCenter]'"; if($cc==$unit['CostCenter']){echo"selected";}elseif($getCC==$unit['CostCenter']){echo"selected";} echo">$unit[uraian]</option>";
											
										}
						
						echo"</select>
						</div>
						<div class='form-group  col-lg-3'>
							<input type='submit' value='Pilih' class='btn btn-primary'>
						</div>
					</div>
				</form>
				";
					if(isset($_POST['cari'])){
					$data=mysql_query("SELECT * FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' 	
										ORDER BY id_srko");
										
					$data1=mysql_query("SELECT	* FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' 
									ORDER BY id_srko");
									
					$data2=mysql_query("SELECT	* FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' 
									ORDER BY id_srko");
					}
				?>
				<script>
					var myLabels=[
					<?php 
						while($info=mysql_fetch_array($data))
							echo '"'.$info['id_srko'].'",';
					?>
					];
					var myData=[
					<?php 
						while($info=mysql_fetch_array($data1))
							echo desimal3($info['target']).",";
					?>
					];
					var myData2=[
					<?php 
						while($info=mysql_fetch_array($data2))
							echo desimal3($info['realisasi']).",";
					?>
					];
				</script>
				<div class='col-lg-12'>
					<script src="assets/js/zingchart/zingchart.min.js"></script>
					<div id="myChart"></div>
					  <script>
						var myConfig = {
							"graphset":[
								{
									"type":"bar",
									"title":{
										"text":"Progress Pencapaian Unit Bulan <?=bulan($getBulan)?> "
									},
									"plot": {
										"value-box": {
										  "text": "%v"
										},
										"tooltip": {
										  "text": "%v"
										}
									 },
									"legend": {
										"toggle-action": "hide",
										"header": {
										  "text": "Legenda"
										},
										"item": {
										  "cursor": "pointer"
										},
										"draggable": true,
										"drag-handler": "icon"
									},
									 // Ini Isi Grafik //
									"scale-x":{
										"labels": myLabels
									},
									
									"series":[
										{
											"values": myData,
											"text" : "Target"
										},
										{
											"values": myData2,
											"text" : "Realisasi"
										}
									]
								}
							]
						};
						
						zingchart.render({ // Render Method
						  id: "myChart",
						  data: myConfig,
						  height: 450,
						  width: "100%",
						  autoResize: true
						});
					  </script>
				</div>
				<div class='col-lg-12'>
				<?php
					if(isset($_POST['cari'])){
						
						echo"
						<a href='?page=data_progress_srko&unit=".ec($getCC)."&tahun=".ec($getTahun)."' target='_blank' class='btn btn-primary'><i class='fa fa-table'></i> Target & Progress Tahunan</a> 
						<a href='print/print_progress_srko.php?id=".ec($getCC)."-".ec($getBulan)."-".ec($getTahun)."' target='_blank' class='btn btn-success'><i class='fa fa-download'></i> Download</a>
						<br>
						<br>
						<div class='table-responsive'>
						<table class='table table-bordered'>
							<thead>
								<tr align='center' bgcolor='#b3d9ff'>
									<td rowspan='2'><b>ID.</b></td>
									<td rowspan='2'><b>Sasaran/Rencana Kerja</b></td>
									<td rowspan='2'><b>Bobot</b></td>
									<td rowspan='2'><b>Target Tahunan</b></td>
									<td colspan='3'><b>Bulan Ini</b></td>
									<td colspan='3'><b>S/d Bulan Ini</b></td>
								</tr>
								<tr bgcolor='#b3d9ff'>
									<td><b>Target</b></td>
									<td><b>Realisasi</b></td>
									<td><b>Pencapaian</b></td>
									<td><b>Target</b></td>
									<td><b>Realisasi</b></td>
									<td><b>Pencapaian</b></td>		
								</tr>								
							</thead>
							<tbody>";
							$query = mysql_query("SELECT DISTINCT id_srko,rencana_kerja,bobot,target,satuan,hasil_akhir FROM srko WHERE CostCenter='$getCC' AND tahun='$getTahun' AND parent_srko=''order by id_srko");							
							while($r=mysql_fetch_array($query)){
								
								$target = mysql_fetch_array(mysql_query("SELECT target FROM target_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								
								$prog 	= mysql_fetch_array(mysql_query("SELECT pencapaian,realisasi,jenis_resume,jenis_pencapaian FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								
								$jrbul	= mysql_fetch_array(mysql_query("SELECT COUNT(realisasi) as bln FROM progress_srko_detile WHERE tahun='$getTahun' AND id_srko='$r[id_srko]' AND realisasi!=''"));
								
								if($prog['jenis_resume']==1){  //Bulan Terakhir
									$jr1 		= mysql_fetch_array(mysql_query("SELECT target FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$tot_target = desimal3($jr1['target']);
									$tt 		= $jr1['target'];
									$jr11 		= mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$realisasi 	= desimal3($jr11['realisasi']);
									$rea	 	= $jr11['realisasi'];
									
								}elseif($prog['jenis_resume']==2){  //Komulatif
									$jr2 		= mysql_fetch_array(mysql_query("SELECT SUM(target) as sumtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$tot_target = desimal3($jr2['sumtarget']);
									$tt 		= $jr2['sumtarget'];
									$jr22 		= mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as sumrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$realisasi 	= desimal3($jr22['sumrealisasi']);
									$rea 		= $jr22['sumrealisasi'];
									
								}elseif($prog['jenis_resume']==3){  //Rata-Rata
									$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$tot_target = desimal3($jr3['avgtarget']);
									$tt 		= $jr3['avgtarget'];
									$jr33 		= mysql_fetch_array(mysql_query("SELECT AVG(realisasi) as avgrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$realisasi 	= desimal3($jr33['avgrealisasi']);
									$rea 		= $jr33['avgrealisasi'];
									
								}elseif($prog['jenis_resume']==4){  //Prof. Margin
									$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$tot_target = desimal3($jr3['avgtarget']);
									$tt 		= $jr3['avgtarget'];								
									$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									$tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100; 
									$realisasi 	= desimal3($tpm);
									$rea 		= $tpm;
								}
								if($prog['jenis_pencapaian']==1){  //Positif
									if($tt==0 AND $rea>0){
										$hasil = 100;
									}elseif($tt>0 AND $rea<=0){
										$hasil = 0;
									}elseif($tt==0 AND $rea<=0){
										$hasil = 100;
									}else{
										$hasil = ($rea/$tt)*100;
									}	
									
								}elseif($prog['jenis_pencapaian']==2){  //Negatif
									if($tt==0 AND $rea>0){
										$hasil = 100;
									}elseif($tt>0 AND $rea<=0){
										$hasil = 0;
									}elseif($tt==0 AND $rea<=0){
										$hasil = 100;
									}else{
										$hasil = (($tt - ($rea-$tt)) / $tt) * 100;
									}
									
								}elseif($prog['jenis_pencapaian']==3){  //Prof. Margin
									if($tt==0 AND $rea>0){
										$hasil = 100;
									}elseif($tt>0 AND $rea<=0){
										$hasil = 0;
									}elseif($tt==0 AND $rea<=0){
										$hasil = 100;
									}else{
										$hasil = ($rea/$tt)*100;
									}
								}
								if($hasil <= 0){
									$pencapaian=0;
								}elseif($hasil > 0){
									if($hasil>120){
										$pencapaian=120;
									}else{
										$pencapaian=desimal3($hasil);
									}
								}
								if($pencapaian < 100){
									$fc1="red";
								}else{
									$fc1="";
								}
								if($prog['pencapaian'] < 100){
									$fc2="red";
								}else{
									$fc2="";
								}
								$jmlKet = mysql_num_rows(mysql_query("SELECT id_ket FROM ket_progress_srko WHERE id_srko='$r[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' "));
								////////////////// Baris ISI
								echo"
								<tr>
									<td align='center'>
										<a href='lookup/ket_progress.php?id=".ec($r['id_srko'])."-".ec($getBulan)."-".ec($getTahun)."-".ec($getCC)."' class='btn btn-xs btn-success popup'  title='Lihat Keterangan'>$r[id_srko] ($jmlKet)</a>
										<div class='btn-group'>
											<button type='button' class='btn btn-xs btn-primary dropdown-toggle' data-toggle='dropdown'>
												<span class='caret'></span>
												<span class='sr-only'>Toggle Dropdown</span>
											</button>
											<ul class='dropdown-menu' role='menu'>";
												if($getInsert==1){
													echo"<li><a target='_blank' href='?page=ket_progress&unit=".ec($r['id_srko'])."-".ec($getCC)."-".ec($getBulan)."-".ec("X")."-".ec($getTahun)."&opt=view' title='Input Keterangan' ><i class='fa fa-plus'></i> Input Keterangan</a></li>";
												}
											echo"
											</ul>
										</div>
									</td>
									<td>$r[rencana_kerja]</td>
									<td align='center'>$r[bobot]</td>
									<td>$r[target] $r[satuan]</td>
									<td align='center' bgcolor='#99ff99' title='Target - Bulanan Ini'>".desimal3($target['target'])."</td>
									<td align='center' bgcolor='#99ff99' title='Realisasi - Bulanan Ini'>"; //Realisasi
										if($r['hasil_akhir']=="P"){ //Awal P
											echo"<a href='lookup/ket_realisasi.php?id=".ec($r['id_srko'])."-".ec($getBulan)."-".ec($getTahun)."-".ec($getCC)."' class='btn btn-xs btn-success popup'  title='Lihat Keterangan'>";
										}
											
											if($prog['jenis_pencapaian']==3){
												echo desimal3($prog['realisasi']);
											}else{
												echo desimal3($prog['realisasi']);
											}
										
										if($r['hasil_akhir']=="P"){
											echo"</a>";
										}
										
									echo"
									</td>
									<td align='center' bgcolor='#99ff99' title='Pencapaian - Bulanan'><span style=\"color:$fc2\">".desimal3($prog['pencapaian'])." %</span></td>
									<td align='center' bgcolor='#FFD700' title='Target - s/d Bulan Berjalan'>$tot_target</td>
									<td align='center' bgcolor='#FFD700' title='Realisasi - s/d Bulan Berjalan'>";
										if($prog['jenis_pencapaian']==3){
											echo desimal3($realisasi);
										}else{
											echo"$realisasi";
										}
									echo"</td>
									<td align='center' bgcolor='#FFD700' title='Pencapaian - s/d Bulan Berjalan'><span style=\"color:$fc1\">$pencapaian %</span></td>
								</tr>
								";
							}
						echo"</tbody>
						</table>
						</div>
						";
					}
				?>
				</div>
			</div>
		</div>
		</div>
	</div>

<script>
        $(function(){
            $(document).on('click','.edit-record',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_kkwk/form_selesai.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal fade" id="modal-alert">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Form Isian Hasil Kerja</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<script>
        $(function(){
            $(document).on('click','.gca-detail',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_gca/gca_bulanan.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
        $(function(){
            $(document).on('click','.jml-gca',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_gca/gca_tahun.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
		$(function(){
            $(document).on('click','.gca-noreal',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_gca/gca_noreal.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal fade" id="modal-message">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Detail GCA</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<script>
        $(function(){
            $(document).on('click','.progress-detail',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_target_srko/ket_progress.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal fade" id="modal-message2">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Keterangan Progress</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
 <script>
        $(function(){
            $(document).on('click','.show-mskk',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_laporan/detail_summary_mskk.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal  fade" id="modal-mskk">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Detail MSKK</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<!-------------------------------awal dari color box------------------------------------>
<script type="text/javascript" src="assets/plugins/jquerycolorbox/jquery.colorbox.js"></script>
<link  rel="stylesheet" type="text/css" href="assets/plugins/jquerycolorbox/colorbox/colorbox.css" />
<!-------------------------------akhir dari color box------------------------------------>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".popup").colorbox({ 		iframe:true		,width:"50%"		,height:"70%"	});
	});
</SCRIPT>