<?php
function role_insert($level, $menu){
	$insert = mysql_num_rows(mysql_query("SELECT * FROM role_permission WHERE id_permission='1' AND level='$level' AND id_menu='$menu'"));
}
function role_update($level, $menu){
	$update = mysql_num_rows(mysql_query("SELECT * FROM role_permission WHERE id_permission='2' AND level='$level' AND id_menu='$menu'"));
}
function role_delete($level, $menu){
	$delete = mysql_num_rows(mysql_query("SELECT * FROM role_permission WHERE id_permission='4' AND level='$level' AND id_menu='$menu'"));
}
?>