<?php
	include"../config/koneksi.php";
	$ex		= explode("-",$_GET['id']);
	$month	= $ex[1]; 
	$year	= $ex[2]; 
	$day	= date("d");
	$nik	= $ex[0];
	
	$data = mysql_fetch_array(mysql_query("SELECT * FROM m_karyawan WHERE regno='$nik'"));
	echo $month."-".$day."-".$year."-".$nik;
?>

<html>
    <head>
        <title>GCA LOAD</title>
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
			<h4>GCA LOAD DETAIL</h4>
				<table width="100%" border="1" cellpadding="3">
					<thead>
						<tr align="center">
							<th>No.</th>
							<th>Aktivitas</th>
							<?php
								
								$no=1;
								$endDate=date("t",mktime(0,0,0,$month,$day,$year));
										for ($d=1;$d<=$endDate;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
													$fontColor="red"; 
												}
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
													$fontColor="red"; 
													$bgcolor="red"; 
												} 
												echo "<td> <span style=\"color:$fontColor\"><b>$d</b></span></td>"; 
										}
							?>
						</tr>
					</thead>
					<tbody>
					<?php
						
						$query = mysql_query("SELECT DISTINCT 	wbs.id,
																wbs.aktivitas,
																waktu_kerja.tgl_kerja
																FROM
																wbs
																INNER JOIN waktu_kerja ON waktu_kerja.id_gca = wbs.id
																WHERE pic='$nik' 
																AND date_format( waktu_kerja.tgl_kerja, '%c %Y' ) = '$month $year'");
						// $query = mysql_query("select * from wbs WHERE pic='$nik'");

						while($r=mysql_fetch_array($query)){
							echo"
								<tr>
									<td align='center'>$no</td>
									<td>$r[aktivitas]</td>";
										for ($d=1;$d<=$endDate;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
													$fontColor="#FF6347";
													$bgcolor="#FF6347";
													
												}else{
													$bgcolor="#7CFC00";
												}
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
													$fontColor="#FF6347";
													$bgcolor="#FF6347"; 
												}
											
											
											$wk = mysql_fetch_array(mysql_query("SELECT * FROM waktu_kerja WHERE nik='$nik' AND id_gca='$r[id]' AND date_format( tgl_kerja, '%e %c %Y' ) = '$d $month $year'"));
												echo "<td width='20px' align='center' bgcolor='$bgcolor'><span style=\"color:$fontColor\">$wk[jam_kerja]</span></td>"; 
										
										}
							echo"</tr>";
							$no++;
							
						}
						echo"
							<tr>
								<td colspan='2' align='center'><b>Jumlah</b></td>";
								for ($d=1;$d<=$endDate;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
													$fontColor="#FF6347"; 
												}
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
													$fontColor="#FF6347";
												}
											$jml_wk = mysql_fetch_array(mysql_query("SELECT sum(jam_kerja) as jum_jam FROM waktu_kerja WHERE nik='$nik' AND date_format( tgl_kerja, '%e %c %Y' ) = '$d $month $year'"));
												echo "<td width='20px' align='center'><span style=\"color:$fontColor\">$jml_wk[jum_jam]</span></td>"; 
										
										}
							echo"
							</tr>
						";
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
