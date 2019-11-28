<?php
include"../../config/koneksi.php";
include"../../config/fungsi_tumbnails.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_timeline.php";
	$nik		= $_POST['nik'];
	$fileName	= $_FILES['foto']['name'];      
	$tmpName 	= $_FILES['foto']['tmp_name']; 
	$fileSize 	= $_FILES['foto']['size'];
	$fileType 	= $_FILES['foto']['type'];
	// $fileType 	= pathinfo($fileName,PATHINFO_EXTENSION);
	$folder	= "../../upload/foto/$fileName";
	// echo"$fileName<br>";
	// echo"$tmpName<br>";
	// echo"$fileSize<br>";
	// echo"$fileType<br>";
	
	$maxsize = 1024 * (1024*3) ;
	$valid_ext 	= array('jpg','jpeg');
	$ext = strtolower(end(explode('.', $_FILES['foto']['name'])));
	
	// echo"$maxsize-";
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
					mysql_query("UPDATE user SET file='$nik.jpeg', type='$fileType', size='$fileSize' WHERE nik='$nik' ");
					timeline($nik,"edit","mengganti foto profil");
					Upload($fileName,$nik);
					// move_uploaded_file($tmpName,$folder);
					
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