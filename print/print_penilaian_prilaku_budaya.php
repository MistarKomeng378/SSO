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
	
	timeline($_SESSION['nik'],"download","Telah melakukan download Penilaian Budaya $unit[uraian] Tahun $getTahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Penilaian Prilaku Budaya ".$unit['uraian']."_".$getTahun.".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>			

			
			<h4 align="center"><b>Penilaian Prilaku (Budaya Kerja) Karyawan Tahun <?=$getTahun?></b></h4>			
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center' bgcolor="#b3d9ff">
						<td width="35" height="30" valign="center"><b>No.</b></td>
						<td width="100"><b>NIK</b></td>
						<td width="350"><b>Nama Karyawan </b></td>
						<td width="150"><b>Unit </b></td>
						<td width="150"><b>Status </b></td>
						<td width="75"><b>Jumlah</b></td>
						<td width="150"><b>Penilai</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
						
						$no=1;
						if(isset($unit['CostCenter'])){
							$query = mysql_query("SELECT * FROM user where cc='$getCC' AND level !='4'");
						}else{						
							$query = mysql_query("SELECT * FROM user where level !='2' AND level !='3' AND level !='4' order by cc ASC ");
						}
						while($r=mysql_fetch_array($query)){
							$cc= mysql_fetch_array(mysql_query("select * from mskko where CostCenter='".$r['cc']."'"));
						
							$nbud= mysql_fetch_array(mysql_query("select * from nilai_budaya where nik='".$r['nik']."' AND tahun='".$getTahun."'"));
							if($nbud['nik']==''){
								$sk = "?";
							}else{
								$sk = "Sudah DiInput";
							}
							
							//===========================================================================//
							$budaya = mysql_query("SELECT * FROM nilai_budaya WHERE nik='$r[nik]' AND tahun='$getTahun'");						
							$tnbud2		= 0;
							while($r2=mysql_fetch_array($budaya)){
								$dbud2 			= mysql_fetch_array(mysql_query("SELECT * FROM budaya WHERE id='$r2[id_budaya]'"));
								$jnbud2 		= $dbud2['bobot'] * $r2['nilai'];
								$tnbud2 		+= $jnbud2;						
							}						
							$total2	 			=$tnbud2;
							$penilai 			= mysql_fetch_array(mysql_query("SELECT DISTINCT pm from nilai_budaya where nik='".$r['nik']."' AND tahun='$getTahun'"));
							$nm_penilai 		= mysql_fetch_array(mysql_query("SELECT * from user where nik='".$penilai['pm']."'"));
							
							
							echo"
							<tr>
								<td align='center'>$no</td>
								<td align='center'>'$r[nik]</td>
								<td >$r[name]</td>
								<td align='center'>$cc[uraian]</td>
								<td align='center'>$sk</td>
								<td>".desimal($total2)."</td>
								<td>$nm_penilai[name]</td>
							</tr>
							";
						$no++;
						}
				?>
				</tbody>
				
				
			</table>
		