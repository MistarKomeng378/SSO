
			<h1 class="page-header">Privileges
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Set Privileges</h4>
			    </div>
			    <div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
<div class="box box-primary">
	<form role="form" method="POST" action="page/mod_user/query_privil.php" id="formku">
		<div class="box-body">
		<?php
			
			if(isset($_REQUEST['succes'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Disimpan.
                    </div>";
			}
		?>
			<div class="col-lg-8">
			<table class="table table-bordered table-striped table-hover" >
				<thead>
					<tr>
						<th width="3%">No</th>
						<th width="5%" colspan="2">ID/ParentId</th>
						<th>Menu</th>
						<th width="3%">View</th>
						<th width="3%">Insert</th>
						<th width="3%">Edit</th>
						<th width="3%">Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						$nik 	= mysql_real_escape_string(dc($_GET['set']));
						$level 	= mysql_fetch_array(mysql_query("SELECT level FROM user WHERE nik='$nik'"));
						echo"<input type='hidden' name='level' value='$level[level]'>";
						echo"<input type='hidden' name='nik' value='$nik'>";
						$query 	= mysql_query("SELECT * FROM m_menu WHERE status='1'");
						while($r=mysql_fetch_array($query)){
							$role = mysql_num_rows(mysql_query("SELECT DISTINCT * FROM role_menu WHERE id_menu='$r[id_menu]' AND level='$level[level]' AND nik='$nik'"));
							echo"
								<tr>
									<td>$no</td>
									<td>$r[id_menu]</td>
									<td>$r[parentId]</td>
									<td>$r[menu]</td>
									<td><input type='checkbox' name='id_menu[]' value='$r[id_menu]' "; if($role == 1){echo"checked";} echo"></td>
									";
									$getPer=mysql_query("SELECT * FROM permission");
									while($p=mysql_fetch_array($getPer)){
										$role_per=mysql_num_rows(mysql_query("SELECT DISTINCT * FROM role_permission WHERE id_permission='$p[id_permission]' AND id_menu='$r[id_menu]' AND level='$level[level]' AND nik='$nik'"));
										echo"<td><input type='checkbox' name='permission[]' value='$r[id_menu]-$p[id_permission]' "; if($role_per == 1){echo"checked";} echo"></td>";
									}
								echo"
								</tr>
							";
						$no++;
						}
					?>
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="box-footer">
			<?php
				if($getInsert==1){
					echo'<button type="submit" name="Simpan" value="Simpan" class="btn btn-primary">Simpan</button>';
				}				
			?>
			</div>
        </div>		
	</form>
	<br>
</div>
<!--------------------------------------------------------------------------------------------------------------------->
		</div>
	</div>