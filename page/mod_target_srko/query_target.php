<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";

$cc 		= mysql_real_escape_string($_POST['cc']);
$tahun		= mysql_real_escape_string($_POST['tahun']);
// $id_srko 	= mysql_real_escape_string($_POST['id_srko']);

$jml	= count($_POST['target']);


for($i=0; $i<$jml; $i++){
	
	$target			= $_POST['target'][$i];
	$bulan 			= $_POST['bulan'][$i];
	$id_srko 		= $_POST['id_srko'][$i];
	$parent_srko 	= $_POST['parent_srko'][$i];
	@$id_target 	= $_POST['id_target'][$i];
	
	mysql_query("REPLACE INTO `target_srko` SET `id_target`		='$id_target',
												`id_srko`		='$id_srko',
												`parent_srko`	='$parent_srko',
												`cc`			='$cc',
												`target`		='$target',
												`bulan`			='$bulan',
												`tahun`			='$tahun' ");
												
	// echo "$target -> $i <br>";
}


//target new
	$query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$cc' AND tahun='$tahun' AND parent_srko='' order by id_srko");
	while($rs=mysql_fetch_array($query)){
		
		for($bln=1;$bln<=12;$bln++){
			$target = mysql_fetch_array(mysql_query("select sum(target) as target from target_srko where parent_srko='$rs[id_srko]' AND tahun='$tahun' AND bulan='$bln'"));
			
			$count = mysql_fetch_array(mysql_query("select COUNT(target) as jumlah from target_srko where parent_srko='$rs[id_srko]' AND tahun='$tahun' AND bulan='$bln'"));
			
			$det = mysql_fetch_array(mysql_query("SELECT * FROM target_srko_detile WHERE bulan='$bln' AND tahun='$tahun' AND id_srko='$rs[id_srko]'"));
			
			$target3 = mysql_fetch_array(mysql_query("SELECT * FROM target_srko WHERE bulan='$bln' AND tahun='$tahun' AND id_srko='$rs[id_srko]'"));
		
			$jum = $count['jumlah'] - 1;									
			if($jum==0){
				$quan = 1;
			}else{
				$quan = $jum; 
			}
			
			$TargetNew = desimal3($target['target']/$quan); 
			
			// echo "$bln -> $rs[id_srko] -> $TargetNew<br>";
			
			mysql_query("UPDATE target_srko SET `target`='$TargetNew' WHERE id_srko='$rs[id_srko]' AND bulan='$bln'");
			mysql_query("REPLACE INTO target_srko_detile SET 	
																id			='$det[id]',
																target		='$TargetNew',
																id_target	='$target3[id_target]',
																id_srko		='$rs[id_srko]',
																bulan		='$bln',
																cc			='$cc',
																tahun		='$tahun' ");
			
		}
	}
	//echo $update;
header("location:../../page.php?page=data_target_srko&unit=".ec($cc)."&succes=1");
?>