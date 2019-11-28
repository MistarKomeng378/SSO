<html>
    <head>
        <title>Data CC</title>
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
				<h4>Data Cost Center</h4>
				<?php
					if(isset($_GET['cc'])){
						echo"<a href='cc.php' class='btn btn-primary'><i class='glyphicon glyphicon-search'></i> Cost Center Divisi</a><hr>";
					}else{
						echo"<a href='cc.php?cc=project' class='btn btn-primary'><i class='glyphicon glyphicon-search'></i> Cost Center Project</a><hr>";
					}
				?>
				<table id="example1" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th >No</th>
							<th >Cost Center</th>
							<th >Uraian</th>
						</tr>
					</thead>
					<tbody>
					<?php
						include"../config/koneksi.php";
						
						
						if(isset($_GET['cc'])){
							$mysql_host2 		= "10.0.1.233";
							$mysql_database2 	= "epm";
							$mysql_user2 		= "root123";
							$mysql_password2 	= "sso123";
							@$conn2 = mysql_connect($mysql_host2,$mysql_user2,$mysql_password2)or die("Can not connect to database!");
							@mysql_select_db($mysql_database2,$conn2);
							$query = mysql_query("SELECT cc as CostCenter, uraian FROM pro_kontrak");
						}else{
							$query = mysql_query("SELECT * FROM mskko WHERE id!='' AND id!='1.6' AND id!='2.1' AND id !='4' order by id");
						}
						$no = 1;
						while($r=mysql_fetch_array($query)){
						echo'<tr onclick="javascript:pilih(this);">
							<td>'.$no.'</td>
							<td>'.$r['CostCenter'].'</td>
							<td>'.$r['uraian'].'</td>
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
//        mendapatkan nama cc
        var cc=row.cells[1].innerHTML;
        var uraian=row.cells[2].innerHTML;
//        memasukkan nama cc dalam form
        window.opener.parent.document.getElementById("cc").value = cc;
        window.opener.parent.document.getElementById("uraian").value = uraian;
//        menutup pop up
        window.close();
    }
</script>