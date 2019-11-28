<?php
include '../../config/koneksi.php';
include '../../config/encript.php';

$nik 	= $_GET['nik'];
$cc 	= $_GET['cc'];
$user	= mysql_fetch_array(mysql_query("SELECT level FROM user WHERE nik='$nik'"));
$level	= $user['level']; 

function hapus($id){
	mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$id'");
	mysql_query("DELETE FROM wbs WHERE id='$id'");
	$select1 = mysql_query("SELECT id FROM wbs WHERE parentId='$id'");
	while($r=mysql_fetch_array($select1)){
		mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$r[id]'");
		mysql_query("DELETE FROM wbs WHERE id='$r[id]'");
		$select2 = mysql_query("SELECT id FROM wbs WHERE parentId='$r[id]'");
		while($r2=mysql_fetch_array($select2)){
			mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$r2[id]'");
			mysql_query("DELETE FROM wbs WHERE id='$r2[id]'");
			$select3 = mysql_query("SELECT id FROM wbs WHERE parentId='$r2[id]'");
			while($r3=mysql_fetch_array($select3)){
				mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$r3[id]'");
				mysql_query("DELETE FROM wbs WHERE id='$r3[id]'");
			}
		}
	}
}
if(empty($_GET['id'])){
	header('Location: ../../page.php?page=data_gca');
}else{
	$ex 	= explode("-",$_GET['id']);
	$count 	= count(explode("-",$_GET['id']));
	for($i=0;$i<=$count-1;$i++){
		
		$id = $ex[$i];
		// echo"$id<br>";
		// echo"$cc<br>";
		// echo"$nik<br>";
		$data 	= mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$id'"));
		$parent = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$data[parentId]'"));
		$atasan2 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$parent[parentId]' "));
		$atasan3 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$atasan2[parentId]' "));
		
		if($level==1){
			hapus($id);
			// echo"delete oke<br>";
		}elseif($level==2){
			if($data['lock']!=1){
				hapus($id);
				// echo"delete oke<br>";
			}
		}elseif($level==3){
			if($data['lock']!=1){
				hapus($id);
				// echo"delete oke<br>";
			}
		}elseif($level==4){
			if($data['cc_id']==$cc AND $data['lock']!=1){
				hapus($id);
				// echo"delete oke<br>";
			}
		}elseif($level==5){
			// if($data['cc_id']==$cc AND $data['lock']!=1 AND ($parent['pic']==$nik OR $data['pic']==$nik OR $data['gca_by']==$nik)){
			if($data['cc_id']==$cc AND $data['lock']!=1 AND ($atasan2['pic']==$nik OR $atasan3['pic']==$nik OR $parent['pic']==$nik OR $data['pic']==$nik OR $data['gca_by']==$nik)){
				$result = hapus($id);
				// echo"delete oke<br>";
			}
		}
		
	}
	header('Location: ../../page.php?page=data_gca');
}
// if ($result){
	
// } else {
	// header('Location: ../../page.php?page=data_gca&failed=1');
// }
?>