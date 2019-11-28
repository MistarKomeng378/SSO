<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

$tahun 		= mysql_real_escape_string($_POST['tahun']);
$unit		= mysql_real_escape_string($_POST['unit']);

// echo $tahun."<br>";
// echo $unit."<br>";

if($_GET['opt']=="edit"){
	
}elseif($_GET['opt']=="tambah"){
	$dir = mysql_fetch_array(mysql_query("SELECT nik FROM v_manager WHERE CostCenter='$unit'"));
	mysql_query("DELETE FROM srkk WHERE cc='$unit' AND tahun='$tahun' AND nik!='$dir[nik]' ");
	// mysql_query("DELETE FROM srkk_bulanan WHERE cc='$unit' AND tahun='$tahun' AND nik!='$dir[nik]' ");
	$jum	= count($_POST['srkk']);
	for($i=0;$i<$jum;$i++){
		$srkk 	= $_POST['srkk'][$i];
		@$rutin 	= $_POST['rutin'][$srkk];
		$r 		= mysql_fetch_array(mysql_query("SELECT id_srko FROM wbs WHERE tahun='$tahun' AND id='$srkk'"));
		$srko	= $r['id_srko'];
		// echo"$srkk - $r[id_srko]<br>";
		
		$getPIC	= mysql_query("SELECT * FROM wbs WHERE id='$srkk' AND tahun='$tahun'");
		while($r=mysql_fetch_array($getPIC)){
			if($r['pic']!="" AND $r['pic']!=$dir['nik']){
				mysql_query("REPLACE INTO srkk SET nik='$r[pic]',id_srko='$srko',id_gca='$srkk',cc='$unit',tahun='$tahun' ,rutin='$rutin'");
				// echo">NIK : $r[pic] $r[aktivitas] SRKO: $srko $srkk<br>";		
			}
			$getsubPIC	= mysql_query("SELECT DISTINCT pic,id FROM wbs WHERE parentId='$r[id]'");
			while($sub=mysql_fetch_array($getsubPIC)){
				if($sub['pic']!="" AND $sub['pic']!=$dir['nik'] OR $sub['pic']!=$r['pic']){
					mysql_query("REPLACE INTO srkk SET nik='$sub[pic]',id_srko='$srko',id_gca='$srkk',cc='$unit',tahun='$tahun' ,rutin='$rutin'");
					// echo"->NIK : $sub[pic] $r[aktivitas] SRKO: $srko $srkk<br>";
				}
				$getsubPIC2	= mysql_query("SELECT DISTINCT pic,id FROM wbs WHERE parentId='$sub[id]'");
				while($sub2=mysql_fetch_array($getsubPIC2)){
					if($sub2['pic']!="" AND $sub2['pic']!=$dir['nik'] OR $sub2['pic']!=$r['pic'] OR $sub2['pic']!=$sub['pic']){
						mysql_query("REPLACE INTO srkk SET nik='$sub2[pic]',id_srko='$srko',id_gca='$srkk',cc='$unit',tahun='$tahun' ,rutin='$rutin'");
						// echo"-->NIK : $sub2[pic] $r[aktivitas] SRKO: $srko $srkk<br>";
					}
					$getsubPIC3	= mysql_query("SELECT DISTINCT pic,id FROM wbs WHERE parentId='$sub2[id]'");
					while($sub3=mysql_fetch_array($getsubPIC3)){
						if($sub3['pic']!="" AND $sub3['pic']!=$dir['nik'] OR $sub3['pic']!=$r['pic'] OR $sub3['pic']!=$sub['pic'] OR $sub3['pic']!=$sub2['pic']){
							mysql_query("REPLACE INTO srkk SET nik='$sub3[pic]',id_srko='$srko',id_gca='$srkk',cc='$unit',tahun='$tahun' ,rutin='$rutin'");
							// echo"--->NIK : $sub3[pic] $r[aktivitas] SRKO: $srko $srkk<br>";
						}
						$getsubPIC4	= mysql_query("SELECT DISTINCT pic,id FROM wbs WHERE parentId='$sub3[id]' ");
						while($sub4=mysql_fetch_array($getsubPIC4)){
							if($sub4['pic']!="" AND $sub4['pic']!=$dir['nik'] OR $sub4['pic']!=$r['pic'] OR $sub4['pic']!=$sub['pic'] OR $sub4['pic']!=$sub2['pic'] OR $sub4['pic']!=$sub3['pic']){
								mysql_query("REPLACE INTO srkk SET nik='$sub4[pic]',id_srko='$srko',id_gca='$srkk',cc='$unit',tahun='$tahun' ,rutin='$rutin'");
								// echo"---->NIK : $sub4[pic] $r[aktivitas] SRKO: $srko $srkk<br>";
							}
							$getsubPIC5	= mysql_query("SELECT DISTINCT pic,id FROM wbs WHERE parentId='$sub4[id]'");
							while($sub5=mysql_fetch_array($getsubPIC5)){
								if($sub5['pic']!="" AND $sub5['pic']!=$dir['nik'] OR $sub5['pic']!=$r['pic'] OR $sub5['pic']!=$sub['pic'] OR $sub5['pic']!=$sub2['pic'] OR $sub5['pic']!=$sub3['pic'] OR $sub5['pic']!=$sub4['pic']){
									mysql_query("REPLACE INTO srkk SET nik='$sub5[pic]',id_srko='$srko',id_gca='$srkk',cc='$unit',tahun='$tahun' ,rutin='$rutin'");
									// echo"----->NIK : $sub5[pic] $r[aktivitas] SRKO: $srko $srkk<br>";
								}
								$getsubPIC6	= mysql_query("SELECT DISTINCT pic,id FROM wbs WHERE parentId='$sub5[id]'");
								while($sub6=mysql_fetch_array($getsubPIC6)){
									if($sub6['pic']!="" AND $sub6['pic']!=$dir['nik'] OR $sub6['pic']!=$r['pic'] OR $sub6['pic']!=$sub['pic'] OR $sub6['pic']!=$sub2['pic'] OR $sub6['pic']!=$sub3['pic'] OR $sub6['pic']!=$sub4['pic'] OR $sub6['pic']!=$sub5['pic']){
										mysql_query("REPLACE INTO srkk SET nik='$sub6[pic]',id_srko='$srko',id_gca='$srkk',cc='$unit',tahun='$tahun' ,rutin='$rutin'");
										// echo"------>NIK : $sub6[pic] $r[aktivitas] SRKO: $srko $srkk<br>";
									}
									$getsubPIC7	= mysql_query("SELECT DISTINCT pic,id FROM wbs WHERE parentId='$sub6[id]'");
									while($sub7=mysql_fetch_array($getsubPIC7)){
										if($sub7['pic']!="" AND $sub7['pic']!=$dir['nik'] OR $sub7['pic']!=$r['pic'] OR $sub7['pic']!=$sub['pic'] OR $sub7['pic']!=$sub2['pic'] OR $sub7['pic']!=$sub3['pic'] OR $sub7['pic']!=$sub4['pic'] OR $sub7['pic']!=$sub5['pic'] OR $sub7['pic']!=$sub6['pic']){
											mysql_query("REPLACE INTO srkk SET nik='$sub7[pic]',id_srko='$srko',id_gca='$srkk',cc='$unit',tahun='$tahun' ,rutin='$rutin'");
											// echo"------->NIK : $sub7[pic] $r[aktivitas] SRKO: $srko $srkk<br>";
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	mysql_query("DELETE FROM srkk WHERE nik=''");	
	mysql_query("DELETE FROM srkk WHERE nik='$dir[nik]' AND tahun='$tahun'");
}
	
 header('Location: ../../page.php?page=data_srkk&success=1');
?>