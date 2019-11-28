<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
$timezone = "Asia/Jakarta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$ex		= explode("-",$_POST['id']);
	$id_gca	= mysql_real_escape_string($ex[0]);
	$tahun	= mysql_real_escape_string($ex[1]);
	$pic	= mysql_real_escape_string($ex[2]);
	
			$tgl_mulai	= date("Y-01-01");
			$tgl_akhir	= date("Y-12-01");
			$start    = new DateTime($tgl_mulai);
			$start->modify('first day of this month');
			$end      = new DateTime($tgl_akhir);
			$end->modify('first day of next month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			
			foreach ($period as $dt) {
				$year 	= $dt->format("Y");
				$month 	= $dt->format("m");
				$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$month,$year);
				echo"<b>".bulan($month)."</b><br>";
				echo'<table width="100%" border="1" cellpadding="3" style="color:#000000">
					<thead>
						<tr align="center" bgcolor="#ccd9ff">
							';
							for ($tgl=1;$tgl<=$lastDay;$tgl++){
								$tgl_kerja 	= $year."-".$month."-".$tgl;
								$fontColor="#000000"; 
								if (date("D",mktime (0,0,0,$month,$tgl,$year)) == "Sun") {
									$fontColor="red"; 
								}
								if (date("D",mktime (0,0,0,$month,$tgl,$year)) == "Sat") {
									$fontColor="red"; 
								}
								$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$tgl $month $year'"));
								$tglLibur		= $liburaNas['tanggal'];
								$libur	 		= date('Y-m-d', strtotime($tgl_kerja));
								if($tglLibur == $libur){
									$fontColor="red";
								}
								if($fontColor=="red"){
									$bgcolor="ffad99";
								}else{
									$bgcolor="";
								}
								echo "<td bgcolor='$bgcolor'> <span style=\"color:$fontColor\"><b>$tgl</b></span></td>"; 								
							}
								
						echo'<td>Total</td>
						</tr>
					</thead>
					<tbody>';
					echo'<tr align="center" bgcolor="#b3ffb3">
							';
							for ($tgl=1;$tgl<=$lastDay;$tgl++){
								$tgl_kerja 	= $year."-".$month."-".$tgl;
								$fontColor="#000000"; 
								if (date("D",mktime (0,0,0,$month,$tgl,$year)) == "Sun") {
									$fontColor="red"; 
								}
								if (date("D",mktime (0,0,0,$month,$tgl,$year)) == "Sat") {
									$fontColor="red"; 
								}
								$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$tgl $month $year'"));
								$tglLibur		= $liburaNas['tanggal'];
								$libur	 		= date('Y-m-d', strtotime($tgl_kerja));
								if($tglLibur == $libur){
									$fontColor="red";
								}
								if($fontColor=="red"){
									$bgcolor="ffad99";
								}else{
									$bgcolor="";
								}
								$jml_wk = mysql_fetch_array(mysql_query("SELECT sum(`$tgl`) as jum_jam FROM waktu_kerja2 WHERE `nik`='$pic' AND `bulan`='$month' AND `tahun`='$year' AND id_gca='$id_gca' "));
								echo "<td bgcolor='$bgcolor'> <span style=\"color:$fontColor\"><b>$jml_wk[jum_jam]</b></span></td>"; 								
							}
							$wk = mysql_fetch_array(mysql_query("SELECT SUM(`1`)+SUM(`2`)+SUM(`3`)+SUM(`4`)+SUM(`5`)+SUM(`6`)+SUM(`7`)+SUM(`8`)+SUM(`9`)+SUM(`10`)+
									SUM(`11`)+SUM(`12`)+SUM(`13`)+SUM(`14`)+SUM(`15`)+SUM(`16`)+SUM(`17`)+SUM(`18`)+SUM(`19`)+SUM(`20`)+
									SUM(`21`)+SUM(`22`)+SUM(`23`)+SUM(`24`)+SUM(`25`)+SUM(`26`)+SUM(`27`)+SUM(`28`)+SUM(`29`)+SUM(`30`)+
									SUM(`31`)+SUM(`32`) as jum FROM waktu_kerja2 
									WHERE `nik`='$pic' 
									AND `bulan`='$month' 
									AND `tahun`='$tahun' 
									AND `id_gca`='$id_gca' ")) ;
						echo"
							<td>$wk[jum]</td>
						</tr>";
					echo"
					</tbody>
				</table>";
			}
		?>