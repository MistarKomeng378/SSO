<?php
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_rupiah.php";
include"../../config/encript.php";

// $getBulan	= mysql_real_escape_string($_POST['bulan']);
// $getTahun	= mysql_real_escape_string($_POST['tahun']) ;
error_reporting(0);
$ex				= explode("-",$_POST['id']);
$getCc			= dc($ex[0]); //1
$getIdSrko		= dc($ex[1]); //2
$getTahun		= dc($ex[2]); //3
//$getBulan		= dc($ex[3]); //4


?>	
		
	<div class="panel panel-inverse">
		<div class="panel-body">		
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr align='center'>
						<td  rowspan="2"><b>No.</b></td>
						<td rowspan="2"><b>Sasaran/Rencana Kerja</td>
						<td rowspan="2"><b>Bobot</b></td>
						<td rowspan="2"><b>Target Tahunan</b></td>
						<td colspan="12"><b>Target Bulanan</b></td>
					</tr>
					<tr align='center'>
						<?php
						for($i=1;$i<=12;$i++){
							echo"<td align='center'><b>$i</b></td>";
						}
						?>
					</tr>
				</thead>
				<?
				$no=1;
				$query = mysql_query("SELECT DISTINCT id_srko, cc, tahun, parent_srko FROM target_srko WHERE tahun='$getTahun' AND cc='$getCc' AND parent_srko='$getIdSrko'");
					while($r=mysql_fetch_array($query)){
						$Srko = mysql_fetch_array(mysql_query("SELECT * FROM srko where id_srko=$r[id_srko]"));
						echo"
						<tr>
							<td align='center'>$no</td>
							<td>$Srko[rencana_kerja]</td>
							<td align='center'>$Srko[bobot]</td>
							<td>$Srko[target] $Srko[satuan]</td>";
							for($i=1;$i<=12;$i++){
								// $TargetParent = mysql_fetch_array(mysql_query("select * from target_srko_detile where id_srko='$getIdSrko' AND tahun='$getTahun' AND bulan='$i'"));
								$TargetSub = mysql_fetch_array(mysql_query("select * from target_srko where id_srko='$r[id_srko]' AND tahun='$getTahun' AND bulan='$i' AND target!=''"));
																
								echo"<td width='5%'>&nbsp;&nbsp;".desimal3($TargetSub['target'])."</td>";
							}
					echo"
						</tr>
						";
					$no++;
					}
					
					// echo "$getCc -> $getIdSrko -> $getTahun";
					
				?>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
	
	
