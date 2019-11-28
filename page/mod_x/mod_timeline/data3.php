<?php
	session_start();
	include '../../config/koneksi.php';
	include '../../config/encript.php';
	
	header("Content-type:application/json");
	
	if(isset($_GET['th'])){
		if($_GET['th']=="all"){
			$where = "";
		}else{
			$where = "WHERE DATE_FORMAT(time,'%Y')='".mysql_real_escape_string(dc($_GET['th']))."'";
		}
	}else{
		$where = "WHERE DATE_FORMAT(time,'%Y')='$_SESSION[tahun]'";
	}
	if(isset($_GET['id'])){
		if($_GET['id']==""){
			$nik = "";
		}else{
			if($_GET['th']=="all"){
				$nik = "WHERE nik='".mysql_real_escape_string(dc($_GET['id']))."'";
			}else{
				$nik = "AND nik='".mysql_real_escape_string(dc($_GET['id']))."'";
			}
		}		
	}
	
	$result = array();
	// $rs = mysql_query("SELECT no_timeline, nik,aksi,DATE_FORMAT(time, '%Y-%m-%d') as time,DATE_FORMAT(time, '%Y-%m-%d') as time2, icon FROM timeline $where");
	$rs = mysql_query("SELECT no_timeline, nik, aksi,time,time as time2,icon FROM timeline $where $nik");
	// $rs = mysql_query("SELECT no_timeline, nik, aksi,time,time as time2,icon FROM timeline $where");
	while($row = mysql_fetch_array($rs)){
		array_push($result, $row);
	}

	echo json_encode($result);
?>