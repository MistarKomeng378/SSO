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
		<h1 class="page-header"> Report Penilaian Sasaran Kerja Karyawan
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Report Penilaian Sasaran Kerja Karyawan <?=$getTahun?></h4>
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
		
		<br>
		<? 
		// if($_SESSION['level']==1){
		if($getInsert==1){
			echo"
			<div class='col-lg-3'>					
				<form method='POST' action='page/mod_penilaian/aksi_tahun_rskk.php'>
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
			<div class='col-lg-2'>
				<a href='print/print_penilian_kerja_karyawan_excel2.php?id=".ec($unit['CostCenter'])."-".ec($getTahun)."' target='_blank' class='btn btn-success'><i class='fa fa-print' ></i> Cetak Excel</a> 		
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
					<th>Divisi</th>
					<th>Nilai</th>
					<th></th>
				</thead>
				<tbody>
					<?php
					
						
								
						if($_SESSION['level']==1){
							if(isset($_GET['unit'])){
								$query = mysql_query("SELECT * FROM user where cc='$getUnit'");
							}else{						
								$query = mysql_query("SELECT * FROM user order by cc ASC ");
							}
						}elseif($_SESSION['level']==2){
							if(isset($_GET['unit'])){
								$query = mysql_query("SELECT * FROM user where cc='$getUnit'");
							}else{						
								$query = mysql_query("SELECT * FROM user order by cc ASC ");
							}
						}elseif($_SESSION['level']==3){
							if(isset($_GET['unit'])){
								$query = mysql_query("SELECT * FROM user where cc='$getUnit'");
							}else{						
								$query = mysql_query("SELECT * FROM user order by cc ASC ");
							}
						}else{
							$query = mysql_query("SELECT * FROM user where nik='".$_SESSION['nik']."' GROUP by nik");
						}
						
						// if(isset($_GET['unit'])){
						// $query = mysql_query("SELECT * FROM user where cc='$getUnit'");
						// }else{						
						// $query = mysql_query("SELECT * FROM user order by cc ASC ");
						// }
						$i=1;
						
						while($r=mysql_fetch_array($query)){
							 $cc= mysql_fetch_array(mysql_query("select * from mskko where CostCenter='".$r['cc']."'"));
							 $sumhasil = mysql_fetch_array(mysql_query("select sum(hasil) as jum_hasil from penilaian_kerja where nik='".$r['nik']."' AND tahun='$getTahun'"));
							
						//=========================================================================//
							$jumlah_nilai1 = 0;
							$jum_bot1 = 0;
							$sql = mysql_query("SELECT * FROM penilaian_kerja where nik='".$r['nik']."' AND tahun='$getTahun'");
							while($r1=mysql_fetch_array($sql)){
								$pencapaian_2 	= @(($r1['hasil'] / $r1['target'])*100);
								if($pencapaian_2 > 120){
									$pencapaian1 = 120;
								}else{
									$pencapaian1 = $pencapaian_2;
								}
								
								if($r1['satuan']=="Hr" && $r1['hasil']!==null){
									if($r1['hasil'] < $r1['target']){
										$pencapaian1 = 120;
									}else{
										$pencapaian1 = @(($r1['target'] / $r1['hasil'])*100);
									}
								}
								if($r1['hasil']<=70){
									$skor1 =($pencapaian1/70)*4.5;								
								}elseif($r1['hasil']<=90){
									$skor1 = 4.5+(($pencapaian1-70)/20)*2;
								}elseif($r1['hasil']<=100){
									$skor1 =6.5+(($pencapaian1-90)/10)*2;
								}elseif($r1['hasil']>100){
									$skor1 = 8.5+(($pencapaian1-100)/20)*1.5;
								}
								
								$sum_bobot_kar_1		= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot FROM penilaian_kerja where nik='".$r['nik']."' AND tahun='$getTahun'"));	
								$bot_kar_1			= @(($r1['bobot'] / $sum_bobot_kar_1['sum_bobot'])*75);
								$jum_bot1 			+= $bot_kar_1;	// Simbol +(plus) untuk penjumlahan berulang 
								
								$nilai1				= $bot_kar_1 * $skor1;
								$jumlah_nilai1		+= $nilai1;	 
							}
							
							// $jumlah_total_nilai1  = array_sum($jumlah_nilai1);
							$jumlah_total_nilai1 	 = $jumlah_nilai1;
							// $jumlah_bobot	 	 = array_sum($jum_bot1);	
							$jumlah_bobot	 		 = $jum_bot1;	
							
							echo"
								<tr>
									<td align='center'>$i</td>
									<td align='center'>$r[nik]</td>
									<td>".$r['name']."</td>
									<td>$cc[uraian]</td>
									<td>".desimal3($jumlah_total_nilai1)."</td>
									<td align='center' width='40' >";
									if($getEdit==1){ 
										if($sumhasil['jum_hasil']==0){
											echo"<span title='Pencapaian Belum Diinput' class='btn-xs btn-danger btn-flat' ><i class='fa fa-times'></i></span>";
										}else{
											echo" 
											<div class='stats-link'>
												<a href='#modal-mskk' title='Detile'  class='show-mskk'  data-id='".ec($r['nik'])."-".ec($r['name'])."-".ec($cc['CostCenter'])."-".ec($getTahun)."' data-toggle='modal'><span class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i></span></a>
											</div>
										";
										}
									}
							echo"	</td>
							</tr>
							";
							$i++;
						}
						// $jumlah_total_nilai1 = 0;
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
				<h4 class="modal-title" align="center"><b>REPORT <br> PENILAIAN SASARAN KERJA KARYAWAN</b></h4>
				
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
