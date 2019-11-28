<?php
include"../../config/koneksi.php";

$table 		="m_menu";
$id 		= mysql_real_escape_string($_POST['id']);
$parentId	= mysql_real_escape_string($_POST['parentId']);
$submenu 	= mysql_real_escape_string($_POST['submenu']);
$url 		= mysql_real_escape_string($_POST['url']);
$dir 		= mysql_real_escape_string($_POST['dir']);
$file 		= mysql_real_escape_string($_POST['file']);
$icon 		= mysql_real_escape_string($_POST['icon']);
$order 		= mysql_real_escape_string($_POST['order']);


// echo "$first-$last-$email-$password";
if($_GET['opt']=="edit"){
	mysql_query("UPDATE `$table` SET `id_menu`				='$id',
												`parentId`	='$parentId',
												`menu`		='$submenu',
												`link`		='$url',
												`dir`		='$dir',
												`file`		='$file',
												`icon`		='$icon',
												`order`		='$order',
												`view`		='1',
												`status`	='1'
									WHERE `id_menu`			='$id'");
	
}elseif($_GET['opt']=="tambah"){
	mysql_query("INSERT INTO `$table` SET `parentId`	='$parentId',
										`menu`	='$submenu',
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