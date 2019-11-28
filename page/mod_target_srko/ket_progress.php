<?php 
include"../../config/koneksi.php";
include"../../config/encript.php";

$ex			= explode("-",$_POST['id']);
$id_srko	= mysql_real_escape_string(dc($ex[0]));
$bulan		= mysql_real_escape_string(dc($ex[1]));
$tahun		= mysql_real_escape_string(dc($ex[2]));
$unit		= mysql_real_escape_string(dc($ex[3]));

$query 	= mysql_query("SELECT * FROM ket_progress_srko WHERE id_srko='$id_srko' AND bulan='$bulan' AND tahun='$tahun' AND cc='$unit'");
$data	= mysql_fetch_array($query);
echo"
<label><b>Keterangan Progress</b></label>
<p>$data[ket_progress]</p>
<label><b>Analisa Masalah /Rencana Perbaikan</b></label>
$data[hasil_analisa]
";
?>