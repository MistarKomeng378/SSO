			<h1 class="page-header">Upload File
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Upload File</h4>
			    </div>
			    <div class="panel-body">
				<div class="form-group col-lg-12 row">
				<?php
					if($getInsert==1){
						echo'<form enctype="multipart/form-data" method="POST">
							<div class="col-lg-4">
								<input type="file" name="berkas" class="form-control">
							</div>
							<div class="col-lg-4">
								<button type="submit" name="simpan" value="simpan" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
							</div>
						</form>';
					}
				?>
				</div>
				
				<div class="form-group col-lg-12 row"><hr>
				<?php
					if(isset($_POST['simpan'])){
						$tipe  		= $_FILES['berkas']['type'];
						$ukuran 	= $_FILES['berkas']['size'];
						$nama_file	= $_FILES['berkas']['name'];
						$tmpName  	= $_FILES['berkas']['tmp_name']; 
						$folder		= "upload/$nama_file";
						move_uploaded_file($tmpName,$folder);
						mysql_query ("insert into resource_file values ('','$nama_file','$ukuran','$tipe','upload')")or die(mysql_error());
						
						header("Location: ?page=upload_file&succes=1");
					}
					if(isset($_REQUEST['delete'])){
						mysql_query("DELETE FROM resource_file WHERE id_resource='$_GET[delete]'");
						unlink("upload/$_GET[file]");
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
				?>
				</div>
				<div class="form-group col-lg-12 ">
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped table-hover" >
						<thead>
						   <tr>
							 <th width="5%">No.</th>
							  <th>Nama file</th>
							  <th>Type</th>
							  <th>Ukuran</th>
							  <th>Deskripsi</th>
							  <th></th>
						   </tr>
						</thead>
						<tbody>
							   <?php 
							   $no=1;
							   $query = mysql_query("SELECT * FROM resource_file");
							   while ($r=mysql_fetch_array($query)){
								   echo"<tr>
											<td>$no</td>
											<td>$r[file]</td>
											<td>$r[type]</td>
											<td>$r[size]</td>
											<td>$r[dir]</td>
											<td>";
											if($getDelete==1){
												echo"<a href='?page=upload_file&delete=$r[id_resource]&file=$r[file]' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
											}
										echo"</td>
									   </tr>";
								$no++;
							  } 
							  ?>
						</tbody>
					</table>
			</div>
			</div>
		</div>
	</div>