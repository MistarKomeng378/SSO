<script type="text/Javascript">
	function cc(){
		var x = window.open("lookup/cc3.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
	function nik(){
		var x = window.open("lookup/nik.php", "nik", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
</script>
<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
<?php
include"config/fungsi_timeline.php";
?>
<h1 class="page-header">Data GCA
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Cari GCA</h4>
	</div>
	<div class="panel-body">
		<div class="form-group col-lg-12 ">
			<div class="form-group col-lg-12 ">
				<?php
					$getBulan 	= mysql_real_escape_string($_POST['bulan']);
					$getNIK		= mysql_real_escape_string($_POST['nik']);
					$getUnit	= mysql_real_escape_string($_POST['unit']);
					$getTahun	= mysql_real_escape_string($_POST['tahun']);
					
					echo"<form method='POST' action='page.php?page=cari_gca' id='formku'>
					<div class='form-group  col-lg-12 row'>
						<div class='form-group  col-lg-2'>
							<input type='hidden' name='page' value='cari_gca'>
							<input type='hidden' name='cari' value='cari'>
							<select name='bulan' class='form-control '>
								<option value=''>Pilih Bulan</option>";
									for($i=1;$i<=12;$i++){
										echo"<option value='$i'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
									}
						echo"</select>
						</div>
						<div class='form-group  col-lg-1'>
							<input type='text' name='tahun' class='form-control required' value='".date("Y")."' placeholder='Tahun'>
						</div>
						<div class='form-group  col-lg-3'>
							<div class='input-group input-group'>
								<input type='text' name='unit' class='form-control' value='$getUnit' id='cc' placeholder='Cost Center'>
								<input type='hidden' name='uraian' class='form-control required' value='' id='uraian' placeholder='Kode Proyek / Cost Center'  readonly>
								<span class='input-group-btn'>
									 <i class='glyphicon glyphicon-search btn btn-primary btn-flat' onclick='cc()'></i>
								</span>
							</div>
						</div>
						<div class='form-group  col-lg-2'>
							<div class='input-group input-group'>
								<input type='text' name='nik' class='form-control' value='$getNIK' placeholder='NIK' id='nik'>
								<span class='input-group-btn'>
									<i class='glyphicon glyphicon-search btn btn-primary btn-flat' onclick='nik()'></i>
								</span>
							</div>
						</div>
						<div class='form-group  col-lg-1'>
							<input type='submit' value='Pilih' class='btn btn-primary'>
						</div>
					</div>
				</form>";
			?>
			</div>
			
			<div class="form-group col-lg-12 ">
			
				
						<?php
						if(isset($_POST['cari'])){
							echo"
							<div class='table-responsive'>
							<table id='example1' class='table table-bordered table-striped table-hover' >
									<thead>
										<th></th>
										<th width='3%'>No.</th>
										<th>Id-> ParentId</th>
										<th>Aktifitas</th>
										<th>CC</th>
										<th>Mulai</th>
										<th>Selesai</th>
										<th>Durasi</th>
										<th>Aktual</th>										
										<th>Progress Terakhir</th>										
										<th>Deliverable</th>
										
									</thead>
									<tbody>";
							if(!empty($_POST['nik'])){
								$nik	= "AND pic='$getNIK' ";
							}
							if(!empty($_POST['unit'])){
								$unit	= "AND cc_id='$getUnit' "; 
							}
							if(!empty($_POST['bulan'])){
								$bln	= "AND waktu_kerja2.bulan='$getBulan' "; 
							}
							$no=1;
							$query = mysql_query("SELECT DISTINCT waktu_kerja2.id_gca as id,
														waktu_kerja2.nik,
														wbs.parentId,
														wbs.aktivitas,
														wbs.cc,
														wbs.durasi,
														wbs.mulai,
														wbs.akhir,
														wbs.pic,
														wbs.deliverable,
														wbs.realisasi,
														waktu_kerja2.tahun,
														ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=wbs.id AND `status`='1')),'') as maxpro
														FROM
														waktu_kerja2
														INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca AND wbs.pic = waktu_kerja2.nik
														WHERE total_jam !='' 
														AND waktu_kerja2.tahun='$getTahun' 
														$nik $bln $unit
														ORDER BY id,parentId,cc");
							timeline($_SESSION['nik'],"cari","pecarian GCA pada menu cari GCA berdasrkan nik : $getNIK bulan : $getBulan CostCenter : $getUnit");
							while($r=mysql_fetch_array($query)){
								if(!empty($_POST['bulan'])){								
									$qdurasi = mysql_fetch_array(mysql_query("SELECT total_jam FROM waktu_kerja2 WHERE id_gca='$r[id]' AND bulan='$getBulan' AND tahun='$r[tahun]'"));
									$qaktual = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jam FROM pencapaian WHERE nik='$r[pic]' AND jo_gca='$r[id]' AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $r[tahun]'"));
									$durasi = $qdurasi['total_jam'];
									$aktual = $qaktual['jam'];
								}else{
									$durasi = $r['durasi'];
									$aktual = $r['realisasi'];
								}
								echo"
									<tr>
										<td>
											<a href='#modal-message' class='edit-record2 btn btn-xs btn-primary' data-id='$r[id]-$tahun_aktif-$r[pic]' data-toggle='modal'><i class='fa fa-list'></i></a>
										</td>
										<td>$no</td>
										<td>$r[id]-> $r[parentId]</td>
										<td>";
										$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$r[id]'"));
										$idParent	= $data['parentId'];
										echo"<b><font color='blue'>$r[aktivitas]</font></b> ->";
										for($ak=1;$ak<=99;$ak++){
											$gca = mysql_fetch_array(mysql_query("SELECT parentId,aktivitas,tahun FROM wbs WHERE id='$idParent'"));
											$fontColor="black";
											if($ak!=1){
												echo"-> ";
											}
											echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
												$idParent=$gca['parentId'];
												$cek_id = mysql_fetch_array(mysql_query("SELECT id_tahun FROM tahun WHERE tahun='$gca[tahun]'"));
											if ($idParent==$cek_id['id_tahun']){
												break;
											}
										}
										echo"</td>
										<td align='center'>$r[cc]</td>
										<td>".tgl_indo($r['mulai'])."</td>
										<td>".tgl_indo($r['akhir'])."</td>
										<td align='center'>$durasi</td>
										<td align='center'>$aktual</td>										
										<td align='center'>$r[maxpro]</td>										
										<td>$r[deliverable]</td>										
									</tr>
								";	
								$no++;
							}
							echo"</tbody>
						</table>
						</div>";
						}
						?>
			</div>
		</div>
	</div>
</div>

<script>
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
<script src="assets/js/ui-modal-notification.demo.min.js"></script>
<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "bottom"
	});
</script>
<!-------------------------------awal dari color box------------------------------------>
<script type="text/javascript" src="assets/plugins/jquerycolorbox/jquery.colorbox.js"></script>
<link  rel="stylesheet" type="text/css" href="assets/plugins/jquerycolorbox/colorbox/colorbox.css" />
<!-------------------------------akhir dari color box------------------------------------>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".popup").colorbox({ 		iframe:true		,width:"90%"		,height:"100%"	});
	});
</SCRIPT>