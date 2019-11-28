<?php
	session_start();
	include"../config/koneksi.php";
	include"../config/encript.php";
	include"../config/fungsi_indotgl.php";
	
	$id		= mysql_real_escape_string(dc($_GET['id']));
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
	<div class="col-lg-12 ">
		<h4>DETAIL GCA <?=$id?></h4>
		<table class="table" id="example1">
			<thead>
				<tr>				
					<th width="4%">No</th>
					<th width="28%">Aktifitas</th>
					<th width="28%">Hasil Aktifitas</th>
					<th width="5%">CC</th>
					<th width="15%">Tanggal</th>
					<th width="15%">Jam</th>
					<th width="5%">Progress</th>
					<th width="5%">Lampiran</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					$parent = mysql_fetch_array(mysql_query("SELECT parentId,cc_id FROM wbs WHERE id='$id' "));
					$atasan1 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$parent[parentId]' "));
					$atasan2 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$atasan1[parentId]' "));
					$qkkwk = mysql_query("SELECT * FROM pencapaian WHERE jo_gca='$id' AND status='1' ORDER BY id_pencapaian DESC");
					while($r=mysql_fetch_array($qkkwk)){
						if(empty($r['file'])){
							$disabled 	="disabled";
							$btn 		="danger";
						}else{
							$disabled 	="";
							$btn 		="success";
						}
						echo"<tr>
								<td>$i</td>
								<td>$r[aktifitas]</td>
								<td>$r[hasil_akhir]</td>
								<td>$r[cc]</td>
								<td>".tgl_indo($r['tgl_aktifitas'])."<br><span style=\"color:green\" title='Tanggal Update'>$r[tgl_update]</span></td>
								<td>$r[total_jam] Jam $r[total_menit] Menit</td>
								<td>$r[progress] %</td>
								<td>";
								if($_SESSION['nik']==$r['nik']){
									echo"<a target='_blank' href='../page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xm btn-$btn' title='$r[ket]' $disabled><i class='glyphicon glyphicon-download-alt'></i></a>";
								}elseif($_SESSION['cc']==$parent['cc_id'] AND $_SESSION['level']==4){
									echo"<a target='_blank' href='../page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xm btn-$btn' title='$r[ket]' $disabled><i class='glyphicon glyphicon-download-alt'></i></a>";
								}elseif($_SESSION['level']==2 OR $_SESSION['level']==3 OR $_SESSION['level']==1){
									echo"<a target='_blank' href='../page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xm btn-$btn' title='$r[ket]' $disabled><i class='glyphicon glyphicon-download-alt'></i></a>";
								}elseif($_SESSION['level']==5 AND $r['laporan']==$_SESSION['nik']){
									echo"<a target='_blank' href='../page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xm btn-$btn' title='$r[ket]' $disabled><i class='glyphicon glyphicon-download-alt'></i></a>";
								}elseif($_SESSION['level']==5 AND $atasan1['pic']==$_SESSION['nik']){
									echo"<a target='_blank' href='../page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xm btn-$btn' title='$r[ket]' $disabled><i class='glyphicon glyphicon-download-alt'></i></a>";
								}elseif($_SESSION['level']==5 AND $atasan2['pic']==$_SESSION['nik']){
									echo"<a target='_blank' href='../page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xm btn-$btn' title='$r[ket]' $disabled><i class='glyphicon glyphicon-download-alt'></i></a>";
								}else{
									echo"<a href='#' class='btn btn-xm btn-danger' title='' disabled><i class='glyphicon glyphicon-download-alt'></i></a>";
								}
								echo"</td>
							</tr>
						";
					$i++;
					}
				?>					
			</tbody>
		</table> 
		<p>
			<br>
			<br>
			<br>
		</p>	
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
				  "autoWidth": true
				});
            });
        </script>
    </body>
</html>
