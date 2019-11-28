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
}elseif($_GET['opt']=="edit"){
	$id				= mysql_real_escape_string(dc($_GET['id']));
	$edit			= mysql_fetch_array(mysql_query("SELECT * FROM pencapaian WHERE id_pencapaian='$id'")); 
	$nama			= mysql_fetch_array(mysql_query("SELECT * FROM m_karyawan WHERE regno='$edit[laporan]'"));
	$urai			= mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='$edit[cc]'"));
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
}
			
		?>
		<script type="text/Javascript">
			function gca(){
				var x = window.open("lookup/gca.php?nik=<?=ec($_SESSION['nik'])?>", "gca", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=1000,height=500");
			}
			function lapor(){
				var x = window.open("lookup/lapor.php", "lapor", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			}
			function cc(){
				var x = window.open("lookup/cc2.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			}
		</script>

		
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
		<form method="POST" action="page/mod_kkwk/aksi_kkwk.php?opt=<?=$_GET['opt']?>" id="formku" enctype="multipart/form-data">
			<div class="form-group  col-lg-6">
				<div class="col-lg-6">
					<label for="jo_gca">GCA</label>
						<div class="input-group input-group">
						<input type="text" name="jo_gca" class="form-control " value="<?=$jo_gca?>" id="jo_gca" onchange="showcetak(this.value)" onclick="showcetak(this.value)" readonly >
						<span class="input-group-btn"> <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="gca()" ></i></span>
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
					<input type='text' name='faktor' id="faktor" value='<?=$faktor_k?>' class='form-control required' autocomplete="off">
					</z>
				</div>
				<div class="col-lg-12">
					<label for="tgl">Tanggal Aktifitas</label>
					<select name="tmulai" class="form-control required">
						<option value="">-Pilih Tanggal-</option>
						<?php
							$now 		= strtotime(date("Y-m-d"));
							$nowDay 	= date("d-m-Y");										
							echo"<option value='".ec($nowDay)."' selected>$nowDay</option>";
							for($i=1;$i<=3;$i++){
								$kemarin 	= date('d-m-Y', strtotime("-$i day", $now));
								echo"<option value='".ec($kemarin)."'>$kemarin</option>";
							}
						?>
					</select>
				</div>
				<div class="col-lg-6">
					<label for="jmulai">Jam Mulai</label>
					<input name="jmulai" value="<?=$jam_mulai?>" type="text" class="form-control required"  id="tp1"/>
				</div>
				<div class="col-lg-6">
					<label for="jselesai">Jam Selesai</label>
					<input name="jselesai" value="<?=$jam_akhir?>" type="text" class="form-control required"  id="tp2"/>
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
						  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="lapor()"></i>
						</span>
					</div>
				</div>
				<div class="col-lg-12">
				<label for="cc">Kode Proyek / Cost Center</label>
					<div class="input-group input-group">
						<input type="text" name="cc" class="form-control required" value="<?=$cc?>" id="cc" placeholder="Kode Proyek / CC" readonly>
						<input type="hidden" name="uraian" class="form-control " value="<?=$uraian?>" id="uraian" placeholder="Kode Proyek / CC"  autocomplete="off" readonly>
						<span class="input-group-btn">
							<i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="cc()"></i>
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
						<z data-tp-title='Informasi' data-tp-desc='Harap Melampirkan hasil pekerjaan apabila progress telah mencapai 100%' >
						<input name="progress" value="<?=$progress?>" type="text" class="form-control required" />
						</z>
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
</script>
<script src="assets/plugins/maskedinput/jquery.maskedinput.js"></script>

<script type="text/javascript">
    $(function() {
        $.mask.definitions['~'] = "[+-]";
		$("#tp1").mask("99:99",{placeholder:"HH:MM" });        
		$("#tp2").mask("99:99",{placeholder:"HH:MM" });        
    });
</script>
<script src="assets/plugins/timepicker/jquery.ui.timepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tp1').timepicker({
			showNowButton: true,
			showDeselectButton: true,
			defaultTime: '',  // removes the highlighted time for when the input is empty.
			showCloseButton: true
		});
		$('#tp2').timepicker({
			showNowButton: true,
			showDeselectButton: true,
			defaultTime: '',  // removes the highlighted time for when the input is empty.
			showCloseButton: true
		});
	})
</script>