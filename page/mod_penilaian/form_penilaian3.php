<?php 
session_start();
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/encript.php";

// echo $_POST['id'];
$ex			= explode("+",$_POST['id']);
$unit		= $ex[0];
$nik		= $ex[1];
$penilai	= $ex[2];
$opt		= $ex[3];


$query = mysql_query("SELECT  id_pencapaian,aktifitas,hasil_akhir,jo_gca,nik,faktor_k,progress,aprove,status_nilai,file,tgl_aktifitas,uraian
FROM pencapaian 
WHERE nik='$nik' 
AND status='1' 
AND progress='100' 
AND laporan='$penilai' 
AND aprove='1' 
AND cc='$unit' 
ORDER BY tgl_aktifitas,jam_mulai DESC");


// $data2		= mysql_query("SELECT parentId FROM wbs WHERE id='$gca'");
// $hitdata	= mysql_num_rows($data2);
// $cekdata	= mysql_fetch_array($data2);
// $idParent	= $cekdata['parentId'];

// echo"$unit<br>";
// echo"$nik<br>";
// echo"$penilai<br>";
// echo"$opt<br>";
?>	<div class="col-lg-12">
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
	<form method="POST" action="page/mod_penilaian/aksi_penilaian2.php?opt=<?=$opt?>&cc=<?=$unit?>"  id="formku" enctype="multipart/form-data">
		<input type="hidden" name="nik" value="<?=$nik?>" class="form-control">
		<input type="hidden" name="penilai" value="<?=$penilai?>" class="form-control">
		<table id="example1" class="table table-bordered table-striped table-hover" >
			<thead>
				<th width="3%">No.</th>
				<th width="25%">Aktifitas</th>
				<th width="20%">Hasil Aktifitas</th>
				<th width="3%">Approve</th>
				<th width="3%">Return</th>				
				<th width="3%">Validasi Progress</th>				
				<th width="20%">Note</th>
				<th width="2%"></th>
			</thead>
			<tbody>
			<?php
				$no=1;
				while($r=mysql_fetch_array($query)){
					echo"
						<input type='hidden' name='gca[]' value='$r[jo_gca]' class='form-control'>
						<input type='hidden' name='id[]' value='$r[id_pencapaian]' class='form-control'>
					";
					
					if(empty($r['file'])){
						$disabled ="disabled";
						$color ="danger";
					}else{
						$disabled ="";
						$color ="success";
					}
							
					$data		= mysql_query("SELECT parentId FROM wbs WHERE id='$r[jo_gca]'");
					$hitdata	= mysql_num_rows($data);
					$cekdata	= mysql_fetch_array($data);
					$idParent	= $cekdata['parentId'];					
					echo"
					<tr>
						<td width='3%'>$no</td>
						<td>";
						if($hitdata <= 0){
							echo"$r[jo_gca] -> <b><font color='blue'>$r[aktifitas]</font></b>";
						}else{
							echo "<span style=\"color:blue\"><b>$r[jo_gca] : $r[aktifitas]</b></span> -> ";
							for($ak=1;$ak<=99;$ak++){
								$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
									$fontColor="black";
									if($ak!=1){
										echo"-> ";
									}
									echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
										$idParent=$gca['parentId'];
										$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
										if ($idParent==$cek_id['id_tahun']){
											break;
										}
							}
						}
					echo"<br>
						<span style=\"color:green\"><b>$unit : $r[uraian]</b></span>
						</td>
						<td>$r[hasil_akhir]</td>
						<td align='center'>
							<input type='radio' value='2' name='aprove_$no'>
						</td>
						<td align='center'>
							<input type='radio' value='4' name='aprove_$no'>
						</td>
						<td>
							<input type='text' name='val_progress[]' value='' class='form-control'>
						</td>
						<td><textarea name='note[]' class='form-control'></textarea></td>
						<td>
							<a target='_blank' href='page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-$color' title='Download Lampiran' $disabled><i class='fa fa-xs fa-download'></i></a>
						</td>
					</tr>
					";
				$no++;
				}
			?>
			</tbody>
		</table>
		<div class="form-group  col-lg-12">
			<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
		</div>
	</form>
