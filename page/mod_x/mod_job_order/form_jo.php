<script type="text/javascript" src="assets/plugins/tp24/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="assets/plugins/tp24/jquery.timepicker.css" />
<?php
if($_GET['opt']=="tambah"){
			$id_lama		= mysql_fetch_array(mysql_query("SELECT max(SUBSTRING(id_jo,7,4)) as id FROM job_order"));
			@$kd			= $id_lama['id'];
			$kd_lama		= (int)$kd + 1;
			$kd_baru		= sprintf('%04s',$kd_lama);
			$id				= "JO".date("ym").$kd_baru;
			$tgl_mulai		= "";
			$tgl_selesai	= "";
			$jam_mulai		= "";
			$jam_selesai	= "";
			$aktifitas		= "";
			$atasan			= "";
			$lampiran		= "";
			$ket			= "";
}elseif($_GET['opt']=="edit"){
			$id				= mysql_real_escape_string($_GET['id']);
			$edit			= mysql_fetch_array(mysql_query("SELECT * FROM job_order WHERE id_jo='$id'")); 
			$tgl_mulai		= $edit['tgl_mulai'];
			$tgl_selesai	= $edit['tgl_selesai'];
			$ex1			= explode("-",$tgl_mulai);
			$tgl_mulai1		= $ex1[2]."/".$ex1[1]."/".$ex1[0];
			$ex2			= explode("-",$tgl_selesai);
			$tgl_selesai1	= $ex2[2]."/".$ex2[1]."/".$ex2[0];
			$jam_mulai		= $edit['jam_mulai'];
			$jam_selesai	= $edit['jam_selesai'];
			$aktifitas		= $edit['aktifitas'];
			$atasan			= $edit['atasan'];
			$lampiran		= $edit['lampiran'];
			$ket			= $edit['ket'];
		}
			
		?>
		<script type="text/Javascript">
			// function gca(){
				// var x = window.open("lookup/gca.php?nik=<?=$data_user['nik']?>", "gca", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			// }
			// function lapor(){
				// var x = window.open("lookup/lapor.php?nik=<?=$data_user['nik']?>", "lapor", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			// }
			// function cc(){
				// var x = window.open("lookup/cc2.php?nik=<?=$data_user['nik']?>", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			// }
		</script>
		<link rel="stylesheet" href="assets/plugins/select2-master/dist/css/select2.min.css"/>
		

			<h1 class="page-header">Job Order
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Form Job Order</h4>
			    </div>
			    <div class="panel-body">
				<form method="POST" action="page/mod_job_order/aksi_jo.php?opt=<?=$_GET['opt']?>"  id="formku" enctype="multipart/form-data">
					<div class="form-group col-lg-12 ">
					<div class="form-group  col-lg-6">
						<div class="col-lg-12">
								<label for="aktifitas">Aktifitas</label>
								<textarea name="aktifitas" class="form-control required" id="aktifitas"><?=$aktifitas?></textarea>
								<input type="hidden" name="id" value="<?=$id?>" class="form-control" >
								<input type="hidden" name="atasan" value="<?=$atasan?>" class="form-control" >
						</div>
						<div class="col-lg-12">
						<label for="pic">Diberikan Kepada</label>
								<select class="multiple-select2 form-control required" multiple="multiple" id="pic" name="pic[]">
                                   <?php
										if($_GET['opt']=="edit"){
											$qpic = mysql_query("SELECT	m_karyawan.`name`,
																		pic_jo.id_jo,
																		pic_jo.pic,
																		m_karyawan.regno
																		FROM
																		m_karyawan
																		INNER JOIN pic_jo ON pic_jo.pic = m_karyawan.regno
																		WHERE pic_jo.id_jo='$id'");
											while($epic=mysql_fetch_array($qpic)){
												echo"<option value='$epic[regno]' selected >$epic[name]</option>";
											}
										}
										$query3 = mysql_query("SELECT * FROM m_karyawan ");										
										while($r=mysql_fetch_array($query3)){
											echo"<option value='$r[regno]' >$r[name]</option>";
										}
									?>
                                </select><br>
						</div>
							<div class="col-lg-6">
								<label for="tgl">Target Mulai</label>
								<input type="text" name="tgl_mulai" value="<?=$tgl_mulai1?>" class="form-control required" placeholder="Tanggal Mulai" id="datepicker">
							</div>
							<div class="col-lg-6">
								<label for="jam_mulai">Jam Mulai</label>
								<div class="input-group bootstrap-timepicker">
									<input id="tp1" name="jam_mulai" value="<?=$jam_mulai?>" type="text" class="form-control required" />
								</div>
							</div>
							<div class="col-lg-6">
								<label for="tgl">Target Selesai</label>
								<input type="text" name="tgl_selesai" value="<?=$tgl_selesai1?>" class="form-control required" placeholder="Tanggal Selesai" id="datepicker1">
							</div>
							<div class="col-lg-6">
								<label for="jam_selesai">Jam Selesai</label>
								<div class="input-group bootstrap-timepicker">
									<input id="tp2" name="jam_selesai" value="<?=$jam_selesai?>" type="text" class="form-control required" />
								</div>
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
		<script>
			 $(function() {
				$('#tp1').timepicker({ 'timeFormat': 'H:i:s' });
				$('#tp2').timepicker({ 'timeFormat': 'H:i:s' });
			});
		</script>	
        <script src="assets/plugins/select2-master/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
               
                $("#pic").select2({
                    placeholder: "Diberikan Kepada"
                });
                $("#integrasi").select2({
                    placeholder: "Pilih Integrasi"
                });
            });
        </script>
