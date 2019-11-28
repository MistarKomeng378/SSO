<script type="text/javascript">
	function show(linkform){
		if (linkform==""){
			document.getElementById("formkkwk").innerHTML="";
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
				document.getElementById("formkkwk").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","get_formkkwk.php?tgl="+linkform,true);
		xmlhttp.send();
	}	
</script>
<link rel="stylesheet" href="assets/plugins/timepicker/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" />
<link rel="stylesheet" href="assets/plugins/timepicker/jquery.ui.timepicker.css?v=0.3.3" type="text/css" />
<script src="assets/plugins/timepicker/jquery.ui.timepicker.js"></script>
<script src="assets/plugins/maskedinput/jquery.maskedinput.js"></script>


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
	if($_GET['opt']=="pilih"){
	?>
		<form method="POST" action="?page=form_kkwk2&opt=tambah" id="formku" enctype="multipart/form-data">
			<div class="col-lg-12">
				<label for="tgl">Tanggal Aktifitas</label>
					<?php
						echo'
						<select name="tmulai" class="form-control required" onchange="show(this.value)">
							<option value="" >-Pilih Tanggal-</option>';
								$now 		= strtotime(date("Y-m-d"));
								$nowDay 	= date("d-m-Y");										
								echo"<option value='".ec($nowDay)."' >$nowDay</option>";
								for($i=1;$i<=6;$i++){
									$kemarin 	= date('d-m-Y', strtotime("-$i day", $now));
									echo"<option value='".ec($kemarin)."'>$kemarin</option>";
								}
						echo'</select>';
					?>
			</div>
			<div class="col-lg-12">
				<div id="formkkwk"></div>
			</div>
		</form>
	<?php
	}elseif($_GET['opt']=="tambah"){
		$count = count($_POST['id_gca'])-1;
		echo"<form method='POST' action='' id='formku' enctype='multipart/form-data'>";
		for($i=0;$i<=$count;$i++){
			$j=$i+1;
	?>
		<script type="text/javascript">
		$(function() {
			$.mask.definitions['~'] = "[+-]";
			$("#jselesai<?=json_encode($j)?>").mask("99:99",{placeholder:"HH:MM" });      
			$("#jmulai<?=json_encode($j)?>").mask("99:99",{placeholder:"HH:MM" }); 
		});
		
		$(document).ready(function() {
			$('#jselesai<?=json_encode($j)?>').timepicker({
				showNowButton: true,
				showDeselectButton: true,
				defaultTime: '',
				showCloseButton: true
			});
			$('#jmulai<?=json_encode($j)?>').timepicker({
				showNowButton: true,
				showDeselectButton: true,
				defaultTime: '',
				showCloseButton: true
			});
		});
		
		function lapor<?=$j?>(){
			var x = window.open("lookup/mlapor.php?id=<?=ec($j)?>", "lapor", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
		}
		function cc<?=$j?>(){
			var x = window.open("lookup/mcc.php?id=<?=ec($j)?>", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
		}
		function show2<?=$j?>(linkinpark){
			if (linkinpark==""){
				document.getElementById("jam_shift<?=$j?>").innerHTML="";
				return;
			}
			if(window.XMLHttpRequest)
				{
				xmlhttp=new XMLHttpRequest();
			}else {
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("jam_shift<?=$j?>").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","get_jam2.php?sts_shift="+linkinpark,true);
			xmlhttp.send();
		}
	</script>
	<?php
			
			if(isset($_POST['tm'])){
				$tmulai 		= mysql_real_escape_string(dc($_POST['tmulai'][$i]));
				$tmulai			= date('Y-m-d', strtotime($tmulai));
			}else{
				$tmulai 		= mysql_real_escape_string(dc($_POST['tmulai']));
				$tmulai			= date('Y-m-d', strtotime($tmulai));
			}
			$id_gca 		= mysql_real_escape_string($_POST['id_gca'][$i]);
			$gca			= mysql_fetch_array(mysql_query("SELECT aktivitas,deliverable,cc FROM wbs WHERE id='".mysql_real_escape_string($id_gca)."' "));
			$aktifitas		= $gca['aktivitas'];
			$deliverable	= $gca['deliverable'];
			$cc				= $gca['cc'];
			$urai			= mysql_fetch_array(mysql_query("SELECT uraian FROM pencapaian WHERE cc='$cc'"));
			$uraian			= $urai['uraian'];
			$qlap			= mysql_fetch_array(mysql_query("SELECT laporan FROM pencapaian WHERE jo_gca='$id_gca'"));
			$laporan		= $qlap['laporan'];
			$nama_lapor		= name($laporan);
			
			@$hasil_aktf	= $_POST['hasil'][$i];
			@$progress		= $_POST['progress'][$i];
			@$jmulai		= $_POST['jmulai'][$i];
			@$jselesai		= $_POST['jselesai'][$i];
			
			
			echo"
			<div class='form-group  col-lg-12'>
			<div class='form-group  col-lg-6'>
					<input type='hidden' name='id_gca[]' class='form-control ' value='$id_gca' readonly >
					<input type='hidden' name='jo_gca[]' class='form-control ' value='$id_gca' id='jo_gca' readonly >
					<input type='hidden' name='nik[]' value='$_SESSION[nik]' class='form-control'>
					<input type='hidden' name='faktor[]' id='faktor' value='A' class='form-control required' readonly autocomplete='off'>
				<div class='col-lg-12'>
					<label for='tgl'>Tanggal Aktifitas</label>
					<input type='text' name='tm' id='' value='$tmulai' class='form-control required' readonly autocomplete='off'>
					<input type='hidden' name='tmulai[]' id='tmulai' value='".ec($tmulai)."' class='form-control required' readonly autocomplete='off'>
				</div>
				<div class='col-lg-6'>
					<label for='jmulai'>Jam Mulai</label>
					<input name='jmulai[]' value='$jmulai' type='text' class='form-control required'  id='jmulai$j' />
				</div>
				<div class='col-lg-6'>
					<label for='jselesai'>Jam Selesai</label>
					<input name='jselesai[]' value='$jselesai' type='text' class='form-control required'  id='jselesai$j' />
				</div>						
				<div class='col-lg-12'>
					<label for='aktifitas'>Aktifitas</label>
					<textarea name='aktifitas[]' class='form-control required' id='aktifitas'>$aktifitas</textarea>
				</div>
				<div class='col-lg-12'>
					<label for='hasil'>Hasil Aktifitas</label>
					<textarea name='hasil[]' class='form-control required' id='hasil'>$hasil_aktf</textarea>
				</div>
				<div class='col-lg-12'>
					<label for='deliverable'>Deliverable / Hasil Akhir</label>
					<input type='text' name='deliverable[]' class='form-control' value='$deliverable' placeholder='Deliverable' id='deliverable' readonly>
				</div>
			</div>
			<div class='form-group  col-lg-6'>
				<div class='col-lg-12'>
					<label for='lapor'>Dilaporkan Kepada</label>
					<div class='input-group input-group'>
						<input type='hidden' name='lapor[]' class='form-control' value='$laporan' id='lapor$j'>
						<input type='text' name='nama_lapor[]' class='form-control required' value='$nama_lapor' id='nama_lapor$j' placeholder='Dilaporkan Kepada' autocomplete='off' readonly>
						<span class='input-group-btn'>
						  <i class='glyphicon glyphicon-search btn btn-primary btn-flat edit-record' onclick='lapor$j()'></i>
						</span>
					</div>
				</div>
				<div class='col-lg-12'>
				<label for='cc'>Kode Proyek / Cost Center</label>
					<div class='input-group input-group'>
						<input type='text' name='cc[]' class='form-control required' value='$cc' id='cc$j' placeholder='Kode Proyek / CC' readonly>
						<input type='hidden' name='uraian[]' class='form-control ' value='$uraian' id='uraian$j' placeholder='Kode Proyek / CC'  autocomplete='off' readonly>
						<span class='input-group-btn'>
							<i class='glyphicon glyphicon-search btn btn-primary btn-flat edit-record' onclick='cc$j()'></i>
						</span>
					</div>
				</div>	
				<div class='col-lg-12'>
					<label for='lampiran'>Lampiran File</label>
					<input type='file' id='lampiran' name='lampiran[]' class='form-control'/>
				</div>
				<div class='col-lg-12'>
					<label for='ket'>Keterangan Lampiran</label>
					<textarea  name='ket[]' class='form-control' placeholder='Keterangan Lampiran'></textarea>
				</div>						
				<div class='col-lg-6'>
						<label for='Progress'>Progress</label>
						<z data-tp-title='Informasi' data-tp-desc='Harap Melampirkan hasil pekerjaan apabila progress telah mencapai 100%' >
						<input name='progress[]' value='$progress' type='text' class='form-control required number' />
						</z>
				</div>
				<div class='col-lg-6'>
					<label for='sts_shift'>Status Shift</label>
					<select name='sts_shift[]' id='sts_shift' class='form-control required' onchange='show2$j(this.value)'>
						<option value=''>-Status Shift-</option>
						<option value='0' selected>Non Shift</option>
						<option value='1'>Shift</option>
					</select>							
				</div>
				<div class='col-lg-12'>
					<div id='jam_shift$j'></div>
				</div>
			</div>
			</div>
			
			<div class='col-lg-12'>
				<hr>
			</div>			
			";
		}
		echo"
			<div class='col-lg-12'>
				<input type='submit' value='Simpan' name='Simpan' class='btn btn-sm btn-primary' >
			</div>
		</form>";
	}
	?>
	</div>
</div>