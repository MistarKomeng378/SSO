<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

	$ex				= explode("-",$_POST['id']);
	$id				= $ex[0];
	$status_nilai	= $ex[1];
	
	$edit			= mysql_fetch_array(mysql_query("SELECT * FROM pencapaian WHERE id_pencapaian='$id'")); 
	$jo_gca			= mysql_real_escape_string($edit['jo_gca']);
	$nik			= mysql_real_escape_string($edit['nik']);
	$tgl_a			= mysql_real_escape_string($edit['tgl_aktifitas']);
	$aktifitas		= mysql_real_escape_string($edit['aktifitas']);
	$jam_mulai		= mysql_real_escape_string($edit['jam_mulai']);
	$status_shift	= mysql_real_escape_string($edit['status_shift']);
	$progresst		= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca='$jo_gca' AND `status`='1')")); 
	
	$gca			= mysql_fetch_array(mysql_query("SELECT jenisAktf FROM wbs WHERE id='$jo_gca' "));
	if($gca['jenisAktf']==2){
?>
<script type="text/javascript">
	function showcetak(linkinpark){
		if (linkinpark==100){
			var txt;
			if (confirm("Anda yakin? Aktifitas ini bersifat Non-Rutin, Jika anda menginputkan 100% aktifitas di anggap selesai dan tidak dapat di gunakan untuk KKKW lagi.") == true) {
				txt = "100";
			} else {
				txt = "90";
			}
			document.getElementById("val_progress").value = txt;
		}
	}
</script>
	<?php
	}
	?>
<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
<form method="POST" action="page/mod_kkwk/aksi_selesai_p.php?nilai=<?=$status_nilai?>"  id="formku" enctype="multipart/form-data">
	<div class="form-group col-lg-12 ">
		<div class="col-lg-6">
			<br>
			<label for="jam_akhir">Jam Selesai</label>
			<input name="jam_akhir" value="<?=date("H:i:s")?>" type="text" class="form-control " readonly />
			<input name="jam_mulai" value="<?=$jam_mulai?>" type="hidden" class="form-control " readonly />
			<input name="tgl_a" value="<?=$tgl_a?>" type="hidden" class="form-control " readonly />
			<input name="id_pencapaian" value="<?=$id?>" type="hidden" class="form-control " />
			<input name="nik" value="<?=$nik?>" type="hidden" class="form-control " />
			<input name="jo_gca" value="<?=$jo_gca?>" type="hidden" class="form-control " />
			<input name="status_shift" value="<?=$status_shift?>" type="hidden" class="form-control " />
		</div>
		<div class="col-lg-12">
			<label for="h_aktifitas">Hasil Aktifitas</label>
			<textarea name="h_aktifitas" class="form-control" placeholder="Hasil Aktifitas" required></textarea>
		</div>
		<div class="col-lg-6">
			<label for="progress">Progress (Komulatif) <p ></p></label>
			<z data-tp-title='Informasi' data-tp-desc='Harap Melampirkan hasil pekerjaan apabila progress telah mencapai 100%' >
			<input type="text" name="progress" value="" class="form-control required" placeholder="Progress" onchange="showcetak(this.value)" required id="val_progress">
			</z>
		</div>
		<div class="col-lg-6">
			<label for="progress">Progress (Terakhir)</label>
			<input type="text" name="progresst" value="<?=$progresst['progress']?>" class="form-control required" placeholder="Progress" readonly>
		</div>
		<div class="col-lg-12">
			<label for="lampiran">Lampiran File</label>
			<input type="file" id="lampiran" name="lampiran" class="form-control"/>
		</div>
		<div class="col-lg-12">
			<label for="ket">Keterangan Lampiran</label>
			<textarea  name="ket" class="form-control" placeholder="Keterangan Lampiran"></textarea>
		</div>
	</div>
	<div class="form-group  col-lg-12">
		<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
	</div>
</form>

<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "bottom"
	});
</script>