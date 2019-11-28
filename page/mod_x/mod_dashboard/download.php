<?php
 
	include"../../config/koneksi.php";
	include"../../config/encript.php";
	include"../../config/fungsi_name.php";
	include"../../config/fungsi_timeline.php";
    // membaca id file dari link
	$ex  = explode("-",$_GET['id']);
    $id  = dc($ex[0]);
    $nik = dc($ex[1]);
	
    // membaca informasi file dari tabel berdasarkan id nya
    $query  = "SELECT * FROM resource_file WHERE id_resource = '$id'";
    $hasil  = mysql_query($query);
    $data 	= mysql_fetch_array($hasil);
	// $name	= $data['file'].".".$data['type'];
	timeline($nik,"download","download file $data[file] dengan id $id pada dashboard");
    // header yang menunjukkan nama file yang akan didownload
    header("Content-Disposition: attachment; filename=".$data['file']);
 
    // header yang menunjukkan ukuran file yang akan didownload
    header("Content-length: ".$data['size']);
 
    // header yang menunjukkan jenis file yang akan didownload
    header("Content-type: ".$data['type']);
 
   // proses membaca isi file yang akan didownload dari folder 'data'
   $fp  = fopen("../../upload/".$data['file'], 'r');
   $content = fread($fp, filesize('../../upload/'.$data['file']));
   fclose($fp);
 
   // menampilkan isi file yang akan didownload
   echo $content;
 
   exit;
?>