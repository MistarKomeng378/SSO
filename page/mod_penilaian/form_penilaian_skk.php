<?php
// $getBulan	= mysql_real_escape_string($_POST['bulan']);
// $getTahun	= mysql_real_escape_string($_POST['tahun']) ;
// if(isset($_POST['tahun'])){
	// $thn = $getTahun;
// }else{
	// $thn = date("Y");
// }

	// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".date('Y')."'"));
	$ay  = date('Y');
	$Thnow = date('Y', strtotime('-1 year', strtotime($ay)));
	$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".$Thnow."'"));
	if($_COOKIE['tahun_srko']==""){
		$getTahun 		= $thn['tahun'];
		$idtahun_srko 	= $thn['id_tahun'];
	}else{
		$getTahun 		= $_COOKIE['tahun_srko'];
		$idtahun_srko	= $_COOKIE['idtahun_srko'];
	}

$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
$getUnit	= dc($_GET['CostCenter']);

if($_GET['opt']=="tambah"){
			$cek		= mysql_query("SELECT max(id_penilaian) as id FROM penilaian_kerja ");
			$qkd 		= mysql_fetch_array($cek);
			@$kd		= $qkd['id'];
			$kd_baru	= (int)$kd + 1;
			$tahun		= date("Y");
			$bobot		= 0;
			
			
		}elseif($_GET['opt']=="edit"){
			$getnik			= dc($_GET['nik']);
			$nik_kar		= mysql_real_escape_string($getnik);
			$edit			= mysql_fetch_array(mysql_query("SELECT * FROM penilaian_kerja WHERE nik='$nik_kar'")); 
			$kd_baru		= $id;
			$kd2			= $edit['id_penilaian'];
			$jabatan		= $edit['jabatan'];
			$pm				= $edit['pm'];
			$divisi			= $edit['divisi'];
			$getCc			= dc($_GET['CostCenter']);
			// $getCc			= $_GET['CostCenter'];
			$rencana_kerja	= $edit['rencana_kerja'];
			$target			= $edit['target'];
			$pencapaian		= $edit['pencapaian'];
			$bobot			= $edit['bobot'];
			$tahun			= $edit['tahun'];
			$satuan			= $edit['satuan'];
			
			if($_SESSION['level']==4){
				$divisi_k = $getCc;
			}else{
				$divisi_k = $getCc;
			}
			$div		  = mysql_fetch_array(mysql_query("select * from mskko where CostCenter='$divisi_k'"));
		 }


