<?php
	include"../config/koneksi.php";
	include"../config/fungsi_indotgl.php";
	include"../config/encript.php";
	$nik	= dc($_GET['nik']);
?>
<html>
    <head>
        <title>Job Order</title>
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
			<h4>Job Order</h4>
			<a href="gca.php?nik=<?=ec($nik)?>" class="btn btn-primary"><i class='glyphicon glyphicon-plus'></i> GCA</a><hr>
				<table id="example1" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th colspan="3">ID Job Order</th>
							<th >Pekerjaan</th>
							<th >PIC</th>
							<th >Atasan</th>
							<th >Rencana Selesai</th>
						</tr>
					</thead>
					<tbody>
					<?php

						$query = mysql_query("SELECT 	pic_jo.pic,
														job_order.id_jo,
														job_order.aktifitas,
														job_order.atasan,
														job_order.tembusan,
														job_order.tgl_mulai,
														job_order.jam_mulai,
														job_order.tgl_selesai,
														job_order.jam_selesai,
														job_order.lampiran,
														job_order.ket
														FROM
														job_order
														INNER JOIN pic_jo ON pic_jo.id_jo = job_order.id_jo 
														WHERE pic='$nik'");
														
						while($r=mysql_fetch_array($query)){
						echo'<tr onclick="javascript:pilih(this);">
								<td>'.$r['id_jo'].'</td>
								<td>'.tgl_indo($r['tgl_mulai']).'</td>
								<td>'.$r['jam_mulai'].'</td>
								<td>'.$r['aktifitas'].'</td>
								<td>';
										$pic = mysql_query("SELECT pic_jo.*,m_karyawan.* FROM pic_jo,m_karyawan WHERE pic_jo.pic=m_karyawan.regno AND pic_jo.id_jo='$r[id_jo]'");
										$j=1;
										while($p=mysql_fetch_array($pic)){
											if($j!=1){
												echo ",";
											}
												echo"$p[name]";
											$j++;
										}
								echo'</td>
								<td>'.$r['atasan'].'</td>
								<td>'.tgl_indo($r['tgl_selesai']).'</td>
						</tr>';
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
		
        var jo_gca=row.cells[0].innerHTML;
        var aktifitas=row.cells[3].innerHTML;
        var faktor= 'B';
		
        window.opener.parent.document.getElementById("jo_gca").value = jo_gca;
        window.opener.parent.document.getElementById("aktifitas").value = aktifitas;
        window.opener.parent.document.getElementById("faktor").value = faktor;
//        menutup pop up
        window.close();
    }
</script>
