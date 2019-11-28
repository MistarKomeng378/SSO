<?php
session_start();

	include"../../config/koneksi.php";
	include"../../config/encript.php";
	include"../../config/fungsi_name.php";
	include"../../config/fungsi_timeline.php";

    // membaca id file dari link
    $id = dc($_GET['id']);
 
    // membaca informasi file dari tabel berdasarkan id nya
    $query  = "SELECT file,type,size FROM pencapaian WHERE id_pencapaian = '$id'";
    $hasil  = mysql_query($query);
    $data 	= mysql_fetch_array($hasil);
	// $name	= $data['file'].".".$data['type'];
	timeline($_SESSION['nik'],"download","Telah melakukan download file $data[file]");
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