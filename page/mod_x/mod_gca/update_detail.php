<?php
	$ex		= explode("-",$_GET['id']);
	$month	= dc($ex[1]); 
	$year	= dc($ex[2]); 
	$day	= date("d");
	$nik	= dc($ex[0]);
	
	// $data = mysql_fetch_array(mysql_query("SELECT * FROM m_karyawan WHERE regno='$nik'"));
?>
<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="assets/plugins/toltip/show_ads.js"></script>

	<h1 class="page-header">GCA Load
		<small><?=$_SESSION['nm_level']?></small>
	</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Update Aktifitas <?=name($nik)?> pada bulan <?=bulan2($month)." - ".$year?></h4>
		</div>
		<div class="panel-body">
				<!--<p><form 
					Setting semua data dari <input type='text' name='nilai_1' value='' size='2'> 
					Jam menjadi <input type='text' name='nilai_2' value='' size='2'> 
					Jam, pada baris <input type='text' name='baris' value='' size='2'>
				</p>-->
			<div class="table-responsive">
				<form method="POST" action="page/mod_gca/aksi_update_baris.php">
					<input type="hidden" name="bulan" value="<?=$month?>" size="4" >
					<input type="hidden" name="tahun" value="<?=$year?>" size="4">
					<input type="hidden" name="nik" value="<?=$nik?>" size="4">
					Setting semua data dari <input type="text" name="jam_awal" value="" size="4" autocomplete="off"> Jam, 
					Menjadi<input type="text" name="set_jam" value="" size="4" autocomplete="off"> Jam, 
					Pada baris <input type="text" name="baris" value="" size="4" autocomplete="off"> 
					<button type="submit" name="simpan" value="simpan" class="btn btn-xs btn-primary">Submit</button>
				</form>
				<hr>
				<form method="POST" action="page/mod_gca/aksi_update.php">
				<table width="100%" border="1" cellpadding="3" style="color:#000000" >
					<thead>
						<tr align="center" bgcolor="#ccd9ff">
							<td> <b >No.</b></td>
							<td> <b >Aktivitas</b></td>
							<?php
								
								$no=1;
								$endDate=date("t",mktime(0,0,0,$month,$day,$year));
										for ($d=1;$d<=$endDate;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
													$fontColor="red"; 
												}
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
													$fontColor="red"; 
												}
											$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $month $year'"));
											$tglLibur		= $liburaNas['tanggal'];
											$formatLibur	= explode("-",$tglLibur);
											if($formatLibur[2] == $d){
												$fontColor="red";
											}
											if($fontColor=="red"){
												$bgcolor="ffad99";
											}else{
												$bgcolor="";
											}
												echo "<td bgcolor='$bgcolor'> <span style=\"color:$fontColor\"><b>$d</b></span></td>"; 
										}
							?>
						</tr>
					</thead>
					<tbody>
					<?php
						
						$query = mysql_query("SELECT 	wbs.aktivitas,
														wbs.id,
														wbs.cc,
														waktu_kerja2.nik,
														waktu_kerja2.bulan,
														waktu_kerja2.tahun,
														waktu_kerja2.`1`,
														waktu_kerja2.`2`,
														waktu_kerja2.`3`,
														waktu_kerja2.`4`,
														waktu_kerja2.`5`,
														waktu_kerja2.`6`,
														waktu_kerja2.`7`,
														waktu_kerja2.`8`,
														waktu_kerja2.`9`,
														waktu_kerja2.`10`,
														waktu_kerja2.`11`,
														waktu_kerja2.`12`,
														waktu_kerja2.`13`,
														waktu_kerja2.`14`,
														waktu_kerja2.`15`,
														waktu_kerja2.`16`,
														waktu_kerja2.`17`,
														waktu_kerja2.`18`,
														waktu_kerja2.`19`,
														waktu_kerja2.`20`,
														waktu_kerja2.`21`,
														waktu_kerja2.`22`,
														waktu_kerja2.`23`,
														waktu_kerja2.`24`,
														waktu_kerja2.`25`,
														waktu_kerja2.`26`,
														waktu_kerja2.`27`,
														waktu_kerja2.`28`,
														waktu_kerja2.`29`,
														waktu_kerja2.`30`,
														waktu_kerja2.`31`,
														waktu_kerja2.`32`
														FROM
														waktu_kerja2
														INNER JOIN wbs ON waktu_kerja2.id_gca = wbs.id
														WHERE waktu_kerja2.nik='$nik' AND waktu_kerja2.bulan='$month' AND waktu_kerja2.tahun='$year'");

						while($r=mysql_fetch_array($query)){
							$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$r[id]'"));
							$idParent	= $data['parentId'];
							echo"<input type='hidden' name='id_gca1[]' value='$r[id]' size='1'/>
								<tr>
									<td align='center' width='2%'>$no</td>
									<td width='25%' >
									<z class='' data-tp-title='Cost Center : <b>$r[cc]</b>' data-tp-desc='
									";
									
									echo "$r[id] : <b>$r[aktivitas]</b> -> ";
									for($ak=1;$ak<=99;$ak++){
										$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
											$fontColor="black";
											if($ak!=1){
												echo"-> ";
											}
											echo "$gca[aktivitas]";
												$idParent=$gca['parentId'];
												$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
												if ($idParent==$cek_id['id_tahun']){
													break;
												}
									}
								echo"'>$r[aktivitas]</z></td>";
										for ($d=1;$d<=$endDate;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
													$fontColor="#FF6347";
													$bgcolor="#ffad99";
													
												}else{
													$bgcolor="#b3ffb3";
												}
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
													$fontColor="#FF6347";
													$bgcolor="#ffad99"; 
												}
											$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $month $year'"));
											$tglLibur		= $liburaNas['tanggal'];
											$formatLibur	= explode("-",$tglLibur);
											if($formatLibur[2] == $d){
												$fontColor="red";
												$bgcolor="#ffad99";
											}
											
											echo "<td width='20px' align='center' bgcolor='$bgcolor'><span style=\"color:$fontColor\">
														<input type='hidden' name='nik' value='$nik' size='1'/>
														<input type='hidden' name='id_gca[]' value='$r[id]' size='1'/>
														<input type='hidden' name='tgl_kerja[]' value='$year-$month-$d' size='1'/>
														<input type='hidden' name='bulan' value='$month' size='1'/>
														<input type='hidden' name='tahun' value='$year' size='1'/>
														<input type='text' name='jam_kerja_$d-$r[id]' value='$r[$d]' size='1'/>
													</span></td>"; 
										
										}
							echo"</tr>";
							$no++;
							
						}
						echo"
							<tr>
								<td colspan='2' align='center'><b>Jumlah</b></td>";
								for ($d=1;$d<=$endDate;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
													$fontColor="#FF6347"; 
												}
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
													$fontColor="#FF6347";
												}
											
											$jml_wk = mysql_fetch_array(mysql_query("SELECT sum(`$d`) as jum_jam FROM waktu_kerja2 WHERE `nik`='$nik' AND `bulan`='$month' AND `tahun`='$year'  "));
											if($jml_wk['jum_jam']>8){
												$fontColor="red";
											}
											$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $month $year'"));
											$tglLibur		= $liburaNas['tanggal'];
											$formatLibur	= explode("-",$tglLibur);
											if($formatLibur[2] == $d){
												$fontColor="red";
												$bgcolor="#ffad99";
											}
												echo "<td width='20px' align='center' bgcolor='#ffff4d'><span style=\"color:$fontColor\"><b>$jml_wk[jum_jam]</b></span></td>"; 
										
										}
						echo"</tr>";
					?>
					
					</tbody>
				</table>
				<br>
				<div class='full-right'>
				<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
				</div>
				</form>
				
			</div>
		</div>
	</div>
<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "right"
	});
</script>