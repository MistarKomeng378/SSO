<?php
include"../../config/koneksi.php";

	// $queryHasil = mysql_query("SELECT distinct id,hasil_akhir FROM wbs WHERE hasil_akhir!='' ");
	// while($h=mysql_fetch_array($queryHasil)){
		// mysql_query("UPDATE wbs SET hasil_akhir='$h[hasil_akhir]' WHERE parentId='$h[id]'");
	// }

	// $query2 = mysql_query("SELECT distinct id_gca,nik,bulan FROM waktu_kerja2 ");
	// while($r=mysql_fetch_array($query2)){	
		// $durasi	= mysql_fetch_array(mysql_query("SELECT SUM(`1`)+SUM(`2`)+SUM(`3`)+SUM(`4`)+SUM(`5`)+SUM(`6`)+SUM(`7`)+SUM(`8`)+SUM(`9`)+SUM(`10`)+
					// SUM(`11`)+SUM(`12`)+SUM(`13`)+SUM(`14`)+SUM(`15`)+SUM(`16`)+SUM(`17`)+SUM(`18`)+SUM(`19`)+SUM(`20`)+
					// SUM(`21`)+SUM(`22`)+SUM(`23`)+SUM(`24`)+SUM(`25`)+SUM(`26`)+SUM(`27`)+SUM(`28`)+SUM(`29`)+SUM(`30`)+
					// SUM(`31`)+SUM(`32`) as jum FROM waktu_kerja2 WHERE id_gca='$r[id_gca]' AND bulan='$r[bulan]' AND nik='$r[nik]' "));
					
		// mysql_query("UPDATE waktu_kerja2 SET total_jam='$durasi[jum]' WHERE id_gca='$r[id_gca]' AND bulan='$r[bulan]' AND nik='$r[nik]' ");
	// }
	
	
	//narik data dari gca load ke durasi di wbs
	// $query = mysql_query("SELECT id,pic FROM wbs ");
	// while($r=mysql_fetch_array($query)){	
		// $durasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r[id]' AND nik='$r[pic]'"));
		// mysql_query("UPDATE wbs SET durasi='$durasi[jum]' WHERE id='$r[id]'");
	// }
	
	
	//UPDATE durasi di wbs
	// $query = mysql_query("SELECT distinct parentId FROM wbs WHERE cc_id='M4300'");
	// while($r=mysql_fetch_array($query)){
		// $durasi	= mysql_fetch_array(mysql_query("SELECT SUM(durasi) as jum FROM wbs WHERE parentId='$r[parentId]' "));
		// mysql_query("UPDATE wbs SET durasi='$durasi[jum]' WHERE id='$r[parentId]'");
	// }
	
	
	//narik data dari pencapaian ke realisasi di wbs & narik data dari gca load ke durasi di wbs
	// $qrealisasi = mysql_query("SELECT id,pic FROM wbs WHERE tahun='2018' AND cc_id='M1002'");
	// while($r=mysql_fetch_array($qrealisasi)){	
		// $realisasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM pencapaian WHERE jo_gca='$r[id]' AND nik='$r[pic]'"));
		// $durasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$r[id]' AND nik='$r[pic]'"));
		// mysql_query("UPDATE wbs SET realisasi='$realisasi[jum]',durasi='$durasi[jum]' WHERE id='$r[id]'");
	// }
	
	// UPDATE durasi & realisasi di WBS
	for($i=0;$i<=4;$i++){		
		$realisasi = mysql_query("SELECT distinct parentId FROM wbs WHERE tahun='2018' AND cc_id='M1002'");
		while($r=mysql_fetch_array($realisasi)){
			$real	= mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as jum FROM wbs WHERE parentId='$r[parentId]' "));
			$durasi	= mysql_fetch_array(mysql_query("SELECT SUM(durasi) as jum FROM wbs WHERE parentId='$r[parentId]' "));
			mysql_query("UPDATE wbs SET durasi='$durasi[jum]',realisasi='$real[jum]' WHERE id='$r[parentId]'");
		}
	}
	
	// UPDATE CC ID
	// $cc_id = mysql_query("SELECT distinct id,cc_id FROM cc_id ");
	 // while($cc=mysql_fetch_array($cc_id)){
		 // mysql_query("UPDATE wbs SET cc_id='$cc[cc_id]' WHERE id='$cc[id]'");
		 // $r = mysql_fetch_array(mysql_query("SELECT id FROM wbs WHERE id='$cc[id]' "));		 
		 // echo"$cc[id]->$cc[cc]->$cc[cc_id] <> $r[cc_id]<br>";
	 // }
	
	// untuk isi id_srko di wbs
	// $query = mysql_query("SELECT id,id_srko,tahun,level FROM wbs WHERE level='10'");
	// while($r=mysql_fetch_array($query)){
		// echo"$r[id] - $r[id_srko] > $r[tahun] > $r[level]<br>";
		// $lv2 = mysql_query("SELECT id,id_srko,level,tahun FROM wbs WHERE parentId='$r[id]' ");
		// while($r2=mysql_fetch_array($lv2)){
			// mysql_query("UPDATE wbs SET id_srko='$r[id_srko]' WHERE id='$r2[id]' ");
			// echo"=> $r2[id] - $r2[id_srko] > $r2[tahun]> $r2[level]><br>";
		// }
	// }
	
	//buat set level
	// $query = mysql_query("SELECT id,parentId,level,aktivitas,cc,cc_id FROM wbs WHERE level='10' AND cc_id='M4200'");
	// while($r=mysql_fetch_array($query)){
		// echo"$r[id] - $r[parentId] > $r[level] > $r[cc] > $r[cc_id] - $r[aktivitas]<br>";
		// $lv2 = mysql_query("SELECT id,parentId,level,aktivitas,cc,cc_id FROM wbs WHERE parentId='$r[id]' ");
			// while($r2=mysql_fetch_array($lv2)){
				// mysql_query("UPDATE wbs SET level='11',cc_id='$r[cc_id]' WHERE id='$r2[id]' ");
				// echo"=> $r2[id] - $r2[parentId] > $r2[level]> $r2[cc]> $r2[cc_id] - $r2[aktivitas]<br>";
			// }
	// }
	
	//UNTUK menambahkan parentId,cc_id, menghitung jumlahHari
	// $load = mysql_query("SELECT nik,id_gca,bulan,tahun FROM waktu_kerja2 WHERE total_hari=''");
	// while($r=mysql_fetch_array($load)){
		// $nik	= $r['nik'];
		// $month	= $r['bulan']; 
		// $year	= $r['tahun']; 
		// $day	= date("d");
		// $id_gca	= $r['id_gca'];
		// $jumlahHari = 0;
		
		// $parent = mysql_fetch_array(mysql_query("SELECT parentId,cc_id FROM wbs WHERE id='$id_gca'"));
		// mysql_query("UPDATE waktu_kerja2 SET parentId='$parent[parentId]',cc='$parent[cc_id]' WHERE nik='$nik' AND id_gca='$id_gca'");
		
		// echo"$i. $r[id_gca] $parent[parentId]<br>";
		
		// echo"$i. $r[id_gca]<br>";
		
		// $endDate=date("t",mktime(0,0,0,$month,$day,$year));
		// for ($d=1;$d<=$endDate;$d++) {
			// $jam_kerja = mysql_fetch_array(mysql_query("SELECT `$d` FROM waktu_kerja2 WHERE nik='$nik' AND bulan='$month' AND tahun='$year' AND id_gca='$id_gca' "));
			// if($jam_kerja[$d] > 0){
				// $hari = 1;
			// }else{
				// $hari = 0;
			// }
			// echo"$d = $jam_kerja[$d]<br>";
			// $jumlahHari += $hari;
		// }
		// echo"jumlahHari = $jumlahHari<br>";
		// mysql_query("UPDATE waktu_kerja2 SET total_hari='$jumlahHari' WHERE nik='$nik' AND bulan='$month' AND tahun='$year' AND id_gca='$id_gca'");
		// $i++;
		// $jumlahHari = 0;
	// }
	
	//update karyawan keluar
	// $query = mysql_query("SELECT * FROM karyawan_keluar");
	// while($r=mysql_fetch_array($query)){
		// mysql_query("UPDATE m_karyawan SET status='1' WHERE regno='$r[nik]' ");
	// }
	
	//delete waktu_kerja gca jenis folder
	// $query = mysql_query("SELECT * FROM wbs WHERE jenisGCA='1' AND tahun='2018'");
	// while($r=mysql_fetch_array($query)){
		// echo"$r[id]<br>";
		// mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$r[id]' AND tahun='2018'");
		// $wk = mysql_fetch_array(mysql_query("SELECT * FROM waktu_kerja2 WHERE id_gca='$r[id]' AND tahun='2018'"));
		// echo"->$wk[bulan]<br>";
	// }

