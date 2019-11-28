<html>
    <head>
        <title>Data PIC</title>
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
				<h4>Data PIC</h4>
				<table id="example1" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th >No</th>
							<th >Cost Center</th>
							<th >Uraian</th>
							<th >pilih</th>
						</tr>
					</thead>
					<tbody>
					<?php
						include"../config/koneksi.php";

						$query = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' AND uraian NOT LIKE '%Divisi%' order by id");
						$no = 1;
						while($r=mysql_fetch_array($query)){
						echo'<tr onclick="javascript:pilih(this);">
							<td>'.$no.'</td>
							<td>'.$r['CostCenter'].'</td>
							<td>'.$r['uraian'].'</td>
							<td></td>
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
//        mendapatkan nama pic
        var pic=row.cells[1].innerHTML;
        var uraian=row.cells[2].innerHTML;
//        memasukkan nama pic dalam form
        window.opener.parent.document.getElementById("pic").value = pic;
        window.opener.parent.document.getElementById("uraian").value = uraian;
//        menutup pop up
        window.close();
    }
</script>