<?php
if($_GET['opt']=="tambah"){
	$tahun			= date('Y');
	$sql_kpi		= mysql_query("SELECT max(id_kpi) as no FROM kpi where tahun='$tahun'");
	$no_kpi			= mysql_fetch_array($sql_kpi);
	$nokpi			= $no_kpi['no'];
	$id_baru		= (int)$nokpi + 1;
	//____________________________________________________________________//
	$sql_kpi2		= mysql_query("SELECT max(no_urut) as nomor FROM kpi ");
	$no_urut		= mysql_fetch_array($sql_kpi2);
	$no_			= $no_urut['nomor'];
	$no_baru		= (int)$no_ + 1;
	$id				= "";
	$kpi			= "";
	$definisi		= "";
}elseif($_GET['opt']=="edit"){
	$getId			= dc($_GET['id']);
	$tahun			= $_GET['tahun'];
	$id				= mysql_real_escape_string($getId);
	$edit			= mysql_fetch_array(mysql_query("SELECT * FROM kpi WHERE id_kpi='$id' AND tahun='$tahun'")); 
	$id				= $edit['id_kpi'];
	$id_baru		= $edit['id_kpi'];
	$no_baru		= $edit['no_urut'];
	$kpi			= $edit['kpi'];
	$definisi		= $edit['definisi'];
	
}
?>
		
	<h1 class="page-header">Form KPI
		<small><?=$_SESSION['nm_level']?></small>
	</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Form KPI</h4>
		</div>
		<div class="panel-body">
			
				<form method="POST" action="page/mod_kpi/aksi_kpi.php?opt=<?=$_GET['opt']?>"  id="formku" enctype="multipart/form-data">
					<div class="form-group col-lg-12 ">
					<div class="form-group  col-lg-6">
						<div class="col-lg-12">
								<label for="kpi">KPI</label>
								<textarea name="kpi" class="form-control required" id="kpi"><?=$kpi?></textarea>
								<input type="hidden" name="id" value="<?=$id_baru?>" class="form-control" >
								<input type="hidden" name="no_urut" value="<?=$no_baru?>" class="form-control" >
						</div>
						<div class="col-lg-12">
								<label for="aktifitas">Definisi KPI</label>
								<textarea name="definisi" class="form-control required" id="definisi"><?=$definisi?></textarea>
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