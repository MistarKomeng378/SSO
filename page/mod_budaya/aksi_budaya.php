<?php
include"../../config/koneksi.php";


$id			= mysql_real_escape_string($_POST['id']);
$prilaku	= mysql_real_escape_string($_POST['prilaku']);
$ket	    = mysql_real_escape_string($_POST['ket']);
$nilai	    = mysql_real_escape_string($_POST['nilai']);
if($_GET['opt']=="edit"){
	$query = mysql_query("UPDATE `budaya`	SET 	`id`		='$id',
													`prilaku`	='$prilaku' ,
													`ket`	    ='$ket',
													`nilai`		='$nilai' 
										WHERE 		`id`		='$id'");
	
}elseif($_GET['opt']=="tambah"){	
	$query = mysql_query("INSERT INTO `budaya` SET 	`id`		='$id',
													`prilaku`	='$prilaku',
													`nilai`		='$nilai'
													`ket`	    ='$ket'");

}

     header('Location: ../../page.php?page=budaya&succes=1');

?>