//generate target SRKO	
// $div = mysql_query("SELECT CostCenter as cc,uraian FROM mskko WHERE status='1' AND id!='0' AND id!='1.6' AND id!='2.1' AND id!='1.6'  ");
// $div = mysql_query("SELECT CostCenter as cc,uraian FROM mskko WHERE CostCenter='M4300'  ");
// while($cc = mysql_fetch_array($div)){
	// $srko = mysql_query("SELECT id_srko,CostCenter as cc,tahun FROM srko WHERE CostCenter='$cc[cc]' AND hasil_akhir='P' AND tahun='2018'");
	// while($id = mysql_fetch_array($srko)){
		// $query = mysql_query("SELECT * FROM wbs WHERE id_srko='$id[id_srko]' AND tahun='$id[tahun]'");
		// $total_jam = 0;
		// while($r=mysql_fetch_array($query)){
			// $load = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total FROM waktu_kerja2 WHERE id_gca='$r[id]'"));
			// $total_jam += $load['total'];
			// echo"$r[id]-$r[level]-$load[total]<br>";
		// }
		// echo"------------>$total_jam<br>";

		// $ttarget = 0;
		// for($i=1;$i<=12;$i++){
			// $jam_bulan = 0;
			// $query = mysql_query("SELECT * FROM wbs WHERE id_srko='$id[id_srko]' AND tahun='$id[tahun]'");
			// while($r=mysql_fetch_array($query)){
				// $load = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total FROM waktu_kerja2 WHERE id_gca='$r[id]' AND bulan='$i' "));
				// $jam_bulan += $load['total'];
			// }
			// $jam_bulan;
			// if($total_jam == 0){
				// $target = 0;
			// }else{
				// $target = $jam_bulan/$total_jam*100;
			// }
			// echo"$i>$jam_bulan / $total_jam = $target<br>";
			// mysql_query("UPDATE target_srko SET target='$target' WHERE cc='$id[cc]' AND bulan='$i' AND tahun='$id[tahun]' AND id_srko='$id[id_srko]' ");
			// mysql_query("UPDATE progress_srko SET target='$target' WHERE cc='$id[cc]' AND bulan='$i' AND tahun='$id[tahun]' AND id_srko='$id[id_srko]' ");
			// $ttarget += $target;
		// }
		// echo"--------------------------------> = $ttarget<br>";
	// }
// }
header('Location: ../../page.php?page=data_gca&succes=2');
?>