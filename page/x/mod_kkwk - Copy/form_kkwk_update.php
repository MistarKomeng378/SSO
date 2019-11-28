
			<h1 class="page-header">Form Update Isian Hasil Kerja
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Form Update Isian Hasil Kerja</h4>
			    </div>
			    <div class="panel-body">
<?php
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_name.php";
include"../../config/encript.php";
	$ex 	= explode("-",$_GET['id']);
	$nik 	= dc($ex[0]);
	$jo_gca = dc($ex[1]);
	$hasil	= dc($ex[2]);
	$id		= dc($ex[3]);
	@$aprove	= dc($ex[4]);
	
	$edit			= mysql_fetch_array(mysql_query("SELECT * FROM pencapaian WHERE id_pencapaian='$id'")); 
	$urai			= mysql_fetch_array(mysql_query("SELECT uraian FROM pencapaian WHERE cc='$edit[cc]'"));
	$note 			= mysql_fetch_array(mysql_query("SELECT penilai,tgl_note,notif FROM note_kinerja WHERE nik='$nik' AND id_pencapaian='$id'"));
	$uraian			= $urai['uraian'];
	$aktifitas		= $edit['aktifitas'];
	$hasil_akhir	= $edit['hasil_akhir'];
	$cc				= $edit['cc'];
	$faktor_k		= $edit['faktor_k'];
	$progress		= $edit['progress'];
	$ket			= $edit['ket'];
?>
<script type="text/Javascript">
	function cc(){
		var x = window.open("lookup/cc2.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
</script>
<?php
	if($aprove==4){	
		if(!empty($note['note'])){
			$icon = "remove";
			echo"<div class='alert alert-$note[notif] alert-dismissable'>
				<i class='fa fa-$icon'></i>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<b>Note!</b> 
				<ul>
					<li>Oleh : ".name($note['penilai'])."</li>
					<li>Pada Tanggal :".tgl_indo($note['tgl_note'])."</li>
					<li>$note[note]</li>
					<li>Mohon dilakukan perbaikan berdasarkan catatan diatas.</li>
					<li>Isikan hasil perbaikan pada form dibawah ini.</li>
				</ul>
			</div>";
		}else{
			echo"<div class='alert alert-$note[notif] alert-dismissable'>
				<i class='fa fa-$icon'></i>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<b>Note!</b> 
				<ul>
					<li>Tidak ada Catatan !!</li>
				</ul>
			</div>
			";
		}
		$aksi = "aksi_revisi.php";
	}else{
		$aksi = "aksi_update.php";
	}
			echo"
			<div class='col-lg-6'>
			<form method='POST' action='page/mod_kkwk/$aksi' enctype='multipart/form-data'>
				<input name='id_pencapaian' value='$id' type='hidden' class='form-control ' />
				<input name='nik' value='$nik' type='hidden' class='form-control ' />
				<input name='jo_gca' value='$jo_gca' type='hidden' class='form-control ' />
				
				<div class='col-lg-12'>
					<label for='cc'>Kode Proyek / CC </label>
						<div class='input-group input-group'>
							<input type='text' name='cc' class='form-control' value='$cc' id='cc' readonly>
							<input type='hidden' name='uraian' class='form-control required' value='$uraian' id='uraian' placeholder='Kode Proyek / CC'  autocomplete='off' readonly>
							<span class='input-group-btn'>
								<i class='glyphicon glyphicon-search btn btn-primary btn-flat' onclick='cc()'></i>
							</span>
						</div>
				</div>
				
				<div class='col-lg-12'>
					<label for='h_aktifitas'>Hasil Aktifitas</label>
					<textarea name='h_aktifitas' class='form-control' placeholder='Hasil Aktifitas' required>$hasil_akhir</textarea>
				</div>
				<div class='col-lg-6'>
					<label for='progress'>Progress</label>
					<input type='text' name='progress' value='$progress' class='form-control required' placeholder='Progress'>
				</div>
				<div class='col-lg-6'>
					<label for='lampiran'>Lampiran File</label>
					<input type='file' id='lampiran' name='lampiran' class='form-control'/>
				</div>
				<div class='col-lg-12'>
					<label for='ket'>Keterangan Lampiran</label>
					<textarea  name='ket' class='form-control' placeholder='Keterangan Lampiran'>$ket</textarea>
				</div>
				
				<div class='form-group  col-lg-12'>
				<hr>
					<button type='submit' name='simpan' value='simpan' class='btn btn-primary'>Submit</button>
				</div>
			</form>
			</div>";
		
?>
		</div>
	</div>