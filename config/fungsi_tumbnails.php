<?php
function Upload($uploadName,$nik){
    $direktori          = "../../upload/foto/";
    $direktoriThumb     = "../../upload/thumbs/";
    $file               = $direktori.$uploadName;
    
    //simpan gambar ukuran sebenernya
    $realImagesName     = $_FILES['foto']['tmp_name'];
    move_uploaded_file($realImagesName, $file);
    
    //identitas file gambar
    $realImages             = imagecreatefromjpeg($file);
    $width                  = imageSX($realImages);
    $height                 = imageSY($realImages);
    
    //simpan ukuran thumbs
    $thumbWidth     = 150;
    $thumbHeight    = ($thumbWidth / $width) * $height;
    
    //mengubah ukuran gambar
    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresampled($thumbImage, $realImages, 0,0,0,0, $thumbWidth, $thumbHeight, $width, $height);
    
    //simpan gambar thumbnail
	$newName = rename($uploadName,$nik);
    imagejpeg($thumbImage,$direktoriThumb."thumb_".$nik.".jpeg");
    
    //hapus objek gambar dalam memori
    imagedestroy($realImages);
    imagedestroy($thumbImage);
	unlink($direktori.$uploadName);
}

?>