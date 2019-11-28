<?php
$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
// $tahun_tsrko = $_COOKIE['tahun_tsrko'];
// $idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
// if(isset($_GET['tahun'])){
	// $tahun_tsrko = dc($_GET['tahun']);
// }

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

			<h1 class="page-header">Profit Margin <?=$unit['CostCenter']?>
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			        </div>
			        <h4 class="panel-title">Profit Margin <?=$unit['uraian']?> Tahun <?=$tahun_tsrko?></h4>
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
				echo"<a href='?page=form_margin&unit=".ec($unit['CostCenter'])."' class='btn btn-primary'><i class='fa fa-plus'></i> Input Margin</a>";
			}
			
			
			?>
			<hr>
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center' bgcolor="#b3d9ff">
						<td  rowspan="2"><b>No.</b></td>
						<td  rowspan="2"><b>Uraian</b></td>
						<td rowspan="2"><b></b></td>
						<td colspan="12"><b>Target Bulanan</b></td>
						<td rowspan="2"><b>Bulan Berjalan</b></td>
						<!--<td rowspan="2"><b>Detail</b></td>-->
					</tr>
					<tr align='center' bgcolor="#b3d9ff">
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
						$query = mysql_query("SELECT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$tahun_tsrko' AND jenis_pencapaian='3'");
						while($r=mysql_fetch_array($query)){
							echo"
							<tr>
								<td align='center' rowspan='3'>$no</td>
								<td rowspan='3'>&nbsp; $r[rencana_kerja]</td>
								<td bgcolor='#ffcccc'>Pendapatan</td>
								";
								$jrbul = mysql_fetch_array(mysql_query("SELECT COUNT(hpp) as bln FROM profit_margin WHERE tahun='$tahun_tsrko' AND id_srko='$r[id_srko]' AND hpp!=''"));
								
								// ============== Pendapatan ====================//
								for($i=1;$i<=13;$i++){
									$Pend = mysql_fetch_array(mysql_query("select * from profit_margin where id_srko='$r[id_srko]' AND tahun='$tahun_tsrko' AND bulan='$i'"));
									
									if($i==13){
										$jtp = mysql_fetch_array(mysql_query("SELECT SUM(pendapatan) as pendapatan FROM profit_margin WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
										$tot_pend =desimal3($jtp['pendapatan']);
											
										echo"<td bgcolor='#ffcccc' align='center'>".$tot_pend."</td>";
									}else{
										echo"<td width='5%' bgcolor='#ffcccc' align='center'>".desimal3($Pend['pendapatan'])."</td>";
									}
								} 
								
						echo" 
							<!--
								<td align='center' rowspan='3'>									
									<div class='stats-link'>
										<a href='#modal-progress'  class='show-progress'  data-id='".ec($r['CostCenter'])."-".ec($r['id_srko'])."-".ec($tahun_tsrko)."' data-toggle='modal'><span class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i></span></a>
									</div
								</td>
							-->
						
						</tr>";
								
							for($row=1;$row<=2;$row++){
								if($row==1){
									$rowname = "Hpp";
									$rowcolor = "#ffffb3";
								}else{
									$rowname = "Margin";
									$rowcolor = "#b3ffb3";
								}
							//===================perhitungan=====================//
								echo"<tr bgcolor='$rowcolor'>
										<td>$rowname</td>";
									for($cols=1;$cols<=13;$cols++){
										
										$prog = mysql_fetch_array(mysql_query("select * from profit_margin where id_srko='$r[id_srko]' AND tahun='$tahun_tsrko' AND bulan='$cols'"));
										
										if($row==1){   // => HPP
											if($cols>=1 AND $cols<=12){												
												$nilai = $prog['hpp'];
											}else{
												$JumHpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as JumHpp FROM profit_margin WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
												
												$nilai = desimal3($JumHpp['JumHpp']);
											}
										}else{   //=> Margin
											if($cols>=1 AND $cols<=12){
												$nilai = $prog['margin'];
											}else{
												
												$nilai = (($jtp['pendapatan'] - $JumHpp['JumHpp'])/$tot_pend)*100;
											}
											
										}
										echo"<td align='center'>".desimal3($nilai)."</td>";
									}
							}
									echo"
									</tr>";

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
            $(document).on('click','.show-progress',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_target_srko/progres_detail.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>

<div class="modal  fade" id="modal-progress">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title" align="center"><b>Target Progress SRKO Detail <br> <?=$unit['uraian']?> <br> Tahun <?=$tahun_tsrko ?></b></h4>
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
