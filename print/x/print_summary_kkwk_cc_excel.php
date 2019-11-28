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
	
	$ex		= explode("-",$_GET['id']);
	$bulan	= mysql_real_escape_string(dc($ex[0]));
	$tahun	= mysql_real_escape_string(dc($ex[1]));
	$cc		= mysql_real_escape_string(dc($_GET['cc']));
	// @$nik	= mysql_real_escape_string(dc($_GET['nik']));
	// $lastDay 	= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
	// $w = 63/$lastDay;
	
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
				<th ></th>
				<th  width="12%">Total Waktu (Jam)</th>
				<th  width="10%">Presentase (%)</th>
			</tr>
		</thead>
	<tbody>
		<?php
			$no=1;
			if(!empty($_GET['cc'])){
				$cc="AND (m_karyawan.dept='$cc' OR pencapaian.cc='$cc') ";
			}
			$query = mysql_query("SELECT DISTINCT	pencapaian.cc,
													pencapaian.nik,
													m_karyawan.dept
													FROM
													pencapaian
													LEFT JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
													WHERE pencapaian.nik!='' AND pencapaian.cc!='' $cc
													ORDER BY pencapaian.nik");
			while($r=mysql_fetch_array($query)){
				$jml_cc 	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jam FROM pencapaian WHERE cc='$r[cc]' AND nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
				$jmlm_cc 	= mysql_fetch_array(mysql_query("SELECT SUM(total_menit) as menit FROM pencapaian WHERE cc='$r[cc]' AND nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
							
				$jml_bln 	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
				$jmlm_bln 	= mysql_fetch_array(mysql_query("SELECT SUM(total_menit) as menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
							
				$sisa_jam		= $jmlm_cc['menit']/60;
				$sisa_jam_bln	= $jmlm_bln['menit']/60;
							
				$total_jam		= $jml_cc['jam']+desimal2($sisa_jam);
				$total_jam_bln		= $jml_bln['total']+desimal2($sisa_jam_bln);
							
				if($total_jam_bln==0){
					$prosen		= 0;
				}else{
					$prosen		= ($total_jam/$total_jam_bln)*100;
				}
							
				echo"
					<tr>
						<td>$no</td>
						<td>'".$r['nik']."</td>
						<td>".name($r['nik'])."</td>
						<td>$r[cc]</td>
						<td></td>
						<td>$total_jam </td>
						<td>".desimal2($prosen)."</td>
					</tr>
					";
				$no++;
			}
		?>
	</tbody>
</table>
		