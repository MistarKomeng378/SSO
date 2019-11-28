<html>
    <head>
        <title>Data Project Manager</title>
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
				<h4>Data Karyawan</h4>
				<table id="example1" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th >No</th>
							<th >NIK</th>
							<th >Nama</th>
							<th >Cost Center</th>
						</tr>
					</thead>
					<tbody>
					<?php
						include"../config/koneksi.php";
						session_start();

						$query = mysql_query("SELECT * FROM user where nik !='".$_SESSION['nik']."'  order by cc ASC");
						$no = 1;
						while($r=mysql_fetch_array($query)){
							$unit = mysql_fetch_array(mysql_query("select * from mskko where CostCenter='$r[cc]'"));
						echo'<tr onclick="javascript:pilih(this);">
							<td>'.$no.'</td>
							<td>'.$r['nik'].'</td>
							<td>'.$r['name'].'</td>
							<td>'.$r['cc'].' - '.$unit['uraian'].'</td>
						</tr>
						';
						$no++;
						}
					?> 
					</tbody>
				</table>
</div><!-- /.box-body -->
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
//        mendapatkan nama pm
        var pm=row.cells[1].innerHTML;
        var nama_pm=row.cells[2].innerHTML;
//        memasukkan nama pm dalam form
        window.opener.parent.document.getElementById("pm").value = pm;
        window.opener.parent.document.getElementById("nama_pm").value = nama_pm;
//        menutup pop up
        window.close();
    }
</script>