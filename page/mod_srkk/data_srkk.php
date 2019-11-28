<?php
	function serialize_ke_string($serial)
	{
		$hasil = unserialize($serial);
		return implode(', ', $hasil);
	}
	$getUnit	= dc($_GET['unit']);
?>
<style>
/*    css disini*/
 
    .mytable th{
        background-color: #ccd9ff
    }
</style>

<h1 class="page-header">Data SRKK
	<small><?=$_SESSION['nm_level']?></small>
</h1>
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Satuan Rencana Kerja Karyawan Tahun <?=$tahun_aktif?></h4>
	</div>
	<div class="panel-body">
			<?php
			
			if(isset($_REQUEST['delete'])){
				// $getId	= dc($_GET['delete']);
				// mysql_query("DELETE FROM srko WHERE id_srko='$getId'");
				// mysql_query("DELETE FROM wbs WHERE id_srko='$getId'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Dihapus.
                    </div>";
			}
			if(isset($_REQUEST['succes'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Disimpan.
                    </div>";
			}
			if(isset($_REQUEST['failed'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Gagal, Terjadi Kesalahan.
                    </div>";
			}
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
			
		?>
		<div class="table-responsive">
		<div class="col-lg-12">
			<table class="table table-bordered table-striped table-hover" >
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th>Cost Center</th>
						<th>Uraian</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						// $query = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='1.6' AND id!='4'");
						$query = mysql_query("SELECT * FROM mskko WHERE id!='1.6' AND id!='4'");
						while($r=mysql_fetch_array($query)){
							$qManager = mysql_fetch_array(mysql_query("SELECT * FROM v_manager WHERE CostCenter='$r[CostCenter]'"));
							echo"
							<tr>
								<td>$no</td>
								<td>$r[CostCenter]</td>
								<td>$r[uraian]</td>
								<td>";
								if($getInsert==1){
									echo"<a href='?page=form_srkk&unit=".ec($r['CostCenter'])."&opt=tambah' class='btn btn-xs btn-primary' title='Input SRKK'><i class='glyphicon glyphicon-plus'></i> Pilih SRKK</a> ";
									echo"<a href='page/mod_srkk/aksi_srkk_unit2.php?tahun=$tahun_aktif&id=".ec($r['id'])."&unit=".ec($r['CostCenter'])."&opt=tambah' class='btn btn-xs btn-primary' ><i class='glyphicon glyphicon-refresh'></i> Generate SRKK Unit</a> ";
									echo"<a href='page/mod_srkk/aksi_srkk_kepala.php?tahun=$tahun_aktif&id=".ec($r['id'])."&unit=".ec($r['CostCenter'])."&opt=tambah' class='btn btn-xs btn-success' ><i class='glyphicon glyphicon-refresh'></i> SRKK Kepala Unit</a> ";
								}
								echo"</td>
							</tr>
							";
						$no++;
						}
					?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>