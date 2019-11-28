<?php
$getBulan	= mysql_real_escape_string($_POST['bulan']);
// $getTahun	= mysql_real_escape_string($_POST['tahun']) ;

	$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where status='1'"));
	// $ay  = date('Y');
	// $Thnow = date('Y', strtotime('-1 year', strtotime($ay)));
	// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".$Thnow."'"));
	if($_COOKIE['tahun_srko']==""){
		$getTahun 		= $thn['tahun'];
		$idtahun_srko 	= $thn['id_tahun'];
	}else{
		$getTahun 		= $_COOKIE['tahun_srko'];
		$idtahun_srko	= $_COOKIE['idtahun_srko'];
	}

?>	
		<h1 class="page-header"> Data Penilaian Sasaran Kerja Karyawan
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title"> Data Penilaian Sasaran Kerja Karyawan Tahun <?=$getTahun?></h4>
			    </div>
			    <div class="panel-body">
			
			<?php
			if(isset($_REQUEST['delete'])){
				$getId	= dc($_GET['delete']);
				mysql_query("DELETE FROM penilaian_kerja WHERE id_penilaian='$getId'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Dihapus.
                    </div>";
			}
			if(isset($_REQUEST['succes'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Disimpan.
                    </div>";
			}
			if(isset($_REQUEST['failed'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-remove'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Failed!</b> Terjadi Kesalahan.
                    </div>";
			}
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
			if(isset($_REQUEST['failed2'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-remove'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Failed!,</b> Bobot anda sudah mencapai 75, anda tidak bisa menambah Sasaran Kerja baru.
                    </div>";
			}
		?>
		
		
		<?php
			
			$jum_bot = mysql_fetch_array(mysql_query("SELECT SUM(bobot) as jum_bot FROM penilaian_kerja where nik = '".$_SESSION['nik']."' AND tahun='$getTahun' "));
			//$getTahun = date('Y');
			if($_SESSION['level']==4){
				$div = mysql_fetch_array(mysql_query("SELECT * FROM mskko where CostCenter = '".$_SESSION['cc']."'"));
				$kar = mysql_fetch_array(mysql_query("select * from m_karyawan where regno = '".$_SESSION['nik']."'")); 
				$jab = mysql_fetch_array(mysql_query("select * from m_jabatan where poscode = '".$kar['poscode']."'"));
				echo "
				<br>
				<table border='0' width='100%'>
						<tr> 
							<td width='10%'>NIK</td>
							<td>:</td>
							<td width='60%'><b>$_SESSION[nik]</b></td>
							<td rowspan='4' width='10%'>
								<form method='POST' action='page/mod_penilaian/aksi_tahun.php'>
									<select name='tahun' class='form-control'>
										<option value=''>-Pilih Tahun-</option>";
										$qtahun = mysql_query("SELECT * FROM tahun");
										while($t=mysql_fetch_array($qtahun)){
											echo"<option value='$t[id_tahun]'"; if($idtahun_srko==$t['id_tahun']){echo"selected";} echo">$t[tahun]</option>";
										}
									echo"</select>
							</td>
							<td rowspan='4' width='10%'>
									<div class='col-lg-2'>
										<button type='submit' name='simpan' value='simpan' class='btn btn-primary'>Submit</button>
									</div>
								</form></td>
							<td rowspan='4' align='right' width='10%'>";								
								echo" <a href='print/print_penilaian_kerja_kepala_unit.php?CostCenter=".ec($_SESSION['cc'])."&tahun=".ec($getTahun)."&nik=".ec($_SESSION['nik'])."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Cetak</a>";
								echo"
								 &nbsp;&nbsp;
							</td>
						</tr>
						<tr> 
							<td>Nama</td>
							<td>:</td>
							<td><b>".name($_SESSION['nik'])."</b></td>
						</tr>
						<tr> 
							<td>Jabatan</td>
							<td>:</td>
							<td><b>$jab[posdesc]</b></td>
						</tr>
						<tr> 
							<td>Divisi / Unit</td>
							<td>:</td>
							<td><b>$div[uraian]</b></td>
						</tr>						
					</table>
					<br>
				";
			}else{
				if($getInsert==1){ 								
					echo"
					<div class='col-lg-8'>
						<a href='?page=form_penilaian_karyawan&opt=tambah&nik=".ec($_SESSION['nik'])."&tahun=".ec($getTahun)."' class='btn btn-primary'><i class='fa fa-plus'></i> Input SKK</a>
					</div>
					
					<div class='col-lg-4'>					
						<form method='POST' action='page/mod_penilaian/aksi_tahun.php'>
							<div class='col-lg-6'>
								<select name='tahun' class='form-control'>
									<option value=''>-Pilih Tahun-</option>";
									$qtahun = mysql_query("SELECT * FROM tahun");
									while($t=mysql_fetch_array($qtahun)){
										echo"<option value='$t[id_tahun]'"; if($idtahun_srko==$t['id_tahun']){echo"selected";} echo">$t[tahun]</option>";
									}
								echo"</select>
							</div>
							<div class='col-lg-2'>
								<button type='submit' name='simpan' value='simpan' class='btn btn-primary'>Submit</button>
							</div>
						</form>
					</div>";
					
				}
			}
		?>
		<hr>
		<br>
		<table class="table table-bordered table-striped table-hover">
				<thead>
					<th>No.</th>
					<th>Sasaran / Rencana Kerja</th>
					<th>Tahun</th>
					<th>Target</th>
					<th>Satuan</th>
					<th>Bobot</th>
					<?
					if($_SESSION['level']==4){
					echo"
						<th>Pencapaian</th>
						<th>Skor</th>
						<th>Nilai</th>
						";
					}else{
					echo"
						<th></th>
						";
					}

					?>
				</thead>
				<tbody>
					<?php
						// $getTahun = date('Y');
						$getBulan = date('m');
						///////////////////////
						if($_SESSION['level']==4){
							$query = mysql_query("SELECT DISTINCT id_srko,rencana_kerja,bobot,target,satuan,hasil_akhir,jenis_pencapaian FROM srko WHERE CostCenter='".$_SESSION['cc']."' AND tahun='$getTahun' order by id_srko");	
						}else{
							$query = mysql_query("SELECT * FROM penilaian_kerja where nik = '".$_SESSION['nik']."' AND tahun='$getTahun' ORDER BY tahun,id_penilaian");
						}
						$i=1;
						while($r=mysql_fetch_array($query)){							
						
							//=============================================================================//
							
							$prog 	= mysql_fetch_array(mysql_query("SELECT pencapaian,realisasi,jenis_resume,jenis_pencapaian FROM progress_srko WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
																					
							if($prog['jenis_resume']==1){  //Bulan Terakhir
								$jr1 		= mysql_fetch_array(mysql_query("SELECT target FROM progress_srko WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr1['target']);
								$tt 		= $jr1['target'];
								$jr11 		= mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr11['realisasi']);
								$rea	 	= $jr11['realisasi'];
								
							}elseif($prog['jenis_resume']==2){  //Komulatif
								$jr2 		= mysql_fetch_array(mysql_query("SELECT SUM(target) as sumtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr2['sumtarget']);
								$tt 		= $jr2['sumtarget'];
								$jr22 		= mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as sumrealisasi FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr22['sumrealisasi']);
								$rea 		= $jr22['sumrealisasi'];
								
							}elseif($prog['jenis_resume']==3){  //Rata-Rata
								$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr3['avgtarget']);
								$tt 		= $jr3['avgtarget'];
								$jr33 		= mysql_fetch_array(mysql_query("SELECT AVG(realisasi) as avgrealisasi FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$realisasi 	= desimal3($jr33['avgrealisasi']);
								$rea 		= $jr33['avgrealisasi'];
								
							}elseif($prog['jenis_resume']==4){  //Prof. Margin
								$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tot_target = desimal3($jr3['avgtarget']);
								$tt 		= $jr3['avgtarget'];								
								$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
								$tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100; 
								$realisasi 	= desimal3($tpm);
								$rea 		= $tpm;
							}
							
							if($prog['jenis_pencapaian']==1){  //Positif
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = ($rea/$tt)*100;
								}	
								
							}elseif($prog['jenis_pencapaian']==2){  //Negatif
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = (($tt - ($rea-$tt)) / $tt) * 100;
								}
								
							}elseif($prog['jenis_pencapaian']==3){  //Prof. Margin
								if($tt==0 AND $rea>0){
									$hasil = 100;
								}elseif($tt>0 AND $rea<=0){
									$hasil = 0;
								}elseif($tt==0 AND $rea<=0){
									$hasil = 100;
								}else{
									$hasil = ($rea/$tt)*100;
								}
							}
							
							if($hasil <= 0){
								$pencapaian=0;
							}elseif($hasil > 0){
								if($hasil>120){
									$pencapaian=120;
								}else{
									$pencapaian=desimal3($hasil);
								}
							}
							
							if($pencapaian<=70){
								$skor = desimal3(($pencapaian/70)*4.5);								
							}elseif($pencapaian<=90){
								$skor = desimal3(4.5+(($pencapaian-70)/20)*2);
							}elseif($pencapaian<=100){
								$skor = desimal3(6.5+(($pencapaian-90)/10)*2);
							}elseif($pencapaian>100){
								$skor = desimal3(8.5+(($pencapaian-100)/20)*1.5);
							}
							
							
							$sum_bobot_kar		= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot FROM penilaian_kerja where nik='$r[nik]' AND tahun='$getTahun'"));
							$sum_bot_kepala	= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot_kep FROM srko where CostCenter='".$_SESSION['cc']."' AND tahun='$getTahun' "));
							
							$bot_kar			= ($r['bobot'] / $sum_bobot_kar['sum_bobot'])*75;
							
							$bot_kep_unit		= ($r['bobot'] / $sum_bot_kepala['sum_bobot_kep'])*75;
							//=====================================//
							
															
							if($_SESSION['level']==4){
								//$satuan = $r['satuan'];
								$bot	= $bot_kep_unit;
								}else{ 
								//$satuan ="%";
								$bot	= $bot_kar; 
								
							}
							
							$jum_bot2[] 		= $bot;	
							$nilai				= desimal3($bot * $skor);
							$jum_nilai[]		= $nilai;	
							echo"
								<tr>
									<td align='center'>$i</td>
									<td >$r[rencana_kerja]</td>
									<td align='center'>$r[tahun]</td>
									<td align='center'>$r[target]</td>
									<td >$r[satuan]</td>
									<td align='center'>".desimal_float($bot)."</td>";
									if($_SESSION['level']==4){										
										echo" 
											<td align='center' width='30'>".desimal_float($pencapaian)."</td>
											<td align='center'>".desimal_float($skor)."</td>
											<td align='center'>".desimal_float($nilai)."</td>";
									}else{
										echo "<td align='center'>";
										if($getEdit==1){
											echo"<a href='?page=form_penilaian_karyawan&opt=edit&id_penilaian=".ec($r['id_penilaian'])."' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-pencil'></i></a> ";
										}if($getDelete==1){
											echo"<a href='?page=data_penilaian_karyawan&delete=".ec($r['id_penilaian'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>";
										}
									echo"</td>";
									}
								echo"
								</tr>
							";
							$i++;
						}
						$jumlah_bobot	 = array_sum($jum_bot2);		
						$nilai_unit 	 = array_sum($jum_nilai);
						
						if($_SESSION['level']==4){
							$jmlh_nilai = $nilai_unit;
						}
						
					?>
						<tr>
							<td align="right" colspan="5"><b>Total Bobot</b></td>
							<td align="center"><b><?=desimal_float($jumlah_bobot)?></b></td>
							<td align="right"></td>
							<?
							if($_SESSION['level']==4){
							echo" 
								<td></td>
								<td align='center' ><b>".desimal_float($jmlh_nilai)."</b></td>
							";							
							}

							?>
						</tr>		
				</tbody>
			</table>			
			<?
			if($_SESSION['level']==4){
			echo" 
			<small> Keterangan : <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<b>Bobot Kepala Unit diambil dari Bobot SRKO yang selanjutnya dikonversikan secara otomatis menjadi 75</b> </small>
				<br>	
				<br>	
				<br>	
				<h6><b>Rumus Perhitungam Skor</b></h6>
				<table border='1' width='100%' align='center')>				
					<tr>
						<td align='center'><b>Dibawah Target &nbsp; (P  0% <u><</u> x <u><</u> 70%)</b></td>
						<td align='center'><b>Mendekati Target &nbsp; (P  70% < x <u><</u> 90%)</b></td>
						<td align='center'><b>Memenuhi Target &nbsp; (P  90% < x <u><</u> 100%)</b></td>
						<td align='center'><b>Melebihi Target &nbsp; (P  100% < x <u><</u> 120%)</b></td>
					</tr>
					<tbody>
						<tr>
							<td align='center'>= (P / 70) x 4,5</td>
							<td align='center'>= 4,5 + (((P - 70)/20) x 2)</td>
							<td align='center'>= 6,5 + (((P - 90)/10) x 2)</td>
							<td align='center'>= 8,5 + (((P - 100)/20) x 1,5)</td>
						</tr>
						
					</tbody>
				</table>
				<small> Keterangan : <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<b>P = Pencapaian / Hasil Kerja (%)</b> </small>
			";
			}else{
				echo"
				<small> Keterangan : <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<b>Bobot yang telah diinput dikonversikan secara otomatis menjadi 75</b> </small>
					";
			}
			?>
			
		</div>
	</div>