<?php 
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/encript.php";

// echo $_POST['id'];
$ex			= explode("+",$_POST['id']);
$bulan		= $ex[0];
$tahun		= $ex[1];
$unit		= $ex[2];
$nik		= $ex[3];
$gca		= $ex[4];
$penilai	= $ex[5];
$id			= $ex[6];
$opt		= $ex[7];

$data = mysql_fetch_array(mysql_query("SELECT * FROM pencapaian WHERE id_pencapaian='$id' AND nik='$nik' "));

$data2		= mysql_query("SELECT parentId FROM wbs WHERE id='$gca'");
$hitdata	= mysql_num_rows($data2);
$cekdata	= mysql_fetch_array($data2);
$idParent	= $cekdata['parentId'];

?>		
	<form method="POST" action="page/mod_penilaian/aksi_penilaian.php?opt=<?=$opt?>&cc=<?=$unit?>"  id="formku" enctype="multipart/form-data">
		<div class="form-group col-lg-12 ">
			<div class="col-lg-6">
				<input type="radio" value="2" name="aprove" required> <b>Aprove</b>
			</div>
			<div class="col-lg-6">
				<div class="col-lg-12">
					<input type="radio" value="4" name="aprove" required> <b>Return</b>
				</div>
				<div class="col-lg-12">
					<label for="note"><b>Validasi Progress</b></label>
					<input type="text" name="val_progress" value="" class="form-control">
					<input type="hidden" name="gca" value="<?=$gca?>" class="form-control">
					<input type="hidden" name="nik" value="<?=$nik?>" class="form-control">
					<input type="hidden" name="penilai" value="<?=$penilai?>" class="form-control">
					<input type="hidden" name="id" value="<?=$id?>" class="form-control">
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
		<p></p>
		<div class="col-lg-12">
			<table class="table table-bordered">
				<thead>
				<tr>
					<th>Hasil Aktifitas</th>
					<th width="30%">CC</th>
					<th width="10%">Progress</th>
					<th width="8%">Lampiran</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="4">
						<?php
							if($hitdata <= 0){
								echo"$gca -> <b><font color='blue'>$data[aktifitas]</font></b>";
							}else{
								echo "<span style=\"color:blue\"><b>$gca : $data[aktifitas]</b></span> -> ";
								for($ak=1;$ak<=99;$ak++){
									$gca2 = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
										$fontColor="black";
										if($ak!=1){
											echo"-> ";
										}
										echo "<span style=\"color:$fontColor\">$gca2[aktivitas]</span>";
											$idParent=$gca2['parentId'];
											$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca2[tahun]'"));
											if ($idParent==$cek_id['id_tahun']){
												break;
											}
								}
							}
						?>
						</td>
					</tr>
					<tr>
						<?php
						if(empty($r['file'])){
							$disabled ="disabled";
							$color ="danger";
						}else{
							$disabled ="";
							$color ="success";
						}
						?>						
						<td><?=$data['hasil_akhir']?></td>
						<td title="<?=$data['uraian']?>"><b><?=$data['cc']?></b> : <?=$data['uraian']?></td>
						<td><?=$data['progress']?> %</td>
						<td >
							<a target='_blank' href='page/mod_penilaian/download.php?id=<?=ec($r['id_pencapaian'])?>' class='btn btn-xs btn-<?=$color?>' title='Download Lampiran' <?=$disabled?>><i class='fa fa-xs fa-download'></i></a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="form-group  col-lg-12">
			<hr>
			<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
		</div>
	</form>
