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
<h4>GCA BELUM DIREALISASIKAN PADA TAHUN <?=$tahun?></h4>
<div class="table-responsive">
<table width="100%" border="1" cellpadding="3" style="color:#000000">
	<thead>
		<tr align="center" bgcolor="#ccd9ff">
			<td rowspan="2" width="3%"> <b >NO.</b></td>
			<td rowspan="2" width="5%"> <b >ID</b></td>
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
			$query = mysql_query("SELECT DISTINCT
										wbs.id,
										wbs.aktivitas,
										wbs.cc
										FROM
										wbs
										WHERE wbs.pic='$nik' AND tahun='$tahun' 
										AND NOT EXISTS (SELECT jo_gca FROM pencapaian WHERE pencapaian.jo_gca = wbs.id AND pencapaian.nik=wbs.pic)");
			while($r=mysql_fetch_array($query)){
				echo"
				<tr>
					<td align='center'>$no</td>
					<td align='center'>$r[id]</td>
					<td>$r[aktivitas]</td>
					<td align='center'>$r[cc]</td>
				";
					for($i=1;$i<=12;$i++){
						if($i < date("m")){
							$bgcolor = "#ff9999";
						}else{
							$bgcolor = "#ffffff";
						}
						$wk = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jam FROM waktu_kerja2 WHERE nik='$nik' AND id_gca='$r[id]' AND tahun='$tahun' AND bulan='$i' "));
						echo"<td align='center' bgcolor='$bgcolor'>$wk[jam]</td>";
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