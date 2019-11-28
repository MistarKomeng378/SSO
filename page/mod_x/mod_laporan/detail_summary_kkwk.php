<?php 
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
// echo $_POST['id'];
$ex		= explode("-",$_POST['id']);
$hari	= $ex[0];
$bulan	= $ex[1];
$tahun	= $ex[2];
$unit	= $ex[3];
$nik	= $ex[4];
$query2 = mysql_query("SELECT m_karyawan.`name` as nama FROM m_karyawan WHERE regno='$nik'");
$data = mysql_fetch_array($query2);
?>		<p><h5>Hasil Kinerja <?=$data['nama']?> Pada Tanggal <?=$hari?> Bulan <?=bulan($bulan)?>  Tahun <?=$tahun?></h5></p>
		<table class="table table-hover table-expandable table-bordered table-striped">
			<thead>
				<tr>
					<th>Tanggal / Jam</th>
					<th>Aktifitas</th>
					<th>Hasil Aktifitas</th>
					<th>Dilaporkan Ke</th>
					<th>FK</th>
					<th>Status</th>
					<th>Kd. Proyek/<br> Cost Center</th>
					<th width='2px'>Progress</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = mysql_query("SELECT 	m_karyawan.`name`as nama,
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
												WHERE pencapaian.nik='$nik' AND  date_format( pencapaian.tgl_aktifitas, '%e %c %Y' ) = '$hari $bulan $tahun'
												ORDER BY pencapaian.tgl_aktifitas DESC");
			while($r=mysql_fetch_array($query)){
						if($r['aprove']==0){
							$status = "Proses";
						}elseif($r['aprove']==1){
							$status = "Open";
						}elseif($r['aprove']==2){
							$status = "Approved";
						}elseif($r['aprove']==3){
							$status = "Not Reported";
						}elseif($r['aprove']==4){
							$status = "Return";
						}
					echo"<tr >
							<td>".tgl_indo($r['tgl_aktifitas'])."<br>$r[jam_mulai]-$r[jam_akhir]<br>Total $r[total_jam] Jam $r[total_menit] Menit</td>
							<td>";
							$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$r[jo_gca]'"));
							$idParent	= $data['parentId'];
							echo"<b><font color='blue'>$r[aktifitas]</font></b> ->";
								for($ak=1;$ak<=99;$ak++){
									$gca = mysql_fetch_array(mysql_query("SELECT parentId,aktivitas,tahun FROM wbs WHERE id='$idParent'"));
									$fontColor="black";
									if($ak!=1){
										echo"-> ";
									}
									echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
									$idParent=$gca['parentId'];
									$cek_id = mysql_fetch_array(mysql_query("SELECT id_tahun FROM tahun WHERE tahun='$gca[tahun]'"));
									if ($idParent==$cek_id['id_tahun']){
										break;
									}
								}
						echo"</td>
							<td>$r[hasil_akhir]<br><span style=\"color:green\" title='Tanggal Update'>$r[tgl_update]</span></td>
							<td>".name($r['laporan'])."</td>
							<td>$r[faktor_k]</td>
							<td >$status</td>
							<td >$r[cc]</td>
							<td >$r[progress]</td>
							
						</tr>";
			}
			?>
			</tbody>
		</table>