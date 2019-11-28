<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";

$cc 		= mysql_real_escape_string($_POST['cc']);
$tahun		= mysql_real_escape_string($_POST['tahun']);


$jml	= count($_POST['pendapatan']);


for($i=0; $i<$jml; $i++){
	
	$pendapatan			= $_POST['pendapatan'][$i];
	$hpp				= $_POST['hpp'][$i];
	$bulan 				= $_POST['bulan'][$i];
	$id_margin 			= $_POST['id_margin'][$i];
	$id_srko 			= $_POST['id_srko'][$i];
	
	mysql_query("REPLACE INTO `profit_margin` SET 		`id_margin`			='$id_margin',
														`cc`				='$cc',
														`id_srko`			='$id_srko',
														`pendapatan`		='$pendapatan',
														`hpp`				='$hpp',
														`bulan`				='$bulan',
														`tahun`				='$tahun' ");
	
	// echo "$pendapatan -> $hpp -> $id_srko -> $i  <br>";
	
}

	
	$query = mysql_query("SELECT * FROM srko WHERE CostCenter='$cc' AND tahun='$tahun' AND jenis_pencapaian='3'");
	while($r=mysql_fetch_array($query)){
		
		for($cols=1;$cols<=12;$cols++){
			
			$prog = mysql_fetch_array(mysql_query("select * from profit_margin where id_srko='$r[id_srko]' AND tahun='$tahun' AND bulan='$cols'"));
			
				@$hasil = (($prog['pendapatan']-$prog['hpp'])/$prog['pendapatan'])*100;
				
				$margin = desimal3($hasil);
				
				
				
				 // echo "$prog[id_margin]  -> $cols -> $prog[id_srko] -> $margin <br>";
				
				mysql_query("UPDATE profit_margin SET margin='$margin' where id_margin='$prog[id_margin]'");
																
		}
		
		
	}

// echo $save;
 header("location:../../page.php?page=data_margin&unit=".ec($cc)."&succes=1");
?>