<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include"config/koneksi.php";
		
	if(isset($_GET['jo_gca'])){
		$cek_gca 	= mysql_query("SELECT * FROM wbs WHERE id='$_GET[jo_gca]'");
		$cek_jo 	= mysql_query("SELECT * FROM job_order WHERE id_jo='$_GET[jo_gca]'");
		
		$hit_gca	= mysql_num_rows($cek_gca);
		$hit_jo		= mysql_num_rows($cek_jo);
		
		if($hit_gca >=1){
			echo"<input type='text' name='faktor' value='A' class='form-control'>";
		}elseif($hit_jo >=1){
			echo"<input type='text' name='faktor' value='B' class='form-control'>";
		}
		
	}
?>