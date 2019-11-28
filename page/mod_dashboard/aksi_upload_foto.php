<?php
include"../../config/koneksi.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_tumbnails.php";
include"../../config/fungsi_timeline.php";

	$nik		= $_POST['nik'];
	$fileName	= $_FILES['foto']['name'];      
	$tmpName 	= $_FILES['foto']['tmp_name']; 
	$fileSize 	= $_FILES['foto']['size'];
	$fileType 	= $_FILES['foto']['type'];
	$folder	= "../../upload/foto/$fileName";
	
	$maxsize = 1024 * (1024*3) ;
	$valid_ext 	= array('jpg','jpeg');
	$ext = strtolower(end(explode('.', $_FILES['foto']['name'])));
	
	
if($fileName == ".htaccess"){
	echo"<SCRIPT language='javascript'>alert('Hayo mau Upload apa..??');document.location='../../page.php?page=dashboard'</SCRIPT>";
}else{
	if($fileType == "php"){
		echo"<SCRIPT language='javascript'>alert('Hayo mau Upload apa..??');document.location='../../page.php?page=dashboard'</SCRIPT>";
	}else{
		if (file_exists($folder)) {
			echo"<SCRIPT language='javascript'>alert('Maaf file yang anda upload sudah ada ..!');document.location='../../page.php?page=dashboard'</SCRIPT>";
		}else{
			if($fileSize <= $maxsize){	
				if(in_array($ext, $valid_ext)){
					echo"$maxsize-$nik-$fileType-$fileSize";
					mysql_query("UPDATE `user` SET file='$nik.jpeg', type='$fileType', size='$fileSize' WHERE nik='$nik' ");
					
					Upload($fileName,$nik);
					timeline($nik,"tambah","Telah menambahkan foto profile");
					
					header("Location: ../../page.php?page=dashboard");
				}else{
					echo"<SCRIPT language='javascript'>alert('Format gambar harus JPG..!!');document.location='../../page.php?page=dashboard'</SCRIPT>";
				}
			}else{
				echo"<SCRIPT language='javascript'>alert('Maaf file yang anda upload terlalu besar, maksimal 3 Mb ..!');document.location='../../page.php?page=dashboard'</SCRIPT>";
			}
		}
	}
}
?>