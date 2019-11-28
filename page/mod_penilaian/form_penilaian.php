<?php
$ex		= explode("-",$_POST['id']);
$bulan	= $ex[0];
$tahun	= $ex[1];
$unit	= $ex[2];
$nik	= $ex[3];
$gca	= $ex[4];
// echo"$bulan<br>";
// echo"$tahun<br>";
// echo"$unit<br>";
// echo"$nik<br>";
?>

	<form method="POST" action="page/mod_kkwk/aksi_kkwk.php?opt=<?=$_GET['opt']?>"  id="formku" enctype="multipart/form-data">
		<div class="form-group col-lg-12 ">
			<div class="col-lg-6">
				<label for="jo_gca">GCA / Job Order</label>
				<div class="input-group input-group">
					<input type="text" name="jo_gca" class="form-control" value="<?=$jo_gca?>" id="jo_gca" readonly>
					<span class="input-group-btn">
						<i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="gca()"></i>
					</span>
				</div>
					<input type="hidden" name="nik" value="<?=$_SESSION['nik']?>" class="form-control">
					<input type="hidden" name="id_pencapaian" value="<?=$kd_baru?>" class="form-control">
			</div>
							
			<div class="col-lg-12">
				<label for="tgl">Tanggal Aktifitas</label>
				<input type="text" name="tgl" value="<?=$tgl_aktifitas?>" class="form-control" placeholder="Tanggal Aktifitas" id="datepicker">
			</div>
			<div class="col-lg-12">
				<label for="deliverable">Deliverable / Hasil Akhir</label>
				<input type="text" name="deliverable" class="form-control" value="" placeholder="Deliverable" id="deliverable" readonly>
			</div>
			<div class="col-lg-12">
				<label for="h_aktifitas">Hasil Aktifitas</label>
				<textarea name="h_aktifitas" class="form-control"><?=$hasil_akhir?></textarea>
			</div>
					<hr/>
		</div>
					<div class="form-group  col-lg-12">
						<hr>
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger">Reset</button>
					</div>
	</form>