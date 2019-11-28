<?php
	$ex		= explode("-",$_GET['id']);
	$nik	= dc($ex[0]);
	$month	= dc($ex[1]);
	$year	= dc($ex[2]);
	$cc		= dc($ex[3]);
	$day	= date("d");
?>
<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">

	<h1 class="page-header">GCA Load
		<small><?=$_SESSION['nm_level']?></small>
	</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Aktifitas <?=name($nik)?> pada bulan <?=bulan2($month)." - ".$year?></h4>
		</div>
		<div class="panel-body">
		<?php
			if($nik==$_SESSION['nik']){
				echo"<a href='?page=update_gca_load&id=".ec($nik)."-".ec($month)."-".ec($year)."' class='btn btn-primary'><i class='fa fa-pencil'></i> Update GCA</a><hr>";
			}elseif($_SESSION['level']==1){
				echo"<a href='?page=update_gca_load&id=".ec($nik)."-".ec($month)."-".ec($year)."' class='btn btn-primary'><i class='fa fa-pencil'></i> Update GCA</a><hr>";
			}elseif($_SESSION['level']==4 AND $_SESSION['cc']==$cc){
				echo"<a href='?page=update_gca_load&id=".ec($nik)."-".ec($month)."-".ec($year)."' class='btn btn-primary'><i class='fa fa-pencil'></i> Update GCA</a><hr>";
			}
		?>
				<table width="100%" border="1" cellpadding="3" style="color:#000000">
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
														INNER JOIN wbs ON waktu_kerja2.id_gca = wbs.id AND wbs.pic = waktu_kerja2.nik
														WHERE waktu_kerja2.nik='$nik'
														AND waktu_kerja2.bulan='$month' 
														AND waktu_kerja2.tahun='$year'
														ORDER BY id,nik,bulan,tahun
														
														");
						// AND wbs.pic = waktu_kerja2.nik
						while($r=mysql_fetch_array($query)){
							$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$r[id]'"));
							$idParent	= $data['parentId'];
							echo"
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
									// $r[aktivitas]
									
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
											echo "<td width='20px' align='center' bgcolor='$bgcolor'><span style=\"color:$fontColor\">$r[$d]</span></td>"; 
										}
							echo"</tr>";
							$no++;
							
						}
						echo"
							<tr>
								<td colspan='2' align='center'><b>Jumlah</b></td>";
								for ($d=1;$d<=$endDate;$d++) { 
									$jml_wk = mysql_fetch_array(mysql_query("SELECT sum(`$d`) as jum_jam FROM waktu_kerja2 WHERE `nik`='$nik' AND `bulan`='$month' AND `tahun`='$year'  "));
									if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
										$fontColor="red"; 
									}elseif(date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
										$fontColor="red";
									}else{
										if($jml_wk['jum_jam']>8){
											$fontColor="red";
										}elseif($jml_wk['jum_jam']<8){
											$fontColor="blue";
										}else{
											$fontColor="black";
										}
										$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %m %Y' ) = '$d $month $year'"));
										$tglLibur		= $liburaNas['tanggal'];
										$formatLibur	= explode("-",$tglLibur);
										if($formatLibur[2] == $d){
											$fontColor="red";
										}
									}
									echo "<td width='20px' align='center' bgcolor='#ffff4d'><span style=\"color:$fontColor\"><b>$jml_wk[jum_jam]</b></span></td>"; 	
								}
					echo"</tr>";
					?>
					</tbody>
				</table>
		</div>
	</div>
<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "bottom"
	});
</script>