<?php
	include"../config/koneksi.php";
	include"../config/fungsi_indotgl.php";
	include"../config/encript.php";
	$nik	= dc($_GET['nik']);
?>
<html>
    <head>
        <title>Data GCA</title>
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
			<h4>Data GCA</h4>
			<a href="job_order.php?nik=<?=ec($nik)?>" class="btn btn-primary"><i class='glyphicon glyphicon-plus'></i> Job Order</a>
			<?php
				if(isset($_GET['full'])){
					echo"<a href='?nik=".ec($nik)."' class='btn btn-primary'><i class='glyphicon glyphicon-search'></i>GCA</a><hr>";
				}else{
					echo"<a href='?nik=".ec($nik)."&full=1' class='btn btn-primary'><i class='glyphicon glyphicon-search'></i> Semua GCA</a><hr>";
				}
			?>
			
				<table id="example1" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th >ID GCA</th>
							<th >Aktifitas</th>
							<th ></th>
							<th >Mulai</th>
							<th >Akhir</th>
							<th >CC</th>
							<th >Deliverable</th>
							<?php
								$todayDate 	= date("Y-m-d");
								$now 		= strtotime(date("Y-m-d"));
								$kemarin 	= date('Y-m-d', strtotime('-5 day', $now));
								$besok 		= date('Y-m-d', strtotime('+5 day', $now));
								$date1 		= date_create($kemarin);
								$arr1 		= explode('-',$kemarin);
								$arr2 		= explode('-',$besok);
								$diff 		= gregoriantojd($arr2[1], $arr2[2], $arr2[0])- gregoriantojd($arr1[1], $arr1[2], $arr1[0]);
								for($k=0;$k<=$diff;$k++){  
								$tgl_kerja = date_format($date1,"Y-m-d");
								$ex		= explode("-",$tgl_kerja);
								$year	= $ex[0]; 
								$month	= $ex[1]; 
								$day	= $ex[2];
								
									if(date("D",mktime (0,0,0,$month,$day,$year)) == "Sun") {
										echo"<td><span style=\"color:red\"><b>$day</b></span></td>";
									}elseif(date("D",mktime (0,0,0,$month,$day,$year)) == "Sat") {
										 echo"<td><span style=\"color:red\"><b>$day</b></span></td>";
									}
									else{
										if($tgl_kerja==$todayDate){
											$fontColor="blue";
										}else{
											$fontColor="black";
										}
										echo"<td><span style=\"color:$fontColor\"><b>$day</b></span></td>";
									}
								date_add($date1, date_interval_create_from_date_string('1 days'));
								
								}
							
							?>
						</tr>
					</thead>
					<tbody>
					<?php
						if(isset($_GET['full'])){
							$query = mysql_query("SELECT DISTINCT
															wbs.aktivitas,
															waktu_kerja2.nik,
															wbs.id,
															wbs.mulai,
															wbs.akhir,
															wbs.hasil_akhir,
															wbs.cc,
															wbs.deliverable
															FROM
															waktu_kerja2
															INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca
															WHERE wbs.pic='$nik' 
															ORDER BY wbs.mulai, wbs.id ");

						}else{
							$query = mysql_query("SELECT DISTINCT
															wbs.aktivitas,
															waktu_kerja2.nik,
															wbs.id,
															wbs.mulai,
															wbs.akhir,
															wbs.hasil_akhir,															
															wbs.cc,
															wbs.deliverable
															FROM
															waktu_kerja2
															INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca
															WHERE wbs.pic='$nik' 
															AND waktu_kerja2.bulan='".date("n")."' 
															AND waktu_kerja2.tahun='".date("Y")."'
															ORDER BY wbs.mulai, wbs.id");
						}
						while($r=mysql_fetch_array($query)){
						echo'<tr onclick="javascript:pilih(this);">
								<td>'.$r['id'].'</td>
								<td>'.$r['aktivitas'].'</td>
								<td>'.$r['hasil_akhir'].'</td>
								<td>'.tgl_indo($r['mulai']).'</td>
								<td>'.tgl_indo($r['akhir']).'</td>
								<td>'.$r['cc'].'</td>
								<td>'.$r['deliverable'].'</td>';
								$todayDate 	= date("Y-m-d");
								// $todayDate 	= "2017-01-16";
								$now 		= strtotime(date("Y-m-d"));
								// $now 		= strtotime(date("2017-01-16"));
								$kemarin 	= date('Y-m-d', strtotime('-5 day', $now));
								$besok 		= date('Y-m-d', strtotime('+5 day', $now));
								$date1 		= date_create($kemarin);
								$arr1 		= explode('-',$kemarin);
								$arr2 		= explode('-',$besok);
								$diff 		= gregoriantojd($arr2[1], $arr2[2], $arr2[0])- gregoriantojd($arr1[1], $arr1[2], $arr1[0]);
								for($k=0;$k<=$diff;$k++){  
								$tgl_kerja = date_format($date1,"Y-m-d");
								$b = date_format($date1,"n");
								$d = date_format($date1,"j");
								$ex		= explode("-",$tgl_kerja);
								$year	= $ex[0]; 
								$month	= $ex[1]; 
								$day	= $ex[2];
								$jam	= mysql_fetch_array(mysql_query("SELECT `$d` FROM waktu_kerja2 WHERE  tahun='$year' AND nik='$nik' AND id_gca='$r[id]'"));
									if(date("D",mktime (0,0,0,$month,$day,$year)) == "Sun") {
										echo"<td><span style=\"color:red\">$jam[$d]</span></td>";
									}elseif(date("D",mktime (0,0,0,$month,$day,$year)) == "Sat") {
										 echo"<td><span style=\"color:red\">$jam[$d]</span></td>";
									}
									else{
										if($tgl_kerja==$todayDate){
											$fontColor="blue";
										}else{
											$fontColor="black";
										}
										echo"<td><span style=\"color:$fontColor\">$jam[$d]</span></td>";
									}
								date_add($date1, date_interval_create_from_date_string('1 days'));
								
								}
						echo'</tr>';
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
        var aktifitas=row.cells[1].innerHTML;
        var cc=row.cells[5].innerHTML;
        var deliverable=row.cells[6].innerHTML;
        var faktor= 'A';
		
        window.opener.parent.document.getElementById("jo_gca").value = jo_gca;
        window.opener.parent.document.getElementById("aktifitas").value = aktifitas;
        window.opener.parent.document.getElementById("deliverable").value = deliverable;
        window.opener.parent.document.getElementById("cc").value = cc;
        window.opener.parent.document.getElementById("faktor").value = faktor;
//        menutup pop up
        window.close();
    }
</script>
