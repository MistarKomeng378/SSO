<?php
session_start();
error_reporting(0);

	if(empty($_SESSION['first']) AND empty($_SESSION['password'])){
		echo "<script language='javascript'>alert('Silahkan login terlebih dahulu');document.location='index.php'</script>";
	}
?>