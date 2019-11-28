<?php
//$getTahun	= mysql_real_escape_string(dc($_GET['tahun']));	
$getTahun	= dc($_GET['tahun']);	

if($_GET['opt']=="tambah"){
			$cek		= mysql_query("SELECT max(id_penilaian) as id FROM penilaian_kerja ");
			$qkd 		= mysql_fetch_array($cek);
			@$kd		= $qkd['id'];
			$kd_baru	= (int)$kd + 1;
			//$tahun		= date("Y");
			$tahun		= $getTahun;
			$bobot		= 0;
			$pm			= "";
			$nama_pm	= "";
			
		}elseif($_GET['opt']=="edit"){
			$getId			= dc($_GET['id_penilaian']);				
			$id				= mysql_real_escape_string($getId);
			$edit			= mysql_fetch_array(mysql_query("SELECT * FROM penilaian_kerja WHERE id_penilaian='$id'")); 
			$kd_baru		= $id;
			$nik			= $edit['nik'];
			$jabatan		= $edit['jabatan'];
			$divisi			= $edit['divisi'];
			$rencana_kerja	= $edit['rencana_kerja'];
			$target			= $edit['target'];
			$hasil			= $edit['hasil'];
			$pencapaian		= $edit['pencapaian'];
			$bobot			= $edit['bobot'];
			$skor			= $edit['skor'];
			$nilai			= $edit['nilai'];
			$hasil_kerja	= $edit['hasil_kerja'];
			$tahun			= $edit['tahun'];
			$satuan			= $edit['satuan'];
			$pm				= $edit['pm'];
			$qnama 			= mysql_fetch_array(mysql_query("SELECT * FROM m_karyawan where regno='$pm'"));
			$nama_pm		= $qnama['name'];
			
		 }
