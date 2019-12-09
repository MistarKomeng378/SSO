<?php
include"../../config/koneksi.php";


$id			= mysql_real_escape_string($_POST['id']);
$prilaku	= mysql_real_escape_string($_POST['prilaku']);
$ket	    = mysql_real_escape_string($_POST['ket']);
$bobot	    = mysql_real_escape_string($_POST['bobot']);
if($_GET['opt']=="edit"){
	$query = mysql_query("UPDATE `budaya`	SET 	`id`		='$id',
													`prilaku`	='$prilaku' ,
													`ket`	    ='$ket',
													`bobot`		='$bobot' 
										WHERE 		`id`		='$id'");
	
}elseif($_GET['opt']=="tambah"){	
	$query = mysql_query("INSERT INTO `budaya` SET 	`id`		='$id',
													`prilaku`	='$prilaku',
													`bobot`		='$bobot'
													`ket`	    ='$ket'");

}

     header('Location: ../../page.php?page=budaya&succes=1');

?>