<?php
session_start();
	include"../config/koneksi.php";
	include"../config/encript.php";
	include"../config/fungsi_indotgl.php";
	include"../config/fungsi_rupiah.php";
	include 'pagination1.php';
	
$ex			= explode("-",$_GET['id']);
$id_srko	= mysql_real_escape_string(dc($ex[0]));
$bulan		= mysql_real_escape_string(dc($ex[1]));
$tahun		= mysql_real_escape_string(dc($ex[2]));
$unit		= mysql_real_escape_string(dc($ex[3]));

$srko		= mysql_fetch_array(mysql_query("SELECT aktivitas FROM wbs WHERE id_srko='$id_srko' AND level='4'"));
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
		<h4>Rincian data realisasi SRKO </h4>
		<?=$srko['aktivitas']?>
		<hr>
		<?php
			if($_SESSION['level']==1){
				if(isset($_GET['edit'])){
					
				}else{
					echo"<a href='../lookup/ket_realisasi.php?edit=1&id=".ec($id_srko)."-".ec($bulan)."-".ec($tahun)."-".ec($unit)."' class='btn btn-sm btn-primary'><i class='glyphicon glyphicon-pencil'></i> Edit Progress</a><br>
						<br>";
				}				
			}
		?>
		
		<form method="POST" action="" id="formku" enctype="multipart/form-data">
		<input type='hidden' name='id_srko' value='<?=$id_srko?>'>
		<input type='hidden' name='cc' value='<?=$unit?>'>
		<input type='hidden' name='bulan' value='<?=$bulan?>'>
		<input type='hidden' name='tahun' value='<?=$tahun?>'>
		<table class="table table-bordered table-striped table-hover">					
			<thead>
				<tr>
					<th width="5%">No</th>
					<th>Nama Proyek/ Aktifitas</th>
					<th width="10%">Progress</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result	= mysql_query("SELECT DISTINCT	srkk.id_gca,
															wbs.aktivitas
															FROM
															srkk
															INNER JOIN wbs ON wbs.id = srkk.id_gca 
															WHERE srkk.id_srko='$id_srko' 
															AND srkk.tahun='$tahun' 
															AND srkk.cc='$unit'
															AND wbs.level!='4'
															");
					$sprog 	= mysql_query("SELECT * FROM progress_srko_sub WHERE id_srko='$id_srko' AND cc='$unit' AND bulan='$bulan' AND tahun='$tahun'");
					$hit	= mysql_num_rows($sprog);
					$i=1;
					while($r = mysql_fetch_array($result)) {
						if($hit > 0){
							$prog 	= mysql_query("SELECT progress as pencapaian FROM progress_srko_sub WHERE id_gca='$r[id_gca]' AND id_srko='$id_srko' AND cc='$unit' AND bulan='$bulan' AND tahun='$tahun'");
							$prog2 	= mysql_query("SELECT pencapaian FROM progress_pgca WHERE id='$r[id_gca]' AND bulan='$bulan' AND tahun='$tahun'");
						}else{
							$prog 	= mysql_query("SELECT pencapaian FROM progress_pgca WHERE id='$r[id_gca]' AND bulan='$bulan' AND tahun='$tahun'");
							$prog2 	= mysql_query("SELECT pencapaian FROM progress_pgca WHERE id='$r[id_gca]' AND bulan='$bulan' AND tahun='$tahun'");
						}
						$r2	 	= mysql_fetch_array($prog);
						$r3	 	= mysql_fetch_array($prog2);
						
						echo"<input type='hidden' name='id_gca[]' value='$r[id_gca]' class='control_form'>
							<tr>
								<td>$i</td>
								<td>$r[aktivitas]</td>
								<td>";
								if(isset($_GET['edit'])){
									echo"<input type='text' name='progress_asli[]' value='$r3[pencapaian]' class='control_form' title='Nilai Asli' readonly > ";
									echo"<input type='text' name='progress[]' value='$r2[pencapaian]' class='control_form' title='Nilai Baru'> ";
								}else{
									if($hit > 0){
										echo desimal($r2['pencapaian']);
									}else{
										// echo desimal($r2['pencapaian']);
									}
									
								}
								echo"</td>
							</tr>						
							";
					$i++; 
					}
				?> 
			</tbody>
		</table> 
		<?php
		if(isset($_GET['edit'])){
			echo"<button type='submit' name='simpan' value='simpan' class='btn btn-primary'>Simpan</button> ";
			echo"<a href='../lookup/ket_realisasi.php?id=".ec($id_srko)."-".ec($bulan)."-".ec($tahun)."-".ec($unit)."' class='btn btn-sm btn-danger'><i class='glyphicon glyphicon-remove'></i> Batal</a>";
		}
		?>
		</form>
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
<?php
if(isset($_POST['simpan'])){
	$id_srko		= mysql_real_escape_string($_POST['id_srko']);
	
	$cc				= mysql_real_escape_string($_POST['cc']);
	$bulan			= mysql_real_escape_string($_POST['bulan']);
	$tahun			= mysql_real_escape_string($_POST['tahun']);
	
	
	$jum1= count($_POST['progress']);
	for($i=0; $i<$jum1; $i++){
	$progress		= mysql_real_escape_string($_POST['progress'][$i]);
	$id_gca			= mysql_real_escape_string($_POST['id_gca'][$i]);
	mysql_query("REPLACE INTO progress_srko_sub SET id_gca	='$id_gca',
													id_srko	='$id_srko',
													cc		='$cc',
													bulan	='$bulan',
													tahun	='$tahun',
													progress='$progress'													
													");
	}
	echo"<SCRIPT language='javascript'>document.location='../lookup/ket_realisasi.php?id=".ec($id_srko)."-".ec($bulan)."-".ec($tahun)."-".ec($cc)."'</SCRIPT>";
}
?>
