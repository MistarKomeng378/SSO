<?php
//memanggil file excel_reader
require "../../config/excel_reader.php";
require "../../config/koneksi.php";
require "../../config/fungsi_hitung_minggu.php";
$timezone = "Asia/Jakarta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
//jika tombol import ditekan
if(isset($_POST['submit'])){

    $target = basename($_FILES['gca']['name']) ;
    move_uploaded_file($_FILES['gca']['tmp_name'], $target);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['gca']['name'],false);
    
//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);
    
//    jika kosongkan data dicentang jalankan kode berikut
    $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
    if($drop == 1){
//             kosongkan tabel pegawai
             $truncate ="TRUNCATE TABLE wbs";
             mysql_query($truncate);
    };
    
//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i=2; $i<=$baris; $i++)
    {
//       membaca data (kolom ke-1 sd terakhir)
		$id			=$data->val($i, 1);
		$parentId	=$data->val($i, 2);
		$id_srko	=$data->val($i, 3);
		$level		=$data->val($i, 4);
		$aktivitas	=$data->val($i, 5);
		$mulai		=$data->val($i, 6);
		$akhir		=$data->val($i, 7);
		$cc			=str_replace(' ','',$data->val($i, 8));
		$pic		=str_replace(' ','',$data->val($i, 9));
		$deliverable=$data->val($i, 10);
		$kode_kpi	=$data->val($i, 11);
		$jam		=$data->val($i, 12);
		$gca_by		=$data->val($i, 13);
		$tahun		=$data->val($i, 14);
		$cc_id		=$data->val($i, 15);
		$hasil_akhir=$data->val($i, 16);		
		$jenisGCA	=$data->val($i, 17);
		$jenisAktf	=$data->val($i, 18);		
		$tgl_input	= date("Y-m-d H:i:s");
		if($jenisGCA==1){
			$icon = "assets/img/folder.png";
		}else{
			$icon = "assets/img/file.png";
		}
		$s = strtotime($mulai);
        $e = strtotime($akhir);
       
		// echo"$id - <br>";
		/////////////////////////////////////////////////////////////////////////////////////////
		if(!empty($mulai) AND !empty($akhir)){
			$start1    = new DateTime("$mulai");
			$start1->modify('first day of this month');
			$end1      = new DateTime("$akhir");
			$end1->modify('first day of next month');
			$interval1 = DateInterval::createFromDateString('1 month');
			$period1   = new DatePeriod($start1, $interval1, $end1);
			foreach ($period1 as $dt1) {
				$thn 		= $dt1->format("Y");
				$bln 		= $dt1->format("m");
				// echo"$bln<br>";
				mysql_query("REPLACE INTO waktu_kerja2(`nik`,`id_gca`,`parentId`,`cc`,`bulan`,`tahun`) 
								VALUES('$pic','$id','$parentId','$cc_id','$bln','$thn') ");
			}
		}
		/////////////////////////////////////////////////////////////////////////////////////////
		$start    = new DateTime("$tahun-01-01");
		$start->modify('first day of this month');
		$end      = new DateTime("$tahun-06-01");
		$end->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		$numRow		= 19;
		$jumlahJam 	= 0;
		$jumlahHari	= 0;
		foreach ($period as $dt) {
			$year 		= $dt->format("Y");
			$month 		= $dt->format("m");
			$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$month,$year);
			$day 		= 1;
			
			for ($tgl=1;$tgl<=$lastDay;$tgl++){
				$tgl_kerja 	= $year."-".$month."-".$tgl;
				$tgl_kerja 	= date('Y-m-d', strtotime($tgl_kerja));
				$jam_kerja	= trim($data->val($i, $numRow));
				if($jam_kerja !=0){
					$hari = 1;
					mysql_query("UPDATE waktu_kerja2 SET  `$tgl`='$jam_kerja' WHERE `nik`='$pic' AND `id_gca`='$id' AND `parentId`='$parentId' AND bulan='$month' AND tahun='$year'");
					// echo"$numRow -$tgl_kerja ($jam_kerja)<br>";
				}else{
					$hari = 0;
				}
			$numRow++;
			$jumlahJam += $jam_kerja;
			$jumlahHari += $hari;
			}
			mysql_query("UPDATE waktu_kerja2 SET total_jam='$jumlahJam',total_hari='$jumlahHari' WHERE id_gca='$id' AND `parentId`='$parentId' AND nik='$pic' AND bulan='$month' AND tahun='$year' ");
			$jumlahHari = 0;
			$jumlahJam = 0;
		}
		// echo"<br>";
		
/////////////////////////////////////////////////////////////////////////////////////////
		// $deleteKosong = mysql_query("SELECT id_gca FROM waktu_kerja2 WHERE NOT EXISTS (SELECT id FROM wbs WHERE waktu_kerja2.id_gca=wbs.id) ");
		// while($dK=mysql_fetch_array($deleteKosong)){
			// echo "$dK[id_gca]<br>";
			// mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$dK[id_gca]'");
		// }
///////////////////////////////////////////////////////////////////////////////////////
		$durasi_gca	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$id' AND parentId='$parentId' AND nik='$pic' AND tahun='$tahun'"));
		$query = "REPLACE INTO wbs(`id`,`parentId`,`id_srko`,`aktivitas`,`mulai`,`akhir`,`cc`,`pic`,`deliverable`,`kode_kpi`,`jam`,`durasi`,`tgl_isi`,`gca_by`,`tahun`,`cc_id`,`realisasi`,`hasil_akhir`,`level`,`jenisGCA`,`jenisAktf`,`icon`) 
						VALUES ('$id','$parentId','$id_srko','$aktivitas','$mulai','$akhir','$cc','$pic','$deliverable','$kode_kpi','$jam','$durasi_gca[jum]','$tgl_input','$gca_by','$tahun','$cc_id','0','$hasil_akhir','$level','$jenisGCA','$jenisAktf','$icon')";
		$hasil = mysql_query($query);
    }
    mysql_query("DELETE FROM wbs WHERE id=''");
    mysql_query("DELETE FROM waktu_kerja2 WHERE nik=''");
    if(!$hasil){
		header('Location: ../../page.php?page=data_gca&failed=1');
	}else{
		header('Location: ../../page.php?page=data_gca&succes=1');
    }
    unlink($_FILES['gca']['name']);
}

?>
