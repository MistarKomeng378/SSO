<?php 
ob_start();
session_start();
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/encript.php";

// echo $_POST['id'];
$ex		= explode("+",$_POST['id']);
$bulan	= $ex[0];
$tahun	= $ex[1];
$unit	= $ex[2];
$nik	= $ex[3];
$gca	= $ex[4];
$penilai= $ex[5];
$lapor	= $_SESSION['nik'];

?>		

		<p><h5><b>History Penilaian Kinerja <?=name($nik)?></b></h5></p>
		<table id="example1" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="20%">Tanggal.</th>
					<th>Aktifitas</th>
					<th>Hasil Aktifitas</th>
					<th>Status</th>
					<th>Progress</th>
					<th  width="3%">Lampiran</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = mysql_query("SELECT 	pencapaian.id_pencapaian,
												pencapaian.nik,
												pencapaian.jo_gca,
												pencapaian.tgl_aktifitas,
												pencapaian.jam_mulai,
												pencapaian.jam_akhir,
												pencapaian.total_jam,
												pencapaian.total_menit,
												pencapaian.aktifitas,
												pencapaian.hasil_akhir,
												pencapaian.progress,
												pencapaian.progress_lama,
												pencapaian.file,
												pencapaian.aprove,
												pencapaian.ket
												FROM
												pencapaian
												WHERE pencapaian.nik='$nik' AND laporan='$lapor'
												AND pencapaian.jo_gca='$gca'
												ORDER BY pencapaian.id_pencapaian DESC");
												
												// AND  date_format( pencapaian.tgl_aktifitas, '%Y' ) = '$tahun'
			while($r=mysql_fetch_array($query)){
					if($r['aprove']==0){
						$aprove="Belum dilaporkan";
					}elseif($r['aprove']==1){
						$aprove="<lable class='btn-xs btn-primary' title='Aktifitas Belum Aprove'>Open</lable>";
					}elseif($r['aprove']==2){
						$aprove="<lable class='btn-xs btn-success' title='Aktifitas Sudah Aprove'>Aprove</lable>";
					}elseif($r['aprove']==4){
						$aprove="<lable class='btn-xs btn-danger' title='Dikembalikan'>Return</lable>";
					}elseif($r['aprove']==5){
						$aprove="<lable class='btn-xs btn-danger' title='Pengajuan Dispensasi'>Dispensation</lable>";
					}
					if(empty($r['file'])){
						$disabled ="disabled";
						$color ="danger";
					}else{
						$disabled ="";
						$color ="success";
					}
					echo"<tr >
							<td>".tgl_indo($r['tgl_aktifitas'])."<br> $r[jam_mulai] - $r[jam_akhir]<br>$r[total_jam] Jam $r[total_menit] Menit</td>
							<td>$r[jo_gca]-> $r[aktifitas]<br> $r[hasil_akhir]</td>
							<td>$r[hasil_akhir]</td>
							<td >$aprove</td>
							<td >$r[progress]</td>
							<td >
								<a target='_blank' href='page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-$color' title='$r[ket]' $disabled><i class='fa fa-xs fa-download'></i></a>
							</td>
						</tr>";
					
			}
			?>
			</tbody>
		</table>