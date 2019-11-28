<?php 
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/fungsi_rupiah.php";
    include "../config/fungsi_bulan.php";
    include "../config/encript.php";
	
	$ex		= explode("-",$_GET['id']);
	$bulan	= mysql_real_escape_string(dc($ex[0]));
	$tahun	= mysql_real_escape_string(dc($ex[1]));
	$unit	= mysql_real_escape_string(dc($_GET['unit']));
	@$nik	= mysql_real_escape_string(dc($_GET['nik']));
	$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
	$w = 63/$lastDay;
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Summary_KKWK_".bulan($bulan).".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<center><h3>SUMMARY KKWK <br>PERIODE BULAN <?=strtoupper(bulan($bulan))?> <?=$tahun?></h3></center><br>
<table width="100%" border="1" cellpadding="3" style="color:#000000">
		<thead>
			<tr align="center">
				<td width="3%"><b>No</b></td>
				<th width="4%"><b>NIK</b></th>
				<th width="18%"><b>Nama</b></th>
						
				<?php
					$day	= date("d");
							$no=1;
					$endDate=date("t",mktime(0,0,0,$bulan,$day,$tahun));
						for ($d=1;$d<=$endDate;$d++) { 
							$fontColor="#000000"; 
							if (date("D",mktime (0,0,0,$bulan,$d,$tahun)) == "Sun") {
								$fontColor="red"; 
							}
							if (date("D",mktime (0,0,0,$bulan,$d,$tahun)) == "Sat") {
								$fontColor="red"; 
								$bgcolor="red"; 
							}
							$liburaNas 		= mysql_fetch_array(mysql_query("SELECT * FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $bulan $tahun'"));
								$tgl_kerja	 	= date('Y-m-d', strtotime($tahun."-".$bulan."-".$d));
								$tglLibur		= $liburaNas['tanggal'];
								if($tgl_kerja == $tglLibur){
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
			<td ><b>Tot</b></td>
			<td ><b>Isi</b></td>
			<td ><b>Rt</b></td>
			<td ><b>RK</b></td>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			if(!empty($_GET['unit'])){
				$andunit="AND mskko.CostCenter='$unit'";
			}else{
				$andunit="";
			}
			if(!empty($_GET['nik'])){
				$andnik="AND m_karyawan.regno='$nik'";
			}else{
				$andnik="";
			}
			$query = mysql_query("SELECT m_karyawan.regno as nik,
										m_karyawan.`name`,
										mskko.CostCenter as cc
										FROM
										m_karyawan
										INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
										LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
										WHERE mskko.id !='0' AND mskko.id !='1.6' AND m_karyawan.regno NOT LIKE '%DM%' AND m_karyawan.status='0' $andunit $andnik 
										ORDER BY regno");
			while($r=mysql_fetch_array($query)){
				echo"
					<tr>
						<td>$no</td>
						<td>$r[nik] </td>
						<td>$r[name] </td>";
						for ($d=1;$d<=$lastDay;$d++) { 
							$fontColor="#000000"; 
							if (date("D",mktime (0,0,0,$bulan,$d,$tahun)) == "Sun") {
								$fontColor="#FF6347";
								$bgcolor="#ffad99";
													
							}else{
								$bgcolor="#b3ffb3";
							}
							if (date("D",mktime (0,0,0,$bulan,$d,$tahun)) == "Sat") {
								$fontColor="#FF6347";
								$bgcolor="#ffad99"; 
							}
							$liburaNas 		= mysql_fetch_array(mysql_query("SELECT * FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $bulan $tahun'"));
							$tgl_kerja	 	= date('Y-m-d', strtotime($tahun."-".$bulan."-".$d));
							$tglLibur		= $liburaNas['tanggal'];
							if($tgl_kerja == $tglLibur){
								$fontColor="red";
								$bgcolor="#ffad99";
							}
											
							$wk = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total_jam FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%e %c %Y' ) = '$d $bulan $tahun'"));
							echo "<td width='20px' align='center' bgcolor='$bgcolor'><span style=\"color:$fontColor\">$wk[total_jam]</span></td>"; 
									// echo "<td >$d</td>"; 
										
						}
							$jml_jam 	= mysql_fetch_array(mysql_query("SELECT sum(total_jam) as jum_jam FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
							$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
								if($jml_hari['jum_hari']==0){
									$rata		= 0;
								}else{
									$rata		= $jml_jam['jum_jam'] / $jml_hari['jum_hari'];
								}
								$hari_kerja	= mysql_fetch_array(mysql_query("SELECT hari_kerja as hari FROM jam_bulanan WHERE bulan='$bulan' AND tahun='$tahun'"));
								$rk			= $jml_jam['jum_jam'] / $hari_kerja['hari'];
							
					echo"
						<td width='25px' align='center' title='Jumlah Jam' ><b>$jml_jam[jum_jam]</b></td>
						<td width='25px' align='center' title='Jumlah Hari Pengisian KKWK' ><b>$jml_hari[jum_hari]</b></td>
						<td width='25px' align='center' title='Rata-Rata Jam Perhari' ><b>".desimal($rata)."</b></td>
						<td width='25px' align='center' title='Rata-Rata Jam Perbulan' ><b>".desimal($rk)."</b></td>	
					</tr>
					";
				$no++;
			}
		?>
	</tbody>
</table>
		