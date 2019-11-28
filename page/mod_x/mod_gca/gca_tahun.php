<?php
	session_start();
	include"../../config/koneksi.php";
	include"../../config/encript.php";
	include"../../config/fungsi_bulan.php";
	$ex		= explode("-",$_POST['id']);
	$tahun	= dc($ex[1]);
	$nik	= dc($ex[0]);
	$cc		= dc($ex[2]);
?>
<h4>GCA ANDA PADA TAHUN <?=$tahun?></h4>
<!--
<table width="50%">
	<tr>
		<td width="5%" bgcolor="#80ff80"></td>
		<td> Telah di realisasikan pada bulan tersebut</td>
		<td width="5%" bgcolor="#ff9999"></td>
		<td> Belum di realisasikan / Tidak ada realisasi pada bulan tersebut</td>
	</tr>
</table><br>
-->
<div class="table-responsive">
<table width="100%" border="1" cellpadding="3" style="color:#000000">
	<thead>
		<tr align="center" bgcolor="#ccd9ff">
			<td rowspan="2"> <b >NO.</b></td>
			<td rowspan="2"> <b >AKTIFITAS</b></td>
			<td rowspan="2"> <b >CC</b></td>
			<td colspan="12"> <b >JAM</b></td>
		</tr>
		<tr align="center" bgcolor="#ccd9ff">
			<?php
				for($i=1;$i<=12;$i++){
					echo"<td width='5%'><b>".STRTOUPPER(bulan($i))."</b></td>";
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			$query = mysql_query("SELECT id,aktivitas,cc FROM wbs WHERE tahun='$tahun' AND pic='$nik'");
			while($r=mysql_fetch_array($query)){
				echo"
				<tr>
					<td align='center'>$no</td>
					<td>$r[aktivitas]</td>
					<td align='center'>$r[cc]</td>
				";
					for($i=1;$i<=12;$i++){
						// $kkwk = mysql_num_rows(mysql_query("SELECT jo_gca FROM pencapaian WHERE jo_gca='$r[id]' AND nik='$nik' AND date_format(tgl_aktifitas,'%c %Y ')='$i $tahun'  "));
						// if($i <= date("m")){
							// if($kkwk > 0){
								// $bgcolor = "#80ff80";
							// }else{
								// $bgcolor = "#ff9999";
							// }							
						// }else{
							// $bgcolor = "#ffffff";
						// }
						$wk = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jam FROM waktu_kerja2 WHERE nik='$nik' AND id_gca='$r[id]' AND tahun='$tahun' AND bulan='$i' "));
						echo"<td align='center' bgcolor=''>$wk[jam]</td>";
						// echo"<td align='center' bgcolor='$bgcolor'>$wk[jam]</td>";
					}
				echo"
				</tr>
				";
				$no++;
			}
		?>
	</tbody>
</table>
</div>
