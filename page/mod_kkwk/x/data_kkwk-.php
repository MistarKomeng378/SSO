<script type="text/javascript">
 window.onload = function() { jam(); }

 function jam() {
  var e = document.getElementById('jam'),
  d = new Date(), h, m, s;
  h = d.getHours();
  m = set(d.getMinutes());
  s = set(d.getSeconds());

  e.innerHTML = h +':'+ m +':'+ s;

  setTimeout('jam()', 1000);
 }

 function set(e) {
  e = e < 10 ? '0'+ e : e;
  return e;
 }
</script>

			<h1 class="page-header">Catatan Kerja dan Hasil Kerja
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a></div>
			        <h4 class="panel-title">Catatan Kerja dan Hasil Kerja</h4>
			    </div>
			    <div class="panel-body">
		<?php
			if($getInsert==1){
				echo"<a href='?page=form_kkwk&opt=tambah' class='btn btn-primary'><i class='fa fa-plus'></i> Isi KKWK</a>";
				echo"
					<div class='pull-right'>
						<a href='?page=pencapaian_kerja&opt=gca' class='btn btn-primary' title='Pekerjaan yang diambil dari GCA'>GCA</a>
						<a href='?page=pencapaian_kerja&opt=lain' class='btn btn-primary' title='Pekerjaan yang diambil diluar GCA dan Job Order'>Lain-Lain</a>
						<a href='?page=pencapaian_kerja&opt=return' class='btn btn-danger' title='Pekerjaan yang dikembalikan oleh atasan'>Return</a>
					</div>
					";
			}	
		?>			
		<hr>
		<?php
			
			if(isset($_REQUEST['delete'])){
				include"config/fungsi_timeline.php";
				timeline($_SESSION['nik'],"delete","penghapusan KKWK dengan id_kkwk ".dc($_GET['delete'])." ");
				mysql_query("DELETE FROM pencapaian WHERE id_pencapaian='".mysql_real_escape_string(dc($_GET['delete']))."' ");
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
		<div class="table-responsive">
			<table id="example1" class="table table-bordered table-striped table-hover" >
				<thead>
					<th width="5%">No.</th>
					<th>Aktifitas</th>
					<th  width="10%">Cost Center</th>
					<th>Tanggal Aktifitas</th>
					<th>Total Jam</th>
					<th>Progress</th>
					<th>Status</th>
					<th width="13%"></th>
				</thead>
				<tbody>
					<?php
						// if($_GET['opt']=="gca"){
							// $query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='1' AND faktor_k='A' ORDER BY id_pencapaian DESC");
						// }elseif($_GET['opt']=="lain"){
							// $query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='1' AND faktor_k='B' ORDER BY id_pencapaian DESC");
						// }elseif($_GET['opt']=="return"){
							// $query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='1' AND aprove='4' ORDER BY id_pencapaian DESC");
						// }else{
							// $query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='1' ORDER BY id_pencapaian DESC");
						// }
						if($_GET['opt']=="gca"){
							$query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='1' AND faktor_k='A' AND DATE_FORMAT(tgl_aktifitas,'%Y')='$tahun_aktif' ORDER BY id_pencapaian DESC");
						}elseif($_GET['opt']=="lain"){
							$query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='1' AND faktor_k='B' AND DATE_FORMAT(tgl_aktifitas,'%Y')='$tahun_aktif' ORDER BY id_pencapaian DESC");
						}elseif($_GET['opt']=="return"){
							$query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='1' AND aprove='4' AND DATE_FORMAT(tgl_aktifitas,'%Y')='$tahun_aktif' ORDER BY id_pencapaian DESC");
						}else{
							$query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='1' AND DATE_FORMAT(tgl_aktifitas,'%Y')='$tahun_aktif' ORDER BY id_pencapaian DESC");
						}
						$no=1;
						while($r=mysql_fetch_array($query)){
							if($r['aprove']==0){
								$aprove="<lable class='btn-xs btn-primary' title='Dalam Proses Pengerjaan'>Proses</lable>";
								$aksi="<a href='page.php?page=form_kkwk&opt=edit&id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-primary' title='Dalam Proses Pengerjaan'><i class='fa fa-pencil'></i></a>";
							}elseif($r['aprove']==1){
								$aprove="<lable class='btn-xs btn-warning' title='Dalam Proses Penilaian'>Open</lable>";
								$aksi="<a href='page.php?page=form_kkwk&opt=edit&id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-warning' data-toggle='modal'  title='Dalam Proses Penilaian'><i class='fa fa-refresh'></i></a>";
							}elseif($r['aprove']==2){
								$aprove="<lable class='btn-xs btn-success' title='Telah dinilai'>Aprove</lable>";
								$aksi="<a href='#modal-note' class='edit-note btn btn-xs btn-success' data-id='$r[nik]-$r[jo_gca]-$r[status_nilai]-$r[id_pencapaian]-$r[aprove]' data-toggle='modal'  title='Telah dinilai'><i class='fa fa-check'></i></a>";
							}elseif($r['aprove']==3){
								$aprove="<lable class='btn-xs btn-primary' title='Data ini tidak untuk dilaporkan'>Not Reported</lable>";
								$aksi="<a href='' class='btn btn-xs btn-primary' data-toggle='modal'  title='Data ini tidak untuk dilaporkan'><i class='fa fa-check'></i></a>";
							}elseif($r['aprove']==4){
								$aprove="<lable class='btn-xs btn-danger' title='Hasil Kerja dikembaliakan Harap pebaiki kekurangan'>Return</lable>";
								$aksi="<a href='page.php?page=form_kkwk&opt=edit&id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-danger' data-toggle='modal'  title='Hasil Kerja dikembaliakan Harap pebaiki kekurangan'><i class='fa fa-refresh'></i></a>";
							}
							echo"
								<tr>
									<td>$no</td>
									<td>$r[jo_gca]-> <span style=\"color:blue\">$r[aktifitas]</span><br>$r[hasil_akhir]</td>
									<td>$r[cc] ($r[status_nilai])</td>
									<td>".tgl_indo($r['tgl_aktifitas'])."<br>Pukul $r[jam_mulai] - $r[jam_akhir]</td>
									<td>$r[total_jam] Jam $r[total_menit] Menit</td>
									<td>$r[progress] %</td>
									<td>$aprove</td>
									<td>";
									echo"$aksi 
									<a href='?page=form_kkwk&opt=tambah3&id=".ec($r['jo_gca'])."' class='btn btn-xs btn-success' title='Buat KKWK Untuk Program Kerja Ini'><i class='fa fa-retweet'></i></a>";
									if($r['jo_gca']!=""){
										echo" <a href='#modal-message' class='edit-show btn btn-xs btn-primary' data-id='$r[nik]-$r[jo_gca]-$r[status_nilai]' data-toggle='modal' title='Lihat Detail Aktifitas'><i class='fa fa-search'></i></a>";
									}
									if($r['status_dispen']==1){
										if($r['aprove']==2){
											echo" <a href='#' class='btn btn-xs btn-danger' disabled><i class='fa fa-trash'></i></a>";
										}else{
											echo" <a href='?page=pencapaian_kerja&delete=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
										}
											
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
<script>
        $(function(){
            $(document).on('click','.edit-record',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_kkwk/form_selesai.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
        $(function(){
            $(document).on('click','.edit-show',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_kkwk/detail_kkwk.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
		$(function(){
            $(document).on('click','.edit-note',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_kkwk/note.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
		$(function(){
            $(document).on('click','.edit-progress',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_kkwk/form_progress.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal fade" id="modal-alert">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Form Isian Hasil Kerja</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-message fade" id="modal-message">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Detail Aktifitas Berdasarkan GCA Yang Sama</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-message fade" id="modal-note">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Catatan Penilai</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/ui-modal-notification.demo.min.js"></script>