?>	
		<h1 class="page-header"> Form Penilaian Kerja Karyawan
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Form Penilaian Kerja Karyawan Tahun <?=$getTahun?></h4>
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
		?>
		
		<?php
			
			// if($getInsert==1){
				// echo"<a href='?page=form_penilaian_karyawan&opt=tambah&nik=".ec($_SESSION['nik'])."' class='btn btn-primary'><i class='fa fa-plus'></i> Input Penilaian</a>";
			// }			
			//echo" <a href='print/print_penilaian_kerja.php?nik=".ec($_SESSION['nik'])."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Cetak</a>";
			
		?>
		<br>
		
		<table width="100%" >
			<tr align="center"> 
				<td><font size="3"><b><u>From Penilaian Sasaran Kerja Karyawan (SKK)</u></b></font></td>
			</tr>
		</table>
		<br>
		<form method="POST" action="page/mod_penilaian/aksi_penilaian_skk.php"  id="formku">
		<table width="50%">
			<tr> 
				<td height="20">NIK/Nama</td>
				<td width="10">:</td>
				<td><b><?=$getnik?> / <?=name($getnik)?></b></td>
				
			</tr>
			<tr> 
				<td height="20">Divisi</td>
				<td>:</td>
				<td><b><?=$div['uraian']?></b></td>
			</tr>
			<tr> 
				<td height="20">Jabatan</td>
				<td>:</td>
				<td><b><?=$jabatan?></b></td>
			</tr>
		</table>
		<br>
		
		<table class="table table-bordered table-striped table-hover">
				<thead>
					<th>No.</th>
					<th>Rencana Kerja</th>
					<th>Penilai</th>
					<th>Target</th>
					<th>Bobot</th>
					<th>Hasil</th>
					<th></th>
				</thead>
				<tbody>
					<?php
						if($_SESSION['level']==5){
							$query = mysql_query("SELECT * FROM penilaian_kerja where nik='".$getnik."' AND pm='".$_SESSION['nik']."' AND tahun='".$getTahun."'");
						}elseif($_SESSION['level']==4){
							$query = mysql_query("SELECT * FROM penilaian_kerja where nik='".$getnik."' AND pm='".$_SESSION['nik']."' AND tahun='".$getTahun."'");
						}else{						
							$query = mysql_query("SELECT * FROM penilaian_kerja where nik='".$getnik."' AND tahun='".$getTahun."'");
						}
						// $query = mysql_query("SELECT * FROM penilaian_kerja where nik='".$getnik."'");
						$i=1;
						while($r=mysql_fetch_array($query)){
							
							$sum_bobot_kar_1		= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot FROM penilaian_kerja where nik='$r[nik]' AND tahun='".$getTahun."'"));	
							$bot_kar_1			= ($r['bobot'] / $sum_bobot_kar_1['sum_bobot'])*75;							
							$jum_bot1[] 		= $bot_kar_1;
							
							// $bot			= ($r['bobot']/100)*75;
							// $jum_bot2[] 	= $bot;	
							$penilai = mysql_fetch_array(mysql_query("select * from user where nik = '$r[pm]'"));
							echo"
									<input type='hidden' name='id_penilaian[]' value='$r[id_penilaian]' size='5'>
									<input type='hidden' name='nik[]' value='$r[nik]' size='5'>
									<input type='hidden' name='penilai[]' value='".$_SESSION['nik']."'>
								<tr>
									<td align='center' width='10'>$i</td>
									<td >
										<textarea  type='text' name='rencana_kerja[]' cols='80' rows='3' id='rencana_kerja' placeholder='rencana_kerja'>$r[rencana_kerja]</textarea> 
									</td>
									<td>$penilai[name]</td>
									<td>
										<input type='text' name='target[]' size='4' value='$r[target]' id='target' placeholder='target'>
										
										<select name='satuan[]'>
											<option value=''>Pilih</option>";
												$qsat = mysql_query("SELECT * FROM satuan order by satuan ASC");
												while($sat=mysql_fetch_array($qsat)){
													echo"<option value='".$sat['satuan']."'"; if($r['satuan']==$sat['satuan']){echo"selected";} echo" >$sat[satuan]</option>";
												}
								echo"			
								</select>
									</td>
									<td align='center'>
										<input type='text' name='bobot[]' size='4' value='$r[bobot]' id='bobot' placeholder='bobot'>
									</td>
									<td >						
										<input type='text' name='hasil[]' value='$r[hasil]' id='hasil' placeholder='Hasil' size='4' maxlength='3'> $r[satuan]
									</td>
									<td >
											<a href='?page=form_penilaian_skk&opt=edit&nik=".ec($r['nik'])."&tahun=".ec($getTahun)."&CostCenter=".ec($getCc)."&delete=".ec($r['id_penilaian'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>
									</td>
								</tr>
							";
							$i++;
						}
						//$jumlah_bobot	 = array_sum($jum_bot1);	
						$jumlah_bobot = mysql_fetch_array(mysql_query("SELECT SUM(bobot) as bobot FROM penilaian_kerja where nik='".$getnik."' AND tahun='$getTahun'"));
						echo"
						<tr>
							<td align='right' colspan='4'><b>Total Bobot</b></td>
							<td align='center'><b>$jumlah_bobot[bobot]</b></td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						</tr>";
					?>	
				</tbody>
				
			</table>
			<div class="form-group  col-lg-12" align="right">
				<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-danger">Reset</button>
			</div>
		</form>
		</div>
	</div>
	
	
