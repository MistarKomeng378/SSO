<?php
include"../../config/koneksi.php";

$id				= mysql_real_escape_string($_POST['id']);
$aktifitas		= mysql_real_escape_string($_POST['aktifitas']);
$atasan			= mysql_real_escape_string($_POST['atasan']);
$ex				= explode("/",$_POST['tgl_mulai']);
$tgl_mulai		= $ex[2]."-".$ex[1]."-".$ex[0];
$ex2			= explode("/",$_POST['tgl_selesai']);
$tgl_selesai	= $ex2[2]."-".$ex2[1]."-".$ex2[0];
$jam_mulai		= mysql_real_escape_string($_POST['jam_mulai']);
$jam_selesai	= mysql_real_escape_string($_POST['jam_selesai']);
$ket			= mysql_real_escape_string($_POST['ket']);

$fileName = $_FILES['lampiran']['name'];     
$tmpName  = $_FILES['lampiran']['tmp_name']; 
$fileSize = $_FILES['lampiran']['size'];
$fileType = $_FILES['lampiran']['type'];
$folder		= "../../upload/$fileName";

if($_GET['opt']=="edit"){
	$query = mysql_query("UPDATE `job_order`	SET 	`id_jo`				='$id' ,
														`aktifitas`			='$aktifitas' ,
														`atasan`			='$atasan' ,
														`tgl_mulai`			='$tgl_mulai' ,
														`tgl_selesai`		='$tgl_selesai' ,
														`jam_mulai`			='$jam_mulai' ,
														`jam_selesai`		='$jam_selesai' ,
														`lampiran`			='$fileName' ,
														`ket`				='$ket'
												WHERE 	`id_jo`				='$id'");
	//////////////////////////////////////////////////////////////////////
	mysql_query("DELETE FROM pic_jo WHERE id_jo='$id'");
	$jml = count($_POST['pic']);
	for($i=0; $i<$jml; $i++){
		$pic	= $_POST['pic'][$i];
		mysql_query("INSERT INTO pic_jo (`id_pic`, `id_jo`, `pic`) VALUES ('', '$id', '$pic')");
	}
	// $pic = array();
	// foreach ($_POST['pic'] as $pic2) {
		// array_push($pic, $pic2);
	// }
	// $pic2 = serialize($pic);
	// mysql_query("INSERT INTO pic_jo (`id_pic`, `id_jo`, `pic`) VALUES ('', '$id', '$pic2')");
	//////////////////////////////////////////////////////////////////////
	
}elseif($_GET['opt']=="tambah"){	
	$query = mysql_query("INSERT INTO `job_order` SET 	`id_jo`				='$id',
														`aktifitas`			='$aktifitas',
														`atasan`			='$atasan',
														`tgl_mulai`			='$tgl_mulai',
														`tgl_selesai`		='$tgl_selesai',
														`jam_mulai`			='$jam_mulai',
														`jam_selesai`		='$jam_selesai',
														`lampiran`			='$fileName',
														`ket`				='$ket' ");
	//////////////////////////////////////////////////////////////////////
	
	$jml = count($_POST['pic']);
	for($i=0; $i<$jml; $i++){
		$pic	= $_POST['pic'][$i];
		mysql_query("INSERT INTO pic_jo (`id_pic`, `id_jo`, `pic`) VALUES ('', '$id', '$pic')");
	}
	//////////////////////////////////////////////////////////////////////
	
	move_uploaded_file($tmpName,$folder);
		
}

     header('Location: ../../page.php?page=job_order&succes=1');

?>