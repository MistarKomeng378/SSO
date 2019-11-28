<?php
	function serialize_ke_string($serial)
	{
		$hasil = unserialize($serial);
		return implode(', ', $hasil);
	}
?>
			<h1 class="page-header">Job Order
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Data Job Order</h4>
			    </div>
			    <div class="panel-body">
				<?php
					if($getInsert==1){
						echo'<a href="?page=form_jo&opt=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Isi Job Order</a>';
					}
				?>
			<hr>
			<?php
			
			if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM job_order WHERE id_jo='$_GET[delete]'");
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
					<th>Aktifitas</th>
					<th>Waktu Mulai</th>
					<th>Waktu Selesai</th>
					<th>PIC</th>
					<th width="8%"></th>
				</thead>
				<tbody>
					<?php
						
							$query = mysql_query("SELECT * FROM job_order ORDER BY id_jo DESC");
						
						$i=1;
						while($r=mysql_fetch_array($query)){
							echo"
								<tr>
									<td>$i</td>
									<td>$r[aktifitas]</td>
									<td>".tgl_indo($r['tgl_mulai'])." $r[jam_mulai]</td>
									<td>".tgl_indo($r['tgl_selesai'])." $r[jam_selesai]</td>
									<td>";
										$pic = mysql_query("SELECT pic_jo.*,m_karyawan.* FROM pic_jo,m_karyawan WHERE pic_jo.pic=m_karyawan.regno AND pic_jo.id_jo='$r[id_jo]'");
										$j=1;
										while($p=mysql_fetch_array($pic)){
											if($j!=1){
												echo ",";
											}
												echo"$p[name]";
											$j++;
										}
								echo"</td>
									<td>";
									if($getEdit==1){
										echo"<a href='?page=form_jo&opt=edit&id=$r[id_jo]' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a>";
									}if($getDelete==1){	
										echo"<a href='?page=job_order&delete=$r[id_jo]' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
									}
							echo"</td>
								</tr>
							";
							$i++;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>