<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include"config/koneksi.php";
		$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".date('Y')."'"));
		if($_COOKIE['tahun_srko']==""){
			$tahun_srko 	= $thn['tahun'];
			$idtahun_srko 	= $thn['id_tahun'];
		}else{
			$tahun_srko 	= $_COOKIE['tahun_srko'];
			$idtahun_srko	= $_COOKIE['idtahun_srko'];
		}
		
		$getdept 	= mysql_real_escape_string($_GET['dept']);
		$ex			= explode("-",$getdept);
		$dept		= $ex[1];
		echo"<label for='srko'>SRKO</label>
				<select name='srko' class='form-control required'>
					<option value=''>--Pilih SRKO--</option>";
				//$null = null;
				$jab = mysql_query("SELECT * FROM srko WHERE CostCenter='$dept' AND tahun='$tahun_srko' AND parent_srko=''");
				while($r=mysql_fetch_array($jab)){
					echo"<option value='$r[id_srko]'>$r[rencana_kerja] </option>";
				}
		echo"</select>";
?>