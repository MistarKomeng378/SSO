<?php

if($_GET['opt']=="tambah"){
			$kd_baru		= "";
			$nik			= "";
			$jo_gca			= "";
			$tgl_aktifitas	= "";
			$jam_mulai		= "";
			$jam_akhir		= "";
			$aktifitas		= "";
			$hasil_akhir	= "";
			$laporan		= "";
			$cc				= "";
			$faktor_k		= "";
			$progress		= "";
			$ket			= "";
			$nama_lapor		= "";
			$uraian			= "";
}elseif($_GET['opt']=="edit"){
			$id				= mysql_real_escape_string($_GET['id']);
			$edit			= mysql_fetch_array(mysql_query("SELECT * FROM pencapaian WHERE id_pencapaian='$id'")); 
			$nama			= mysql_fetch_array(mysql_query("SELECT * FROM m_karyawan WHERE regno='$edit[laporan]'"));
			$urai			= mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='$edit[cc]'"));
			$nama_lapor		= $nama['name'];
			$uraian			= $urai['uraian'];
			$kd_baru		= $id;
			$nik			= $edit['nik'];
			$jo_gca			= $edit['jo_gca'];
			$tgl_a			= $edit['tgl_aktifitas'];
			$ex				= explode("-",$tgl_a);
			$tgl_aktifitas	= $ex[2]."/".$ex[1]."/".$ex[0];
			$jam_mulai		= $edit['jam_mulai'];
			$jam_akhir		= $edit['jam_akhir'];
			$aktifitas		= $edit['aktifitas'];
			$hasil_akhir	= $edit['hasil_akhir'];
			$laporan		= $edit['laporan'];
			$cc				= $edit['cc'];
			$faktor_k		= $edit['faktor_k'];
			$progress		= $edit['progress'];
			$ket			= $edit['ket'];
		}
			
		?>
		<script type="text/Javascript">
			function gca(){
				var x = window.open("lookup/gca.php?nik=<?=$_SESSION['nik']?>", "gca", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=1000,height=500");
			}
			function lapor(){
				var x = window.open("lookup/lapor.php?nik=<?=$_SESSION['nik']?>", "lapor", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			}
			function cc(){
				var x = window.open("lookup/cc2.php?nik=<?=$_SESSION['nik']?>", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			}
		</script>

<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Pencapaian Kerja</a></li>
				<li><a href="" onclick="self.history.back()">Catatan Kerja dan Hasil Kerja</a></li>
				<li><a href="" onclick="self.history.reload()">Form Isian Hasil Kerja</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Form Isian Hasil Kerja
				<small><?=$level['level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			        </div>
			        <h4 class="panel-title">Form Isian Hasil Kerja</h4>
			    </div>
			    <div class="panel-body">
		<!--<a href="javascript:add();"  class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambah Record</a>
		<hr/>-->
			
				<form method="POST" action="page/mod_kkwk/aksi_kkwk.php?opt=<?=$_GET['opt']?>"  id="formku" enctype="multipart/form-data">
					<div class="form-group col-lg-12 ">
					<div class="form-group  col-lg-6">
						
							<div class="col-lg-6">
								<label for="jo_gca">GCA / Job Order</label>
								<div class="input-group input-group">
									<input type="text" name="jo_gca" class="form-control" value="<?=$jo_gca?>" id="jo_gca" readonly>
										<span class="input-group-btn">
										  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="gca()"></i>
										</span>
								</div>
								<input type="hidden" name="nik" value="<?=$_SESSION['nik']?>" class="form-control">
								<input type="hidden" name="id_pencapaian" value="<?=$kd_baru?>" class="form-control">
							</div>
							
						<div class="col-lg-12">
							<label for="tgl">Tanggal Aktifitas</label>
							<input type="text" name="tgl" value="<?=$tgl_aktifitas?>" class="form-control" placeholder="Tanggal Aktifitas" id="datepicker">
						</div>
						
						<div class="col-lg-12">
							<div class="col-lg-6">
								<label for="jam_mulai">Mulai Jam</label>
								
								<div class="input-group bootstrap-timepicker">
									<input id="timepicker2" name="jam_mulai" id="jam_mulai" value="" type="text" class="form-control" />
									<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								</div>
							</div>
							<div class="col-lg-6">
								<label for="jam_akhir">s/d</label>
								<div class="input-group bootstrap-timepicker">
									<input id="timepicker" name="jam_akhir" value="<?=$jam_akhir?>" type="text" class="form-control" />
									<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
								<label for="aktifitas">Aktifitas</label>
								<textarea name="aktifitas" class="form-control" id="aktifitas"><?=$aktifitas?></textarea>
						</div>
						<div class="col-lg-12">
								<label for="deliverable">Deliverable / Hasil Akhir</label>
								<input type="text" name="deliverable" class="form-control" value="" placeholder="Deliverable" id="deliverable" readonly>
						</div>
						<div class="col-lg-12">
								<label for="h_aktifitas">Hasil Aktifitas</label>
								<textarea name="h_aktifitas" class="form-control"><?=$hasil_akhir?></textarea>
						</div>
					</div>
					<div class="form-group  col-lg-6">
						<div class="col-lg-12">
							<div class="col-lg-12">
								<label for="lapor">Dilaporkan Kepada</label>
								<div class="input-group input-group">
									<input type="hidden" name="lapor" class="form-control" value="<?=$laporan?>" id="lapor">
									<input type="text" name="nama_lapor" class="form-control" value="<?=$nama_lapor?>" id="nama_lapor" placeholder="Dilaporkan Kepada">
										<span class="input-group-btn">
										  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="lapor()"></i>
										</span>
								</div>
							</div>
							<div class="col-lg-12">
								<label for="cc">Kode Proyek / CC</label>
								<div class="input-group input-group">
									<input type="hidden" name="cc" class="form-control" value="<?=$cc?>" id="cc">
									<input type="text" name="uraian" class="form-control" value="<?=$uraian?>" id="uraian" placeholder="Kode Proyek / CC">
										<span class="input-group-btn">
										  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="cc()"></i>
										</span>
								</div>
							</div>
							<div class="col-lg-6">
								<label for="faktor">Faktor Kontribusi</label>
								<select name="faktor" class="form-control">
									<option value="">-Faktor Kontribusi-</option>
									<option value="A" <?php if($faktor_k=="A") echo"selected"; ?> >A</option>
									<option value="B" <?php if($faktor_k=="B") echo"selected"; ?> >B</option>
									<option value="C" <?php if($faktor_k=="C") echo"selected"; ?> >C</option>
									<option value="D" <?php if($faktor_k=="D") echo"selected"; ?> >D</option>
								</select>
							</div>
							<div class="col-lg-6">
								<label for="progress">Progress</label>
								<input type="text" name="progress" value="<?=$progress?>" class="form-control" placeholder="Progress">
							</div>
							<div class="col-lg-12">
								<label for="lampiran">Lampiran File</label>
								<input type="file" id="lampiran" name="lampiran" class="form-control"/>
							</div>
							<div class="col-lg-12">
								<label for="ket">Keterangan Lampiran</label>
								<textarea  name="ket" class="form-control" placeholder="Keterangan Lampiran"><?=$ket?></textarea>
							</div>
						</div>
					</div>
					<hr/>
					</div>
					<div id="record"></div>
					<div class="form-group  col-lg-12">
						<hr>
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger">Reset</button>
					</div>
				</form>
		
		</div>
	</div>
</div>