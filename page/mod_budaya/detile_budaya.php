<?php
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_rupiah.php";
include"../../config/encript.php";

// $getBulan	= mysql_real_escape_string($_POST['bulan']);
// $getTahun	= mysql_real_escape_string($_POST['tahun']) ;

$ex				= explode("-",$_POST['id']);
$getNik			= dc($ex[0]);
$getName		= dc($ex[1]);
$getCc			= dc($ex[2]);
$getThnNow		= dc($ex[3]);
$sql			= mysql_fetch_array(mysql_query("SELECT * FROM penilaian_kerja WHERE nik='$getNik' group by nik")); 
$jabatan		= $sql['jabatan'];
$div= mysql_fetch_array(mysql_query("select * from mskko where CostCenter='".$getCc."'"));

?>	
		
			<div class="panel panel-inverse">
			    <div class="panel-body">
	
					<?php
						$query = mysql_query("SELECT * FROM nilai_budaya WHERE nik='$getNik' AND tahun='$getThnNow'");						
						$tnbud2		= 0;
						while($r2=mysql_fetch_array($query)){
							$dbud2 			= mysql_fetch_array(mysql_query("SELECT * FROM budaya WHERE id='$r2[id_budaya]'"));
							$jnbud2 		= $dbud2['bobot'] * $r2['nilai'];
							$tnbud2 		+= $jnbud2;						
						}						
						$total2	 			=$tnbud2;
					?>	
	
		
		<table border="0" width="100%">
			<tr> 
				<td width="10%">NIK/Nama</td>
				<td>:</td>
				<td><b><?=$getNik?>/<?=name($getNik) ?></b></td>
				<td rowspan="3" align="right">
					<?php
						// echo" <a href='print/print_penilaian_kerja.php?nik=".ec($getNik)."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Cetak</a>";
						
						echo" <a href='print/print_penilaian_prilaku.php?nik=".ec($getNik)."&CostCenter=".ec($getCc)."&tahun=".ec($getThnNow)."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Cetak</a>";
						
						
					?> &nbsp;&nbsp;
				</td>
			</tr>
			<tr> 
				<td>Jabatan</td>
				<td>:</td>
				<td><b><?=$jabatan?></b></td>
			</tr>
			<tr> 
				<td>Divisi</td>
				<td>:</td>
				<td><b><?=$div['uraian']?></b></td>
			</tr>
			<tr> 
				<td>Nilai</td>
				<td>:</td>
				<td><b><font size="3"><?=desimal_float($total2)?></font></b></td>
			</tr>
		</table>
		<br>
		
		<table class="table table-bordered table-striped table-hover">
				<thead>
					<th width="10%">No.</th>
					<th colspan="2">Prilaku</th>
					<th>Bobot</th>
					<th>Nilai</th>
					<th>Jumlah</th>
				</thead>
				<tbody>
					<?php
						$query = mysql_query("SELECT * FROM nilai_budaya WHERE nik='$getNik' AND tahun='$getThnNow'");						
						$i=1;
						$tnbud		= 0;
						while($r=mysql_fetch_array($query)){
							$dbud 		= mysql_fetch_array(mysql_query("SELECT * FROM budaya WHERE id='$r[id_budaya]'"));
							$jnbud 		= $dbud['bobot'] * $r['nilai'];
							$tnbud 		+= $jnbud;
							echo"
								<tr>
									<td align='center'>$i</td>
									<td><i>$dbud[prilaku]</i></td>
									<td>$dbud[ket]</td>
									<td align='center'>$dbud[bobot]</td>
                                    <td align='center'>$r[nilai]</td>
                                    <td align='center'>$jnbud</td>
									
								</tr>
							";
							$i++;
						}						
						$total	 	= $tnbud;	
					?>	
								<tr>
									<td colspan="2" align="right"><b>TOTAL</b></td>
									<td align="center">&nbsp;</td>
									<td align="center" colspan="2"><b></b></td>
									<td align="center"><b><?=desimal_float($total)?></b></td>
								</tr>	
				</tbody>
			</table>
		</div>
	</div>
	
	
