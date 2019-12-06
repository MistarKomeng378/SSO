<?php

	$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where status='1'"));	
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
			$cek		= mysql_query("SELECT max(id) as id FROM nilai_budaya ");
			$qkd 		= mysql_fetch_array($cek);
			// @$kd		= $qkd['id'];
			// $kd_baru	= (int)$kd + 1;
			$tahun		= date("Y");
			$bobot		= 0;
			
			
		}elseif($_GET['opt']=="edit"){
			$getnik			= dc($_GET['nik']);
			$nik_kar		= mysql_real_escape_string($getnik);
			$edit			= mysql_fetch_array(mysql_query("SELECT * FROM nilai_buaya WHERE nik='$nik_kar'")); 
			$kd_baru		= $id;
			$kd2			= $edit['id'];
			$jabatan		= $edit['jabatan'];
			$pm				= $edit['pm'];
			$divisi			= $edit['divisi'];
			$getCc			= dc($_GET['CostCenter']);
			$bobot			= $edit['bobot'];
			$budaya			= $edit['budaya'];
			$nilai			= $edit['nilai'];
			$tahun			= $edit['tahun'];

			
			if($_SESSION['level']==4){
				$divisi_k = $getCc;
			}else{
				$divisi_k = $getCc;
			}
			$div		  = mysql_fetch_array(mysql_query("select * from mskko where CostCenter='$divisi_k'"));
		 }


?>	
		<h1 class="page-header"> Nilai Budaya Karyawan
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Nilai Budaya Karyawan Tahun <?=$getTahun?></h4>
			    </div>
			    <div class="panel-body">
			
			<?php
			if(isset($_REQUEST['delete'])){
				$getId	= dc($_GET['delete']);
				mysql_query("DELETE FROM nilai_budaya WHERE id='$getId'");
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
				<td><font size="3"><b><u>Nilai Budaya Karyawan</u></b></font></td>
			</tr>
		</table>
		<br>
		<form method="POST" action="page/mod_budaya/aksi_nilaibudaya.php"  id="formku">
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
					
					<th width="10%">No.</th>
					<th colspan='2'>Perilaku</th>
					<th>Bobot</th>
					<th width="15%">Nilai</th>
				</thead>
				<tbody>
				<?php
					$query  = mysql_query("SELECT * FROM budaya");
					$no 	= 1;
					while($bd = mysql_fetch_array($query)){
						$pm = mysql_fetch_array(mysql_query("SELECT pm,jabatan,divisi FROM penilaian_kerja where nik='".$getnik."' AND tahun='".$getTahun."'"));
						$point = mysql_fetch_array(mysql_query("SELECT nilai FROM nilai_budaya where nik='".$getnik."' AND tahun='".$getTahun."'"));

						echo"							
							
							<input type='hidden' name='nik[]' value='$getnik' size='5'>
							<input type='hidden' name='pm[]' value='".$pm['pm']."'>
							<input type='hidden' name='tahun[]' value='".$getTahun."'>
							<input type='hidden' name='jabatan[]' value='".$pm['jabatan']."'>
							<input type='hidden' name='divisi[]' value='".$pm['divisi']."'>
							
							<tr> 
								<td align='center'>$no</td>
								<td><i>$bd[prilaku]</i></td>
								<td>$bd[ket] <input type='hidden' size='5' name='id_budaya[]' value='$bd[id]'> </td>
								<td align='center'>2.5</td>
								<td>
									<input type='text' size='10' name='nilai[]' value='$point[nilai]'>
								</td>
							</tr>
						";
						$no++;
					}

				?>
				</tbody>
				
			</table>
			<div class="form-group  col-lg-12" align="right">
				<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
				<!-- <button type="reset" class="btn btn-danger">Reset</button> -->
			</div>
		</form>
		</div>
	</div>
	
	
