<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include"config/koneksi.php";
	if($_GET['sts_shift']==1){
		echo"<label for='jam_shift'>Jam Shift</label>
				<select name='jam_shift' class='form-control required' id='jam_shift'>
					<option name=''>-Jam Shift-</option>";
				$id=1;
				$getShift = mysql_query("SELECT * FROM jam_shift ORDER BY id_jam ASC");
				while($r=mysql_fetch_array($getShift)){
					echo"<option value='$r[id_jam]'>$id :: $r[jam_mulai] - $r[jam_selesai]</option>";
					$id++;
				}
		echo"</select>";
	}
?>