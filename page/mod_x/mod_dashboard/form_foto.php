<?php
session_start();
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_name.php";

	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$nik	  = dc($_POST['id']);
?>

<form method="POST" action="page/mod_dashboard/aksi_upload_foto.php"  enctype="multipart/form-data">
		<div class="form-group col-lg-3 ">
			
			<?php
				if(foto($nik)==""){
					echo'<img src="assets/img/no_foto.png" alt="" width="80%" />';
				}else{
					echo"<img src='upload/thumbs/thumb_".$nik.".jpeg' alt='' width='80%' />";
				}
			?>
		</div>
		<div class="form-group col-lg-9 ">
			<input name="nik" value="<?=$nik?>" type="hidden" class="form-control " />
			<label for="foto">Foto</label>
			<input type="file" id="foto" name="foto" class="form-control"/><br>
			<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
		</div>
		
</form>