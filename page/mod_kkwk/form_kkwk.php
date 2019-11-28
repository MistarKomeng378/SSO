<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="assets/plugins/timepicker/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" />
<link rel="stylesheet" href="assets/plugins/timepicker/jquery.ui.timepicker.css?v=0.3.3" type="text/css" />
<script type="text/javascript">
	function show(linkinpark){
		if (linkinpark==""){
			document.getElementById("jam_shift").innerHTML="";
			return;
		}
		if(window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("jam_shift").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","get_jam.php?sts_shift="+linkinpark,true);
		xmlhttp.send();
	}	
</script>

<?php
$cekStatus = mysql_num_rows(mysql_query("SELECT status FROM pencapaian WHERE nik='$_SESSION[nik]' AND status='0' "));
if($cekStatus >=1){
	echo"<SCRIPT language='javascript'>alert('Maaf...masih ada aktifitas yang berjalan !!');document.location='page.php?page=pencapaian_kerja'</SCRIPT>";
}
if($_GET['opt']=="tambah"){
	$kd_baru		= "";
	$nik			= mysql_real_escape_string($_SESSION['nik']);
	$data			= mysql_fetch_array(mysql_query("SELECT laporan FROM pencapaian WHERE nik='$nik' ORDER BY id_pencapaian DESC LIMIT 1")); 
	$jo_gca			= "";
	$tgl_aktifitas	= "";
	$jam_mulai		= "";
	$jam_akhir		= "";
	$aktifitas		= "";
	$deliverable	= "";
	$hasil_akhir	= "";
	$laporan		= $data['laporan'];
	$cc				= "";
	$faktor_k		= "";
	$progress		= "";
	$ket			= "";
	$nama_lapor		= name($data['laporan']);
	$uraian			= "";
	$shift			= "";
	$read			= "";
	$tpick1			= "tpick1";
	$tpick2			= "tpick2";
}elseif($_GET['opt']=="tambah2"){
	$jo_gca			= dc($_GET['id']);
	$gca			= mysql_fetch_array(mysql_query("SELECT aktivitas,deliverable,cc FROM wbs WHERE id='".mysql_real_escape_string($jo_gca)."' "));
	$kd_baru		= "";
	$nik			= mysql_real_escape_string($_SESSION['nik']);
	$data			= mysql_fetch_array(mysql_query("SELECT laporan FROM pencapaian WHERE nik='$nik' ORDER BY id_pencapaian DESC LIMIT 1"));
	$tgl_aktifitas	= "";
	$jam_mulai		= "";
	$jam_akhir		= "";
	$aktifitas		= $gca['aktivitas'];
	$deliverable	= $gca['deliverable'];
	$hasil_akhir	= "";
	$laporan		= $data['laporan'];
	$cc				= $gca['cc'];
	$urai			= mysql_fetch_array(mysql_query("SELECT uraian FROM pencapaian WHERE cc='$cc'"));
	$faktor_k		= "A";
	$progress		= "";
	$ket			= "";
	$nama_lapor		= name($data['laporan']);
	$uraian			= $urai['uraian'];
	$shift			= "";
	$read			= "";
	$tpick1			= "tpick1";
	$tpick2			= "tpick2";
}elseif($_GET['opt']=="tambah3"){
	$jo_gca			= dc($_GET['id']);
	$gca			= mysql_fetch_array(mysql_query("SELECT nik,aktifitas,laporan,cc,faktor_k FROM pencapaian WHERE jo_gca='".mysql_real_escape_string($jo_gca)."' ORDER BY id_pencapaian DESC "));
	$kd_baru		= "";
	$nik			= $gca['nik'];
	$tgl_aktifitas	= "";
	$jam_mulai		= "";
	$jam_akhir		= "";
	$aktifitas		= $gca['aktifitas'];
	$deliv			= mysql_fetch_array(mysql_query("SELECT deliverable FROM wbs WHERE id='".mysql_real_escape_string($jo_gca)."' "));
	$deliverable	= $deliv['deliverable'];
	$hasil_akhir	= "";
	$laporan		= $gca['laporan'];
	$cc				= $gca['cc'];
	$urai			= mysql_fetch_array(mysql_query("SELECT uraian FROM pencapaian WHERE cc='$cc'"));
	$faktor_k		= $gca['faktor_k'];
	$progress		= "";
	$ket			= "";
	$nama_lapor		= name($gca['laporan']);
	$uraian			= $urai['uraian'];
	$shift			= "";
	$read			= "";
	$tpick1			= "tpick1";
	$tpick2			= "tpick2";
}elseif($_GET['opt']=="edit"){
	$id				= mysql_real_escape_string(dc($_GET['id']));
	$edit			= mysql_fetch_array(mysql_query("SELECT * FROM pencapaian WHERE id_pencapaian='$id'")); 
	$nama			= mysql_fetch_array(mysql_query("SELECT * FROM m_karyawan WHERE regno='$edit[laporan]'"));
	$urai			= mysql_fetch_array(mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$edit[cc]'"));
	$nama_lapor		= $nama['name'];
	$uraian			= $urai['uraian'];
	$kd_baru		= $id;
	$nik			= $edit['nik'];
	$jo_gca			= $edit['jo_gca'];
	$tgl_aktifitas	= date('d-m-Y', strtotime($edit['tgl_aktifitas']));
	$jam_mulai		= date('H:i', strtotime($edit['jam_mulai']));
	$jam_akhir		= date('H:i', strtotime($edit['jam_akhir']));
	$aktifitas		= $edit['aktifitas'];
	$deliverable	= $edit['deliverable'];
	$hasil_akhir	= $edit['hasil_akhir'];
	$laporan		= $edit['laporan'];
	$cc				= $edit['cc'];
	$faktor_k		= $edit['faktor_k'];
	$progress		= $edit['progress'];
	$ket			= $edit['ket'];
	$shift			= "";
	$read			= "readonly";
	$tpick1			= "";
	$tpick2			= "";
	
	function datediff($tgl1, $tgl2){
		$tgl1 = strtotime($tgl1);
		$tgl2 = strtotime($tgl2);
		$diff_secs = abs($tgl1 - $tgl2);
		$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
	}
	$tgl1 		= date("$tgl_aktifitas 00:00:00");
	$tgl2 		= date("Y-m-d 00:00:00");
	$a 			= datediff($tgl1, $tgl2);
	$dispenDay	= $a['days'];
	
}
			
		?>
<h1 class="page-header">Form Isian Hasil Kerja
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Form Isian Hasil Kerja</h4>
	</div>
	<div class="panel-body">
		<div class='alert alert-success alert-dismissable'>
			<i class='fa fa-check'></i><b> Catatan</b>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<ul>
				<li>Harap melakuakan pengisian aktifitas berurutan sesuai dengan jam kerja.</li>
			</ul>
        </div>
		<form method="POST" action="page/mod_kkwk/aksi_kkwk.php?opt=<?=$_GET['opt']?>" id="formku" enctype="multipart/form-data">
			<div class="form-group  col-lg-6">
				<div class="col-lg-6">
					<label for="jo_gca">GCA</label>
						<div class="input-group input-group">
						<input type="text" name="jo_gca" class="form-control " value="<?=$jo_gca?>" id="jo_gca" onchange="showcetak(this.value)" onclick="showcetak(this.value)" readonly >
						<?php
						if($_GET['opt']!="edit"){
							echo'<span class="input-group-btn"> 
								<i class="gca-show glyphicon glyphicon-search btn btn-primary btn-flat" data-id="'.ec($_SESSION['nik']).'-today" data-toggle="modal" data-target="#GCA" title="Data GCA" ></i>
								<i class="gca-show glyphicon glyphicon-search btn btn-primary btn-flat" data-id="'.ec($_SESSION['nik']).'-full" data-toggle="modal" data-target="#GCA" title="Data GCA Full" ></i>
							</span>';
						}
						?>
					</div>
					<input type="hidden" name="nik" value="<?=$_SESSION['nik']?>" class="form-control">
					<input type="hidden" name="id_pencapaian" value="<?=$kd_baru?>" class="form-control">
				</div>
				<div class="col-lg-6">
					<z class='' data-tp-title='Faktor Kontribusi' data-tp-desc='
					<ul>
						<li>A = Aktifitas yag berasal dari GCA.</li>
						<li>B = Aktifitas diluar GCA / aktifitas pribadi / tidak berkaitan dengan Perusahaan.</li>
					</ul>
					'>
					<label for="faktor">Faktor Kontribusi</label>
					<input type='text' name='faktor' id="faktor" value='<?=$faktor_k?>' class='form-control required' autocomplete="off" >
					</z>
				</div>
				<div class="col-lg-12">
					<label for="tgl">Tanggal Aktifitas</label>
					<?php
						echo'
						<select name="tmulai" class="form-control required">
							<option value="">-Pilih Tanggal-</option>';
							if($_GET['opt']=="edit"){
								if($dispenDay > 7){
									echo"<option value='".ec($tgl_aktifitas)."' selected >$tgl_aktifitas</option>";
								}else{
									$now 		= strtotime($edit['tgl_aktifitas']);
									$nowDay 	= $tgl_aktifitas;
									$nmHari2 	= date('D', strtotime($nowDay));
									if($nmHari2 == "Sun"){
										$fontColor="red";
									}elseif($nmHari == "Sat"){
										$fontColor="red";
									}else{
										$fontColor="#000000";
									}									
									echo"<option value='".ec($nowDay)."'  style=\"color:$fontColor\" selected>$nowDay</option>";
									for($i=1;$i<=7;$i++){
										$kemarin 	= date('d-m-Y', strtotime("-$i day", $now));
										$nmHari 	= date('D', strtotime($kemarin));
										if($nmHari == "Sun"){
											$fontColor="red";
										}elseif($nmHari == "Sat"){
											$fontColor="red";
										}else{
											$fontColor="#000000";
										}
										echo"<option value='".ec($kemarin)."' style=\"color:$fontColor\">$kemarin</option>";
									}
								}								
							}else{
								$now 		= strtotime(date("Y-m-d"));
								$nowDay 	= date("d-m-Y");
								$nmHari2 	= date('D', strtotime($nowDay));
								if($nmHari2 == "Sun"){
									$fontColor="red";
								}elseif($nmHari == "Sat"){
									$fontColor="red";
								}else{
									$fontColor="#000000";
								}
								echo"<option value='".ec($nowDay)."' style=\"color:$fontColor\" selected>$nowDay</option>";
								for($i=1;$i<=7;$i++){
									$kemarin 	= date('d-m-Y', strtotime("-$i day", $now));
									$nmHari 	= date('D', strtotime($kemarin));
									if($nmHari == "Sun"){
										$fontColor="red";
									}elseif($nmHari == "Sat"){
										$fontColor="red";
									}else{
										$fontColor="#000000";
									}
									echo"<option value='".ec($kemarin)."' style=\"color:$fontColor\">$kemarin</option>";
								}
							}
						echo'</select>';
					?>
				</div>
				<div class="col-lg-6">
					<label for="jmulai">Jam Mulai</label>
					<input name="jmulai" value="<?=$jam_mulai?>" type="text" class="form-control required"  id="<?=$tpick1?>" <?=$read?>/>
				</div>
				<div class="col-lg-6">
					<label for="jselesai">Jam Selesai</label>
					<input name="jselesai" value="<?=$jam_akhir?>" type="text" class="form-control required"  id="<?=$tpick2?>"  <?=$read?>/>
				</div>						
				<div class="col-lg-12">
					<label for="aktifitas">Aktifitas</label>
					<textarea name="aktifitas" class="form-control required" id="aktifitas"><?=$aktifitas?></textarea>
				</div>
				<div class="col-lg-12">
					<label for="hasil">Hasil Aktifitas</label>
					<textarea name="hasil" class="form-control required" id="hasil"><?=$hasil_akhir?></textarea>
				</div>
				<div class="col-lg-12">
					<label for="deliverable">Deliverable / Hasil Akhir</label>
					<input type="text" name="deliverable" class="form-control" value="<?=$deliverable?>" placeholder="Deliverable" id="deliverable" readonly>
				</div>
			</div>
			<div class="form-group  col-lg-6">
				<div class="col-lg-12">
					<label for="lapor">Dilaporkan Kepada</label>
					<div class="input-group input-group">
						<input type="hidden" name="lapor" class="form-control" value="<?=$laporan?>" id="lapor">
						<input type="text" name="nama_lapor" class="form-control required" value="<?=$nama_lapor?>" id="nama_lapor" placeholder="Dilaporkan Kepada" autocomplete="off" readonly>
						<span class="input-group-btn">
							<i class="lapor-show glyphicon glyphicon-search btn btn-primary btn-flat" data-toggle="modal" data-target="#Laporan" title="Data Karyawan" ></i>
						</span>
					</div>
				</div>
				<div class="col-lg-12">
				<label for="cc">Kode Proyek / Cost Center</label>
					<div class="input-group input-group">
						<input type="text" name="cc" class="form-control required" value="<?=$cc?>" id="cc" placeholder="Kode Proyek / CC" readonly>
						<input type="hidden" name="uraian" class="form-control " value="<?=$uraian?>" id="uraian" placeholder="Uraian"  autocomplete="off" readonly>
						<span class="input-group-btn">
							<i class="cc-show glyphicon glyphicon-search btn btn-primary btn-flat" data-id="office" data-toggle="modal" data-target="#myModal" title="CostCenter" ></i>
							<i class="cc-show glyphicon glyphicon-search btn btn-primary btn-flat" data-id="project" data-toggle="modal" data-target="#myModal"  title="Kode Project"  ></i>
						</span>
					</div>
				</div>	
				<div class="col-lg-12">
					<label for="lampiran">Lampiran File</label>
					<input type="file" id="lampiran" name="lampiran" class="form-control"/>
				</div>
				<div class="col-lg-12">
					<label for="ket">Keterangan Lampiran</label>
					<textarea  name="ket" class="form-control" placeholder="Keterangan Lampiran"><?=$ket?></textarea>
				</div>						
				<div class="col-lg-6">
					<label for="Progress">Progress</label>
					<input name="progress" value="<?=$progress?>" type="text" class="form-control required number" data-toggle="tooltip" title="Harap Melampirkan hasil pekerjaan apabila progress telah mencapai 100%"/>
				</div>
				<div class="col-lg-6">
					<label for="sts_shift">Status Shift</label>
					<select name="sts_shift" id="sts_shift" class="form-control required" onchange="show(this.value)">
						<option value="">-Status Shift-</option>
						<option value="0" selected>Non Shift</option>
						<option value="1">Shift</option>
					</select>							
				</div>
				<div class="col-lg-12">
					<div id="jam_shift"></div>
				</div>
			</div>
			<hr/>
				<div class="form-group  col-lg-12">
				<hr>
					<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-danger" onclick="history.back()">Back</button>
				</div>
		</form>
	</div>
</div>
<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "bottom"
	});
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
</script>
<script src="assets/plugins/maskedinput/jquery.maskedinput.js"></script>

