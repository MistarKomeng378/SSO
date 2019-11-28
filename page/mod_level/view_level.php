			<h1 class="page-header">Management
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Management Level</h4>
			    </div>
			    <div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->

		<?php
			if($getInsert==1){
				echo'<a class="btn btn-primary btn-flat" href="page.php?page=form_level&tambah"><i class="fa fa-plus"></i> Tambah Level</a>';
			}
		?>
		<hr>
		<?php
			
			if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM users WHERE id='$_REQUEST[delete]' ");
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
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
?>
		<div class="col-lg-6">
			<table class="table table-bordered table-striped table-hover" >
				<thead>
					<tr>
						<th width="7%" colspan="2">Action</th>
						<th>No</th>
						<th>Level</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						$query = mysql_query("SELECT * FROM `level`");
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
											if($getInsert==1){
												echo"<li><a href='page.php?page=privileges_lv&set=$r[id_level]'><i class='fa fa-gear'></i> Privileges</a></li>";
											}if($getEdit==1){
												echo"<li><a href='page.php?page=form_user&edit=$r[id_level]'><i class='fa fa-edit'></i> Edit</a></li>";
											}if($getDelete==1){
												echo"<li><a href='page.php?page=user&delete=$r[id_level]' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash-o'></i> Delete</a></li>";
											}
										echo"</ul>
									</div>
									</td>
									<td>
									</td>
									<td>$no</td>
									<td>$r[level] </td>
								</tr>
							";
						$no++;
						}
					?>
				</tbody>
				</table>
			</div>
<!--------------------------------------------------------------------------------------------------------------------->
		</div>
	</div>