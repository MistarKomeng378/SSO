<?php 
error_reporting(E_ALL);
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/fungsi_rupiah.php";
    include "../config/fungsi_bulan.php";
    include "../config/fungsi_name.php";
    include "../config/encript.php";
    include "../config/fungsi_timeline.php";
    
	$ex			= explode("-",$_GET['id']);
	$getCC		= mysql_real_escape_string(dc($ex[0]));
	$getTahun	= mysql_real_escape_string(dc($ex[1]));
	$unit		= mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='$getCC' "));
	
	timeline($_SESSION['nik'],"download","Telah melakukan download file Progress SRKO $unit[uraian] Tahun $getTahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Data_SRKO_".$unit['uraian']."_".$getTahun.".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>
			<h4><b>Sasaran/Rencana Kerja Organisasi (SRKO) : <?=$unit['uraian']?> Tahun <?=$getTahun?></b></h4>
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center' bgcolor="#b3d9ff">
						<td  rowspan="2"><b>No.</b></td>
						<td rowspan="2"><b>Sasaran/Rencana Kerja</td>
						<td rowspan="2"><b>Bobot</b></td>
						<td rowspan="2"><b>Target Tahunan</b></td>
						<td colspan="12"><b>Target (Tahun)</b></td>
					</tr>
					<tr align='center' bgcolor="#b3d9ff">
						<?php
						for($i=1;$i<=12;$i++){
							echo"<td align='center'><b>$i</b></td>";
						}
						?>
					</tr>
				</thead>
				<tbody>
				<?php
						// $no=1;
						// $data=0;
						// $query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$getTahun' order by id_srko");
						// while($r=mysql_fetch_array($query)){
							// echo"
							// <tr>
								// <td align='center' rowspan='3'>$no</td>
								// <td  rowspan='3'>$r[rencana_kerja]</td>
								// <td  rowspan='3' align='center'>$r[bobot]</td>
								// <td  rowspan='3' align='center'>$r[target] $r[satuan]</td>";
								// for($i=1;$i<=12;$i++){
								// $target = mysql_fetch_array(mysql_query("SELECT * FROM target_srko WHERE bulan='$i' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									// echo"<td width='5%'>$target[target]";
								// }
						// $no++;
						// $data++;
						// }
						$no=1;
						$data=0;
						$query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$getTahun' order by id_srko");
						while($r=mysql_fetch_array($query)){
							echo"
							<tr>
								<td align='center'>$no</td>
								<td>$r[rencana_kerja]</td>
								<td align='center'>$r[bobot]</td>
								<td>$r[target] $r[satuan]</td>";
								for($i=1;$i<=12;$i++){
									$target = mysql_fetch_array(mysql_query("SELECT * FROM target_srko WHERE bulan='$i' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
									echo"<td width='5%'>$target[target]";
							}
						echo"</tr>
							";
						$no++;
						$data++;
						}
				?>
				</tbody>
				
				
			</table>
		