?>
	<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
	<script type="text/Javascript">
		function pm(){
			var x = window.open("lookup/pm.php", "pm", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=600");
		}		
	</script>

	<h1 class="page-header">Form Penilaian Karyawan
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Form Penilaian Karyawan </h4>
			    </div>
				<?
					if(isset($_REQUEST['failed2'])){
						echo"<div class='alert alert-danger alert-dismissable'>
								<i class='fa fa-remove'></i>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								<b>Failed!</b> Bobot Yang Anda Isikan Melebihi <b>75</b>, Silahkan Isi Kembali.
							</div>";
					}
				
					
					// $bulan = date('m');
					// if($bulan<12){
						// $input = "readonly";
						// $note = "Diinput diakhir Tahun (Bulan Desember)";
					// }else{
						// $input2 = "readonly";						
					// }
					
					$cc = mysql_fetch_array(mysql_query("SELECT * FROM mskko where CostCenter='".$_SESSION['cc']."'"));
					
					$qr = mysql_fetch_array(mysql_query("SELECT SUM(bobot) as jmlh_bobot FROM penilaian_kerja where nik = '".$_SESSION['nik']."'"));
					
					
					
					$kar = mysql_fetch_array(mysql_query("select * from m_karyawan where regno = '".$_SESSION['nik']."'")); 
					$jab = mysql_fetch_array(mysql_query("select * from m_jabatan where poscode = '".$kar['poscode']."'"));
					
				?>
			    <div class="panel-body">
				<form method="POST" action="page/mod_penilaian/aksi_penilaian_karyawan.php?opt=<?=$_GET['opt']?>"  id="formku">
					<div class="form-group col-lg-8 ">
							<div class="col-lg-6">
								<label for="gca_by">NIK/Nama</label>
								<input type="text" name="srko_by" value=" <?=$_SESSION['nik']?> / <?=name($_SESSION['nik'])?>" class="form-control" readonly>
								<input type="hidden" name="nik" value="<?=$_SESSION['nik']?>" class="form-control">
								<input type="hidden" name="id_penilaian" value="<?=$kd_baru?>" class="form-control">
							</div>
							<div class="col-lg-6">
								<label for="jabatan">Jabatan</label>
								<input type="text" name="jabatan" value="<?=$jab['posdesc']?>" class="form-control " readonly >
							</div>
							<div class="col-lg-6">
								<label for="divisi">Divisi</label>
								<input type="text" name="cc" value="<?=$cc['uraian']?>" class="form-control"  readonly >
								<input type="hidden" name="divisi" value="<?=$cc['CostCenter']?>" class="form-control">
							</div>
							<div class="col-lg-6">
								<label for="tahun">Tahun</label>
								<input type="text" name="tahun" value="<?=$tahun?>" class="form-control" readonly>
							</div>
							<div class="col-lg-12">
								<label for="rencana">Rencana Kerja</label>
								<textarea name="rencana_kerja" class="form-control" rows="4" <?=$input2?> ><?=$rencana_kerja?></textarea>
							</div>
							<div class="col-lg-2">
								<label for="target">Target</label>
								<input type="text" name="target" value="<?=$target?>"  <?=$input2?> class="form-control"  placeholder="Target" maxlength="3">
							</div>
							<div class="form-group  col-lg-3">
								<label for="satuan">Satuan</label>
								<select name="satuan" class="form-control">
									<option value="">Pilih</option>
									<?php
										
										$qsat = mysql_query("SELECT * FROM satuan order by satuan ASC");
										while($sat=mysql_fetch_array($qsat)){
											echo"<option value='".$sat['satuan']."'"; if($satuan==$sat['satuan']){echo"selected";} echo" >$sat[satuan]</option>";
										}
									?>
								</select>
							</div>
							<div class="col-lg-2">
								<label for="bobot">Bobot</label>
								<input type="text" name="bobot" id="<?=$idbot?>" value="<?=$bobot?>" <?=$input2?> class="form-control" placeholder="Bobot"  onkeyup="masuk()" maxlength="3">								
							</div>
							<div class="col-lg-5">
								<label for="pm">Penilai<!--/ NIK--></label>
								<div class="input-group input-group">
									<input type="hidden" name="pm" class="form-control required" value="<?=$pm?>" id="pm" placeholder="Atasan/Project Manager" required autocomplete="off">
									
									<input type="text" name="nama_pm" class="form-control required " value="<?=$nama_pm?>" id="nama_pm" placeholder="Atasan/Project Manager/Kepala Unit"  required readonly autocomplete="off">
									
										<span class="input-group-btn">
										  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="pm()"></i>
										</span>
								</div>
							</div>
							<div class="col-lg-2">
									<label for="bobot">&nbsp;</label>									
									<input type="hidden" name="total" id="<?=$idtot?>" value="<?=$qr['jmlh_bobot']?>" readonly class="form-control" placeholder="Bobot">									
									<input type="hidden" name="jumlah_bobot" id="<?=$jumbot?>" value="<?=$qr['jmlh_bobot']?>" readonly class="form-control">									
									<!--<small>Bobot Komulatif</small>-->
							</div>							
					<div class="form-group  col-lg-12">	
						<hr>
						<small><b>Keterangan : </b></small><br>
						&nbsp;&nbsp;&nbsp;<small>* Target & bobot di input Tanpa Menggunakan Simbol Persen (%)<br>
						&nbsp;&nbsp;&nbsp;		 * Bobot yang diinput dikonversikan secara otomatis menjadi 75<br>
						&nbsp;&nbsp;&nbsp;		 * Penilai Diisikan oleh atasan Penilai (Atasan/Project Manager/Kepala Unit)

						</small>	
					</div>
					<div class="form-group  col-lg-12">
						
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger">Reset</button>
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

<script>
function masuk(no) {
			//Plus
		var jumlah_bobot 	= $('#jumlah_bobot').val();
			bobot			= $('#bobot').val();
			jumlah			= (eval(jumlah_bobot)+eval(bobot));
			$('#total').val(Math.round(jumlah));		
			
			//Minus	
		var	jum_min		 	= $('#jum_min').val();//
			bobot_min		= $('#bobot_min').val();//
			jumlah_min		= (eval(jum_min)-eval(bobot_min));//
			$('#total_min').val(Math.round(jumlah_min));	//
	}
</script>

<script src="assets/plugins/select2-master/dist/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
	   
		$("#pm").select2({
			placeholder: "Project Manager"
		});
	});
</script>
