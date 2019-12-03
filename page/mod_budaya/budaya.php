<?php

// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".date('Y')."'"));
// 	if($_COOKIE['tahun_srko']==""){
// 		$getTahun 		= $thn['tahun'];
// 		$idtahun_srko 	= $thn['id_tahun'];
// 	}else{
// 		$getTahun 		= $_COOKIE['tahun_srko'];
// 		$idtahun_srko	= $_COOKIE['idtahun_srko'];
// 	}

// $unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
// $getUnit	= dc($_GET['unit']);
?>	
		<h1 class="page-header"> Nilai Budaya Perusahaan
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Nilai Budaya Perusahaan <?=$getTahun?></h4>
			    </div>
			    <div class="panel-body">
			
			<?php
			if(isset($_REQUEST['delete'])){
				$getId	= dc($_GET['delete']);
				mysql_query("DELETE FROM budaya WHERE id='$getId'");
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
		
		
		<table border="0" width="100%">
			<tr>
				<td>
					<div class='col-lg-8'>
					    <a href='?page=form_budaya&opt=tambah' class='btn btn-primary'><i class='fa fa-plus'></i> Input Nilai Budaya</a>
			        </div>
				</td>
			</tr>
		</table>
		<br>
		<table id="example1" class="table table-bordered table-striped table-hover" width="70%">
				<thead>
					<th width="5%">No.</th>
					<th>Prilaku</th>
					<th>Keterangan</th>
					<th width="10%"></th>
				</thead>
				<tbody>
					<?php
						$query = mysql_query("SELECT * FROM budaya");
						$i=1;
						while($r=mysql_fetch_array($query)){
							echo"
								<tr>
									<td align='center'>$i</td>
									<td >$r[prilaku]</td>
									<td>$r[ket]</td>
									<td align='center' width='30' >";
									//=====================
									if($getEdit==1){
										echo"<a href='?page=form_budaya&opt=edit&id=".ec($r['id'])."' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a> ";
									}if($getDelete==1){
										echo"<a href='?page=budaya&delete=".ec($r['id'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
									}
									echo"
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

