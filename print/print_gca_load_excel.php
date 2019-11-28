<?php 
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    // include "../config/fungsi_rupiah.php";
    include "../config/fungsi_bulan.php";
    include "../config/encript.php";
	include "../config/fungsi_name.php";
    include "../config/fungsi_timeline.php";
	
	$ex		= explode("-",$_GET['id']);
	$getCC	= mysql_real_escape_string(dc($ex[0]));
	$tahun	= mysql_real_escape_string(dc($ex[1]));
	$qunit 	= mysql_fetch_array(mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$getCC' "));
	$unit	= $qunit['uraian'];
	timeline($_SESSION['nik'],"download","Telah melakukan download GCA Load $unit Tahun $tahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=GCA_load_".$unit."_tahun_".$tahun.".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<center><h3>GCA LOAD <br><?=strtoupper($unit)?> TAHUN <?=$tahun?></h3></center><br>
<table width="100%" border="1" cellpadding="3" style="color:#000000">
		<thead>
			<tr>
				<th rowspan="2">No.</th>
				<th rowspan="2">NIK</th>
				<th rowspan="2">NAMA</th>
				<th colspan="12">BULAN</th>
				<th rowspan="2">TOTAL</th>
			</tr>
			<tr>
			<?php
				for($i=1;$i<=12;$i++){
					echo"<th>$i</th>";
				}
			?>
		</tr>
	</thead>
	<tbody>
	<?php
	$no=1;
	$query = mysql_query("SELECT	m_jabatan.posdesc,
									m_karyawan.regno,
									m_karyawan.`name`,
									m_karyawan.poscode,
									m_karyawan.email,
									mskko.uraian,
									mskko.CostCenter,
									m_jabatan.poscode
								FROM
									m_karyawan
								LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
								INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
								WHERE m_karyawan.dept='$getCC' AND m_karyawan.status='0'
								ORDER BY m_karyawan.regno");
	while($r=mysql_fetch_array($query)){
		echo"
			<tr>
				<td align='center'>$no</td>
				<td align='center'>'$r[regno]</td>
				<td>$r[name]</td>";
				$start    = new DateTime("$tahun-01-01");
				$start->modify('first day of this month');
				$end      = new DateTime("$tahun-12-01");
				$end->modify('first day of next month');
				$interval = DateInterval::createFromDateString('1 month');
				$period   = new DatePeriod($start, $interval, $end);
				$b=1;
				foreach ($period as $dt) {
					$year 		= $dt->format("Y");
					$month 		= $dt->format("m");
					$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$month,$year);						
												
					$i		= 0;
					$x   	= 0;
					$endz   = 1;

					$mulai	="$year-$month-01";
					$akhir	="$year-$month-$lastDay";
					$date1 	= date_create($mulai);
					$s 		= strtotime($mulai);
					$e 		= strtotime($akhir);
					$diff 	= ($e-$s)/86400;
					for($k=0;$k<=$diff;$k++){  
						$tgl_kerja = date_format($date1,"Y-m-d");
													
						$ex		= explode("-",$tgl_kerja);
						$tahun	= $ex[0]; 
						$bulan	= $ex[1]; 
						$hari	= $ex[2];
													
						if(date("D",mktime (0,0,0,$month,$hari,$year)) == "Sun") {
														
						}elseif(date("D",mktime (0,0,0,$month,$hari,$year)) == "Sat") {
														 
						}else{
							$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%d %m %Y' ) = '$hari $bulan $tahun'"));
							if($liburaNas['tanggal'] == $tgl_kerja){
															
							}else{
								$x += $endz-$i;
							}
						}
							date_add($date1, date_interval_create_from_date_string('1 days'));
					}
												
					$jumHariKerja 	= $x;
					$jumJamKerja	= $jumHariKerja * 8;
					$wk = mysql_fetch_array(mysql_query("SELECT SUM(`total_jam`) as jum FROM waktu_kerja2 
														WHERE nik='$r[regno]' AND bulan='$month' AND tahun='$year'"));
					if($wk['jum'] > $jumJamKerja){
						$fontColor="red"; 
					}elseif($wk['jum'] < $jumJamKerja){
						$fontColor="blue"; 
					}else{
						$fontColor="black"; 
					}
						echo"<td align='center'><span style=\"color:$fontColor\"><b>".$wk['jum']." </b></span></td>";
						$b++;
				}
					$tot_jam = mysql_fetch_array(mysql_query("SELECT SUM(`total_jam`) as total FROM waktu_kerja2 
																WHERE nik='$r[regno]' AND tahun='$year'"));
				echo"	<td  align='center'>$tot_jam[total]</td>
			</tr>";
			$no++;
	}
	?>
		<tr align="center">
			<td></td>
			<td></td>
			<td>Jumlah Jam Kerja Standar</td>
			<?php
				for($i=1;$i<=12;$i++){
					$jambul = mysql_fetch_array(mysql_query("SELECT * FROM jam_bulanan	WHERE tahun='$year' AND bulan='$i' "));
					echo"<td><span style=\"color:green\">$jambul[jam_bulanan]</span></td>";
				}
			?>
			<td></td>
		</tr>
	</tbody>
</table>
		