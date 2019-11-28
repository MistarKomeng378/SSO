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
	$nik	= mysql_real_escape_string(dc($ex[2]));
	$unit	= mysql_real_escape_string(dc($_GET['cc']));
	
	timeline($_SESSION['nik'],"download","Telah melakukan download file kinerja bulanan ".name($nik)." Bulan ".bulan($bulan)." Tahun $tahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Kinerja_bulanan".bulan($bulan).".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<center><h3>DATA KINERJA BULANAN <br>PERIODE BULAN <?=strtoupper(bulan($bulan))?> <?=$tahun?></h3></center><br>


	<table width="100%" border="0" cellpadding="3" style="color:#000000">
		<tr>
			<td  colspan="2">NIK</td>
			<td>:</td>
			<td colspan="3">'<?=$nik?></td>
			<td colspan="5"></td>
		</tr>
		<tr>
			<td colspan="2">Nama</td>
			<td>:</td>
			<td colspan="3"><?=name($nik)?></td>
			<td colspan="5"></td>
		</tr>
	</table>
	<br>
	<table width="100%" border="1" cellpadding="3" style="color:#000000">
		<thead>
			<tr align="center">
				<td><b>No</b></td>
				<td><b>Tanggal</b></td>
				<td><b>Jam Mulai</b></td>
				<td><b>Jam Selesai</b></td>
				<td><b>Total Jam</b></td>
				<td><b>CC</b></td>
				<td><b>Aktifitas</b></td>
				<td><b>Hasil Aktifitas</b></td>
				<td><b>FK</b></td>
				<td><b>Status</b></td>
				<td width='2px'><b>Progress</b></td>
			</tr>
	</thead>
	<tbody>
		<?php
				$query = mysql_query("SELECT DISTINCT	m_karyawan.`name` as nama,
														pencapaian.nik
														FROM
														pencapaian
														INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
														WHERE pencapaian.nik='$nik'
														ORDER BY pencapaian.id_pencapaian DESC");
			while($r=mysql_fetch_array($query)){
				// echo"<tr>
						// <td colspan='2'>";
						// if(foto($nik)==""){
							// echo'<img src="../assets/img/no_foto.png" alt="" width="80px" />';
						// }else{
							// echo"<img src='../upload/foto/".foto($nik)."' alt='' width='80px'/>";
						// }
					// echo"</td>
						// <td colspan='9'>$r[nik] /$r[nama]</td>
					// </tr>";
					if(!empty($unit)){
						$cc="AND pencapaian.cc='$unit' ";
						$query2 = mysql_query("SELECT 	m_karyawan.`name`as nama,
												pencapaian.id_pencapaian,
												pencapaian.nik,
												pencapaian.jo_gca,
												pencapaian.tgl_aktifitas,
												pencapaian.jam_mulai,
												pencapaian.jam_akhir,
												pencapaian.total_jam,
												pencapaian.total_menit,
												pencapaian.aktifitas,
												pencapaian.hasil_akhir,
												pencapaian.laporan,
												pencapaian.cc,
												pencapaian.faktor_k,
												pencapaian.progress,
												pencapaian.progress_lama,
												pencapaian.file,
												pencapaian.status,
												pencapaian.aprove,
												pencapaian.ket
												FROM
												pencapaian
												INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
												WHERE pencapaian.nik='$r[nik]' 
												AND  date_format( pencapaian.tgl_aktifitas, '%c %Y' ) = '$bulan $tahun' $cc
												AND pencapaian.status='1'
												ORDER BY pencapaian.tgl_aktifitas DESC");
					}else{
						$query2 = mysql_query("SELECT 	m_karyawan.`name`as nama,
												pencapaian.id_pencapaian,
												pencapaian.nik,
												pencapaian.jo_gca,
												pencapaian.tgl_aktifitas,
												pencapaian.jam_mulai,
												pencapaian.jam_akhir,
												pencapaian.total_jam,
												pencapaian.total_menit,
												pencapaian.aktifitas,
												pencapaian.hasil_akhir,
												pencapaian.laporan,
												pencapaian.cc,
												pencapaian.faktor_k,
												pencapaian.progress,
												pencapaian.progress_lama,
												pencapaian.file,
												pencapaian.status,
												pencapaian.aprove,
												pencapaian.ket
												FROM
												pencapaian
												INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
												WHERE pencapaian.nik='$r[nik]' 
												AND  date_format( pencapaian.tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'
												AND pencapaian.status='1'
												ORDER BY pencapaian.tgl_aktifitas DESC");
					}
						
					$no=1;
					while($r2=mysql_fetch_array($query2)){
						if($r2['aprove']==0){
							$aprove="Proses";
						}elseif($r2['aprove']==1){
							$aprove="Open";
						}elseif($r2['aprove']==2){
							$aprove="Aproveed";
						}elseif($r2['aprove']==3){
							$aprove="Not Reported";
						}elseif($r2['aprove']==4){
							$aprove="Return";
						}
						$jam_mulai	= date('H:i', strtotime($r2['jam_mulai']));
						$jam_akhir	= date('H:i', strtotime($r2['jam_akhir']));
						$tgl_kerja	= date('d-m-Y', strtotime($r2['tgl_aktifitas']));
						if($r2['total_menit']>=30){
							$sisa_jam = 1;
						}else{
							$sisa_jam = 0;
						}
						$jumlah_jam	= $r2['total_jam']+$sisa_jam;
						
						
					echo"<tr >
							<td align='center'>$no</td>
							<td><font color='blue'>".$tgl_kerja."</font></td>
							<td align='center'>$jam_mulai</td>
							<td align='center'>$jam_akhir</td>
							<td align='center'>".$r2['total_jam'].", ".$r2['total_menit']."</td>
							<td ><font color='blue'>$r2[cc]</font></td>
							<td>$r2[aktifitas]</td>
							<td>$r2[hasil_akhir]</td>
							<td align='center'>$r2[faktor_k]</td>
							<td align='center'>$aprove</td>
							<td align='center'>$r2[progress] %</td>
							
						</tr>";
					$no++;
					// @$jum_jam +=$jumlah_jam;
					@$jum_jam +=$r2['total_jam'];
					@$jum_men +=$r2['total_menit'];
					}
					// if($unit==""){
						// $jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
					// }else{
						// $jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun' AND pencapaian.cc='$unit'"));
					// }
					$totmen	= $jum_men/ 60;
					$totjam	= $jum_jam+$totmen;
					$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
					
					echo"<tr align='center'>
							<td></td>
							<td><b>".$jml_hari['jum_hari']." Hari</b></td>
							<td colspan='2'></td>
							<td colspan='2'><b>".desimal($totjam)." Jam</b></td>
							<td colspan='5'></td>
						</tr>";
					
					
			}
			?>
	</tbody>
</table>
		