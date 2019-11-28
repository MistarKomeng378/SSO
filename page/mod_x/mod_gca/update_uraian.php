<?php
include"../../config/koneksi.php";

$query = mysql_query("SELECT DISTINCT	pencapaian.cc,
										pencapaian.nik,
										m_karyawan.dept
									FROM
										pencapaian
									LEFT JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
									WHERE pencapaian.nik!='' AND pencapaian.cc!='' AND pencapaian.uraian=''
									ORDER BY pencapaian.nik");

while($r=mysql_fetch_array($query)){
	$cc = mysql_fetch_array(mysql_query("SELECT uraian FROM pro_kontrak WHERE cc='$r[cc]'"));
	// $cc = mysql_fetch_array(mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$r[cc]'"));
	mysql_query("UPDATE pencapaian SET uraian='$cc[uraian]' WHERE cc='$r[cc]' ");
	echo"$r[nik]- $r[cc] = $cc[uraian]<br>";
	
}
	
// header('Location: ../../page.php?page=data_gca&succes=2');
?>