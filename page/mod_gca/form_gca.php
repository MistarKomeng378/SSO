<link rel="stylesheet" type="text/css" media="all" href="assets/plugins/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="assets/plugins/daterangepicker/moment.js"></script>
<script type="text/javascript" src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<link href="assets/plugins/multupledate/jquery.datepick.css" rel="stylesheet">
<script src="assets/plugins/multupledate/jquery.plugin.js"></script>
<script src="assets/plugins/multupledate/jquery.datepick.js"></script>
<link rel="stylesheet" href="assets/plugins/select2-master/dist/css/select2.min.css"/>
<script>
$(function() {
	$('#popupDatepicker').datepick({ 
    multiSelect: 999, monthsToShow: 1, 
    showTrigger: '#calImg'});
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>
<script type="text/javascript">
	function showcetak(linkinpark){
		if (linkinpark==""){
			document.getElementById("tinjau").innerHTML="";
			return;
		}
		if(window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		}else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("tinjau").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","getForm.php?jenis="+linkinpark,true);
		xmlhttp.send();
	}
</script>
<script type="text/javascript">
	function showcetak2(link){
		if (link==""){
			document.getElementById("jam").innerHTML="";
			return;
		}
		if(window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		}else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("jam").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","getForm2.php?jenis="+link,true);
		xmlhttp.send();
	}	
</script>
<?php
		if($_GET['opt']=="tambah"){
			$idParent	= dc($_GET['id']);
			$parentId	= dc($_GET['id']);
			$cc_id		= dc($_GET['cc']);
			$kdhuruf	= substr($parentId,0,1);
			$cek		= mysql_query("SELECT max(id) as id FROM wbs WHERE cc_id='$cc_id' ORDER by parentId DESC");
			$qkd 		= mysql_fetch_array($cek);
			$cutId		= (int) substr($qkd['id'],3,5);
			$cutId ++;
			$kd_baru	= $kdhuruf.date("y").sprintf("%05s", $cutId);
			
			$aktifitas	= "";
			$tgl_mulai	= "";
			$tgl_akhir	= "";
			$durasi		= "";
			$jam		= "";
			$pic		= "";
			$deliverable= "";		
			$cc			= "";
			$nama_cc	= "";			
			$nama		= "";			
			$qhasil		= mysql_fetch_array(mysql_query("SELECT hasil_akhir,level,id_srko FROM wbs WHERE id='$parentId' "));
			$hasil_akhir= $qhasil['hasil_akhir'];			
			$lvl		= $qhasil['level']+1;			
			$id_srko	= $qhasil['id_srko'];
			$jenisGCA	= "";
			$jenisAktf	= "";
			$disabled 	= "disabled";
			$cekjam		= mysql_num_rows(mysql_query("SELECT id_gca FROM waktu_kerja2 WHERE id_gca='$parentId' "));
			if($cekjam > 0){
				echo"<SCRIPT language='javascript'>alert('GCA ini diset sebagai aktifitas, apabila akan di tambahkan sub aktifitas maka perencanaan (GCA Load) dan aktifitas (KKWK) sebelumnya akan dihapus')</SCRIPT>";
			}
			
		}elseif($_GET['opt']=="edit"){
			$id			= mysql_real_escape_string(dc($_GET['id']));
			$edit		= mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$id'"));
			$qnama		= mysql_fetch_array(mysql_query("SELECT * FROM m_karyawan WHERE regno='$edit[pic]'"));
			$nama		= $qnama['name'];
			$qnama_cc	= mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='$edit[cc]'"));
			$nama_cc	= $qnama_cc['uraian'];
			$kd_baru	= $id;
			$id_srko	= $edit['id_srko'];
			$idParent	= $edit['parentId'];
			$parentId	= $edit['parentId'];
			$aktifitas	= $edit['aktivitas'];
			$mulai		= $edit['mulai'];
			$akhir		= $edit['akhir'];
			$tgl_1		= explode("-",$mulai);
			@$tgl_mulai	= $tgl_1[2]."/".$tgl_1[1]."/".$tgl_1[0];
			$tgl_2		= explode("-",$akhir);
			@$tgl_akhir	= $tgl_2[2]."/".$tgl_2[1]."/".$tgl_2[0];
			$durasi		= $edit['durasi'];
			$pic		= $edit['pic'];
			$cc			= $edit['cc'];
			$cc_id		= $edit['cc_id'];
			$deliverable= $edit['deliverable'];
			$jam		= $edit['jam'];
			$hasil_akhir= $edit['hasil_akhir'];
			$lvl		= $edit['level'];
			$jenisGCA	= $edit['jenisGCA'];
			$jenisAktf	= $edit['jenisAktf'];
			if($jenisGCA==1){ $disabled = "disabled"; }else{ $disabled = ""; }
		}

		?>
<script type="text/Javascript">
			function cc(){
				var x = window.open("lookup/cc.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			}
			function pic(){
				var x = window.open("lookup/pic.php", "pic", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
			}
		</script>
			<h1 class="page-header">Form GCA
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Form GCA</h4>
			    </div>
			    <div class="panel-body">
				<?php
				if($_GET['opt']=="tambah"){
				?>
				<form method="POST" action="page.php?page=cek_gca&opt=<?=$_GET['opt']?>"  id="formku" name="formku">
					<div class="form-group  col-lg-6">
							
							<div class="col-lg-12">
								<p align="justify"><b>
								<?php
								
								for($ak=1;$ak<=99;$ak++){
									$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
									if($ak==1){
										$fontColor="blue";
									}else{
										$fontColor="black";
									}
									if($ak!=1){
										echo"-> ";
									}
									echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
									setcookie("expandrow_$ak", $gca['id'], time() + (60 * 60), '/');
									$idParent=$gca['parentId'];
									$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
									if ($idParent==$cek_id['id_tahun'])
									  {
									  break;
									  }
								}
								if($data['level'] > 1){
									setcookie("level", $ak, time() + (60 * 60), '/');
								}
								?>
								</b></p>
							</div>
							<div class="col-lg-6">
								<label for="id">ID</label>
								<input type="text" name="id" value="<?=$kd_baru?>" class="form-control" readonly>
								<input type="hidden" name="hasil_akhir" value="<?=$hasil_akhir?>" class="form-control" readonly>
								<input type="hidden" name="cc_id" value="<?=$cc_id?>" class="form-control" readonly>
								<input type="hidden" name="level" value="<?=$lvl?>" class="form-control" readonly>
								<input type="hidden" name="tahun_aktif" value="<?=$tahun_aktif?>" class="form-control" readonly>
							</div>
							<div class="col-lg-6">
								<label for="parentId">Parent ID</label>
								<input type="text" name="parentId" value="<?=$parentId?>" class="form-control required" placeholder="Parent ID" readonly>
								<input type="hidden" name="id_srko" value="<?=$id_srko?>" class="form-control">
							</div>
							<div class="col-lg-12">
								<label for="aktifitas">Aktifitas</label>
								<textarea name="aktifitas" placeholder="Aktifitas" class="form-control required"><?=$aktifitas?></textarea>
							</div>
							<div class="col-lg-6">
								<label for="jenis">Jenis GCA</label>
								<select name="jenis" class="form-control required" onchange="showcetak2(this.value)">
									<option value="">-Jenis GCA-</option>
									<option value="1">Folder</option>
									<option value="2">Aktifitas</option>
								</select>
							</div>
							<div class="col-lg-6">
								<label for="jenisA">Jenis Aktifitas</label>
								<select name="jenisA" class="form-control required" >
									<option value="">-Jenis Aktifitas-</option>
									<option value="1">Rutin</option>
									<option value="2">Non Rutin</option>
								</select>
							</div>
							<div class="col-lg-6">
								<label for="tanggal">Rentang Tanggal</label>
								<input type="text" id="demo" class="form-control" name="tanggal" value=""  autocomplete="off">
							</div>
							<div class="col-lg-6">
								<label for="jam">Jam Perhari</label>
								<div id="jam"><input type="text" name="jam" value="<?//=$jam?>" class="form-control " placeholder="Jam Perhari" readonly ></div>
							</div>
							<div class="col-lg-12">
								<label for="pengecualian">Pengecualian Tanggal </label>
								<input type="text" name="pengecualian" value="" class="form-control" id="popupDatepicker" placeholder="Pengecualian Tanggal" onchange="showcetak(this.value)" onclick="showcetak(this.value)"  autocomplete="off">
							</div>
						
					</div>
					<div class="form-group  col-lg-6">
						<div class="col-lg-12">
							<div class="col-lg-12">
								<label for="cc">Cost Center<!--/ Kode Proyek--></label>
									<div class="input-group input-group">
										<input type="text" name="cc" class="form-control" value="<?=$cc?>" id="cc" placeholder="Kode Proyek / Cost Center" autocomplete="off">
										<input type="hidden" name="uraian" class="form-control required" value="<?=$nama_cc?>" id="uraian" placeholder="Kode Proyek / Cost Center"  readonly autocomplete="off">
											<span class="input-group-btn">
											  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="cc()"></i>
											</span>
									</div>
							</div>
							<div class="col-lg-12">
									<input type="hidden" name="pic_asli" value="<?=$pic?>" class="form-control ">
									<label for="nama_pic">Penanggung Jawab</label>
									<select class="multiple-select2 form-control required" multiple="multiple" id="pic" name="pic[]"  autocomplete="off">
                                   <?php
										$qpic = mysql_query("SELECT * FROM m_karyawan WHERE regno='$pic'");
										$epic = mysql_fetch_array($qpic);
										$cekpic = mysql_num_rows($qpic);
										$query3 = mysql_query("SELECT * FROM m_karyawan ");										
										while($r=mysql_fetch_array($query3)){
												echo"<option value='$r[regno]' "; if($r['regno']==$pic){echo"selected";} echo">$r[name]</option>";
										}
									?>
                                </select>
							</div>
							<div class="col-lg-12">
								<label for="deliverable">Deliverable</label>
								<textarea name="deliverable"  placeholder="Deliverable" class="form-control "><?=$deliverable?></textarea>
							</div>
							<div class="col-lg-6">
								<label for="tgl_isi">Waktu Isi GCA</label>
								<input type="text" name="tgl_isi" value="<?=date("Y-m-d H:i:s")?>" class="form-control required" placeholder="Tanggal Isi GCA" readonly>
							</div>
							<div class="col-lg-12">
								<label for="gca_by">GCA BY</label>
								<input type="text" name="gca_by" value="<?=name($_SESSION['nik'])?>" class="form-control required" placeholder="GCA BY" readonly>
								<input type="hidden" name="nik" value="<?=$_SESSION['nik']?>" class="form-control" placeholder="GCA BY">
							</div>
							<div class="col-lg-12">
								<label for="tinjau">Tinjau Ke GCA Load</label>
								<br>
								<input type="radio" name="tinjau" value="1" required > Ya<br>
								<input type="radio" name="tinjau" value="0" required > Tidak
							</div>
						</div>
					</div>
					<hr/>
					<div class="form-group  col-lg-12">
						<hr>
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger" onclick="self.history.back()">Back</button>
					</div>
				</form>
				<?php
				}else{
				?>
				<form method="POST" action="page.php?page=cek_gca&opt=<?=$_GET['opt']?>"  id="formku" name="formku">
					<div class="form-group  col-lg-6">
							<div class="col-lg-12">
								<p align="justify"><b>
								<?php
								
								for($ak=1;$ak<=99;$ak++){
									$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
									if($ak==1){
										$fontColor="blue";
									}else{
										$fontColor="black";
									}
									if($ak!=1){
										echo"-> ";
									}
									echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
									setcookie("expandrow_$ak", $gca['id'], time() + (60 * 60), '/');
									$idParent=$gca['parentId'];
									$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
									if ($idParent==$cek_id['id_tahun'])
									  {
									  break;
									  }
								}
								setcookie("level", $ak, time() + (60 * 60), '/');
								?>
								</b></p>
							</div>
							<div class="col-lg-6">
								<label for="id">ID</label>
								<input type="text" name="id" value="<?=$kd_baru?>" class="form-control" readonly>
								<input type="hidden" name="hasil_akhir" value="<?=$hasil_akhir?>" class="form-control" readonly>
								<input type="hidden" name="cc_id" value="<?=$cc_id?>" class="form-control" readonly>
								<input type="hidden" name="level" value="<?=$lvl?>" class="form-control" readonly>
								<input type="hidden" name="tahun_aktif" value="<?=$tahun_aktif?>" class="form-control" readonly>
							</div>
							<div class="col-lg-6">
								<label for="parentId">Parent ID</label>
								<input type="text" name="parentId" value="<?=$parentId?>" class="form-control required" placeholder="Parent ID" readonly>
								<input type="hidden" name="id_srko" value="<?=$id_srko?>" class="form-control">
							</div>
							<div class="col-lg-6">
								<label for="tanggal">Rentang Tanggal</label>
								<input type="text" id="demo" class="form-control" name="tanggal" value=""  autocomplete="off">
							</div>
							
							<div class="col-lg-12">
								<label for="aktifitas">Aktifitas</label>
								<textarea name="aktifitas" placeholder="Aktifitas" class="form-control required"><?=$aktifitas?></textarea>
							</div>
							
							<div class="col-lg-12">
								<label for="deliverable">Deliverable</label>
								<textarea name="deliverable"  placeholder="Deliverable" class="form-control "><?=$deliverable?></textarea>
							</div>
							
					</div>
					<div class="form-group  col-lg-6">
							<div class="col-lg-12">
							<label for="cc">Cost Center<!--/ Kode Proyek--></label>
									<div class="input-group input-group">
										<input type="text" name="cc" class="form-control required" value="<?=$cc?>" id="cc" placeholder="Kode Proyek / Cost Center" autocomplete="off">
										<input type="hidden" name="uraian" class="form-control " value="<?=$nama_cc?>" id="uraian" placeholder="Kode Proyek / Cost Center"  readonly autocomplete="off">
											<span class="input-group-btn">
											  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="cc()"></i>
											</span>
									</div>
							</div>
							<div class="col-lg-12">
									<input type="hidden" name="pic_asli" value="<?=$pic?>" class="form-control ">
									<label for="nama_pic">Penanggung Jawab</label>
									<select class="multiple-select2 form-control required" multiple="multiple" id="pic" name="pic[]"  autocomplete="off">
                                   <?php
										$qpic = mysql_query("SELECT * FROM m_karyawan WHERE regno='$pic'");
										$epic = mysql_fetch_array($qpic);
										$cekpic = mysql_num_rows($qpic);
										$query3 = mysql_query("SELECT * FROM m_karyawan ");										
										while($r=mysql_fetch_array($query3)){
												echo"<option value='$r[regno]' "; if($r['regno']==$pic){echo"selected";} echo">$r[name]</option>";
										}
									?>
									</select>
							</div>
								
							<div class="col-lg-6">
								<label for="jenis">Jenis GCA</label>
								<select name="jenis" class="form-control required" onchange="showcetak(this.value)">
									<option value="">-Jenis GCA-</option>
									<option value="1" <?php if($jenisGCA==1){echo"selected";}?> >Folder</option>
									<option value="2" <?php if($jenisGCA==2){echo"selected";}?> >Aktifitas</option>
								</select>
							</div>
							<div class="col-lg-6">
								<label for="jenisA">Jenis Aktifitas</label>
								<select name="jenisA" class="form-control required" >
									<option value="">-Jenis Aktifitas-</option>
									<option value="1" <?php if($jenisAktf==1){echo"selected";}?> >Rutin</option>
									<option value="2" <?php if($jenisAktf==2){echo"selected";}?> >Non Rutin</option>
								</select>
							</div>
							<div class="col-lg-6">
								<label for="tinjau">Atur GCA Load</label>
								<div id="tinjau">
								<select name="tinjau" class="form-control" <?=$disabled?> >
									<option value="1">Ya</option>
									<option value="0" selected>Tidak</option>
								</select>
								</div>
							</div>
							<div class="col-lg-6">
								<label for="tgl_isi">Waktu Isi GCA</label>
								<input type="text" name="tgl_isi" value="<?=date("Y-m-d H:i:s")?>" class="form-control required" placeholder="Tanggal Isi GCA" readonly>
							</div>
							<div class="col-lg-12">
								<label for="gca_by">GCA BY</label>
								<input type="text" name="gca_by" value="<?=name($_SESSION['nik'])?>" class="form-control required" placeholder="GCA BY" readonly>
								<input type="hidden" name="nik" value="<?=$_SESSION['nik']?>" class="form-control" placeholder="GCA BY">
							</div>
							
					</div>
					<div class="form-group  col-lg-12">
						<hr>
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger" onclick="self.history.back()">Back</button>
					</div>
				</form>
				<?php
				}
				?>
		</div>
	</div>
<?php
if($_GET['opt']=="edit"){
	if($tgl_mulai=="//"){
		$tgl_mulai		= date("Y-m-d");
	}else{
		$tgl_mulai		= $edit['mulai'];
	}
	if($tgl_akhir=="//"){
		$tgl_akhir		= date("Y-m-d");
	}else{
		$tgl_akhir		= $edit['akhir'];
	}
?>
<script type="text/javascript">
var tgl_mulai = new Date("<?php echo $tgl_mulai; ?>");
var tgl_akhir = new Date("<?php echo $tgl_akhir; ?>");
</script>
<?php
}else{
?>
<script type="text/javascript">
var tgl_mulai = new Date();
var tgl_akhir = new Date();
</script>
<?php	
}
?>
<script type="text/javascript">
$('#demo').daterangepicker({
	"startDate": tgl_mulai,
    "endDate":  tgl_akhir,
    "autoApply": false,
	 locale: {
            format: 'DD/MM/YYYY'
        }
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
});
</script>
        <script src="assets/plugins/select2-master/dist/js/select2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
               
                $("#pic").select2({
                    placeholder: "Penanggung Jawab"
                });
                $("#integrasi").select2({
                    placeholder: "Pilih Integrasi"
                });
            });
        </script>