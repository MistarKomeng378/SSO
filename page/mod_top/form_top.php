
<?php
		// $unit = mysql_fetch_array(mysql_query("SELECT * FROM proyek WHERE id_srko='".mysql_real_escape_string(dc($_GET['id']))."'"));
		// $tahun_srko = $_COOKIE['tahun_srko'];
		if($_GET['opt']=="tambah"){
			$getBulan	= mysql_real_escape_string(dc($_GET['bulan']));
			$getId		= dc($_GET['id_proyek']);
			$cek		= mysql_query("SELECT max(id_pproyek) as id FROM proyek ");
			$qkd 		= mysql_fetch_array($cek);
			@$kd		= $qkd['id'];
			$kd_baru	= (int)$kd + 1;
			$tahun		= date("Y");
			
			
			
		}elseif($_GET['opt']=="edit"){
			$getId		= dc($_GET['id']);		
			$id			= mysql_real_escape_string($getId);
			$getBulan	= mysql_real_escape_string(dc($_GET['bulan']));
			$edit		= mysql_fetch_array(mysql_query("SELECT * FROM proyek WHERE id_proyek='$id'")); 
			
			$kd_baru		= $id;
			$unit			= $edit['cc'];
			$nama_proyek	= $edit['nama_proyek'];
			$tahun			= $edit['tahun'];
			$bulan			= $edit['bulan'];
			//$kode_keuangan	= $edit['kode_keuangan'];
			$kode_proyek	= $edit['kode_proyek'];
			$lokasi_proyek	= $edit['lokasi_proyek'];
			$jarak_proyek	= $edit['jarak_proyek'];
			$resiko_kerja	= $edit['resiko_kerja'];
			
		}
			
		?>
		
	
		<h1 class="page-header">Form Tunjangan Operasional Proyek
			<small><?=$_SESSION['nm_level']?></small>
		</h1>
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				</div>
				<h4 class="panel-title">Tunjangan Operasional Proyek</h4>
			</div>
			<div class="panel-body">
				<form method="POST" action="page/mod_top/aksi_top.php?opt=<?=$_GET['opt']?>"  id="formku">
					<div class="form-group col-lg-12 ">
						<input type="hidden" name="id_proyek" value="<?=$kd_baru?>" class="form-control" placeholder="id_proyek">
						<div class="form-group  col-lg-6">
							<div class='col-lg-6'>
								<label for="bulan">Bulan</label>
								<select name='bulan' class='form-control required'>
									<option value=''>Pilih Bulan</option>
										<?
											for($i=1;$i<=12;$i++){
												echo"<option value='$i'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
											}
											?>
								</select>
							</div>
							<div class="col-lg-6">
								<label for="tahun">Tahun</label>
								<input type="text" name="tahun" value="<?=$tahun?>" class="form-control " placeholder="Tahun" >
							</div>
							
							<div class="col-lg-12">
								<label for="unit">Cost Center</label>
								<select name="unit"  class="form-control" required id="dept" onchange="show(this.value)" >
									<option value="">- Pilih Cost Center -</option>
									<?php
										$query1 = mysql_query("SELECT * FROM mskko where status!='0' AND id!='0'AND id!='2.1'");
										while($r=mysql_fetch_array($query1)){
											if($r['CostCenter']==$unit){
												echo"<option value='$r[CostCenter]' selected>$r[uraian]</option>";
											}else{
												echo"<option value='$r[CostCenter]'>$r[uraian]</option>";
											}
										}
									?>
								</select>
							</div>
							<div class="col-lg-12">
									<label for="Kode">Kode Proyek</label>
									<input type="text" name="kode_proyek" value="<?=$kode_proyek?>" class="form-control" placeholder="Kode Proyek">
							</div>
							<!--
							<div class="col-lg-12">
									<label for="Kode">Kode Keuangan</label>
									<input type="text" name="kode_keuangan" value="<?=$kode_keuangan?>" class="form-control" placeholder="Kode Keuangan">
							</div>
							-->
							<div class="col-lg-12">
									<label for="Lokasi">Lokasi Proyek/ Perusahaan</label>
									<input type="text" name="lokasi_proyek" value="<?=$lokasi_proyek?>" class="form-control" placeholder="Lokasi Proyek">
							</div>
							
							<div class="col-lg-12">
								<label for="rencana">Nama Project</label>
								<textarea name="nama_proyek" class="form-control" rows="3" required><?=$nama_proyek?></textarea>
							</div>
							<div class="col-lg-12">
								<label for="Jarak">Jarak Proyek Dari Kantor (KM)</label>
								<select name="jarak_proyek"  class="form-control" required >
									<option value="">- Pilih Jarak -</option>
									<?php
										$qjarak = mysql_query("SELECT * FROM tbl_jarak");
										while($j=mysql_fetch_array($qjarak)){
											if($j['id']==$jarak_proyek){
												echo"<option value='$j[id]' selected>$j[jarak]</option>";
											}else{
												echo"<option value='$j[id]'>$j[jarak]</option>";
											}
										}
									?>
								</select>
							</div>
							
							<div class="col-lg-12">
								<label for="Resiko">Tingkat Ketidaknyamanan Area Kerja</label>
								<select name="resiko_kerja"  class="form-control" required  >
									<option value="">- Pilih Resiko Area -</option> 
									<?php
										$qresiko = mysql_query("SELECT * FROM tbl_resiko");
										while($rs=mysql_fetch_array($qresiko)){
											if($rs['id']==$resiko_kerja){
												echo"<option value='$rs[id]' selected>$rs[resiko]</option>";
											}else{
												echo"<option value='$rs[id]'>$rs[resiko]</option>";
											}
										}
									?>
								</select>
							</div>
							
						</div>	
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
        