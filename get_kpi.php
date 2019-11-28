<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include"config/koneksi.php";
		
	if(!empty($_GET['rencana_kerja'])){
		$query = mysql_query("SELECT  * FROM srko WHERE id_srko='$_GET[rencana_kerja]'");
		$r=mysql_fetch_array($query);
		$kpi = mysql_fetch_array(mysql_query("SELECT * FROM kpi WHERE id_kpi='$r[id_kpi]'"));
			echo "<input type='text' name='kpi_rinci' value='$kpi[kpi]' class='form-control' readonly>";
			echo "<input type='hidden' name='kpi' value='$r[id_kpi]' class='form-control'>";
			echo "<input type='hidden' name='perspektif' value='$r[perspektif]' class='form-control'>";
			echo "<label for='kpm'>KPM</label>
					<input type='text' name='kpm' value='$r[rencana_kerja]' class='form-control'>";
		
		

	}
?>