<?php
	include"../config/koneksi.php";
	include"../config/encript.php";
	include"../config/fungsi_indotgl.php";
	include 'pagination1.php';
	
$ex			= explode("-",$_GET['id']);
$id_srko	= mysql_real_escape_string(dc($ex[0]));
$bulan		= mysql_real_escape_string(dc($ex[1]));
$tahun		= mysql_real_escape_string(dc($ex[2]));
$unit		= mysql_real_escape_string(dc($ex[3]));
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
		<h4>Keterangan Progress, Analisa Masalah dan Rencana Perbaikan </h4>
		<hr>
		<table class="table table-bordered table-striped table-hover">					
			<tbody>
				<tr>
					<td><b>Keterangan Progress</b></td>
					<td><b>Analisa Masalah</b></td>
					<td><b>Recana Perbaikan</b></td>
					
				</tr>
				<?php
					$result	= mysql_query("SELECT * FROM keterangan_progress WHERE id_srko='$id_srko' AND bulan='$bulan' AND tahun='$tahun' AND cc='$unit'");
					
                       while( $r = mysql_fetch_array($result)){
						echo"
							<tr>
								<td>$r[keterangan_progress]</td>
								<td>$r[analisa_masalah]</td>
								<td>$r[rencana_perbaikan]</td>
							</tr>			
							";
					}
				?> 
			</tbody>
		</table> 
		<div>
		<?php 
			if($tcount= 0){
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
