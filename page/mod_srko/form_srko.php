<link rel="stylesheet" href="assets/plugins/select2-master/dist/css/select2.min.css"/>
<?php
		$unit = mysql_fetch_array(mysql_query("SELECT * FROM srko WHERE id_srko='".mysql_real_escape_string(dc($_GET['id']))."'"));
		// $unit = mysql_fetch_array(mysql_query("SELECT * FROM srko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['cc']))."'"));
		$tahun_srko = $_COOKIE['tahun_srko'];
		if($_GET['opt']=="tambah"){
			$getCc		= dc($_GET['cc']);
			$cek		= mysql_query("SELECT max(id_srko) as id FROM srko ");
			$qkd 		= mysql_fetch_array($cek);
			@$kd		= $qkd['id'];
			$kd_baru	= (int)$kd + 1;
			$tahun		= date("Y");
			$kpm		= "";
			$kpi		= "";
			$bobot		= "";
			$satuan		= "";
			$target		= "";
			$rencana	="";
			
			
		}elseif($_GET['opt']=="edit"){
			$getId		= dc($_GET['id']);
			$getCc		= dc($_GET['cc']);			
			$id			= mysql_real_escape_string($getId);
			$edit		= mysql_fetch_array(mysql_query("SELECT * FROM srko WHERE id_srko='$id'")); 
			$kd_baru	= $id;
			$id_srko	= $edit['id_srko'];
			$cc			= $edit['CostCenter'];
			$id_mskko	= $edit['id_mskko'];
			$tahun		= $edit['tahun'];
			$perspektif	= "";
			$kpm		= $edit['kpm'];
			$kpi		= "";
			$bobot		= $edit['bobot'];
			$satuan		= $edit['satuan'];
			$target		= $edit['target'];
			$rencana	= $edit['rencana_kerja'];
			$hasil		= $edit['hasil_akhir'];
			$srko_by	= $edit['srko_by'];
			
		}
			
		?>
		<script type="text/javascript">
		 function add() {
		  var content = '';
		  content += '<a href="javascript:;" onclick="hapus(this)" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Hapus record</a><hr>';
		  content += '<div class="form-group  col-lg-6"><div class="col-lg-12"><div class="col-lg-12"><label for="rencana">Rencana Kerja</label><textarea name="rencana[]" class="form-control"></textarea></div>';
		  content += '<div class="col-lg-6"><label for="bobot">Bobot THD PI</label><input type="text" name="bobot_kpi[]" value="" class="form-control" placeholder="Bobot THD PI"></div>';
		  content += '<div class="col-lg-6"><label for="bobot">Bobot RK</label><input type="text" name="bobot_kpi[]" value="" class="form-control" placeholder="Bobot RK"></div>';
		  content += '<div class="col-lg-6"><label for="pic">PIC</label><br></div><div class="col-lg-6"><label for="integrasi">Integrasi</label><br></div></div></div>';

		  var x = document.createElement('div');
		  x.innerHTML = content;
		  document.getElementById('record').appendChild(x);
		 }

		 function hapus(element) {
		  var x = document.getElementById('record');
		  x.removeChild(element.parentNode);
		 }
		</script>
		<script type="text/Javascript">
			function pic(){
				var x = window.open("lookup/pic2.php", "pic", 'height=400,width=900');
			}
			function integrasi(){
				var x = window.open("lookup/integrasi.php", "pic", 'height=400,width=600');
			}
		</script>
		
		<script type="text/javascript">
			function show(linkinpark){
				if (linkinpark==""){
					document.getElementById("parent_srko").innerHTML="";
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
						document.getElementById("parent_srko").innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","get_srko.php?dept="+linkinpark,true);
				xmlhttp.send();
			}
		</script>

			<h1 class="page-header">Form SRKO Unit <?=$edit['parent_srko'] ?>
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Form SRKO</h4>
			    </div>
			    <div class="panel-body">
				<form method="POST" action="page/mod_srko/aksi_srko.php?opt=<?=$_GET['opt']?>"  id="formku">
					<div class="form-group col-lg-12 ">
					<div class="form-group  col-lg-6">
						
							<div class="col-lg-6">
								<label for="tahun">Tahun</label>
								<input type="text" name="tahun" value="<?=$tahun?>" class="form-control " placeholder="Tahun" >
								<input type="hidden" name="id_srko" value="<?=$kd_baru?>" class="form-control">
							</div>
							<!--
							<div class="col-lg-6">
								<label for="perspektif">Perspektif</label>
								<select name="perspektif"  class="form-control ">
									<option value="">Pilih Perspektif</option>
									// <?php
										// $query1 = mysql_query("SELECT * FROM m_perspektif");
										// while($r=mysql_fetch_array($query1)){
											// if($r['perspektif']==$edit['perspektif']){
												// echo"<option value='$r[perspektif]' selected>$r[perspektif]</option>";
											// }else{
												// echo"<option value='$r[perspektif]'>$r[perspektif]</option>";
											// }
										// }
									// ?>
								</select>
							</div>-->
							
							<div class="col-lg-12">
								<label for="unit">Unit</label>
								<select name="unit"  class="form-control" required id="dept" onchange="show(this.value)" >
									<option value="">-Pilih Unit-</option>
									<?php
										$query1 = mysql_query("SELECT * FROM mskko where status!='0'");
										while($r=mysql_fetch_array($query1)){
											if($r['id']==$edit['id_mskko']){
												echo"<option value='$r[id]-$r[CostCenter]' selected>$r[uraian]</option>";
											}else{
												echo"<option value='$r[id]-$r[CostCenter]'>$r[uraian]</option>";
											}
										}
									?>
								</select>
							</div>
							
						<!--
						<div class="col-lg-12">
							<label for="kpm">KPM</label>
							<input type="hidden" name="kpm" value="<?=$kpm?>" class="form-control " placeholder="KPM">
						</div>
						-->
						<input type="hidden" name="kpm" value="<?=$kpm?>" class="form-control " placeholder="KPM">
						<div class="col-lg-12">
							<label for="kpi">KPI</label>
							<select name="kpi"  class="form-control" required >
								<?php
									$query2 = mysql_query("SELECT * FROM kpi where tahun='".date('Y')."' order by id_kpi");
									while($r=mysql_fetch_array($query2)){
										if($r['id_kpi']==$edit['id_kpi']){
												echo"<option value='$r[id_kpi]' selected>$r[kpi]</option>";
											}else{
												echo"<option value='$r[id_kpi]'>$r[kpi]</option>";
											}
									}
								?>
							</select>
						</div>
						<div class="col-lg-4">
								<label for="bobot">Bobot</label>
								<input type="text" name="bobot" value="<?=$bobot?>" class="form-control" placeholder="Bobot">
						</div>
						<div class="col-lg-4">
								<label for="satuan">Satuan</label>
								<input type="text" name="satuan" value="<?=$satuan?>" class="form-control" placeholder="Satuan">
						</div>
						<div class="col-lg-4">
							<label for="target">Target</label>
							<input type="text" name="target" value="<?=$target?>" class="form-control" placeholder="Target">
						</div>
						<div class="col-lg-12">
								<label for="gca_by">SRKO BY</label>
								<input type="text" name="nama" value="<?=name($_SESSION['nik'])?>" class="form-control required" placeholder="SRKO BY" readonly>
								<input type="hidden" name="srko_by" value="<?=$_SESSION['nik']?>" class="form-control" placeholder="SRKO BY">
						</div>
					</div>	
					
					<div class="form-group  col-lg-6">
						<div class="col-lg-12">
							<div class="col-lg-12">							
							<label for="Rencana">Rencana Kerja (Parent)</label>
								<select class="form-control" name="parent_srko" id="parent_srko" >
									<option value="">-Pilih SRKO-</option>
									<?php
									if($_GET['opt']=="edit"){
										$jab = mysql_query("SELECT * FROM srko where id_srko='$edit[id_srko]' AND CostCenter='$getCc'");
											while($r=mysql_fetch_array($jab)){
												echo"<option value='$r[parent_srko]' "; if($r['parent_srko']==$edit['parent_srko']){ echo"selected";} echo">"; //$r[parent_srko]</option>";
												$tt = mysql_fetch_array(mysql_query("select * from srko where id_srko='$r[parent_srko]'"));
												echo" $tt[rencana_kerja]</option> ";
											}
									}
									?>
								</select>
							</div>
							<div class="col-lg-12">
								<label for="rencana">Rencana Kerja</label>
								<textarea name="rencana" class="form-control" required><?=$rencana?></textarea>
							</div>
							<div class="col-lg-6">
								<label for="kpi">Rumus Pencapaian (Positif/Negatif)</label>
								<select name="jenis_pencapaian"  class="form-control " required>							
									<option value="">-Pilih-</option>
									<option value="1" <?if($edit['jenis_pencapaian']==1){echo"selected";}?>>Positif</option>
									<option value="2" <?if($edit['jenis_pencapaian']==2){echo"selected";}?>>Negatif</option>
									<option value="3" <?if($edit['jenis_pencapaian']==3){echo"selected";}?>>Prof. Margin</option>
								</select>
							</div>
						
							<!--<div class="col-lg-4">
								<label for="bobot">Bobot THD PI</label>
								<input type="text" name="bobot_thd_pi" value="" class="form-control" placeholder="Bobot THD PI">
							</div>
							<div class="col-lg-4">
								<label for="bobot">Bobot RK</label>
								<input type="text" name="bobot_rk" value="" class="form-control" placeholder="Bobot RK">
							</div>-->
							<div class="col-lg-8">
								<label for="hasil">Hasil Akhir</label>
								<select type="text" name="hasil" class="form-control" required>
									<!--<option value="">-Pilih -</option>-->
									<option value="H"  <?php if($hasil=="H"){echo"selected";} ?>>Hasil</option>
									<option value="P" <?php if($hasil=="P"){echo"selected";} ?> >Proses</option>
									
								</select>
							</div>
							<div class="col-lg-12">
								<label for="pic">PIC</label>
								<select class="multiple-select2 form-control " multiple="multiple" id="pic" name="pic[]" required>
                                   <?php
										///////////////// JIKA TAMBAH SRKO TANPA PILIH UNIT ////////////////////////////////////  
									if($getCc=="M1000" OR $getCc=="M1300" OR $getCc==""){
										$qpic = mysql_query("SELECT * FROM pic WHERE id_srk='".dc($_GET['id'])."'");
										$epic = mysql_fetch_array($qpic);
										$cekpic = mysql_num_rows($qpic);
										$query3 = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' AND id!='1.5'  order by id");										
										// $query3 = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' AND uraian NOT LIKE '%Divisi%' order by id");										
										while($r=mysql_fetch_array($query3)){
											if($_GET['opt']=="edit"){
												if($cekpic <= 0){
													echo"<option value='$r[uraian]'>$r[uraian]</option>";
												}else{
												?>
													<option value="<?php echo $r['uraian'] ?>" <?php echo in_array($r['uraian'], unserialize($epic['pic'])) ? 'selected="selected"' : '' ?>><?php echo $r['uraian'] ?></option>
												<?php
												}
											}else{
												echo"<option value='$r[uraian]'>$r[uraian]</option>";
											}
										}
										/////////////////////////// JIKA TAMBAH SRKO DENGAN PILIH UNIT///////////////////////
									// }if($getCc=="KB" OR $getCc=="KH" OR $getCc=="KF" OR $getCc=="KD" OR $getCc=="KJ"){
									}if($getCc!=="M1000" OR $getCc!=="M1300"){
										$qpic = mysql_query("SELECT * FROM pic WHERE id_srk='".dc($_GET['id'])."'");
										$epic = mysql_fetch_array($qpic);
										$cekpic = mysql_num_rows($qpic);
										//$query3 = mysql_query("SELECT * FROM group_sbu");
										$query3 = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' AND id!='1.5' order by id");										
										// $query3 = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' AND uraian NOT LIKE '%Divisi%' order by id");										
										while($r=mysql_fetch_array($query3)){
											if($_GET['opt']=="edit"){
												if($cekpic <= 0){
													echo"<option value='$r[uraian]'>$r[uraian]</option>";
												}else{
												?>
													<option value="<?php echo $r['uraian'] ?>" <?php echo in_array($r['uraian'], unserialize($epic['pic'])) ? 'selected="selected"' : '' ?>><?php echo $r['uraian'] ?></option>
												<?php
												}
											}else{
												echo"<option value='$r[uraian]'>$r[uraian]</option>";
											}
										}
										
										//////////////////////// KETIKA EDIT  ///////////////////////////		
									}else{
										$qpic = mysql_query("SELECT * FROM integrasi WHERE id_srk='".dc($_GET['id'])."'");
										$epic = mysql_fetch_array($qpic);
										$cekpic = mysql_num_rows($qpic);
										// $query3 = mysql_query("SELECT * FROM m_karyawan WHERE dept='$getCc'");
										$query3 = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' AND id!='1.5' order by id");
																						
										while($r=mysql_fetch_array($query3)){
											if($_GET['opt']=="edit"){
												if($cekpic <= 0){													
													echo"<option value='$r[name]'>$r[name]</option>";
												}else{
												?>
													<!--<option value="<?php echo $r['name'] ?>" <?php echo in_array($r['name'], unserialize($epic['pic'])) ? 'selected="selected"' : '' ?>><?php echo $r['name'] ?></option>-->
													<option value="<?php echo $r['uraian'] ?>" <?php echo in_array($r['uraian'], unserialize($epic['pic'])) ? 'selected="selected"' : '' ?>><?php echo $r['uraian'] ?></option>
												<?php
												}
											}else{
												echo"<option value='$r[name]'>$r[name]</option>";
											}
										}
									}
									?>
                                </select>
								<!--<div class="input-group input-group">
									<input type="hidden" name="pic" class="form-control" value="" id="pic" >
									<input type="text" name="uraian" class="form-control" value="" id="uraian" readonly>
										<span class="input-group-btn">
										  <i class="glyphicon glyphicon-search btn btn-primary btn-flat edit-record" onclick="pic()"></i>
										</span>
								</div>-->
							</div>
							<div class="col-lg-12">
								<label for="integrasi">Integrasi</label><br>
								<select class="multiple-select2 form-control " multiple="multiple" id="integrasi" name="integrasi[]" required>
                                   <?php
										$qin = mysql_query("SELECT * FROM integrasi WHERE id_srk='".dc($_GET['id'])."'");
										$ein = mysql_fetch_array($qin);
										$cekin = mysql_num_rows($qin);
										$query4 = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' order by id");
										while($r=mysql_fetch_array($query4)){
											if($_GET['opt']=="edit"){
												if($cekin <= 0){
													echo"<option value='$r[uraian]'>$r[uraian]</option>";
												}else{
											?>
												<option value="<?php echo $r['uraian'] ?>" <?php echo in_array($r['uraian'], unserialize($ein['integrasi'])) ? 'selected="selected"' : '' ?>><?php echo $r['uraian'] ?></option>
											<?php
												}
											}else{
												echo"<option value='$r[uraian]'>$r[uraian]</option>";
											}
										}
									?>
                                </select>
								<!--<div class="input-group input-group">
									<input type="hidden" name="integrasi" class="form-control" value="" id="integrasi">
									<input type="text" name="uraian_2" class="form-control" value="" id="uraian_2" readonly>
										<span class="input-group-btn">
										   <i class="glyphicon glyphicon-search btn btn-primary btn-flat" onclick="integrasi()"> </i>
										</span>
								</div>-->
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
        <script src="assets/plugins/select2-master/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
               
                $("#pic").select2({
                    placeholder: "Pilih PIC"
                });
                $("#integrasi").select2({
                    placeholder: "Pilih Integrasi"
                });
            });
        </script>