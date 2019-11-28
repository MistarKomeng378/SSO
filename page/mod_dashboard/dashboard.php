

<h1 class="page-header">Dashboard <small><?=$_SESSION['nm_level']?></small></h1>
		
	
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
					// $data=mysql_query("SELECT * FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' 	
										// ORDER BY id_srko");
					
					$data=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT id_srko) as JumlahID FROM progress_srko_detile WHERE  tahun='$getTahun' AND cc='$getCC'"));
										
					$data1=mysql_query("SELECT	* FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' 
									ORDER BY id_srko");
									
					$data2=mysql_query("SELECT	* FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' 
									ORDER BY id_srko");
					}
				?>
				<script>
					var myLabels=[
					<?php 
						for($id=1; $id<=$data['JumlahID']; $id++){
							echo $id.",";
						}
						// while($info=mysql_fetch_array($data))
							// echo '"'.$info['id_srko'].'",';
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
					
					
					<div class='table-responsive'>
						<table width='90%' align='center'>
							<thead>
								<tr align='center'> 
									<?
									$Idss=mysql_query("SELECT * FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCC' ORDER BY id_srko");
									while($cv = mysql_fetch_array($Idss)){
										//$sr = mysql_fetch_array(mysql_query("SELECT rencana_kerja, id_srko FROM srko where id_srko='$cv[id_srko]'"));
										
										echo"<td>
												<a href='#modal-message2' class='detile-srko' data-id='".ec($cv['id_srko'])."-".ec($getBulan)."-".ec($getTahun)."-".ec($getCC)."' data-toggle='modal'>".$cv['id_srko']."</a>
											</td>";
									}
									?>								
								</tr>
								
							</thead>
						</table>
					</div>
					
				</div>
				
				<div class='col-lg-12'>
				<?php
					if(isset($_POST['cari'])){
					
					echo"
						<br><br><br>
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
            $(document).on('click','.detile-srko',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_dashboard/detail-grafik.php',
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
				<?$ms = mysql_fetch_array(mysql_query("select * from mskko where CostCenter='$getCC'"));  ?>
				<h4 class="modal-title"><?=$ms['uraian']?></h4>
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