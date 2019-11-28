<?php 
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/fungsi_rupiah.php";
    include "../config/fungsi_bulan.php";
    include "../config/fungsi_name.php";
    include "../config/encript.php";
	include "../config/fungsi_timeline.php";
	
	$ex		= explode("-",$_GET['id']);
	$bulan	= mysql_real_escape_string(dc($ex[0]));
	$tahun	= mysql_real_escape_string(dc($ex[1]));
	$cc		= mysql_real_escape_string(dc($_GET['cc']));
	// @$nik	= mysql_real_escape_string(dc($_GET['nik']));
	// $lastDay 	= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
	// $w = 63/$lastDay;
	timeline($_SESSION['nik'],"download","Telah melakukan download Summary KKWK Per Cost Center $cc Bulan ".bulan($bulan)." Tahun $tahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Summary_KKWK_cc_".bulan($bulan).".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<center><h3>SUMMARY KKWK Per COST CENTER<br>PERIODE BULAN <?=strtoupper(bulan($bulan))?> <?=$tahun?></h3></center><br>
<table width="100%" border="1" cellpadding="3" style="color:#000000">
		<thead>
			<tr align="center">
				<th width="3%">No</th>
				<th width="4%">NIK</th>
				<th width="20%">Nama</th>
				<th width="11%">Cost Center</th>
				<th >Uraian</th>
				<th  width="12%">Total Waktu (Jam)</th>
				<th  width="10%">Presentase (%)</th>
			</tr>
		</thead>
	<tbody>
		<?php
			$no=1;
			if(!empty($_GET['cc'])){
				// $cc="AND (m_karyawan.dept='$cc' OR pencapaian.cc='$cc') ";
				$cc="AND pencapaian.cc='$cc' ";
			}
			$query = mysql_query("SELECT DISTINCT	pencapaian.nik,
																pencapaian.cc,
																m_karyawan.`name`,
																mskko.uraian
																FROM
																pencapaian
																INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
																INNER JOIN mskko ON mskko.CostCenter = pencapaian.cc
																WHERE pencapaian.nik!='' AND pencapaian.cc!='' $cc
																AND DATE_FORMAT(tgl_aktifitas,'%c %Y')='$bulan $tahun'
																ORDER BY pencapaian.nik
																");
			while($r=mysql_fetch_array($query)){
				$jml_jam 	= mysql_query("SELECT total_jam,total_menit FROM pencapaian WHERE cc='$r[cc]' AND nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'");
				while($jj=mysql_fetch_array($jml_jam)){
					if($jj['total_menit']>=30){
						$sisa_jam = 1;
					}else{
						$sisa_jam = 0;
					}
					@$jum_jam	+= $jj['total_jam']+$sisa_jam;
				}
							
				$jam_bulan 	= mysql_query("SELECT total_jam,total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'");
				while($jb=mysql_fetch_array($jam_bulan)){
					if($jb['total_menit']>=30){
						$sisa_jam = 1;
					}else{
						$sisa_jam = 0;
					}
					@$jum_jam_bulan	+= $jb['total_jam']+$sisa_jam;
				}		
							
				if($jum_jam_bulan==0){
					$prosen		= 0;
				}else{
					$prosen			= ($jum_jam/$jum_jam_bulan)*100;
				}		
				echo"
					<tr>
						<td>$no</td>
						<td>'".$r['nik']."</td>
						<td>".name($r['nik'])."</td>
						<td>$r[cc]</td>
						<td>$r[uraian]</td>
						<td>$jum_jam</td>
						<td>".desimal2($prosen)."</td>
					</tr>
					";
				$no++;
				$jum_jam = 0;
				$jum_jam_bulan = 0;
			}
		?>
	</tbody>
</table>
		