<?php
	session_start();
	include"../../config/koneksi.php";
	include"../../config/encript.php";
	$ex		= explode("-",$_POST['id']);
	$month	= dc($ex[1]); 
	$year	= dc($ex[2]); 
	$day	= date("d");
	$nik	= dc($ex[0]);
	$cc		= dc($ex[3]);
?>


		<?php
			if($nik==$_SESSION['nik']){
				echo"<a href='?page=update_gca_load&id=".ec($nik)."-".ec($month)."-".ec($year)."' class='btn btn-primary'><i class='fa fa-pencil'></i> Update GCA</a><hr>";
			}elseif($_SESSION['level']==1){
				echo"<a href='?page=update_gca_load&id=".ec($nik)."-".ec($month)."-".ec($year)."' class='btn btn-primary'><i class='fa fa-pencil'></i> Update GCA</a><hr>";
			}elseif($_SESSION['level']==4 AND $_SESSION['cc']==$cc){
				echo"<a href='?page=update_gca_load&id=".ec($nik)."-".ec($month)."-".ec($year)."' class='btn btn-primary'><i class='fa fa-pencil'></i> Update GCA</a><hr>";
			}
		?>
			<div class="table-responsive">
				<table width="100%" border="1" cellpadding="3" style="color:#000000">
					<thead>
						<tr align="center" bgcolor="#ccd9ff">
							<td> <b >No.</b></td>
							<td> <b >Aktifitas</b></td>
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
											$formatLibur	= date('d', strtotime($tglLibur));
											if($formatLibur == $d){
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
														WHERE waktu_kerja2.nik='$nik' AND waktu_kerja2.bulan='$month' AND waktu_kerja2.tahun='$year'
														ORDER BY id,nik,bulan,tahun");

						while($r=mysql_fetch_array($query)){
							echo"
								<tr>
									<td align='center' width='2%'>$no</td>
									<td width='25%' title='ID : $r[id] GCA $r[cc] '>$r[aktivitas]</td>";
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
											$formatLibur	= date('d', strtotime($tglLibur));
											if($formatLibur == $d){
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
										$formatLibur	= date('d', strtotime($tglLibur));
										if($formatLibur == $d){
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