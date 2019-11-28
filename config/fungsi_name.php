<?php
	function name($nik){
		$name 	= mysql_fetch_array(mysql_query("SELECT name FROM m_karyawan WHERE regno='$nik'"));
		$nama	= $name['name'];
		return($nama);
	}
	function jabatan($nik){
		$jabatan 	= mysql_fetch_array(mysql_query("SELECT	m_jabatan.posdesc as jabatan,
														m_karyawan.regno
														FROM
														m_karyawan
														INNER JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode 
														WHERE m_karyawan.regno='$nik'"));
		$jabatan	= $jabatan['jabatan'];
		return($jabatan);
	}
	function jab($poscode){
		$jabatan 	= mysql_fetch_array(mysql_query("SELECT	posdesc FROM m_jabatan WHERE poscode='$poscode'"));
		$jabatan	= $jabatan['posdesc'];
		return($jabatan);
	}
	function foto($nik){
		$foto 	= mysql_fetch_array(mysql_query("SELECT	file FROM user WHERE nik='$nik'"));
		$foto	= $foto['file'];
		return($foto);
	}
?>