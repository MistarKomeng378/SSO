<?php
include"../../config/koneksi.php";
$query = mysql_query("SELECT id FROM wbs WHERE parentId='100020'");
while($r=mysql_fetch_array($query)){
	echo"$r[id]<br>";
	$sub1 = mysql_query("SELECT id FROM wbs WHERE parentId='$r[id]'");
	while($s1=mysql_fetch_array($sub1)){
		echo"->$s1[id]";
		$sub2 = mysql_query("SELECT id FROM wbs WHERE parentId='$s1[id]'");
		while($s2=mysql_fetch_array($sub2)){
			$wk = mysql_fetch_array(mysql_query("SELECT 	waktu_kerja2.nik,
											waktu_kerja2.id_gca,
											wbs.parentId,
											SUM(waktu_kerja2.total_jam) as tot
											FROM
											waktu_kerja2
											INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca
											WHERE waktu_kerja2.id_gca='$s2[id]'
											"));
			echo"-->$s2[id]($wk[tot])";
			// $sub3 = mysql_query("SELECT id FROM wbs WHERE parentId='$s2[id]'");
			// while($s3=mysql_fetch_array($sub3)){
				
				// echo"--->$s3[id]->$wk[total_jam]";
				// $sub4 = mysql_query("SELECT id FROM wbs WHERE parentId='$s3[id]'");
				// while($s4=mysql_fetch_array($sub4)){
					// echo"---->$s4[id]";
					// $sub5 = mysql_query("SELECT id FROM wbs WHERE parentId='$s4[id]'");
					// while($s5=mysql_fetch_array($sub5)){
						// echo"----->$s5[id]";
						
					// }
					// echo"<br>";
				// }
				// echo"<br>";
			// }
			echo"<br>";
		}
		echo"<br>";
	}
	echo"<br>";
}


?>