<?php
	include"../../config/koneksi.php";
	include"../../config/encript.php";
	
	if(dc($_REQUEST['sts'])==1){
		$query = mysql_query("UPDATE kpi SET id_kpi='".dc($_REQUEST['id'])."',
												status_kpi='0'
										WHERE  id_kpi='".dc($_REQUEST['id'])."' ");
	
		if($query){
				 header('Location: ../../page.php?page=katalog_kpi&succes=1');
			}else{
				 header('Location: ../../page.php?page=katalog_kpi&failed=1');
			}
			
	}elseif(dc($_REQUEST['sts'])==0){
		$query = mysql_query("UPDATE kpi SET id_kpi='".dc($_REQUEST['id'])."',
												status_kpi='1'
										WHERE  id_kpi='".dc($_REQUEST['id'])."' ");
	
		if($query){
				 header('Location: ../../page.php?page=katalog_kpi&succes=1');
			}else{
				 header('Location: ../../page.php?page=katalog_kpi&failed=1');
			}
}
?>