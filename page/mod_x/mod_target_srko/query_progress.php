<?php
include"../../config/koneksi.php";
include"../../config/encript.php";

$cc 		= mysql_real_escape_string($_POST['cc']);
$tahun		= mysql_real_escape_string($_POST['tahun']);
// $id_srko 	= mysql_real_escape_string($_POST['id_srko']);

$jml	= count($_POST['target']);
for($i=0; $i<$jml; $i++){
	$target		= $_POST['target'][$i];
	$realisasi	= $_POST['realisasi'][$i];
	$pencapaian	= $_POST['pencapaian'][$i];
	@$hpp		= $_POST['hpp'][$i];
	$bulan 		= $_POST['bulan'][$i];
	$id_srko 	= $_POST['id_srko'][$i];
	@$id_progress 	= $_POST['id_progress'][$i];
	
	mysql_query("REPLACE INTO `progress_srko` SET `id_progress`	='$id_progress',
													`id_srko`	='$id_srko',
													`cc`		='$cc',
													`target`	='$target',
													`realisasi`	='$realisasi',
													`hpp`		='$hpp',
													`pencapaian`='$pencapaian',
													`bulan`		='$bulan',
													`tahun`		='$tahun' ");
}

$jml2	= count($_POST['id_srko2']);
for($i=0; $i<$jml2; $i++){
	$id_srko2	= $_POST['id_srko2'][$i];
	$jr			= $_POST['jr'][$i];
	$jp			= $_POST['jp'][$i];
	
	$qdata		= mysql_query("SELECT * FROM progress_srko WHERE id_srko='$id_srko2' ");
	while($r=mysql_fetch_array($qdata)){
		if($jp==1){
			if($r['target']==0 AND $r['realisasi']>0){
				$hasil = 100;
			}elseif($r['target']>0 AND $r['realisasi']<=0){
				$hasil = 0;
			}elseif($r['target']==0 AND $r['realisasi']<=0){
				$hasil = 100;
			}else{
				$hasil = ($r['realisasi']/$r['target'])*100;
			}										
		}elseif($jp==2){
			if($r['target']==0 AND $r['realisasi']>0){
				$hasil = 100;
			}elseif($r['target']>0 AND $r['realisasi']<=0){
				$hasil = 0;
			}elseif($r['target']==0 AND $r['realisasi']<=0){
				$hasil = 100;
			}else{
				$hasil = (($r['target'] - ($r['realisasi']-$r['target'])) / $r['target']) * 100;
			}
		}elseif($jp==3){
			
			@$pm = (($r['realisasi']-$r['hpp'])/$r['realisasi'])*100;
			mysql_query("UPDATE `progress_srko` SET `realisasi`	='$pm',`realisasi_pm`	='$r[realisasi]' WHERE id_progress='$r[id_progress]' ");
			
			if($r['target']==0 AND $pm>0){
				$hasil = 100;
			}elseif($r['target']>0 AND $pm<=0){
				$hasil = 0;
			}elseif($r['target']==0 AND $pm<=0){
				$hasil = 100;
			}else{
				$hasil = ($pm/$r['target'])*100;
			}
		}
		if($hasil <= 0){
			$nilai=0;
		}elseif($hasil > 0){
			if($hasil>120){
				$nilai=120;
			}else{
				$nilai=$hasil;
			}										
		}else{
			$nilai="";
		}
		mysql_query("UPDATE `progress_srko` SET `jenis_resume`		='$jr',
												`jenis_pencapaian`	='$jp',
												`pencapaian`		='$nilai'
									WHERE id_progress='$r[id_progress]' ");
	
	}
}

header("location:../../page.php?page=data_progress_srko&unit=".ec($cc)."&succes=1");
?>