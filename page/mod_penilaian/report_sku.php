<?php
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_rupiah.php";
include"../../config/encript.php";

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


?>
		<h1 class="page-header"> Report Penilaian Sasaran Kerja Unit (SKU)
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Report Penilaian Sasaran Kerja Unit (SKU) <?=$getTahun?></h4>
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
			
			if($getInsert==1){				
			echo"
				<div class='col-lg-8'>					
				<form method='POST' action='page/mod_penilaian/aksi_tahun_unit.php'>
					<div class='col-lg-3'>
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
			";
			}			
			
		?>
		
		<br>
		<br>
		<br>
		<table id="example1" class="table table-bordered table-striped table-hover">
				<thead>
					<th>No.</th>
					<th>Unit / Divisi</th>
					<th></th>
				</thead>
				<tbody>
					<?php
						// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".date('Y')."'"));
						// if($_COOKIE['tahun_srko']==""){
							// $tahun_srko 	= $thn['tahun'];
							// $idtahun_srko 	= $thn['id_tahun'];
						// }else{
							// $tahun_srko 	= $_COOKIE['tahun_srko'];
							// $idtahun_srko	= $_COOKIE['idtahun_srko'];
						// }
						
						//$tahun_skr	= date('Y');
						$bulan		= date('12');						
						$query = mysql_query("SELECT * FROM mskko WHERE id !='1.6' AND id!='4' order by id");
						
						$i=1;
						while($r=mysql_fetch_array($query)){
							 
							echo"
								<tr>
									<td align='center' width='10'>$i</td>
									<td>$r[uraian]</td>
									<td align='center' width='40' >";
									if($getEdit==1){										
											echo" 
											<div class='stats-link'>
												<a href='#modal-sku'  class='show-sku'  data-id='".ec($r['CostCenter'])."-".ec($r['uraian'])."-".ec($getTahun)."-".ec($bulan)."' data-toggle='modal'><span class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i></span></a>
											</div>
										";
										// }
									}
							echo"	</td>
							</tr>
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
            $(document).on('click','.show-sku',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_penilaian/report_sku_detile.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<?
	$hari		= date('d');
	$bulan_2		= date('m');
	$tahun		= date('Y');
?>
<div class="modal  fade" id="modal-sku">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title" align="center"><b>REPORT <br> PENILAIAN SASARAN KERJA UNIT (SKU)</b></h4>				
				<h5 align="center"><b> Periode: Januari - Desember  Tahun <?=$getTahun ?></b> </h5>
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
