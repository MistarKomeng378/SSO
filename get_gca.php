<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include"config/koneksi.php";
	
	if(isset($_GET['mulai'])){
		$count = count(explode(",",$_GET['mulai']));
		$ex = explode(",",$_GET['mulai']);
		
		echo"
		<h5><b>Jam yang sudah diinput pada tanggal yang sama</b></h5>
		<table border='1' cellpadding='5' >";
		for($i=0;$i<$count;$i++){
			$ex2 = explode("/",$ex[$i]);
			$tgl = $ex2[2]."-".$ex2[0]."-".$ex2[1];
			echo"<tr>
					<td>$tgl $_GET[nik2]</td>";
					$query = mysql_query("SELECT * FROM waktu_kerja WHERE tgl_kerja='$tgl' AND nik='$_GET[nik2]'");
					while($r=mysql_fetch_array($query)){
						$jumlah = mysql_fetch_array(mysql_query("SELECT count(jam_kerja) as jml FROM waktu_kerja WHERE tgl_kerja='$r[tgl_kerja]' AND nik='$r[nik]'"));
						echo"<td><input type='text' name='jam_lama[]' value='$r[jam_kerja]' size='2'></td>";
							echo"<td><input type='text' name='jam_baru[]' value='$jumlah[jml]' size='2'></td>";
						// for($c=1;$c<=8;$c++){
							// echo"<td><input type='text' name='jam_lama[]' value='' size='2'></td>";
						// }
					}
						// echo"<td><input type='text' name='jam_baru[]' value='' size='2'></td>";
			echo"</tr>";
		}
		echo"</table";
	}
?>