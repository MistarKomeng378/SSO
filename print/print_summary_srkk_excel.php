<?php 
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/fungsi_rupiah.php";
    include "../config/fungsi_bulan.php";
    include "../config/encript.php";
	include "../config/fungsi_name.php";
	include "../config/fungsi_timeline.php";
	
	@$ex			= explode("-",$_GET['id']);
	@$getTahun		= mysql_real_escape_string(dc($ex[0]));
	@$getLevel		= mysql_real_escape_string($ex[1]);
	@$getnik		= mysql_real_escape_string(dc($ex[2]));
	@$getUnit		= mysql_real_escape_string(dc($_GET['unit']));	
	
	timeline($_SESSION['nik'],"download","Telah melakukan download Summary SRKK  $getUnit Tahun $getTahun");
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Summary_SRKK_".$getTahun.".xls");//ganti nama sesuai keperluan
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<center>
	<h3>SUMMARY MSKK <?php $uraian=mysql_fetch_array(mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$getUnit'")); if(!empty($getUnit)){echo"".strtoupper($uraian['uraian'])."";}?><br>
	PERIODE <?=$getTahun?>
	</h3>

</center><br>
<table width="100%" border="1" cellpadding="3" style="color:#000000">
		<thead>
			<tr align="center">
				<td width="3%"><b>No</b></td>
				<td width="5%"><b>NIK</b></td>
				<td width="18%"><b>Nama</b></td>
				<td width="8%"><b>Jumlah SRKK / Tahun</b></td>
				<?php
					for($i=1;$i<=12;$i++){
						echo"<td align='center' width='6%'>".bulan($i)."</td>";
					}
				?>
			</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			if(!empty($getUnit)){
				$unit="AND mskko.CostCenter='$getUnit'";
			}else{
				$unit="";
			}
			if($getLevel==4){
				$query = mysql_query("SELECT m_karyawan.regno as nik,
																		m_karyawan.`name`,
																		m_karyawan.`status`,
																		mskko.CostCenter AS cc,
																		`user`.`level`
																		FROM
																		m_karyawan
																		INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																		LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																		INNER JOIN `user` ON `user`.nik = m_karyawan.regno
																		WHERE `user`.`level`!='2' 
																		AND `user`.`level`!='3' 
																		AND mskko.id !='1.6' 
																		AND mskko.CostCenter='$getUnit' 
																		AND m_karyawan.regno NOT LIKE '%DM%' 
																		AND m_karyawan.status='0'
																		ORDER BY regno");
			}elseif($getLevel==5){
				$query = mysql_query("SELECT m_karyawan.regno as nik,
																		m_karyawan.`name`,
																		m_karyawan.`status`,
																		mskko.CostCenter AS cc,
																		`user`.`level`
																		FROM
																		m_karyawan
																		INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																		LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																		INNER JOIN `user` ON `user`.nik = m_karyawan.regno
																		WHERE  `user`.`level`!='2' 
																		AND `user`.`level`!='3' 
																		AND mskko.id !='1.6' 
																		AND m_karyawan.regno='$getnik' 
																		AND m_karyawan.status='0'
																		ORDER BY regno");

			}else{
				$query = mysql_query("SELECT m_karyawan.regno as nik,
																		m_karyawan.`name`,
																		m_karyawan.`status`,
																		mskko.CostCenter AS cc,
																		`user`.`level`
																		FROM
																		m_karyawan
																		INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																		LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																		INNER JOIN `user` ON `user`.nik = m_karyawan.regno
																		WHERE `user`.`level`!='2' 
																		AND `user`.`level`!='3' 
																		AND mskko.id !='1.6' 
																		AND m_karyawan.regno NOT LIKE '%DM%' 
																		AND m_karyawan.status='0' $unit 
																		ORDER BY regno");
			}
			while($r=mysql_fetch_array($query)){
				$TotalSRKK	= mysql_num_rows(mysql_query("SELECT id_gca FROM srkk WHERE nik='$r[nik]' AND tahun='$getTahun' "));
					echo"
						<tr>
							<td align='center'>$no</td>
							<td align='center'>'$r[nik] </td>
							<td>$r[name] </td>
							<td align='center'>$TotalSRKK</td>";
							for($i=1;$i<=12;$i++){
								$JmlSRKK	= mysql_num_rows(mysql_query("SELECT id_gca FROM srkk_bulanan WHERE nik='$r[nik]' AND bulan='$i' AND tahun='$getTahun' "));
								echo"<td align='center'>$JmlSRKK</td>";
							}
				echo"</tr>";
				$no++;				
			}
		?>
	</tbody>
</table>
		