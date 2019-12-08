<?php
if($_GET['opt']=="tambah"){
	$tahun			= date('Y');
	$sql_sat		= mysql_query("SELECT max(id) as no FROM budaya");
	$no_sat			= mysql_fetch_array($sql_sat);
	$nosat			= $no_sat['no'];
	$id_baru		= (int)$nosat + 1;
	
	$id				= "";
	$prilaku			= "";
	$ket		= "";
}elseif($_GET['opt']=="edit"){
	$getId			= dc($_GET['id']);
	//$id				= mysql_real_escape_string($getId);
	$edit			= mysql_fetch_array(mysql_query("SELECT * FROM budaya WHERE id='$getId'")); 
	$id				= $edit['id'];
	$id_baru		= $edit['id'];
	$prilaku		= $edit['prilaku'];
	$ket	        = $edit['ket'];
	$nilai			= $edit['nilai'];
    
}
?>
		
	<h1 class="page-header">Form Nilai Budaya
		<small><?=$_SESSION['nm_level']?></small>
	</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>Form Satuan</h4>
		</div>
		<div class="panel-body">
			
				<form method="POST" action="page/mod_budaya/aksi_budaya.php?opt=<?=$_GET['opt']?>"  id="formku">
					<div class="form-group col-lg-12 ">
					<div class="form-group  col-lg-6">
						<div class="col-lg-12">
								<label for="prilaku">Prilaku</label>
								<input type="text"name="prilaku" class="form-control" value="<?=$prilaku?>" required id="prilaku">
								<input type="hidden" name="id" value="<?=$id_baru?>" class="form-control" >
						</div>
						<div class="col-lg-12">
								<label for="aktifitas">Keterangan</label>
								<textarea name="ket" class="form-control" required id="ket"><?=$ket?></textarea>
						</div>
						<div class="col-lg-12">
								<label for="aktifitas">Bobot</label>
								<input type="text"name="nilai" class="form-control" value="<?=$nilai?>" required id="nilai">
								<!-- <small>default Nilai diisikan dengan angka 2.5</small> -->
						</div>
					</div>
					<hr/>
					</div>
					<div id="record"></div>
					<div class="form-group  col-lg-12">
						<hr>
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger">Reset</button>
					</div>
				</form>
		</div>
	</div>