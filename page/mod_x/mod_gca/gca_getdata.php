<?php
session_start();
include '../../config/koneksi.php';
include '../../config/encript.php';

header("Content-type:application/json");
$result = array();

if(isset($_GET['th'])){
	if($_GET['th']=="all"){
		$where = "";
	}else{
		$where = "WHERE a.tahun='".mysql_real_escape_string(dc($_GET['th']))."'";
	}
}else{
	$where = "WHERE a.tahun='$_SESSION[tahun]'";
}
$rs = mysql_query("SELECT 	a.id,
							a.parentId,
							a.aktivitas,
							a.mulai,
							a.akhir,
							a.deliverable,
							a.durasi,
							a.hasil_akhir,				
							a.realisasi,
							a.jenisGCA,
							a.icon,
							a.cc,
							a.`prog-b` as pb,
							a.`prog-l` as pl,
							CONCAT(a.pic,'-',m_karyawan.`name`) as picname
							FROM
							wbs a							
							LEFT JOIN m_karyawan ON m_karyawan.regno = a.pic
							$where
							ORDER BY id ASC");
while($row = mysql_fetch_array($rs)){
	array_push($result, $row);
}

echo json_encode($result);

?>
