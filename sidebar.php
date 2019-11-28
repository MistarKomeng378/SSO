<?php
include"config/koneksi.php";
ob_start();
session_start();
function show($id = '',$level,$nik){
	$where = '';
	if(strlen($id) > 0) $where = " AND m_menu.parentId='$id'";
		$sql = "SELECT m_menu.id_menu, m_menu.menu, m_menu.link, m_menu.parentId
				FROM
					m_menu
				INNER JOIN role_menu ON m_menu.id_menu = role_menu.id_menu
				WHERE m_menu.status='1' 
				AND m_menu.view='1' 
				AND m_menu.parentId='0' 
				AND level='$level' 
				AND nik='$nik'
				$where";
		// $sql	= "SELECT * FROM m_menu WHERE status='1' AND view='1' $where";
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		$i=0;
	while($row = mysql_fetch_assoc($res)){
		
		if($i == 0) echo "<ul class='$typeMenu'>";
		$i++;
		
		$cekId	= mysql_fetch_array(mysql_query("SELECT COUNT(*) as jum FROM m_menu WHERE parentId='$row[id_menu]' "));
		
		
		echo "<li >
				<a href=''>
					<i class='fa fa-laptop'></i>
						<span>$row[menu]</span>";
						if($subType=="has-sub"){
						echo"
						<span class='pull-right-container'>
						  <i class='fa fa-angle-left pull-right'></i>
						</span>";
						}
		echo"</a>";
			show($row['id_menu'],$level,$nik);
		echo "</li>";
		if($i == $num)echo "</ul>";
	}

}
show("0",1,90496);
?>
