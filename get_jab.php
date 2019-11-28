<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include"config/koneksi.php";
		$getdept 	= mysql_real_escape_string($_GET['dept']);
		$ex			= explode("-",$getdept);
		$dept		= $ex[1];
		echo"<label for='jab'>Jabatan</label>
				<select name='jab' class='form-control required'>
					<option name=''>-Pilih Jabatan-</option>";
				
				$jab = mysql_query("SELECT * FROM m_jabatan WHERE dept='$dept'");
				while($r=mysql_fetch_array($jab)){
					echo"<option value='$r[poscode]'>$r[posdesc] </option>";
				}
		echo"</select>";
?>