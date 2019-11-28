<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
if($_GET['act']=="tahun"){
	@$id_tahun	= mysql_real_escape_string($_POST['id_tahun']);
	@$tahun		= mysql_real_escape_string($_POST['tahun']);

	if($_GET['opt']=="edit"){
		$query = mysql_query("UPDATE `tahun`	SET `id_tahun`	='$id_tahun' ,
													`tahun`		='$tahun' 
											WHERE 	`id_tahun`	='$id_tahun'");
		header('Location: ../../page.php?page=time&succes=1');
	}elseif($_GET['opt']=="status"){
		$ex 	= explode("-",$_GET['id']);
		$id 	= mysql_real_escape_string(dc($ex[0]));
		$sts 	= mysql_real_escape_string(dc($ex[1]));
		mysql_query("UPDATE tahun SET status='0' ");
		if($sts==1){
			$query = mysql_query("UPDATE tahun SET id_tahun='".$id."',
													status='0'
											WHERE  id_tahun='".$id."' ");
		
			if($query){
					 header('Location: ../../page.php?page=time&succes=1');
				}else{
					 header('Location: ../../page.php?page=time&failed=1');
				}
				
		}elseif($sts==0){
			$query = mysql_query("UPDATE tahun SET id_tahun='".$id."',
													status='1'
											WHERE  id_tahun='".$id."' ");
		
			if($query){
					 header('Location: ../../page.php?page=time&succes=1');
				}else{
					 header('Location: ../../page.php?page=time&failed=1');
				}
		}
	}else{	
		$query = mysql_query("INSERT INTO `tahun` SET 	`id_tahun`	='$id_tahun',
														`tahun`		='$tahun'
														");
		header('Location: ../../page.php?page=time&succes=1');
	}
}elseif($_GET['act']=="libnas"){
	@$id_libur		= mysql_real_escape_string($_POST['id_libur']);
	@$tanggal_libur	= mysql_real_escape_string($_POST['tanggal_libur']);
	@$keterangan	= mysql_real_escape_string($_POST['keterangan']);
	if($_GET['opt']=="edit"){
		$query = mysql_query("UPDATE `libur_nasional`	SET `id_libur`	='$id_libur' ,
															`tanggal`	='$tanggal_libur', 
															`keterangan`='$keterangan' 
													WHERE 	`id_libur`	='$id_libur'");
		header('Location: ../../page.php?page=time&succes-l=1');
	}else{
		$query = mysql_query("INSERT INTO `libur_nasional` SET 	`id_libur`	='$id_libur' ,
																`tanggal`	='$tanggal_libur', 
																`keterangan`='$keterangan'
														");
		header('Location: ../../page.php?page=time&succes-l=1');
	}
}
?>