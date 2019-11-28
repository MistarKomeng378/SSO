			<h1 class="page-header">Management
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Management Menu</h4>
			    </div>
			    <div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->

		<?php
			$getSub = dc($_GET['sub_menu']);
			if($getInsert==1){
				if(isset($_GET['sub_menu'])){
					echo'<a class="btn btn-primary btn-flat" href="?page=form_submenu&opt=tambah&id='.ec($getSub).'"><i class="fa fa-plus"></i> Tambah Submenu</a>';
				}else{
					echo'<a class="btn btn-primary btn-flat" href="?page=form_menu&opt=tambah"><i class="fa fa-plus"></i> Tambah Menu</a>';
				}
			}
		?>
		<hr>
		<?php
			
			if(isset($_REQUEST['delete'])){		
				$getId	= dc($_GET['delete']);
				mysql_query("DELETE FROM m_menu WHERE id_menu='$getId'");
				mysql_query("DELETE FROM m_menu WHERE parentId='$getId'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Dihapus.
                    </div>";
			}
			if(isset($_REQUEST['subdelete'])){
				$getId_sub	= dc($_GET['subdelete']);
				mysql_query("DELETE FROM sub_menu WHERE id_sub='$getId_sub'");
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
			if(isset($_REQUEST['failed'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Failed!</b> Terjadi Kesalahan.
                    </div>";
			}
		?>
			<table class="table table-bordered table-striped table-hover" >
				<thead>
					<tr>
						<th width="3%">Action</th>
						<th>No</th>
						<th colspan="2">ID/ParentId</th>
						<th>Menu</th>
						<th>Link</th>
						<th>Direktori</th>
						<th>File</th>
						<th>Icon</th>
						<th width="4%">Status</th>
						<th width="4%">View</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						if(isset($_GET['sub_menu'])){
							$query = mysql_query("SELECT * FROM m_menu WHERE parentId='$getSub' ORDER BY `id_menu`"); //submenu
						}else{
							$query = mysql_query("SELECT * FROM m_menu WHERE parentId='0' ORDER BY `order`");  // menu uatama
						}						
						while($r=mysql_fetch_array($query)){
							///////////////////// STATUS  ///////////////////////////////////////
							if($r['status']==1){
								$status="<a href='page/mod_menu/query_status.php?id=$r[id_menu]&sts=$r[status]' title='Nonaktifkan Menu' class='btn-xs btn-primary btn-flat' ><i class='fa fa-check'></i></a>";
							}else{
								$status="<a href='page/mod_menu/query_status.php?id=$r[id_menu]&sts=$r[status]' title='Aktifkan Menu' class='btn-xs btn-danger btn-flat' ><i class='fa fa-times'></i></a>";
							}
							//////////////////// VIEW ///////////////////////////////////////////
							if($r['view']==1){
								$view="<a href='page/mod_menu/query_view.php?id=$r[id_menu]&view=$r[view]' title='Nonaktifkan View' class='btn-xs btn-primary btn-flat' ><i class='fa fa-check'></i></a>";
							}else{
								$view="<a href='page/mod_menu/query_view.php?id=$r[id_menu]&view=$r[view]' title='Aktifkan View' class='btn-xs btn-danger btn-flat' ><i class='fa fa-times'></i></a>";
							}
							echo"
								<tr>
									<td>
                                        <div class='btn-group'>
                                            <button type='button' class='btn btn-primary btn-xs dropdown-toggle' data-toggle='dropdown'>
                                                <span class='caret'>
                                            </button>
                                            <ul class='dropdown-menu'>";
											if($getInsert==1){
												if(!isset($_GET['sub_menu'])){
													echo"<li><a href='page.php?page=manage_menu&sub_menu=".ec($r['id_menu'])."'><i class='fa fa-plus'></i> Submenu</a></li>";
												}
											}if($getEdit==1){
												if(isset($_GET['sub_menu'])){
													echo"<li><a href='page.php?page=form_submenu&opt=edit&id=".ec($r['id_menu'])."'><i class='fa fa-edit'></i> Edit</a></li>";													
												}else{
													echo"<li><a href='page.php?page=form_menu&opt=edit&id=".ec($r['id_menu'])."'><i class='fa fa-edit'></i> Edit</a></li>";
												}
											}if($getDelete==1){
												if(isset($_GET['sub_menu'])){
													echo"<li><a href='page.php?page=manage_menu&subdelete=".ec($r['id_menu'])."' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash-o'></i> Delete</a></li>";
												}else{
													echo"<li><a href='page.php?page=manage_menu&delete=".ec($r['id_menu'])."' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash-o'></i> Delete</a></li>";
												}
											}
										echo"</ul>
										</div>
									</td>
									<td>$no</td>
									<td>$r[id_menu]</td>
									<td>$r[parentId]</td>
									<td>$r[menu]</td>
									<td>$r[link]</td>
									<td>$r[dir]</td>
									<td>$r[file]</td>
									<td>$r[icon]</td>
									<td>";
									if($getEdit==1){
										echo"$status";
									}
								echo"</td>
									<td>";
									if($getEdit==1){
										echo"$view";
									}
								echo"</td>
								</tr>
							";
						$no++;
						}
					?>
				</tbody>
				</table>
<!--------------------------------------------------------------------------------------------------------------------->
		</div>
	</div>