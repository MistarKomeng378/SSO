<?php
	function serialize_ke_string($serial)
	{
		$hasil = unserialize($serial);
		return implode(', ', $hasil);
	}
?>
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Kinerja</a></li>
				<li><a href="javascript:;">Data KPI</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Data KPI
				<small><?=$level['level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Data KPI</h4>
			    </div>
			    <div class="panel-body">
			<a href="?page=form_kpi&opt=tambah" class="btn btn-primary"><i class='fa fa-plus'></i> Tambah KPI</a>
			<!--<a href="?page=import_srko" class="btn btn-primary"><i class='fa fa-upload'></i> Import SRKO</a>-->
			
			<hr>
			<?php
			
			if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM kpi WHERE id+kpi='$_GET[delete]'");
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
                        <i class='fa fa-remove'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Failed!</b> Terjadi Kesalahan.
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
			<table id="example1" class="table table-bordered table-striped table-hover" >
				<thead>
					<th>No.</th>
					<th>KPI</th>
					<th>Definisi</th>
					<th>Status</th>
					<th width="8%"></th>
				</thead>
				<tbody>
					<?php
						$query = mysql_query("SELECT * FROM kpi ORDER BY id_kpi");
						$i=1;
						while($r=mysql_fetch_array($query)){
							if($r['status_kpi']==1){
								$status="<a href='page/mod_kpi/query_status.php?id=$r[id_kpi]&sts=$r[status_kpi]' title='Nonaktifkan User' class='btn-xs btn-primary btn-flat' ><i class='fa fa-check'></i></a>";
							}else{
								$status="<a href='page/mod_kpi/query_status.php?id=$r[id_kpi]&sts=$r[status_kpi]' title='Aktifkan User' class='btn-xs btn-danger btn-flat' ><i class='fa fa-times'></i></a>";
							}
							
							echo"
								<tr>
									<td>$i</td>
									<td>$r[kpi]</td>
									<td>$r[definisi]</td>
									<td>$status</td>
									<td>
										<a href='?page=form_kpi&opt=edit&id=$r[id_kpi]' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a>
										<a href='?page=katalog_kpi&delete=$r[id_kpi]' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>
									</td>
								</tr>
							";
							$i++;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>