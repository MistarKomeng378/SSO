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
			<h1 class="page-header">From Keterangan Progress
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			        </div>
			        <h4 class="panel-title">From Keterangan Progress SRKO Bulan <?=bulan($getBulan)?> Tahun <?=$getTahun?></h4>
			    </div>
			    <div class="panel-body">
			<?php
			
			if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM ket_progress_srko WHERE id_ket='$getKet'");
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
	
	if($_GET['opt']=="analisa"){
		if($_GET['act']=="edit"){
			$analisa = mysql_fetch_array(mysql_query("SELECT * FROM ket_progress_srko WHERE id_ket='$getKet' AND id_srko='$getID' AND cc='$getCC' AND bulan='$getBulan' AND tahun='$getTahun'"));
			$kode_baru = $analisa['id_ket'];
		}else{
			$id_ket = mysql_fetch_array(mysql_query("select MAX(id_ket) as idKet from ket_progress_srko ")) or die (mysql_error());
			$kode_lama = substr($id_ket['idKet'],2,6);
			$kode_lama = (int) $kode_lama + 1;
			$kode_baru = date("y").sprintf('%06s',$kode_lama);
		}
			
		?>
		<h5>Form isian keterangan srko : <b><?=$getID?></b>. <?=$srko['rencana_kerja']?></h5><hr>
		<form method="POST" action="page/mod_target_srko/query_ket_progress.php?act=<?=$_GET['act']?>&opt=<?=$_GET['opt']?>"  id="formku">
			<input type='hidden' name='id_ket' value='<?=$kode_baru?>' readonly>
			<input type='hidden' name='id_srko' value='<?=$getID?>'>
			<input type='hidden' name='cc' value='<?=$getCC?>'>
			<input type='hidden' name='bulan' value='<?=$getBulan?>'>
			<input type='hidden' name='tahun' value='<?=$getTahun?>'>
			<div class="col-lg-12">
				<label for="ket"><b>KETERANGAN PROGRESS</b></label>
					<textarea name="ket" class="form-control required"><?=$analisa['ket_progress']?></textarea>
					<hr>
			</div>
			
			<div class="col-lg-12">
				<label for="what"><b>WHAT</b>: Apa infomasi / kendala</label>
				<p><i><b><b>Contoh</b></b> : Keterlambatan pembuatan sistem Prosedur WI SPL baru 50% dari seharusnya 65%</i></p>
					<textarea name="what" class="form-control required"><?=$analisa['what']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="who"><b>WHO</b>: Siapa yang terkait dengan informasi/ kendala tersebut</label>
				<p><i><b>Contoh</b> : Tini dan Hedi</i></p>
					<textarea name="who" class="form-control required"><?=$analisa['who']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="when"><b>WHEN</b>: Kapan kejadiannya</label>
				<p><i><b>Contoh</b> : Sejak 7 Januari 2017 s/d 25 Januari 2017</i></p>
					<textarea name="when" class="form-control required"><?=$analisa['when']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="where"><b>WHERE</b>: Area mana yang berdampak? (Area kejadian)</label>
				<p><i><b>Contoh</b> : Semua Unit</i></p>
					<textarea name="where" class="form-control required"><?=$analisa['where']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="why"><b>WHY</b>: Alasan hal tersebut bisa terjadi? / Mengapa hal tersebut terjadi?</label>
				<p><i><b>Contoh</b> : Format Pembuatan WI </i></p>
					<textarea name="why" class="form-control required"><?=$analisa['why']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="how"><b>HOW</b>: Bagaimana cara menghindari dampak agar tidak lebih buruk? Bagaimana menangani permasalahan ini?</label>
				<p><i><b>Contoh</b> : Mengikuti Format Pembuatan WI saat ini</i></p>
					<textarea name="how" class="form-control required"><?=$analisa['how']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="how_much"><b>HOW MUCH/ HOW MANY</b>: Berapa besar kerugian yang terjadi akibat hal ini?</label>
				<p><i><b>Contoh</b> : Waktu pengerjaan WI menjadi bertambah 2 minggu</i></p>
					<textarea name="how_much" class="form-control required"><?=$analisa['how_much']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="time"><b>TIME (Waktu/Kapan)</b>: Kapan anda akan melaporkan. Apakah pada saat briefing, atau ketika sudah mulai bekerja.</label>
				<p><i><b>Contoh</b> : Tanggal 26 Januari 2017 </i></p>
					<textarea name="time" class="form-control required"><?=$analisa['time']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="place"><b>PLACE (Tempat)</b>: Dimana anda akan melaporkan?</label>
				<p><i><b>Contoh</b> : Di Divisi Human Capital</i></p>
					<textarea name="place" class="form-control required"><?=$analisa['place']?></textarea>
			</div>
			<div class="col-lg-12">
				<label for="organization"><b>ORGANIZATION (Kepada Siapa)</b>: Kepada siapa anda melaporkan? Apakah kepada atasan atau teman kerja yang lain?</label>
				<p><i><b>Contoh</b> : Ke kepala Divisi Human Capital </i></p>
					<textarea name="organization" class="form-control required"><?=$analisa['organization']?></textarea>
			</div>
			
			<hr>
			<div class="form-group  col-lg-12">
			</div>
			<div class="form-group  col-lg-12">
				<?php
				if($_GET['act']=="input"){
					echo'<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Lihat Hasil</button>';
				}if($_GET['act']=="edit"){
					echo'<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Simpan</button>
					<a href="" class="btn btn-danger" onClick="history.back()"> Batal</a>';
				}
				?>
				
			</div>
		</form>
<?php
	}elseif($_GET['opt']=="hasil"){
			if($_GET['act']=="input"){
				$hasil 	= mysql_fetch_array(mysql_query("SELECT CONCAT( `what`,'. ', `who`,'. ', `when`,'. ', `where`,'. ', `why`,'. ', `how`,'. ', `how_much`,'. ', `time`,'. ', `place`,'. ', `organization`) as hasil FROM ket_progress_srko WHERE id_ket='$getKet' AND id_srko='$getID' AND cc='$getCC' AND bulan='$getBulan' AND tahun='$getTahun'"));
				$isi	= $hasil['hasil'];
			}elseif($_GET['act']=="edit"){				
				$hasil 	= mysql_fetch_array(mysql_query("SELECT id_ket,hasil_analisa FROM ket_progress_srko WHERE id_ket='$getKet' AND id_srko='$getID' AND cc='$getCC' AND bulan='$getBulan' AND tahun='$getTahun'"));
				if($hasil['hasil_analisa']==""){
					$hasil 	= mysql_fetch_array(mysql_query("SELECT CONCAT( `what`,'. ', `who`,'. ', `when`,'. ', `where`,'. ', `why`,'. ', `how`,'. ', `how_much`,'. ', `time`,'. ', `place`,'. ', `organization`) as hasil FROM ket_progress_srko WHERE id_ket='$getKet' AND id_srko='$getID' AND cc='$getCC' AND bulan='$getBulan' AND tahun='$getTahun'"));
					$isi	= $hasil['hasil'];
				}else{
					$isi	= $hasil['hasil_analisa'];
				}				
			}
			
		
?>
		<form method="POST" action="page/mod_target_srko/query_ket_progress.php?opt=<?=$_GET['opt']?>" id="formku">
			<input type='hidden' name='id_ket' value='<?=$getKet?>' readonly>
			<input type='hidden' name='id_srko' value='<?=$getID?>'>
			<input type='hidden' name='cc' value='<?=$getCC?>'>
			<input type='hidden' name='bulan' value='<?=$getBulan?>'>
			<input type='hidden' name='tahun' value='<?=$getTahun?>'>
			<div class="col-lg-12">
				<p>
				<b>Contoh hasil:</b> <br>
				Terjadi Keterlambatan Pembuatan  sistem Prosedur WI SPL yang baru  50% dari seharusnya 65%. Pembuatan Sistem Prosedur WI SPL dikerjakan oleh Tini dan Hedi. Keterlambatan terjadi sejak tanggal 7 Januari 2017 s/d 25 Januari 2017, karena bingung dengan Format Pembuatan WI yang digunakan. Sehingga hal ini berdampak pada semua unit. keterlambatan ini sudah di laporkan pada tanggal 26 Januari 2017 kepada Kepala Divisi Human Capital di Divisi Human Capital. Akhirnya masalah ini akan diselesaikan dengan mengikuti Format Pembuatan WI saat ini.

				</p>
			</div>
			<div class="col-lg-12">
				<label for="editor"><b>Hasil</b></label>
					<textarea name="editor" class="form-control required"><?=$isi?></textarea>
			</div>
			<hr>
			<div class="form-group  col-lg-12">
			</div>
			<div class="form-group  col-lg-12">
				<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Simpan</button>
				<a href="" class='btn btn-danger' onClick='history.back()' > Batal</a>
			</div>
		</form>
<?php
	}elseif($_GET['opt']=="view"){
		
	$newBulan	= $getBulan-1;
?>
	<h5>Form isian keterangan srko : <b><?=$getID?></b>. <?=$srko['rencana_kerja']?></h5><hr>
	<a href="<?php echo"?page=ket_progress&unit=".ec($getID)."-".ec($getCC)."-".ec($getBulan)."-".ec($getKet)."-".ec($getTahun)."&act=input&opt=analisa";?>" class='btn btn-primary'><i class='fa fa-plus'></i> Input Keterangan</a>
	<?php echo"<a href='lookup/ket_progress2.php?id=".ec($getID)."-".ec($getCC)."-".ec($newBulan)."-".ec($getTahun)."' class='btn btn-success popup'  title='Lihat Keterangan'><i class='fa fa-table'></i> Bulan sebelumnya</a>";?>
	<!--<a href="<?php //echo"page/mod_target_srko/query_ket_progress.php?id=".ec($getID)."-".ec($getCC)."-".ec($getBulan)."-".ec($getTahun)."&opt=recycle";?>" class='btn btn-success'><i class='fa fa-refresh'></i> Input Dari bulan sebelumnya</a>-->
	<hr>
	<table class="table table-bordered" id="example1">
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="40%">Keterangan</th>
				<th width="40%">Resume</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$no=1;
				$qket = mysql_query("SELECT id_ket,id_srko,hasil_analisa,ket_progress FROM ket_progress_srko WHERE id_srko='$getID' AND cc='$getCC' AND bulan='$getBulan' AND tahun='$getTahun'");
				while($r=mysql_fetch_array($qket)){
					$str = substr($r['hasil_analisa'],0,100);
					echo"
					<tr>
						<td>$no</td>
						<td>$r[ket_progress]</td>
						<td>$str...</td>
						<td>
							<a href='?page=ket_progress&unit=".ec($r['id_srko'])."-".ec($getCC)."-".ec($getBulan)."-".ec($r['id_ket'])."-".ec($getTahun)."&act=edit&opt=analisa' class='btn btn-xs btn-success' title='Edit Analisa Masalah' ><i class='fa fa-pencil'></i></a> 
							<a href='?page=ket_progress&unit=".ec($r['id_srko'])."-".ec($getCC)."-".ec($getBulan)."-".ec($r['id_ket'])."-".ec($getTahun)."&act=edit&opt=hasil' class='btn btn-xs btn-success' title='Edit Resume' ><i class='fa fa-pencil'></i></a> 
							<a href='?page=ket_progress&unit=".ec($r['id_srko'])."-".ec($getCC)."-".ec($getBulan)."-".ec($r['id_ket'])."-".ec($getTahun)."&delete=1&opt=view' class='btn btn-xs btn-danger' onClick=\"return confirm('Yakin Hapus Data?')\" title='Delete Keterangan' ><i class='fa fa-trash'></i></a>
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
<script type="text/javascript">
// Replace textarea dengan CKEditor
CKEDITOR.replace( 'editor',
{
filebrowserBrowseUrl : 'kcfinder/browse.php', 
height:"200", width:"100%",
});
</script>
<script type="text/javascript">
// Replace textarea dengan CKEditor
CKEDITOR.replace( 'ket',
{
filebrowserBrowseUrl : 'kcfinder/browse.php', 
height:"200", width:"100%",
});
</script>
<!-------------------------------awal dari color box------------------------------------>
<script type="text/javascript" src="assets/plugins/jquerycolorbox/jquery.colorbox.js"></script>
<link  rel="stylesheet" type="text/css" href="assets/plugins/jquerycolorbox/colorbox/colorbox.css" />
<!-------------------------------akhir dari color box------------------------------------>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".popup").colorbox({ 		iframe:true		,width:"80%"		,height:"90%"	});
	});
</SCRIPT>