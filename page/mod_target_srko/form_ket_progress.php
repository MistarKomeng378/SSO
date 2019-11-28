<?php
$ex			= explode("-",$_GET['unit']);
$getID		= mysql_real_escape_string(dc($ex[0]));
$getCC		= mysql_real_escape_string(dc($ex[1]));
$getBulan	= mysql_real_escape_string(dc($ex[2]));
@$getKet	= mysql_real_escape_string(dc($ex[3]));
$getTahun	= mysql_real_escape_string(dc($ex[4]));

$unit 		= mysql_fetch_array(mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$getCC'"));
$srko 		= mysql_fetch_array(mysql_query("SELECT rencana_kerja FROM srko WHERE id_srko='$getID'"));
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script >
			<h1 class="page-header">Form Keterangan Progress
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			        </div>
			        <h4 class="panel-title">Form Keterangan Progress SRKO Bulan <?=bulan($getBulan)?> Tahun <?=$getTahun?></h4>
			    </div>
			    <div class="panel-body">
			<?php
			
			if(isset($_REQUEST['delete'])){
				// mysql_query("DELETE FROM ket_progress_srko WHERE id_ket='$getKet'");
				mysql_query("DELETE FROM keterangan_progress WHERE id_ket='".dc($_GET['delete'])."'");
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
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Gagal, Terjadi Kesalahan.
                    </div>";
			}
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
	
	
	if($_GET['opt']=="hasil"){
			if($_GET['act']=="input"){
				$id_ket = mysql_fetch_array(mysql_query("select MAX(id_ket) as idKet from keterangan_progress ")) or die (mysql_error());
				$kode_lama = substr($id_ket['idKet'],2,6);
				$kode_lama = (int) $kode_lama + 1;
				$kode_baru = date("y").sprintf('%06s',$kode_lama);
				
			}elseif($_GET['act']=="edit"){				
				$hasil 	= mysql_fetch_array(mysql_query("SELECT * FROM keterangan_progress WHERE id_ket='$getKet' AND id_srko='$getID' AND cc='$getCC' AND bulan='$getBulan' AND tahun='$getTahun'"));
				$kode_baru = $hasil['id_ket'];
				
			}
			
		
?>
		<form method="POST" action="page/mod_target_srko/query_ket_progress.php?act=<?=$_GET['act']?>&opt=<?=$_GET['opt']?>" id="formku">
			<input type='hidden' name='id_ket' value='<?=$kode_baru?>' readonly>
			<input type='hidden' name='id_srko' value='<?=$getID?>'>
			<input type='hidden' name='cc' value='<?=$getCC?>'>
			<input type='hidden' name='bulan' value='<?=$getBulan?>'>
			<input type='hidden' name='tahun' value='<?=$getTahun?>'>
			<div class="col-lg-12">
			</div>
			<div class="col-lg-12">
				<label for="editor"><b>Keterangan Progress</b></label>
					<textarea name="keterangan_progress" class="form-control required"><?=$hasil['keterangan_progress']?></textarea>
			</div>
			<hr>
			<div class="form-group  col-lg-12">
			</div>
			<div class="col-lg-12">
				<label for="editor"><b>Analisa Masalah</b></label>
					<textarea name="analisa_masalah" class="form-control required"><?=$hasil['analisa_masalah']?></textarea>
			</div>
			<hr>
			<div class="form-group  col-lg-12">
			</div>
			<div class="col-lg-12">
				<label for="editor"><b>Rencana Perbaikan</b></label>
					<textarea name="rencana_perbaikan" class="form-control required"><?=$hasil['rencana_perbaikan']?></textarea>
			</div>
			<hr>
			<div class="form-group  col-lg-12">
			</div>
			
			<div class="form-group  col-lg-12">
				<?php
				if($_GET['act']=="input"){
					echo'<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Simpan</button>';
				}if($_GET['act']=="edit"){
					echo'<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Simpan</button>
					<a href="" class="btn btn-danger" onClick="history.back()"> Batal</a>';
				}
				?>
			</div>
		</form>
<?php
	}elseif($_GET['opt']=="view"){
		
	$newBulan	= $getBulan-1;
?>
	
	<h5>Form isian keterangan srko : <b><?=$getID?></b>. <?=$srko['rencana_kerja']?></h5><hr>
	<a href="<?php echo"?page=ket_progress&unit=".ec($getID)."-".ec($getCC)."-".ec($getBulan)."-".ec($getKet)."-".ec($getTahun)."&act=input&opt=hasil";?>" class='btn btn-primary'><i class='fa fa-plus'></i> Input Keterangan</a>
	
	
	<?php echo"<a href='lookup/ket_progress2.php?id=".ec($getID)."-".ec($getCC)."-".ec($newBulan)."-".ec($getTahun)."' class='btn btn-success popup'  title='Lihat Keterangan'><i class='fa fa-table'></i> Bulan sebelumnya</a>";?>
	<!--<a href="<?php //echo"page/mod_target_srko/query_ket_progress.php?id=".ec($getID)."-".ec($getCC)."-".ec($getBulan)."-".ec($getTahun)."&opt=recycle";?>" class='btn btn-success'><i class='fa fa-refresh'></i> Input Dari bulan sebelumnya</a>-->
	<hr>
	<table class="table table-bordered" id="example1">
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="25%">Keterangan Progress</th>
				<th width="30%">Analisa Masalah</th>
				<th width="30%">Rencana Perbaikan</th>
				<!--<th width="40%">Resume</th>-->
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$no=1;
				$qket = mysql_query("SELECT * FROM keterangan_progress WHERE id_srko='$getID' AND cc='$getCC' AND bulan='$getBulan' AND tahun='$getTahun'");
				while($r=mysql_fetch_array($qket)){
					echo"
					<tr>
						<td>$no</td>
						<td>$r[keterangan_progress]</td>
						<td>$r[analisa_masalah]</td>
						<td>$r[rencana_perbaikan]</td>
						<td align='center'>
							<a href='?page=ket_progress&unit=".ec($r['id_srko'])."-".ec($getCC)."-".ec($getBulan)."-".ec($r['id_ket'])."-".ec($getTahun)."&act=edit&opt=hasil' class='btn btn-xs btn-success' title='Edit Analisa Masalah' ><i class='fa fa-pencil'></i></a>
						
							<a href='?page=ket_progress&unit=".ec($r['id_ket'])."-".ec($getCC)."-".ec($getBulan)."-".ec($r['id_ket'])."-".ec($getTahun)."&delete=".ec($r['id_ket'])."&opt=view' class='btn btn-xs btn-danger' onClick=\"return confirm('Yakin Hapus Data?')\" title='Delete Keterangan' ><i class='fa fa-trash'></i></a>
							
							<!--<a href='?page=ket_progress&delete=".ec($r['id_ket'])."' class='btn btn-xs btn-danger' title='Delete' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-trash'></i></a>-->
							
						</td>
					</tr>
					";
				$no++;
				}
			?>
		</tbody>
	</table>
<?php	
	}
?>
	</div>
</div>

<!-------------------------------awal dari color box------------------------------------>
<script type="text/javascript" src="assets/plugins/jquerycolorbox/jquery.colorbox.js"></script>
<link  rel="stylesheet" type="text/css" href="assets/plugins/jquerycolorbox/colorbox/colorbox.css" />
<!-------------------------------akhir dari color box------------------------------------>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".popup").colorbox({ 		iframe:true		,width:"80%"		,height:"90%"	});
	});
</SCRIPT>