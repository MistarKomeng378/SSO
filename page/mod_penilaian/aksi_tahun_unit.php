<?php
include"../../config/koneksi.php";

$id_tahun = mysql_real_escape_string($_POST['tahun']);
$tahun 	= mysql_fetch_array(mysql_query("SELECT tahun FROM tahun WHERE id_tahun='$id_tahun' "));

setcookie("tahun_srko", $tahun['tahun'], time() + (60 * 60 * 24), '/');
setcookie("idtahun_srko", $id_tahun, time() + (60 * 60 * 24), '/');

 header('Location: ../../page.php?page=report_sku&succes=1');
?>