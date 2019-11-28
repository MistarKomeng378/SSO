<?php
// function name($nik){
	// $name 	= mysql_fetch_array(mysql_query("SELECT name FROM m_karyawan WHERE regno='$nik'"));
	// $nama	= $name['name'];
	// return($nama);
// }
	
function timeline($nik,$aksi,$text){
	if($aksi=="tambah"){
		$icon = "add";
	}elseif($aksi=="edit"){
		$icon = "edit";
	}elseif($aksi=="delete"){
		$icon = "delete";
	}elseif($aksi=="generate"){
		$icon = "generate";
	}elseif($aksi=="cari"){
		$icon = "search";
	}elseif($aksi=="download"){
		$icon = "download";
	}elseif($aksi=="open"){
		$icon = "open";
	}elseif($aksi=="login"){
		$icon = "login";
	}elseif($aksi=="logout"){
		$icon = "logout";
	}elseif($aksi=="approve"){
		$icon = "approve";
	}elseif($aksi=="return"){
		$icon = "return";
	}
	$name	= name($nik);
	$date	= date("Y-m-d H:i:s");
	$date2	= date("Y m d");
	$no_time 	= mysql_query("SELECT MAX(no_timeline) as maxKode FROM timeline WHERE DATE_FORMAT(time,'%Y %m %d')='$date2' " );
	$data  		= mysql_fetch_array($no_time);	
	$kode		= $data['maxKode'];
	$noUrut 	= (int) substr($kode, 6, 4);
	$noUrut++;
	$kodeBaru 	= date("ymd").sprintf("%04s", $noUrut);
	
	$isitimeline = "$nik - $name telah melakukan $text";
	$timeline = mysql_query("INSERT INTO timeline(`no_timeline`,`nik`,`time`,`aksi`,`icon`) 
						VALUES ('$kodeBaru','$nik','$date','$isitimeline','$icon')");
	return $kodeBaru;	
}

// echo timeline(90496,"tambah","pencapaian_kerja");
?>