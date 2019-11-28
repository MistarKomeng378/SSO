<?php
$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
$tahun_tsrko = $_COOKIE['tahun_tsrko'];
$idtahun_tsrko = $_COOKIE['idtahun_tsrko'];

$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun ='".date('Y')."'"));

// $ay  = date('Y');
// $Thnow = date('Y', strtotime('-1 year', strtotime($ay)));
// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".$Thnow."'"));
if($_COOKIE['tahun_tsrko']==""){
	$tahun_tsrko 	= $thn['tahun'];
	$idtahun_tsrko 	= $thn['id_tahun'];
}else{
	$tahun_tsrko = $_COOKIE['tahun_tsrko'];
	$idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
}
?>

			<h1 class="page-header">Data Target SRKO
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			        </div>
			        <h4 class="panel-title">Sasaran/Rencana Kerja Organisasi <?=$unit['uraian']?> Tahun <?=$tahun_tsrko?></h4>
			    </div>
			    <div class="panel-body">
			<?php
			
			if(isset($_REQUEST['delete'])){
				// mysql_query("DELETE FROM srko WHERE id_srko='$_GET[id_srko]'");
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
		?>
			<?php
			if($getInsert==1){
				echo"<a href='?page=form_target&unit=$_GET[unit])' class='btn btn-primary'><i class='fa fa-plus'></i> Input Target</a>";
			}
			
			
			//echo"<a href='?page=form_target&unit=$_GET[unit])' class='btn btn-primary'><i class='fa fa-plus'></i> Input Target</a>";
			
			?>
			<hr>
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center'>
						<td  rowspan="2"><b>No.</b></td>
						<td rowspan="2"><b>Sasaran/Rencana Kerja</td>
						<td rowspan="2"><b>Bobot</b></td>
						<td rowspan="2"><b>Target Tahunan</b></td>
						<td colspan="12"><b>Target Bulanan</b></td>
						<td rowspan="2"><b>Detail</b></td>
					</tr>
					<tr align='center'>
						<?php
						for($i=1;$i<=12;$i++){
							echo"<td align='center'><b>$i</b></td>";
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						$data=0;
						$query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$tahun_tsrko' AND parent_srko=''");
						while($r=mysql_fetch_array($query)){
							echo"
							<tr>
								<td align='center'>$no</td>
								<td>$r[rencana_kerja]";
								$h = mysql_query("select * from srko where parent_srko='$r[id_srko]'");
										while($P=mysql_fetch_array($h)){
											echo"
												<br>&nbsp; $P[rencana_kerja]
											";
										}
								echo"
								</td>
								<td align='center'>$r[bobot]</td>
								<td>$r[target] ".$r['satuan']."</td>";
								for($i=1;$i<=12;$i++){
								
									// $target = mysql_fetch_array(mysql_query("select SUM(target) as target from target_srko where parent_srko='$r[id_srko]' AND tahun='$tahun_tsrko' AND bulan='$i'"));
								
									$target = mysql_fetch_array(mysql_query("select * from target_srko_detile where id_srko='$r[id_srko]' AND tahun='$tahun_tsrko' AND bulan='$i'"));
									
									echo"<td width='5%'>&nbsp;&nbsp;".desimal3($target['target'])." </td>";
								}
						echo"
								<td align='center'>									
									<div class='stats-link'>
										<a href='#modal-sku'  class='show-sku'  data-id='".ec($r['CostCenter'])."-".ec($r['id_srko'])."-".ec($tahun_tsrko)."' data-toggle='modal'><span class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i></span></a>
									</div
								</td>
								
						</tr>
							";
						$no++;
						$data++;
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
                $.post('page/mod_target_srko/target_detail.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>

<div class="modal  fade" id="modal-sku">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title" align="center"><b>Target SRKO Detail<br> <?=$unit['uraian']?> <br> Tahun <?=$tahun_tsrko ?></b></h4>
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
