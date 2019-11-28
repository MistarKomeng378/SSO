<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_rupiah.php";

	$getUnit		= mysql_real_escape_string(dc($_GET['unit']));
	$id				= mysql_real_escape_string(dc($_GET['id']));
	$tahun_aktif	= mysql_real_escape_string($_GET['tahun']);
	$dir 			= mysql_fetch_array(mysql_query("SELECT nik FROM v_manager WHERE CostCenter='$unit'"));
	mysql_query("DELETE FROM srkk_jam WHERE cc='$unit' AND tahun='$tahun' AND nik!='$dir[nik]' ");
	$queryKaryawan	= mysql_query("SELECT nik,level FROM user WHERE grup_id='$id' ORDER BY nik");
	while($r=mysql_fetch_array($queryKaryawan)){
		if($r['level']!=4){
		// echo"nik->$r[nik]<br>";
			$queryAktifitas = mysql_query("SELECT DISTINCT
											wbs.id,
											wbs.parentId,
											waktu_kerja2.bulan,
											waktu_kerja2.tahun,
											waktu_kerja2.nik,
											wbs.cc
											FROM
											waktu_kerja2
											INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca
											WHERE parentId!='2' AND mulai !='' AND akhir!=''
											AND nik='$r[nik]' AND waktu_kerja2.tahun='$tahun_aktif'
											ORDER BY id, bulan, nik, cc ASC");
			while($ak=mysql_fetch_array($queryAktifitas)){
				$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$ak['bulan'],$tahun_aktif);
				// echo"bulan : $ak[bulan] $ak[id]<br>";
				for($d=1;$d<=$lastDay;$d++){
					$jam = mysql_fetch_array(mysql_query("SELECT `$d` FROM waktu_kerja2 WHERE bulan='$ak[bulan]' AND tahun='$tahun_aktif' AND nik='$r[nik]' AND id_gca='$ak[id]'"));
					if($jam[$d]==""){
					}elseif($jam[$d]==0){
					}else{
						mysql_query("REPLACE INTO srkk_jam(`id_gca`, `parentId`, `nik`, `tgl`, `bulan`, `tahun`)
												VALUES('$ak[id]','$ak[parentId]','$r[nik]','$d','$ak[bulan]','$tahun_aktif')");
						// echo"$jam[$d]-";
					}
				}
				// echo"<br>";
			}
		}
	}
	header('Location: ../../page.php?page=data_srkk');
?>