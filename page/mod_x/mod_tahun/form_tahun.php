<?php
if($_GET['opt']=="tambah"){
			$id			= "";
			$kpi			= "";
			$definisi		= "";
}elseif($_GET['opt']=="edit"){
			$id				= mysql_real_escape_string($_GET['id']);
			$edit			= mysql_fetch_array(mysql_query("SELECT * FROM kpi WHERE id_kpi='$id'")); 
			$id				= $edit['id_kpi'];
			$kpi			= $edit['kpi'];
			$definisi		= $edit['definisi_kpi'];
		}
			
		?>
		
		
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Kinerja</a></li>
				<li><a href="javascript:;">Data KPI</a></li>
				<li><a href="javascript:;">Form KPI</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Form KPI
				<small><?=$level['level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Form KPI</h4>
			    </div>
			    <div class="panel-body">
		<!--<a href="javascript:add();"  class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambah Record</a>
		<hr/>-->
			
				<form method="POST" action="page/mod_kpi/aksi_kpi.php?opt=<?=$_GET['opt']?>"  id="formku" enctype="multipart/form-data">
					<div class="form-group col-lg-12 ">
					<div class="form-group  col-lg-6">
						<div class="col-lg-12">
								<label for="kpi">KPI</label>
								<textarea name="kpi" class="form-control required" id="kpi"><?=$kpi?></textarea>
								<input type="hidden" name="id" value="<?=$id?>" class="form-control" >
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
</div>