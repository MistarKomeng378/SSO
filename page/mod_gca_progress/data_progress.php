<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
<?php
	$getNIK			= mysql_real_escape_string($_POST['nik']);
	$ex				= explode("/",$_POST['tgl_mulai']);
	$mulai			= $ex[2]."-".$ex[1]."-".$ex[0];
	$ex1			= explode("/",$_POST['tgl_selesai']);
	$selesai		= $ex1[2]."-".$ex1[1]."-".$ex1[0];
	$tgl_mulai		= date('Y-m-d', strtotime($mulai));
	$tgl_selesai 	= date('Y-m-d', strtotime($selesai));
?>
<script type="text/Javascript">
	function nik(){
		var x = window.open("lookup/nik.php", "nik", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
</script>
			<h1 class="page-header">Progress GCA
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			        </div>
			        <h4 class="panel-title">Progress GCA Personal : <?=name($getNIK)?></h4>
			    </div>
			    <div class="panel-body">
			<?php
			
			if(isset($_REQUEST['delete'])){
				// mysql_query("DELETE FROM srko WHERE id_srko='$_GET[id_srko]'");
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
			
					echo"
					<form method='POST' action='page.php?page=progress_gca' id='formku'>
					<div class='form-group  col-lg-12 row'>
						<div class='form-group  col-lg-2'>
							<div class='input-group input-group'>
								<input type='text' name='nik' class='form-control' value='$getNIK' placeholder='NIK' id='nik'>
								<span class='input-group-btn'>
									<i class='glyphicon glyphicon-search btn btn-primary btn-flat edit-record' onclick='nik()'></i>
								</span>
							</div>
						</div>
						<div class='form-group  col-lg-2' row>
							<input type='text' name='tgl_mulai' class='form-control' value='$_POST[tgl_mulai]' placeholder='Tanggal Awal' id='datepicker'>
						</div>
						<div class='form-group  col-lg-2' row>
							<input type='text' name='tgl_selesai' class='form-control' value='$_POST[tgl_selesai]' placeholder='Tanggal Akhir' id='datepicker1'>
						</div>
						<div class='form-group  col-lg-1'>
							<input type='submit' name='submit' value='Pilih' class='btn btn-primary'>
						</div>
					</div>
				</form>";
				
			if($getInsert==1){
				// echo"<a href='?page=form_progress&unit=".ec($unit['CostCenter'])."' class='btn btn-primary'><i class='fa fa-plus'></i> Input Progress</a>";
				// class="table table-bordered table-striped table-hover"
			}
			?>
			<table border='1' cellpadding='3' width="100%" >
				<thead>
					
					<tr align="center">
						<td rowspan="2" width='4%'><b>No.</b></td>
						<td rowspan="2" width='20%'><b>Aktifitas</b></td>
						<td colspan="3" bgcolor='#99ff99'><b>S/d Bulan Berjalan (<?=bulan(date("m"))?>)</b></td>
						<td colspan="3" bgcolor='#99ccff'><b>Rentang Tanggal</b></td>
						<td rowspan="2" width='4%'></td>
					</tr>
					<tr align="center">
						<td bgcolor='#99ff99' width="5%"><b>Planning</b></td>
						<td bgcolor='#99ff99' width="5%"><b>Realisasi</b></td>
						<td bgcolor='#99ff99' width="5%"><b>Progress</b></td>
						<td bgcolor='#99ccff' width="5%"><b>Planning</b></td>
						<td bgcolor='#99ccff' width="5%"><b>Realisasi</b></td>
						<td bgcolor='#99ccff' width="5%"><b>Progress</b></td>
					</tr>
					<!--
					<tr align="center">
						<td width='3%'><b>No.</b></td>
						<td width='30%'><b>Aktifitas</b></td>
						<td  width='8%'><b>Planning (Jam)</b></td>
						<td width='8%'><b>Realisasi (Jam) Bersarkan rentang tanggal</b></td>
						<td width='8%'><b>Total Realisasi (Jam)</b></td>
						<td width='8%'><b>Progress (%) Terakhir</b></td>
						<td width='3%'></td>
					</tr>-->
				</thead>
				<tbody>
					<?php
						if(isset($_POST['submit'])){
							$no=1;
							$query = mysql_query("SELECT DISTINCT a.id,a.parentId,a.aktivitas,a.durasi,a.pic,a.cc_id,
												ifnull((SELECT SUM(total_jam) FROM pencapaian WHERE jo_gca=a.id AND `status`='1'),'') as realisasi,
												ifnull((SELECT SUM(total_jam) FROM pencapaian WHERE jo_gca=a.id AND tgl_aktifitas BETWEEN '$tgl_mulai' AND '$tgl_selesai' AND `status`='1'),'') as rjam,
												ifnull((SELECT SUM(total_jam) FROM waktu_kerja2 WHERE id_gca=a.id AND bulan >=$ex[1] AND bulan <=$ex1[1] AND tahun='$ex[2]'),'') as planningrentang,
												ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=a.id AND `status`='1' AND date_format(tgl_aktifitas,'%m %Y')='$ex1[1] $ex1[2]'  )),'') as rmaxpro,
												ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=a.id AND `status`='1')),'') as maxpro
												FROM wbs a
												INNER JOIN waktu_kerja2 ON waktu_kerja2.id_gca = a.id
												WHERE a.pic='$getNIK' AND a.tahun='$tahun_aktif'
												ORDER BY a.realisasi DESC");
							while($r=mysql_fetch_array($query)){
								$idParent	= $r['parentId'];
								echo"
								<tr>
									<td align='center'>$no</td>
									<td><z class='' data-tp-title='Cost Center : <b>$r[cc_id]</b>' data-tp-desc='
										";									
										echo "$r[id] : <b>$r[aktivitas]</b> -> ";
										for($ak=1;$ak<=99;$ak++){
											$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
												$fontColor="black";
												if($ak!=1){
													echo"-> ";
												}
												echo "$gca[aktivitas]";
													$idParent=$gca['parentId'];
													$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
													if ($idParent==$cek_id['id_tahun']){
														break;
													}
										}
									echo"'>$r[aktivitas]</z></td>
									<td align='center' bgcolor='#99ff99' title='Planning satu tahun'>$r[durasi]</td>
									<td align='center' bgcolor='#99ff99' title='Realisasi sampai dengan bulan berjalan'>$r[realisasi]</td>
									<td align='center' bgcolor='#99ff99' title='Progress Terakhir'>$r[maxpro]</td>
									<td align='center' bgcolor='#99ccff' title='Planning berdasarkan rentang tanggal'>$r[planningrentang]</td>
									<td align='center' bgcolor='#99ccff' title='Realisasi berdasarkan rentang tanggal'>$r[rjam]</td>
									<td align='center' bgcolor='#99ccff' title='Progress Terakhir berdasarkan rentang tanggal'>$r[rmaxpro]</td>																	
									<td align='center'><a href='#modal-message' class='edit-record2 btn btn-xs btn-primary' data-id='$r[id]-$tahun_aktif-$r[pic]' data-toggle='modal'><i class='fa fa-list'></i></td>								
								</tr>
								";
								$no++;
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "bottom"
	});
	
	$(function(){
            $(document).on('click','.edit-record2',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_cari_gca/detail_gca2.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal modal-message fade" id="modal-message">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Detail GCA dan Aktifitas</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>