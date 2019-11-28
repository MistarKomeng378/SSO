
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
		<div class="table-responsive">
			<table id="example2" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nik</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Divisi</th>
						<th>Jabatan</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						$query = mysql_query("SELECT m_karyawan.regno as nik,
														m_karyawan.`name`,
														m_karyawan.email,
														m_jabatan.posdesc,
														mskko.uraian,
														mskko.CostCenter as cc,
														mskko.id,
														m_jabatan.poscode as kd_jab
														FROM
														m_karyawan
														INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
														LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
														");
						while($r=mysql_fetch_array($query)){
							
							echo"
								<tr>
									<td>$no</td>
									<td>$r[nik] </td>
									<td>$r[name] </td>
									<td>$r[email]</td>
									<td>$r[uraian]</td>
									<td>$r[posdesc]</td>
									<td>";
									$cek = mysql_num_rows(mysql_query("SELECT * FROM user WHERE nik='$r[nik]'"));
									if($cek >= 1){
										echo"<a class='btn btn-xs btn-danger' href='#'><i class='fa fa-check'></i> Telah dibuat</a>";
									}else{
										echo"<a class='btn btn-xs btn-primary' href='?page=form_user&nik=".ec($r['nik'])."'><i class='fa fa-plus'></i> Buat User</a>";
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
	</div>