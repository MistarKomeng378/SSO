<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";

$cc 		= mysql_real_escape_string($_POST['cc']);
$tahun		= mysql_real_escape_string($_POST['tahun']);
//$id_srko 	= mysql_real_escape_string($_POST['id_srko']);


$jml	= count($_POST['target']);
for($i=0; $i<$jml; $i++){
	$hasil_akhir= $_POST['hasil_akhir'][$i];
	$target		= $_POST['target'][$i];
	$realisasi	= $_POST['realisasi'][$i];
	$margin		= $_POST['margin1'][$i];
	
	if($hasil_akhir == "P"){
		if($realisasi == 0){
			$real	= 0;
		}else{
			$real		= ($realisasi*$target)/100;
		}
	}else{
		$real = $realisasi;
	}
		
	$pencapaian		= $_POST['pencapaian'][$i];
	@$hpp			= $_POST['hpp'][$i];
	$bulan 			= $_POST['bulan'][$i];
	$id_srko 		= $_POST['id_srko'][$i];
	$parent_srko 	= $_POST['parent_srko'][$i];
	@$id_progress 	= $_POST['id_progress'][$i];
	
	// echo"$target-$realisasi-$real-$hasil_akhir<br>";
	
	mysql_query("REPLACE INTO `progress_srko` SET `id_progress`		='$id_progress',
													`id_srko`		='$id_srko',
													`parent_srko`	='$parent_srko',
													`cc`			='$cc',
													`target`		='$target',
													`realisasi`		='$real',
													`hpp`			='$hpp',
													`margin`		='$margin',
													`pencapaian`	='$pencapaian',
													`bulan`			='$bulan',
													`tahun`			='$tahun' ");

	// echo" $id_srko -> $bulan -> $realisasi -> $margin <br>";	
}

//Realisasi new
	$query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$cc' AND tahun='$tahun' AND parent_srko='' order by id_srko");
	while($rs=mysql_fetch_array($query)){
		
		for($bln=1;$bln<=12;$bln++){
			$RealisasiOld = mysql_fetch_array(mysql_query("select sum(realisasi) as realisasi from progress_srko where parent_srko='$rs[id_srko]' AND tahun='$tahun' AND bulan='$bln'"));
			
			$TargetOld = mysql_fetch_array(mysql_query("select sum(target) as target from target_srko where parent_srko='$rs[id_srko]' AND tahun='$tahun' AND bulan='$bln'"));
			
			$count = mysql_fetch_array(mysql_query("select COUNT(target) as jumlah from target_srko where parent_srko='$rs[id_srko]' AND tahun='$tahun' AND bulan='$bln'"));
			
			$IdDetProg = mysql_fetch_array(mysql_query("SELECT * FROM progress_srko_detile WHERE bulan='$bln' AND tahun='$tahun' AND id_srko='$rs[id_srko]'"));
			
			$IdProgress = mysql_fetch_array(mysql_query("SELECT * FROM progress_srko WHERE bulan='$bln' AND tahun='$tahun' AND id_srko='$rs[id_srko]'"));
			
			$GetTarget = mysql_fetch_array(mysql_query("SELECT * FROM target_srko_detile WHERE bulan='$bln' AND tahun='$tahun' AND id_srko='$rs[id_srko]'"));
			
			$mar = mysql_fetch_array(mysql_query("SELECT * FROM progress_srko WHERE bulan='$bln' AND tahun='$tahun' AND id_srko='$rs[id_srko]'"));
		
			$jum = $count['jumlah'] - 1;									
			if($jum==0){
				$quan = 1;
			}else{
				$quan = $jum; 
			}
			
			$RealisasiNew = desimal3($RealisasiOld['realisasi']/$quan);
			//$TargetNew = desimal3($TargetOld['target']/$quan);//
			
			//echo "$bln -> $rs[id_srko] -> $RealisasiNew<br>"; //
			
			
			mysql_query("REPLACE INTO progress_srko_detile SET 	
																id_prog_detile	='$IdDetProg[id_prog_detile]',
																id_progress		='$IdProgress[id_progress]',
																id_srko			='$rs[id_srko]',
																cc				='$cc',
																target			='$GetTarget[target]',
																realisasi		='$RealisasiNew',
			 													bulan			='$bln',
			 													margin			='$mar[margin]',
																tahun			='$tahun' ");
			
			//mysql_query("UPDATE progress_srko SET realisasi='$RealisasiNew', target='$TargetNew' WHERE id_srko='$rs[id_srko]' AND bulan='$bln'");//
			
		}
	}



/////////////////// yang ini /////////////////////////
$jml2	= count($_POST['id_srko2']);
for($i=0; $i<$jml2; $i++){
	$id_srko2	= $_POST['id_srko2'][$i];
	$jr			= $_POST['jr'][$i];
	$jp			= $_POST['jp'][$i];
	
	
	$qdata		= mysql_query("SELECT * FROM progress_srko_detile WHERE id_srko='$id_srko2'");
	while($r=mysql_fetch_array($qdata)){
		
		if($jp==1){		//Positif
			if($r['target']==0 AND $r['realisasi']>0){
				$hasil = 100;
			}elseif($r['target']>0 AND $r['realisasi']<=0){
				$hasil = 0;
			}elseif($r['target']==0 AND $r['realisasi']<=0){
				$hasil = 100;
			}else{
				$hasil = ($r['realisasi']/$r['target'])*100;
			}										
		}elseif($jp==2){	//Negatif
			if($r['target']==0 AND $r['realisasi']>0){
				$hasil = 100;
			}elseif($r['target']>0 AND $r['realisasi']<=0){
				$hasil = 0;
			}elseif($r['target']==0 AND $r['realisasi']<=0){
				$hasil = 100;
			}else{
				$hasil = (($r['target'] - ($r['realisasi']-$r['target'])) / $r['target']) * 100;
			}
		}elseif($jp==3){	//Profit Margin
			
			// @$pm = (($r['realisasi']-$r['hpp'])/$r['realisasi'])*100;
			//@$pm = desimal3((($r['target']-$r['margin'])/$r['target'])*100);
			
			// mysql_query("UPDATE `progress_srko` SET `realisasi`	='$pm',`realisasi_pm` ='$r[realisasi]' WHERE id_progress='$r[id_progress]' ");
			mysql_query("UPDATE `progress_srko` SET `realisasi`	='$r[margin]',`realisasi_pm` ='$r[realisasi]' WHERE id_progress='$r[id_progress]' ");
			 //------------------------Update Detile-------------------------------------------//
			 // mysql_query("UPDATE `progress_srko_detile` SET `realisasi`	='$pm' WHERE id_progress='$r[id_progress]' ");
			 mysql_query("UPDATE `progress_srko_detile` SET `realisasi`	='$r[margin]' WHERE id_progress='$r[id_progress]' ");
			
			// if($r['target']==0 AND $pm>0){
				// $hasil = 100;
			// }elseif($r['target']>0 AND $pm<=0){
				// $hasil = 0;
			// }elseif($r['target']==0 AND $pm<=0){
				// $hasil = 100;
			// }else{
				// //$hasil = ($pm/$r['target'])*100;
			// }
			
			if($r['target']==0 AND $r['margin']>0){
				$hasil = 100;
			}elseif($r['target']>0 AND $r['margin']<=0){
				$hasil = 0;
			}elseif($r['target']==0 AND $r['margin']<=0){
				$hasil = 100;
			}else{
				// $hasil = ($pm/$r['target'])*100;
				$hasil = ($r['margin']/$r['target'])*100;
			}
		}
		if($hasil <= 0){
			$nilai=0;
		}elseif($hasil >0){
			if($hasil>120){
				$nilai=120;
			}else{
				$nilai=desimal3($hasil);
			}										
		}else{
			$nilai="";
		}
		mysql_query("UPDATE `progress_srko` SET  `jenis_resume`				='$jr',
												 `jenis_pencapaian`			='$jp',
												 `pencapaian`				='$nilai'
									WHERE id_progress='$r[id_progress]'");
									
		//-------------------------------Update Detile--------------------------------//							
		mysql_query("UPDATE `progress_srko_detile` SET `jenis_resume`		='$jr',
												 `jenis_pencapaian`			='$jp',
												 `pencapaian`				='$nilai'
									WHERE id_progress='$r[id_progress]'");
									
		
									
		$update=mysql_query("UPDATE `srko` SET `jenis_pencapaian`	='$jp'
													WHERE id_srko	='$id_srko2'");
		
		
	
	}
	
	// $qprog		= mysql_query("SELECT * FROM progress_srko WHERE id_srko='$id_srko2'");	
	// while($rp=mysql_fetch_array($qprog)){
		// mysql_query("UPDATE `progress_srko` SET  `jenis_resume`				='$jr',
												 // `jenis_pencapaian`			='$jp'
											// WHERE id_progress='$rp[id_progress]'");
	// }
}


	// echo $update;	
										
header("location:../../page.php?page=data_progress_srko&unit=".ec($cc)."&succes=1");
?>