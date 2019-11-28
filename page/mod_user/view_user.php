			<h1 class="page-header">Management
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Management User</h4>
			    </div>
			    <div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
		<?php
			if($getInsert==1){
				echo'<a class="btn btn-primary btn-flat" href="page.php?page=data_karyawan"><i class="fa fa-plus"></i> Tambah User</a>';
				echo' <a class="btn btn-primary btn-flat" href="page.php?page=form_karyawan"><i class="fa fa-plus"></i> Tambah Master Karyawan</a>';
			}
		?>
		<hr>
		<?php
			
			if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM user WHERE id='".dc($_REQUEST['delete'])."' ");
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
                        <b>Failed!</b> User Sudah dibuat.
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
			<table class="table table-bordered table-striped table-hover" id="example2">
				<thead>
					<tr>
						<th width="7%" colspan="2">Action</th>
						<th>No</th>
						<th>NIK</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Level</th>						
						<th>Divisi</th>
						<th>Date Reg</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						// $query = mysql_query("SELECT `level`.`level` as otorisasi, `mskko`.`uraian`, `user`.* FROM `user` INNER JOIN `level` ON `level`.id_level = `user`.`level`,`mskko` where `mskko`.`CostCenter` = `user.`cc`  ");
						$query = mysql_query("SELECT
												`level`.level AS otorisasi,
												`user`.id,
												`user`.nik,
												`user`.name,
												`user`.email,
												`user`.password,
												`user`.grup_id,
												`user`.level,
												`user`.date_reg,
												`user`.date_update,
												`user`.cc,
												mskko.uraian
												FROM
												`user`
												INNER JOIN `level` ON `level`.id_level = `user`.`level`,
												mskko
												WHERE
												mskko.CostCenter = `user`.cc 
											");
						
						while($r=mysql_fetch_array($query)){
							
							echo"
								<tr>
									<td>
									<div class='btn-group'>
										  <button type='button' class='btn btn-primary btn-xs dropdown-toggle' data-toggle='dropdown'>
											<span class='caret'></span>
											<span class='sr-only'>Toggle Dropdown</span>
										  </button>
										  <ul class='dropdown-menu' role='menu'>";
											echo"<li><a href='page.php?page=timeline&th=&id=".ec($r['nik'])."'><i class='fa fa-clock-o'></i> Timeline</a></li>";
											if($getInsert==1){
												echo"<li><a href='page.php?page=privileges&set=".ec($r['nik'])."'><i class='fa fa-gear'></i> Privileges</a></li>";
											}if($getEdit==1){
												echo"<li><a href='page.php?page=form_user&edit=".ec($r['id'])."'><i class='fa fa-edit'></i> Edit</a></li>";
												echo"<li><a href='page.php?page=form_user&opt=nik&edit=".ec($r['id'])."'><i class='fa fa-edit'></i> Edit NIK</a></li>";
											}if($getDelete==1){
												echo"<li><a href='page.php?page=manage_user&delete=".ec($r['id'])."' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash-o'></i> Delete</a></li>";
											}
										echo" </ul>
									</div>
									</td>
									<td>
									</td>
									<td>$no</td>
									<td>$r[nik]</td>
									<td>$r[name]</td>
									<td>$r[email]</td>
									<td>$r[otorisasi]</td>
									<td>$r[uraian]</td>
									<td>".tgl_indo($r['date_reg'])."</td>
								</tr>
							";
						$no++;
						}
						// <li><a href='page.php?page=privileges&set=$r[id]'><i class='fa fa-gear'></i> Privileges</a></li>
					?>
				</tbody>
				</table>
<!--------------------------------------------------------------------------------------------------------------------->
		</div>
	</div>