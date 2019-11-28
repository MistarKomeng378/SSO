<?php
// $getBulan	= mysql_real_escape_string($_POST['bulan']);
// $getTahun	= mysql_real_escape_string($_POST['tahun']) ;
// if(isset($_POST['tahun'])){
	// $thn = $getTahun;
// }else{
	// $thn = date("Y");
// }


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

$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
$getUnit	= dc($_GET['unit']);
?>	
		<h1 class="page-header"> Penilaian Sasaran Kerja Karyawan
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Penilaian Sasaran Kerja Karyawan <?=$getTahun?></h4>
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
			
			// if($_SESSION['level']==1){			
		if($getInsert==1){			
			echo"
			<div class='col-lg-4'>					
				<form method='POST' action='page/mod_penilaian/aksi_tahun_skk.php'>
					<div class='col-lg-9'>
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
			</div>
			
			<div class='col-lg-2'>
				<a href='print/print_penilian_kerja_karyawan_result.php?id=".ec($unit['CostCenter'])."-".ec($getTahun)."' target='_blank' class='btn btn-success'><i class='fa fa-print' ></i> Cetak Excel</a> 		
			</div>
			
			<table border='0' width='30%' align='right'>
			<tr >
				<td width='75%' height='50'>
				<form method='GET' action='".$_SERVER['PHP_SELF']."'>
					<input type='hidden' name='page' value='penilaian_skk'>
					<select name='unit' class='form-control'>
						<option value=''>Pilih Unit</option>
			";
					$qunit = mysql_query("SELECT * FROM mskko WHERE id !='1.6' AND id!='4' order by id");
					while($unit=mysql_fetch_array($qunit)){
						echo"<option value='".ec($unit['CostCenter'])."'"; if(dc($_GET['unit'])==$unit['CostCenter']){echo"selected";} echo" >$unit[uraian]</option>";
					}
			echo"
					</select>
				</td>
				<td align='center'> &nbsp; &nbsp;
					<input type='submit' value='Pilih' class='btn btn-primary'>
				</td>
				</form>
			</tr>
			</table>
			";
		}
		
		else{
			echo"
				<div class='col-lg-4'>					
				<form method='POST' action='page/mod_penilaian/aksi_tahun_skk.php'>
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
		?>
		<br>
		<br>
		<br>
		<table id="example1" class="table table-bordered table-striped table-hover">
				<thead>
					<th>No.</th>
					<th>NIK</th>
					<th>Nama Karyawan</th>
					<th>Divisi</th>
					<th></th>
					<th></th>
				</thead>
				<tbody>
					<?php
						//$thnNow = date('Y');
						//$qpenilai = mysql_fetch_array(mysql_query("select * from penilaian_kerja where pm='".$_SESSION['nik']."'"));
						
						// if($_SESSION['level']==1 OR 2 OR 3){
						if($_SESSION['level']==1){
							if(isset($_GET['unit'])){
								$query = mysql_query("SELECT * FROM user where cc='$getUnit' AND level !='4'");
							}else{						
								$query = mysql_query("SELECT * FROM user where level !='2' AND level !='3' AND level !='4' order by cc ASC ");
							}
							//Kepala Unit
						// }elseif($_SESSION['level']==4){													
							// $query = mysql_query("SELECT DISTINCT nik, divisi FROM penilaian_kerja where pm='".$_SESSION['nik']."'");	
							
							// Karyawan 
						}elseif($_SESSION['level']==4 OR 5){							
							$query = mysql_query("SELECT DISTINCT nik, divisi FROM penilaian_kerja where pm='".$_SESSION['nik']."'");
						
						}else{
							$query = mysql_query("SELECT * FROM user order by cc ASC ");
						}
						$i=1;
						while($r=mysql_fetch_array($query)){
							 $cc= mysql_fetch_array(mysql_query("select * from mskko where CostCenter='".$r['cc']."'"));// admin
							 
							 $cc_kar= mysql_fetch_array(mysql_query("select * from mskko where CostCenter='".$r['divisi']."'"));
							 
							 // $skk= mysql_fetch_array(mysql_query("select * from penilaian_kerja where nik='".$r['nik']."'"));
							 $skk= mysql_fetch_array(mysql_query("select * from penilaian_kerja where nik='".$r['nik']."' AND tahun='".$getTahun."'"));
							 							
							 $sumhasil = mysql_fetch_array(mysql_query("select sum(hasil) as jum_hasil from penilaian_kerja where nik='".$r['nik']."' AND tahun='".$getTahun."'"));
							 
							 
							 if($_SESSION['level']==1){
								$nama		= $r['name'];
								$divisi		= $cc['uraian'];
								$div		= $r['cc'];
							 }elseif($_SESSION['level']==4 OR 5){
								$nama		= name($r['nik']);
								$divisi		= $cc_kar['uraian'];
								$div		= $r['divisi'];
							 }else{
								$nama		= $r['name'];
								$divisi		= $cc['uraian'];
								$div		= $cc['CostCenter']; 
							 }
							echo"
								<tr>
									<td align='center'>$i</td>
									<td align='center'>$r[nik]</td>
									<td>$nama</td>
									<td>$divisi</td>
									<td align='center' width='30' >";
									//=====================
									if($getEdit==1){
										if($skk['target']==''){
											echo"<span title='Belum Input SKK' class='btn-xs btn-danger btn-flat'><i class='fa fa-minus'></i></span> ";
										}else{
											echo"<a href='?page=form_penilaian_skk&opt=edit&nik=".ec($r['nik'])."&tahun=".ec($getTahun)."&CostCenter=".ec($div)."' class='btn btn-xs btn-primary' title='Input Pencapaian'><i class='fa fa-pencil'></i></a> ";
										}
									echo"
									</td> 
									<td align='center' width='30'>";										
										if($sumhasil['jum_hasil']==0){
											echo"<span title='Pencapaian Belum Diinput' class='btn-xs btn-danger btn-flat' ><i class='fa fa-times'></i></span>";	
										}else{
											echo"
											<div class='stats-link'>
												<a href='#modal-mskk'  class='show-mskk'  data-id='".ec($r['nik'])."-".ec($r['name'])."-".ec($div)."-".ec($getTahun)."' data-toggle='modal'><span title='Lihat Hasil' class='btn-xs btn-primary btn-flat' ><i class='fa fa-search-plus'></i></span>
											</div>
											</td>";
										}
										
									}
									//========================
							echo"</tr>
							";
							$i++;
						}
					?>
				</tbody>
				
			</table>
			
		</div>
	</div>

	<script>
        $(function(){
            $(document).on('click','.show-mskk',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_penilaian/report_skk_detile.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal  fade" id="modal-mskk">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title" align="center"><b>REPORT <br>PENILAIAN SASARAN KERJA KARYAWAN</b></h4>
				
				<h5 align="center"><b> Periode: Januari - Desember  Tahun <?=$getTahun; ?></b> </h5>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<!-------------------------------awal dari color box------------------------------------>
<script type="text/javascript" src="assets/plugins/jquerycolorbox/jquery.colorbox.js"></script>
<link  rel="stylesheet" type="text/css" href="assets/plugins/jquerycolorbox/colorbox/colorbox.css" />
<!-------------------------------akhir dari color box------------------------------------>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".popup").colorbox({ 		iframe:true		,width:"50%"		,height:"70%"	});
	});
</SCRIPT>

