<?php
	include"../config/koneksi.php";
	include"../config/encript.php";
	include"../config/fungsi_indotgl.php";
	include"../config/fungsi_bulan.php";
	include 'pagination1.php';
	
$ex			= explode("-",$_GET['id']);
$id_srko	= mysql_real_escape_string(dc($ex[0]));
$unit		= mysql_real_escape_string(dc($ex[1]));
$bulan		= mysql_real_escape_string(dc($ex[2]));
$tahun		= mysql_real_escape_string(dc($ex[3]));

?>

<html>
    <head>
        <title>Keterangan Progress SRKO</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">	
        <link rel="stylesheet" href="css/dataTables.bootstrap.css">
<style>
/*    css disini*/
    *{
        font-family: arial;font-size: small;
    }
    .mytable th{
        background-color: black;color: white;
    }
    .mytable tr:hover{
        background-color: lightblue;cursor: pointer;
    }
    .mytable td, th{
        padding: 5px
    }
</style>
    </head>
    <body>
	<div class="col-lg-12 ">
		<h4>Analisa Masalah Berdasarkan HORENSO Bulan <?=bulan($bulan)?></h4>
		<hr>
		<table class="table table-bordered table-striped table-hover">					
			<tbody>
				<?php
					$result	= mysql_query("SELECT * FROM ket_progress_srko WHERE id_srko='$id_srko' AND bulan='$bulan' AND tahun='$tahun' AND cc='$unit'");
					$rpp = 1;
					$reload = "ket_progress2.php?id=".$_GET['id']."&pagination=true";
					$page = intval(isset($_GET["page"])?$_GET["page"]:0);						
					if($page<=0) $page = 1;  
					$tcount = mysql_num_rows($result);
					@$tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
					$count = 0;
					$i = ($page-1)*$rpp;
					$no_urut = ($page-1)*$rpp;
					while(($count<$rpp) && ($i<$tcount)) {
						
                        mysql_data_seek($result,$i);
                        $r = mysql_fetch_array($result);
						echo"
							<tr>
								<td><a target='_blank' href='../page/mod_target_srko/query_ket_progress.php?id=".ec($r['id_srko'])."-".ec($r['cc'])."-".ec($r['bulan'])."-".ec($r['tahun'])."-".ec($r['id_ket'])."&opt=recycle' class='btn btn-success'><i class='fa fa-refresh'></i> Tambahkan ke bulan ini</a></td>
							</tr>
							<tr>
								<td><b>Keterangan Progress</b></td>
							</tr>
							<tr>
								<td>$r[ket_progress]</td>
							</tr>
							<tr>
								<td><b>Resume /Rencana Perbaikan</b></td>
							</tr>
							<tr>
								<td>$r[hasil_analisa]</td>
							</tr>							
							";
					$i++; 
                    $count++;
					}
				?> 
			</tbody>
		</table> 
		<div>
		<?php 
			if($tcount != 0){
				echo paginate_one($reload, $page, $tpages);
			}else{
				echo"<center><h3>Belum ada analisa dan keterangan yang diinputkan<b3></center>";
			}
		?>
		</div>
	</div>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.js"></script>	
	<script type="text/javascript">
		$(function() {
			$('#example1').dataTable({
			  "paging": true,
			  "lengthChange": true,
			  "searching": false,
			  "ordering": false,
			  "info": true,
			  "autoWidth": true,
			  "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			});
        });
        </script>
    </body>
</html>
