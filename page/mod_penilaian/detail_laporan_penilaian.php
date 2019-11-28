<?php 
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/encript.php";

// echo $_POST['id'];
$ex		= explode("-",$_POST['id']);
$bulan	= $ex[0];
$tahun	= $ex[1];
$unit	= $ex[2];
$nik	= $ex[3];
$gca	= $ex[4];
$penilai	= $ex[5];
// echo"$bulan<br>";
// echo"$tahun<br>";
// echo"$unit<br>";
// echo"$nik<br>";
// $query2 = mysql_query("SELECT m_karyawan.`name` as nama FROM m_karyawan WHERE regno='$nik'");
// $data = mysql_fetch_array($query2);
?>		
	<form method="POST" action="page/mod_penilaian/aksi_penilaian.php"  id="formku" enctype="multipart/form-data">
		<div class="form-group col-lg-12 ">
			<div class="col-lg-6">
				<input type="radio" value="2" name="aprove"> <b>Aprove</b>
			</div>
			<div class="col-lg-6">
				<div class="col-lg-12">
					<input type="radio" value="4" name="aprove"> <b>Return</b>
				</div>
				<div class="col-lg-12">
					<label for="note"><b>Validasi Progress</b></label>
					<input type="text" name="val_progress" value="" class="form-control">
					<input type="hidden" name="gca" value="<?=$gca?>" class="form-control">
					<input type="hidden" name="nik" value="<?=$nik?>" class="form-control">
					<input type="hidden" name="penilai" value="<?=$penilai?>" class="form-control">
				</div>
			</div>
			<div class="col-lg-12">
				<p align="justify">
				<ul>
					<li>Apabila hasil pekerjaan dirasa masih kurang maksimal, atasan dapat mengembalikan pekerjaan kepada yang bersangkutan dengan memilih return dan mengurangi progres. 
					Sehingga pegawai yang bersangkutan dapat memperbaiki kekurangan yang ada.
					</li>
					<li>Berikan catatan untuk Karyawan agar dapat memperbaiki kekurangan pada pekerjaan yang dikembalikan.</li>
					<li>Atasan dapat memberikan catatan positif pada karyawan yang telah menyelesaikan pekerjaan.</li>
				
				</ul>
				</p>
			</div>
			<div class="col-lg-12">
				<label for="note"><b>Note</b> </label>
				<textarea name="note" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group  col-lg-12">
			<hr>
			<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
		</div>
	</form>



<p><h5><b>Detail Kinerja <?=name($nik)?></b></h5></p>



		<table class="table table-hover table-expandable table-bordered table-striped" id="example3">
			<thead>
				<tr>
					<th width="20%">Tanggal.</th>
					<th>Aktifitas</th>
					<th>Hasil Aktifitas</th>
					<th>Status</th>
					<th>Progress</th>
					<th>Lampiran</th>
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
												WHERE pencapaian.nik='$nik' 
												AND pencapaian.jo_gca='$gca'
												ORDER BY pencapaian.id_pencapaian DESC");
												
												// AND  date_format( pencapaian.tgl_aktifitas, '%Y' ) = '$tahun'
			while($r=mysql_fetch_array($query)){
					if($r['aprove']==0){
						$aprove="Belum dilaporkan";
					}elseif($r['aprove']==1){
						$aprove="Open";
					}elseif($r['aprove']==2){
						$aprove="Aprove";
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
								<a target='_blank' href='page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-$color' title='Download Lampiran' $disabled><i class='fa fa-xs fa-download'></i>$r[ket]</a>
							</td>
						</tr>";
					
			}
			?>
			</tbody>
		</table>