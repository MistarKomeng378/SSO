<html>
    <head>
        <title>Data Jabatan</title>
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
				<h4>Data Jabatan Proyek</h4>
				<input type="hidden" name="no" id="nomor" value="<?=$_REQUEST['no']?>" />	
				<table id="example1" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th width="5%" >No</th>
							<th >Jabatan Proyek</th>
						</tr>
					</thead>
					<tbody>
					<?php
						include"../config/koneksi.php";
						//$dept = $_GET['cc'];						
						$query = mysql_query("SELECT * FROM tbl_jabatan_proyek");
						$no = 1;
						while($tampil=mysql_fetch_array($query)){
						echo'
							<tr class="odd gradeX" onClick="ada(\''.$tampil['jabatan'].'\')">
								<td>'.$no.'</td>
								<td>'.$tampil['jabatan'].'</td>
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
	var no = <?=$_REQUEST['no']?>;
		function ada(jabatan){
			window.opener.document.getElementById('jabatan'+no). value = jabatan;
			window.close();				
		}
	
</script>