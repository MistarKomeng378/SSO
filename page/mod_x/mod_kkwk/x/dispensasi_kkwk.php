<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" media="all" type="text/css" href="assets/plugins/tp/jquery-ui-timepicker-addon.css" />

<script type="text/javascript">
	function showcetak(linkinpark){
		if (linkinpark==""){
			document.getElementById("faktor").innerHTML="";
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
				document.getElementById("faktor").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","get_fk.php?jo_gca="+linkinpark,true);
		xmlhttp.send();
	}
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

	$kd_baru		= "";
	$nik			= "";
	$jo_gca			= "";
	$tgl_aktifitas	= "";
	$jam_mulai		= "";
	$jam_akhir		= "";
	$aktifitas		= "";
	$deliverable	= "";
	$hasil_akhir	= "";
	$laporan		= "";
	$cc				= "";
	$faktor_k		= "";
	$progress		= "";
	$ket			= "";
	$nama_lapor		= "";
	$uraian			= "";
	$alasan			= "";
	$status_shift	= "";
			
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


			<h1 class="page-header">Dispensasi KKWK
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Dispensasi KKWK</h4>
			    </div>
			    <div class="panel-body">
				<a href="?page=dispensasi_kkwk_oleh_atasan&opt=view_karyawan" class="btn btn-primary"><i class="fa fa-plus"></i> Dispensasi Karyawan</a>
				<hr>
				<div class='alert alert-success alert-dismissable'>
					<ul>
						<li>Saat ini dispensasi KKWK hanya berlaku untuk hari ini, hingga 1 hari sebelumnya</li>
						<li>Apabila dispensasi lebih dari 1 hari silahkan menghubingi atasan untuk melakukan dispensasi</li>
					</ul>
				</div>
				<form method="POST" action="page/mod_kkwk/aksi_dispensasi.php?opt=<?=$_GET['opt']?>" id="formku" enctype="multipart/form-data">
					<div class="form-group col-lg-12 ">
					<div class="form-group  col-lg-6">
						
							<div class="col-lg-6">
								<label for="jo_gca">GCA / Job Order</label>
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
									<li>A = Aktivitas yag berasal dari GCA.</li>
									<li>B = Aktivitas yang berasal dari atasan/Job Order. (Belum Tersedia)</li>
									<li>C = Aktivitas yang dilakukan sendiri masih terkait dengan Perusahaan.</li>
									<li>D = Aktivitas yang dilakukan sendiri tidak terkait dengan Perusahaan.</li>
								</ul>
								'>
								<label for="faktor">Faktor Kontribusi</label>
								<input type='text' name='faktor' id="faktor" value='<?=$faktor_k?>' class='form-control required' autocomplete="off">
								</z>
							</div>
							<div class="col-lg-6">
								<label for="tmulai">Tanggal Mulai</label>
								<select name="tmulai" class="form-control required">
									<option value="">-Pilih Tanggal-</option>
									<?php
										$now 		= strtotime(date("Y-m-d"));
										$nowDay 	= date("d-m-Y");										
										echo"<option value='$nowDay'>$nowDay</option>";
										for($min=1;$min<=1;$min++){
											$kemarin 	= date('d-m-Y', strtotime("-$min day", $now));
											echo"<option value='$kemarin'>$kemarin</option>";
										}
									?>
								</select>
							</div>
							<div class="col-lg-6">
								<label for="jmulai">Jam Mulai</label>
								<input name="jmulai" value="<?=$date_a?>" type="text" class="form-control required"  id="tp1"/>
							</div>
							<div class="col-lg-6">
								<label for="tselesai">Tanggal Selesai</label>
								<select name="tselesai" class="form-control required">
									<option value="">-Pilih Tanggal-</option>
									<?php
										$now2 		= strtotime(date("Y-m-d"));
										$nowDay2 	= date("d-m-Y");
										echo"<option value='$nowDay2'>$nowDay2</option>";
										for($min=1;$min<=1;$min++){
											$kemarin2 	= date('d-m-Y', strtotime("-$min day", $now2));
											echo"<option value='$kemarin2'>$kemarin2</option>";
										}
									?>
								</select>
							</div>
							<div class="col-lg-6">
								<label for="jselesai">Jam Selesai</label>
								<input name="jselesai" value="<?=$date_s?>" type="text" class="form-control required"  id="tp2"/>
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
						<div class="col-lg-6">
								<label for="Progress">Progress</label>
								<z data-tp-title='Informasi' data-tp-desc='Harap Melampirkan hasil pekerjaan apabila progress telah mencapai 100%' >
								<input name="progress" value="<?=$progress?>" type="text" class="form-control required" />
								</z>
						</div>
					</div>
					<div class="form-group  col-lg-6">
						<div class="col-lg-12">
							<div class="col-lg-12">
								<label for="lampiran">Lampiran File</label>
								<input type="file" id="lampiran" name="lampiran" class="form-control"/>
							</div>
							<div class="col-lg-12">
								<label for="ket">Keterangan Lampiran</label>
								<textarea  name="ket" class="form-control" placeholder="Keterangan Lampiran"><?=$ket?></textarea>
							</div>
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
									<input type="text" name="cc" class="form-control required" value="<?=$cc?>" id="cc" readonly placeholder="Kode Proyek / CC">
									<input type="hidden" name="uraian" class="form-control" value="<?=$uraian?>" id="uraian" placeholder="Kode Proyek / CC"  autocomplete="off" readonly>
										<span class="input-group-btn">
										  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="cc()"></i>
										</span>
								</div>
							</div>
							<div class="col-lg-12">
								<label for="sts_shift">Status Shift</label>
								<select name="sts_shift" id="sts_shift" class="form-control required" onchange="show(this.value)">
									<option value="">-Status Shift-</option>
									<option value="0">Non Shift</option>
									<option value="1">Shift</option>
								</select>
							</div>
							<div class="col-lg-12">
									<div id="jam_shift"></div>
							</div>
							<div class="col-lg-12">
								<label for="alasan">Alasan Dispensasi</label>
								<textarea name="alasan" class="form-control required" id="alasan"><?=$alasan?></textarea>
							</div>
							
						</div>
					</div>
					<hr/>
					</div>
					<div class="form-group  col-lg-12">
						<hr>
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger" onclick="history.back()">Back</button>
					</div>
				</form>
		
		</div>
	</div>
<script>
     $(function() {
        $('#tp1').timepicker({ 'timeFormat': 'HH:mm' });
        $('#tp2').timepicker({ 'timeFormat': 'HH:mm' });
    });
</script>
<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "bottom"
	});
</script>