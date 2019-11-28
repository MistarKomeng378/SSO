<?php
	include"../../config/koneksi.php";
	if($_REQUEST['view']==1){
		$query = mysql_query("UPDATE m_menu SET id_menu='".$_REQUEST['id']."',
												view='0'
										WHERE  id_menu='".$_REQUEST['id']."' ");
	
		if($query){
				 header('Location: ../../page.php?page=manage_menu&succes=1');
			}else{
				 header('Location: ../../page.php?page=manage_menu&failed=1');
			}
			
	}elseif($_REQUEST['view']==0){
		$query = mysql_query("UPDATE m_menu SET id_menu='".$_REQUEST['id']."',
												view='1'
										WHERE  id_menu='".$_REQUEST['id']."' ");
	
		if($query){
				 header('Location: ../../page.php?page=manage_menu&succes=1');
			}else{
				 header('Location: ../../page.php?page=manage_menu&failed=1');
			}
}
?>