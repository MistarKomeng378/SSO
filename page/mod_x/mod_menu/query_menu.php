<?php
include"../../config/koneksi.php";

$table 		="m_menu";
$id 		= mysql_real_escape_string($_POST['id']);
$menu 		= mysql_real_escape_string($_POST['menu']);
$url 		= mysql_real_escape_string($_POST['url']);
$dir 		= mysql_real_escape_string($_POST['dir']);
$file 		= mysql_real_escape_string($_POST['file']);
$icon 		= mysql_real_escape_string($_POST['icon']);
$order 		= mysql_real_escape_string($_POST['order']);


// echo "$first-$last-$email-$password";
if($_GET['opt']=="edit"){
	$query = mysql_query("UPDATE `$table` SET `id_menu`		='$id',
												`parentId`	='0',
												`menu`		='$menu',
												`link`		='$url',
												`dir`		='$dir',
												`file`		='$file',
												`icon`		='$icon',
												`icon`		='$icon',
												`order`		='$order',
												`view`		='1',
												`status`	='1'
									WHERE `id_menu`			='$id'");
	
}elseif($_GET['opt']=="tambah"){
	$query = mysql_query("INSERT INTO `$table` SET `parentId`	='0',
													`menu`	='$menu',
													`link`		='$url',
													`dir`		='$dir',
													`file`		='$file',
													`icon`		='$icon',
													`order`		='$order',
													`view`		='1',
													`status`	='1' ");
	}
 header('Location: ../../page.php?page=manage_menu&succes=1');
?>