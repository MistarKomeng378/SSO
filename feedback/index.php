<?php
// session_start();
include '../config/koneksi.php';

/////////CLEAN URL///////////////////////////////
$url		= $_SERVER['QUERY_STRING'];
$pecah 		= explode('-',$url);
$page  		= $pecah[0];
@$tahun	   	= $pecah[1];
@$bulan	   	= $pecah[2];
////////////////////////////////////////////////

header("Content-type:application/json");
$result = array();

$rs = mysql_query("SELECT COUNT(DISTINCT tgl_aktifitas) as jml_hari
					FROM
					pencapaian
					WHERE nik='$page' 
					AND DATE_FORMAT(tgl_aktifitas,'%m %Y')='$bulan $tahun'");

while($row = mysql_fetch_array($rs)){
	array_push($result, $row);
}
if(isset($tahun) AND isset($bulan)){
	echo json_encode($result);
}
?>
