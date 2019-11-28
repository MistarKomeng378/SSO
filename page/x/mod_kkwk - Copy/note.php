<div class='col-lg-12'>
<?php
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_name.php";
include"../../config/encript.php";
	$ex 	= explode("-",$_POST['id']);
	$nik 	= $ex[0];
	$jo_gca = $ex[1];
	$hasil	= $ex[2];
	$id		= $ex[3];
	$aprove	= $ex[4];
	$note = mysql_fetch_array(mysql_query("SELECT * FROM note_kinerja WHERE nik='$nik' AND id_pencapaian='$id'"));
	// $data 	= mysql_fetch_array(mysql_query("SELECT * FROM pencapaian WHERE nik='$nik' AND id_pencapaian='$id'"));
	// $cc		= $data['cc'];
	// $uraian	= $data['uraian'];
	if($aprove==4){	
		if(!empty($note['note'])){
				$icon = "remove";
				echo"<div class='alert alert-$note[notif] alert-dismissable'>
				<i class='fa fa-$icon'></i>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<b>Note!</b> 
				<ul>
					<li>Oleh : ".name($note['penilai'])."</li>
					<li>Pada Tanggal :".tgl_indo($note['tgl_note'])."</li>
					<li>$note[note]</li>
					<li>Mohon dilakukan perbaikan berdasarkan catatan diatas.</li>
					<li>Isikan hasil perbaikan pada form dibawah ini.</li>
				</ul>
			</div>
			<form method='POST' action='page/mod_kkwk/aksi_revisi.php'>
				<input name='id_pencapaian' value='$id' type='hidden' class='form-control ' />
				<input name='nik' value='$nik' type='hidden' class='form-control ' />
				<div class='col-lg-12'>
					<label for='h_aktifitas'>Hasil Aktifitas</label>
					<textarea name='h_aktifitas' class='form-control' placeholder='Hasil Aktifitas' required></textarea>
				</div>
				<div class='col-lg-6'>
					<label for='progress'>Progress</label>
					<input type='text' name='progress' value='100' class='form-control required' placeholder='Progress' >
				</div>
				<div class='col-lg-6'>
					<label for='lampiran'>Lampiran File</label>
					<input type='file' id='lampiran' name='lampiran' class='form-control'/>
				</div>
				<div class='col-lg-12'>
					<label for='ket'>Keterangan Lampiran</label>
					<textarea  name='ket' class='form-control' placeholder='Keterangan Lampiran'></textarea>
				</div>
				
				<div class='form-group  col-lg-12'>
				<hr>
					<button type='submit' name='simpan' value='simpan' class='btn btn-primary'>Submit</button>
				</div>
			</form>
			<br>
			";
		}else{
			echo"<h4>Tidak ada Catatan !!</h4>
			<form method='POST' action='page/mod_kkwk/aksi_revisi.php'>
				<input name='id_pencapaian' value='$id' type='hidden' class='form-control ' />
				<input name='nik' value='$nik' type='hidden' class='form-control ' />
				<div class='col-lg-12'>
					<label for='h_aktifitas'>Hasil Aktifitas</label>
					<textarea name='h_aktifitas' class='form-control' placeholder='Hasil Aktifitas' required></textarea>
				</div>
				<div class='col-lg-6'>
					<label for='progress'>Progress</label>
					<input type='text' name='progress' value='100' class='form-control required' placeholder='Progress' >
				</div>
				<div class='col-lg-6'>
					<label for='lampiran'>Lampiran File</label>
					<input type='file' id='lampiran' name='lampiran' class='form-control'/>
				</div>
				<div class='col-lg-12'>
					<label for='ket'>Keterangan Lampiran</label>
					<textarea  name='ket' class='form-control' placeholder='Keterangan Lampiran'></textarea>
				</div>
				
				<div class='form-group  col-lg-12'>
				<hr>
					<button type='submit' name='simpan' value='simpan' class='btn btn-primary'>Submit</button>
				</div>
			</form>
			<br>";
		}
	}else{
		if(!empty($note['note'])){
			$icon = "check";
					echo"<div class='alert alert-$note[notif] alert-dismissable'>
					<i class='fa fa-$icon'></i>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<b>Note!</b> 
					<ul>
						<li>Oleh : ".name($note['penilai'])."</li>
						<li>Pada Tanggal :".tgl_indo($note['tgl_note'])."</li>
						<li>$note[note]</li>
					</ul>
				</div>";
		}else{
			echo"<h4>Tidak ada Catatan !!</h4>";
		}
	}
?>
</div>
