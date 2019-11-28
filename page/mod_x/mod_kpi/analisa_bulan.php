<?php 
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_bulan.php";

$ex			= explode("-",$_POST['id']);
$id_kpi		= mysql_real_escape_string(dc($ex[0]));
$bulan		= mysql_real_escape_string(dc($ex[1]));
$tahun		= mysql_real_escape_string(dc($ex[2]));

$query 	= mysql_query("SELECT analisa,usulan_solusi FROM kpku_kpi_target WHERE id_kpi='$id_kpi' AND bulan='$bulan' AND tahun='$tahun' ");
$data	= mysql_fetch_array($query);
echo"
<h4><b>ANALISA ".strtoupper(bulan($bulan))." $tahun</b></h4>
<p>$data[analisa]</p>
<hr>
<h4><b>USULAN SOLUSI</b></h4>
<p>$data[usulan_solusi]</p>
";
?>