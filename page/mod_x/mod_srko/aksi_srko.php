<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

$id_srko	= mysql_real_escape_string($_POST['id_srko']);
$tahun 		= mysql_real_escape_string($_POST['tahun']);
$unit		= mysql_real_escape_string($_POST['unit']);
$ex			= explode("-",$_POST['unit']);
$mskko		= $ex[0];
$cc			= $ex[1];
$perspektif = mysql_real_escape_string($_POST['perspektif']);
$kpm		= mysql_real_escape_string($_POST['kpm']);
$kpi		= mysql_real_escape_string($_POST['kpi']);
$bobot		= mysql_real_escape_string($_POST['bobot']);
$satuan		= mysql_real_escape_string($_POST['satuan']);
$target		= mysql_real_escape_string($_POST['target']);
@$hasil		= mysql_real_escape_string($_POST['hasil']);
@$rencana	= mysql_real_escape_string($_POST['rencana']);

// echo $cc;
// echo $id_mskko;

if($_GET['opt']=="edit"){
	mysql_query("UPDATE `srko` SET `id_srko`		='$id_srko',
											`id_mskko`		='$mskko',
											`CostCenter`	='$cc',
											`tahun`			='$tahun',
											`perspektif`	='$perspektif',
											`kpm`			='$kpm',
											`id_kpi`		='$kpi',
											`bobot`			='$bobot',
											`satuan`		='$satuan',
											`target`		='$target',
											`rencana_kerja`	='$rencana',
											`hasil_akhir`	='$hasil'
									WHERE `id_srko`			='$id_srko'");
	
	mysql_query("UPDATE wbs SET aktivitas='$rencana',hasil_akhir='$hasil' WHERE id_srko='$id_srko'");
	$getGCA = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id_srko='$id_srko'"));
	$idKPM	= $getGCA['parentId'];
	mysql_query("UPDATE wbs SET aktivitas='$kpm',hasil_akhir='$hasil' WHERE id='$idKPM'");
	
	mysql_query("DELETE FROM pic WHERE id_srk='$id_srko'");
	mysql_query("DELETE FROM integrasi WHERE id_srk='$id_srko'");
	mysql_query("DELETE FROM bobot_pi WHERE id_srk='$id_srko'");
	//////////////////////////////////////////////////////////////////////
	$pic = array();
	foreach ($_POST['pic'] as $pic2) {
		array_push($pic, $pic2);
	}
	$pic2 = serialize($pic);
	mysql_query("INSERT INTO pic (`id_pic`, `id_srk`, `pic`) VALUES ('', '$id_srko', '$pic2')");
	//////////////////////////////////////////////////////////////////////
	$integrasi = array();
	foreach ($_POST['integrasi'] as $integrasi2) {
		array_push($integrasi, $integrasi2);
	}
	$integrasi2 = serialize($integrasi);
	mysql_query("INSERT INTO integrasi (`id_integrasi`, `id_srk`, `integrasi`) VALUES ('', '$id_srko', '$integrasi2')");
	//////////////////////////////////////////////////////////////////////
	// $bobot_thd_pi	= $_POST['bobot_thd_pi'];
	// $bobot_rk		= $_POST['bobot_rk'];
	// mysql_query("INSERT INTO `bobot_pi`(`id_srk`, `bobot_thd_pi`, `bobot_rk`) VALUES ('$id_srko','$bobot_thd_pi','$bobot_rk')");
	//////////////////////////////////////////////////////////////////////
}elseif($_GET['opt']=="tambah"){
		mysql_query("INSERT INTO `srko`	(`id_srko`,`id_mskko`,`CostCenter`,`tahun`,`perspektif`,`kpm`,`id_kpi`,`bobot`,`satuan`,`target`,`rencana_kerja`,`hasil_akhir`)VALUES 
										('$id_srko','$mskko','$cc','$tahun','$perspektif','$kpm','$kpi','$bobot','$satuan','$target','$rencana','$hasil') ");
	
		$queryId	= mysql_query("SELECT id FROM wbs WHERE aktivitas='$kpm' AND cc='$cc'");
		$rowId		= mysql_num_rows($queryId);
		$idMin		= mysql_fetch_array($queryId);
		$cek		= mysql_query("SELECT max(id) as id FROM wbs  WHERE cc='$cc' ORDER by parentId DESC");
		$qkd 		= mysql_fetch_array($cek);
		@$kd		= $qkd['id'];
		$kd_baru	= (int)$kd + 1;
		$idRk		= (int)$kd_baru + 1;
		
		if($rowId==1){
			$idMaster	= $idMin['id'];
				mysql_query("INSERT INTO wbs(`id`, `parentId`, `id_srko`, `aktivitas`, `mulai`, `akhir`, `cc`, `pic`, `deliverable`,
										`bobot`, `kode_kpi`, `jam`, `durasi`, `tgl_isi`, `gca_by`, `tahun`, `hasil_akhir`, `lock`)
						VALUES ('$kd_baru','$idMaster','$id_srko','$rencana','','','$cc','','','','$kpi','','','','','$tahun','$hasil','')");
		}else{
			$idLama		= mysql_fetch_array(mysql_query("SELECT min(id) as id FROM wbs  WHERE cc='$cc'"));
			$idMaster	= $idLama['id'];
			mysql_query("INSERT INTO wbs(`id`, `parentId`, `id_srko`, `aktivitas`, `mulai`, `akhir`, `cc`, `pic`, `deliverable`,
										`bobot`, `kode_kpi`, `jam`, `durasi`, `tgl_isi`, `gca_by`, `tahun`, `hasil_akhir`, `lock`)
						VALUES ('$kd_baru','$idMaster','','$kpm','','','$cc','','','','$kpi','','','','','$tahun','$hasil','')");
			mysql_query("INSERT INTO wbs(`id`, `parentId`, `id_srko`, `aktivitas`, `mulai`, `akhir`, `cc`, `pic`, `deliverable`,
										`bobot`, `kode_kpi`, `jam`, `durasi`, `tgl_isi`, `gca_by`, `tahun`, `hasil_akhir`, `lock`)
						VALUES ('$idRk','$kd_baru','$id_srko','$rencana','','','$cc','','','','$kpi','','','','','$tahun','$hasil','')");
		}
		// echo"$idMaster<br>";
		// echo"$kd_baru<br>";
		// echo"$kd<br>";
		// echo"$idRk<br>";
	////////////////////////////////////////////////////////
	$pic = array();
	foreach ($_POST['pic'] as $pic2) {
		array_push($pic, $pic2);
	}
	$pic2 = serialize($pic);

	mysql_query("INSERT INTO pic (`id_pic`, `id_srk`, `pic`) VALUES ('', '$id_srko', '$pic2')");
	//////////////////////////////////////////////////
	$integrasi = array();
	foreach ($_POST['integrasi'] as $integrasi2) {
		array_push($integrasi, $integrasi2);
	}
	$integrasi2 = serialize($integrasi);
	mysql_query("INSERT INTO integrasi (`id_pic`, `id_srk`, `integrasi`) VALUES ('', '$id_srko', '$integrasi2')");
	//////////////////////////////////////////////////////
	// $bobot_thd_pi	= $_POST['bobot_thd_pi'];
	// $bobot_rk	= $_POST['bobot_rk'];
	// mysql_query("INSERT INTO `bobot_pi`(`id_srk`, `bobot_thd_pi`, `bobot_rk`) VALUES ('$id_srko','$bobot_thd_pi','$bobot_rk')");
	//////////////////////////////////////////////////////
	
}
	
 header('Location: ../../page.php?page=data_srko_full&unit='.ec($cc).'&succes=1');
?>