<?php 
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_rupiah.php";
include"../../config/encript.php";

$ex		= explode("-",$_POST['id']);
$bulan	= dc($ex[0]);
$tahun	= dc($ex[1]);
$unit	= dc($ex[2]);
$nik	= dc($ex[3]);
echo" 
<a target='_blank' href='print/print_kinerja_bulanan_pdf.php?id=".ec($bulan)."-".ec($tahun)."-".ec($nik)."&cc=".ec($unit)."' class='btn btn-danger'><i class='fa fa-file-pdf-o'></i> PDF</a>
<a target='_blank' href='print/print_kinerja_bulanan_excel.php?id=".ec($bulan)."-".ec($tahun)."-".ec($nik)."&cc=".ec($unit)."' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>
";
?>		<p><h5>Hasil Kinerja <?=name($nik)?> Pada Bulan <?=bulan($bulan)?></h5></p>
		<table cellpadding='5' cellspacing='15' width='100%' class="table-bordered table-striped table-hover">
			<thead>
				<tr align='center'>
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
				echo"<tr>
						<td colspan='2'>";
						if(foto($nik)==""){
							echo'<img src="assets/img/no_foto.png" alt="" width="80px" />';
						}else{
							echo"<img src='upload/thumbs/thumb_".foto($nik)."' alt='' width='80px'/>";
						}
					echo"</td>
						<td colspan='9'>$r[nik] /$r[nama]</td>
					</tr>";
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
												pencapaian.tgl_update,
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
												pencapaian.tgl_update,
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
						if(empty($r2['tgl_update'])){
							$tgl_update	= "";
						}else{
							$tgl_update	= date('d-m-Y', strtotime($r2['tgl_update']));
						}
						if($r2['total_menit']>30){
							$sisa_jam = 1;
						}else{
							$sisa_jam = 0;
						}
						$jumlah_jam	= $r2['total_jam']+$sisa_jam;
						
						
					echo"<tr >
							<td align='center'>$no</td>
							<td><font color='blue'>".$tgl_kerja."</font><br><font color='green' title='Tanggal Update'>".$tgl_update."</font></td>
							<td align='center'>$jam_mulai</td>
							<td align='center'>$jam_akhir</td>
							<td align='center'>$jumlah_jam</td>
							<td ><font color='blue'>$r2[cc]</font></td>
							<td>$r2[aktifitas]</td>
							<td>$r2[hasil_akhir]</td>
							<td align='center'>$r2[faktor_k]</td>
							<td align='center'>$aprove</td>
							<td align='center'>$r2[progress] %</td>
							
						</tr>";
					$no++;
					@$jum_jam +=$jumlah_jam;
					}
					if($unit==""){
						$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND status='1' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
					}else{
						$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND status='1' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun' AND pencapaian.cc='$unit'"));
					}
					echo"<tr align='center'>
							<td></td>
							<td><b>$jml_hari[jum_hari]</b></td>
							<td colspan='2'></td>
							<td ><b>$jum_jam</b></td>
							<td colspan='6'></td>
						</tr>";
					
					
			}
			?>
			</tbody>
		</table>