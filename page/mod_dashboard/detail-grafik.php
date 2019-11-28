<?php 
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_bulan.php";

$ex			= explode("-",$_POST['id']);  
$id_srko	= mysql_real_escape_string(dc($ex[0]));
$bulan		= mysql_real_escape_string(dc($ex[1]));
$tahun		= mysql_real_escape_string(dc($ex[2]));
$Cc			= mysql_real_escape_string(dc($ex[3]));

// $query 	= mysql_query("SELECT analisa,usulan_solusi FROM kpku_kpi_target WHERE id_kpi='$id_kpi' AND bulan='$bulan' AND tahun='$tahun' ");
// $data	= mysql_fetch_array($query);

$dt_srko = mysql_fetch_array(mysql_query("select * from srko where id_srko='$id_srko'"));
echo"
	
<h5><b><u>SRKO</u></b></h5> <h5>$dt_srko[rencana_kerja] </h5>
<br>
<h5> Analisa Solusi </h5>
";
?>
	<table class="table table-bordered" id="example1">
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="25%">Keterangan Progress</th>
				<th width="30%">Analisa Masalah</th>
				<th width="30%">Rencana Perbaikan</th>	
			</tr>
		</thead>
		<tbody>
			<?php
				$no=1;
				$qket = mysql_query("SELECT * FROM keterangan_progress WHERE id_srko='$id_srko' AND cc='$Cc' AND bulan='$bulan' AND tahun='$tahun'");
				while($r=mysql_fetch_array($qket)){
					echo"
					<tr>
						<td>$no</td>
						<td>$r[keterangan_progress]</td>
						<td>$r[analisa_masalah]</td>
						<td>$r[rencana_perbaikan]</td>
					</tr>
					";
				$no++;
				}
			?>
		</tbody>
	</table>