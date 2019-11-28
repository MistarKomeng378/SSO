<?php
// $getBulan	= mysql_real_escape_string($_POST['bulan']);
// $getTahun	= mysql_real_escape_string($_POST['tahun']) ;
// if(isset($_POST['tahun'])){
	// $thn = $getTahun;
// }else{
	// $thn = date("Y");
// }
	// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".date('Y')."'"));
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
		<h1 class="page-header"> Penilaian Sasaran Kerja Kepala Unit
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Penilaian Sasaran Kerja Kepala Unit <?=$getTahun?></h4>
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
			
			if($_SESSION['level']==1){
			echo"
			<div class='col-lg-4'>					
				<form method='POST' action='page/mod_penilaian/aksi_tahun_kepskk.php'>
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
			</div>
			
			<table border='0' width='30%' align='right'>
			<tr >
				<td width='75%' height='50'>
				<form method='GET' action='".$_SERVER['PHP_SELF']."'>
					<input type='hidden' name='page' value='report_skk'>
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
		?>
		<br>
		<br>
		<br>
		<table id="example1" class="table table-bordered table-striped table-hover">
				<thead>
					<th>No.</th>
					<th>NIK</th>
					<th>Nama Karyawan</th>
					<th>Unit</th>
					<th></th>
				</thead>
				<tbody>
					<?php
						//$thnNow = date('Y');						
						$bulan  = date('12');				
											
						$query = mysql_query("SELECT * FROM user where level ='4' order by cc ASC ");						
						$i=1;
						while($r=mysql_fetch_array($query)){
							 $cc= mysql_fetch_array(mysql_query("select * from mskko where CostCenter='".$r['cc']."'"));
							echo"
								<tr>
									<td align='center'>$i</td>
									<td align='center'>$r[nik] $bulan_ss</td>
									<td>".$r['name']."</td>
									<td>$cc[uraian]</td>
									<td align='center' width='30' >
										<div class='stats-link'>
											<a href='#modal-unit'  class='show-unit'  data-id='".ec($r['nik'])."-".ec($r['name'])."-".ec($cc['CostCenter'])."-".ec($getTahun)."-".ec($bulan)."' data-toggle='modal'><span title='Lihat Pencapaian' class='btn-xs btn-primary btn-flat' ><i class='fa fa-search-plus'></i></span>
										</div>
									</td>
								</tr>";
							$i++;
						}
					?>
				</tbody>
				
			</table>
			
		</div>
	</div>

<script>
        $(function(){
            $(document).on('click','.show-unit',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_penilaian/report_kepala_unit_detile.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal  fade" id="modal-unit">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title" align="center"><b>REPORT <br> PENILAIAN SATUAN KERJA KEPALA UNIT</b></h4>
				
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

