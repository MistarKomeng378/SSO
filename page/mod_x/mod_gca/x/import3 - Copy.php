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
		$aktivitas	=$data->val($i, 4);
		$mulai		=$data->val($i, 5);
		$akhir		=$data->val($i, 6);
		$cc			=trim($data->val($i, 7));
		$pic		=trim($data->val($i, 8));
		$deliverable=$data->val($i, 9);
		$bobot		=$data->val($i, 10);
		$kode_kpi	=$data->val($i, 11);
		$jam		=$data->val($i, 12);
		$gca_by		=$data->val($i, 13);
		$tahun		=$data->val($i, 14);
		
		// echo"$id<br>";
		/////////////////////////////////////////////////////////////////////////////////////////
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
			// mysql_query("REPLACE INTO waktu_kerja2_bekup(`nik`,`id_gca`,`bulan`,`tahun`) VALUES('$pic','$id','$bln','$thn') ");
		}
		/////////////////////////////////////////////////////////////////////////////////////////
		$start    = new DateTime("$tahun-07-01");
		$start->modify('first day of this month');
		$end      = new DateTime("$tahun-12-01");
		$end->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		$bulan		= 1;
		$numRow		= 15;
		foreach ($period as $dt) {
			$year 		= $dt->format("Y");
			$month 		= $dt->format("m");
			$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$month,$year);
			$day 		= 1;
			// $numRow		= 15;
			
			for ($tgl=1;$tgl<=$lastDay;$tgl++){
				$tgl_kerja 	= $year."-".$month."-".$tgl;
				$tgl_kerja 	= date('Y-m-d', strtotime($tgl_kerja));
				$jam_kerja	= trim($data->val($i, $numRow));
				if($jam_kerja !=0){
					mysql_query("UPDATE waktu_kerja2_bekup SET  `$tgl`='$jam_kerja' WHERE `nik`='$pic' AND `id_gca`='$id' AND bulan='$month' AND tahun='$year'");
					// echo"$numRow -$tgl_kerja ($jam_kerja)<br>";
				}
			$numRow++;
			}
			$numRow++;
			$bulan++;
		}
		// echo"<br>";
		
/////////////////////////////////////////////////////////////////////////////////////////
		// $deleteKosong = mysql_query("SELECT id_gca FROM waktu_kerja2_bekup WHERE NOT EXISTS (SELECT id FROM wbs_bekup WHERE waktu_kerja2_bekup.id_gca=wbs_bekup.id) ");
		// while($dK=mysql_fetch_array($deleteKosong)){
			// echo "$dK[id_gca]<br>";
			// mysql_query("DELETE FROM waktu_kerja2_bekup WHERE id_gca='$dK[id_gca]'");
		// }
///////////////////////////////////////////////////////////////////////////////////////
      $query = "REPLACE INTO wbs_bekup(`id`, `parentId`, `id_srko`, `aktivitas`, `mulai`, `akhir`, `cc`, `pic`, `deliverable`, `bobot`, `kode_kpi`, `jam`, `tgl_isi`, `gca_by`, `tahun`, `durasi`) 
						VALUES ('$id','$parentId','$id_srko','$aktivitas','$mulai','$akhir','$cc','$pic','$deliverable','$bobot','$kode_kpi','$jam','$tgl_isi','$gca_by','$tahun','$durasi')";
      $hasil = mysql_query($query);
    }
    mysql_query("DELETE FROM wbs_bekup WHERE id=''");
    if(!$hasil){
         header('Location: ../../page.php?page=data_gca&failed=1');
      }else{
           header('Location: ../../page.php?page=data_gca&succes=1');
    }
    unlink($_FILES['gca']['name']);
}

?>
