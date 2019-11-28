<?php
include '../../config/koneksi.php';
include '../../config/encript.php';
include"../../config/fungsi_name.php";
include"../../config/fungsi_timeline.php";

// $id = intval($_REQUEST['id']);
$getId 		= explode("-",$_GET['id']);
$id 		= dc($getId[0]);
$nik 		= dc($getId[1]);
$aktifitas 	= dc($getId[2]);
timeline($nik,"delete","penghapusan GCA dengan ID_GCA $id -> $aktifitas");
// echo"$id";

mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$id'");
mysql_query("DELETE FROM wbs WHERE id='$id'");
$select1 = mysql_query("SELECT id FROM wbs WHERE parentId='$id'");
while($r=mysql_fetch_array($select1)){
	mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$r[id]'");
	mysql_query("DELETE FROM wbs WHERE id='$r[id]'");
	$select2 = mysql_query("SELECT id FROM wbs WHERE parentId='$r[id]'");
	while($r2=mysql_fetch_array($select2)){
		mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$r2[id]'");
		mysql_query("DELETE FROM wbs WHERE id='$r2[id]'");
		$select3 = mysql_query("SELECT id FROM wbs WHERE parentId='$r2[id]'");
		while($r3=mysql_fetch_array($select3)){
			mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$r3[id]'");
			mysql_query("DELETE FROM wbs WHERE id='$r3[id]'");
		}
	}
}

// if ($result){
	header('Location: ../../page.php?page=data_gca&succes3=1');
// } else {
	// header('Location: ../../page.php?page=data_gca&failed=1');
// }
?>