<?php
//memanggil file excel_reader
require "../../config/excel_reader.php";
require "../../config/koneksi.php";

//jika tombol import ditekan
if(isset($_POST['submit'])){

    $target = basename($_FILES['fileSrko']['name']) ;
    move_uploaded_file($_FILES['fileSrko']['tmp_name'], $target);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['fileSrko']['name'],false);
    
//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);
    
//    jika kosongkan data dicentang jalankan kode berikut
    $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
    if($drop == 1){
//             kosongkan tabel pegawai
             $truncate ="TRUNCATE TABLE srko";
             mysql_query($truncate);
    };
    
//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i=2; $i<=$baris; $i++)
    {
//       membaca data (kolom ke-1 sd terakhir)
		$id_srko		=$data->val($i, 1);		
		$perspektif		=$data->val($i, 2);
		$kpm			=$data->val($i, 3);
		$id_kpi			=$data->val($i, 4);
		$bobot			=$data->val($i, 5);
		$satuan			=$data->val($i, 6);
		$target			=$data->val($i, 7);
		$rencana_kerja	=$data->val($i, 8);
		$pic			=$data->val($i, 9);
		$integrasi		=$data->val($i, 10);
		$tahun			=$data->val($i, 11);
		$hasil_akhir	=$data->val($i, 12);		
		$CostCenter		=$data->val($i, 13);
		
	// echo"$perspektif - $kpm - $id_kpi - $bobot - $satuan - $target - $rencana_kerja - $tahun - $hasil_akhir - $CostCenter<br>";
	// echo"$perspektif<br>";
//      setelah data dibaca, masukkan ke tabel pegawai sql
      $query = "INSERT INTO srko(`id_srko`, `CostCenter`, `tahun`, `perspektif`, `kpm`, `id_kpi`, `bobot`, `satuan`, `target`, `rencana_kerja`, `hasil_akhir`,`pic`,`integrasi`) 
	  VALUES ('$id_srko','$CostCenter','$tahun','$perspektif','$kpm','$id_kpi','$bobot','$satuan','$target','$rencana_kerja','$hasil_akhir','$pic','$integrasi')";
	  $hasil = mysql_query($query);
	  mysql_query("DELETE FROM srko WHERE CostCenter='' AND tahun='' ");
    }
    
    if(!$hasil){
         // jika import gagal
         header('Location: ../../page.php?page=data_srko&failed=1');
      }else{
         // jika impor berhasil
           header('Location: ../../page.php?page=data_srko&succes=1');
    }
    
//    hapus file xls yang udah dibaca
    unlink($_FILES['fileSrko']['name']);
}

?>
