<?php
include"../../config/koneksi.php";


$id			= mysql_real_escape_string($_POST['id']);
$satuan		= mysql_real_escape_string($_POST['satuan']);
$definisi	= mysql_real_escape_string($_POST['definisi']);
if($_GET['opt']=="edit"){
	$query = mysql_query("UPDATE `satuan`	SET 	`id`		='$id',
													`satuan`	='$satuan' ,
													`definisi`	='$definisi' 
										WHERE 		`id`		='$id'");
	
}elseif($_GET['opt']=="tambah"){	
	$query = mysql_query("INSERT INTO `satuan` SET 	`id`		='$id',
													`satuan`	='$satuan',
													`definisi`	='$definisi'");

}

     header('Location: ../../page.php?page=satuan&succes=1');

?>