<script type="text/javascript">
    $(function() {
        $.mask.definitions['~'] = "[+-]";
		$("#tpick1").mask("99:99",{placeholder:"HH:MM" });        
		$("#tpick2").mask("99:99",{placeholder:"HH:MM" });        
    });
</script>
<script src="assets/plugins/timepicker/jquery.ui.timepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tpick1').timepicker({
			showNowButton: true,
			showDeselectButton: true,
			defaultTime: '',
			showCloseButton: true
		});
		$('#tpick2').timepicker({
			showNowButton: true,
			showDeselectButton: true,
			defaultTime: '',
			showCloseButton: true
		});
	})
</script>
<script>
	$(function(){
		$(document).on('click','.cc-show',function(e){
			e.preventDefault();
			$("#myModal").modal('show');
			$.post('lookup/kkwk/cc.php',
				{id:$(this).attr('data-id')},
				function(html){
					$(".modal-body").html(html);
				}   
			);
		});
	});
	
	$(document).on('click', '.pilih', function (e) {
		document.getElementById("cc").value = $(this).attr('data-cc');
		document.getElementById("uraian").value = $(this).attr('data-uraian');
		$('#myModal').modal('hide');
	});
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Cost Center </h4>
			</div>
			<div class="modal-body">
				  
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$(document).on('click','.lapor-show',function(e){
			e.preventDefault();
			$("#Laporan").modal('show');
			$.post('lookup/kkwk/lapor.php',
				{id:$(this).attr('data-id')},
				function(html){
					$(".modal-body").html(html);
				}   
			);
		});
	});
	
	$(document).on('click', '.select', function (e) {
		document.getElementById("lapor").value = $(this).attr('data-nik');
		document.getElementById("nama_lapor").value = $(this).attr('data-nama');
		$('#Laporan').modal('hide');
	});
</script>
<div class="modal fade" id="Laporan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Data Karyawan </h4>
			</div>
			<div class="modal-body">
				  
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$(document).on('click','.gca-show',function(e){
			e.preventDefault();
			$("#GCA").modal('show');
			$.post('lookup/kkwk/gca.php',
				{id:$(this).attr('data-id')},
				function(html){
					$(".modal-body").html(html);
				}   
			);
		});
	});
	
	$(document).on('click', '.selectgca', function (e) {
		document.getElementById("jo_gca").value = $(this).attr('data-gca');
		document.getElementById("aktifitas").value = $(this).attr('data-aktivitas');
		document.getElementById("cc").value = $(this).attr('data-cc');
		document.getElementById("deliverable").value = $(this).attr('data-deliverable');
		document.getElementById("faktor").value = $(this).attr('data-faktor');
		$('#GCA').modal('hide');
	});
</script>
<div class="modal fade" id="GCA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
	<div class="modal-dialog" style="width:100%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Data GCA </h4>
			</div>
			<div class="modal-body">
				  
			</div>
		</div>
	</div>
</div>