<?php
	include"../config/koneksi.php";
	include"../config/fungsi_indotgl.php";
	include"../config/fungsi_bulan.php";
	include"../config/fungsi_rupiah.php";
	include"../config/encript.php";
	$getTahun	= dc($_GET['id']);
?>
<html>
    <head>
        <title>Progress SRKO</title>
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
        <div class="container">
			<div class="box-body table-responsive">
				<h4>Data SRKO Direktur Utama Tahun <?=$getTahun?></h4>
				<table class='table table-bordered'>
					<thead>
						<tr align='center' bgcolor='#b3d9ff'>
							<td><b>ID.</b></td>
							<td><b>Sasaran/Rencana Kerja</b></td>
							<td><b>Bobot</b></td>
							<td><b>Target Tahunan</b></td>
						</tr>								
					</thead>
					<tbody>
					<?php
					$query = mysql_query("SELECT DISTINCT id_srko,rencana_kerja,bobot,target,satuan FROM srko WHERE CostCenter='M1000' AND tahun='$getTahun' order by id_srko");
					while($r=mysql_fetch_array($query)){
						echo"
						<tr onclick='javascript:pilih(this);'>
							<td align='center'>$r[id_srko]</td>
							<td>$r[rencana_kerja]</td>
							<td align='center'>$r[bobot]</td>
							<td>$r[target] $r[satuan]</td>
						</tr>
						";
					}
					?>
					</tbody>
				</table>
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
				  "searching": true,
				  "ordering": true,
				  "info": true,
				  "autoWidth": false
				});
            });
        </script>
    </body>
</html>
<script>
    function pilih(row){
        var id_srko=row.cells[0].innerHTML;
        window.opener.parent.document.getElementById("id_srko").value = id_srko;
        window.close();
    }
</script>