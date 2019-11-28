<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
ob_start();
session_start();
include"config/koneksi.php";
include"config/encript.php";
if(isset($_GET['tgl'])){
?>
<table class="table" >
	<thead>
		<tr>
			<th width="3%" >No</th>
			<th width="3%" >Pilih GCA</th>
			<th>Aktifitas</th>
			<th>Cost Center</th>
			<th width="3%" >Jam</th>			
			<th>Deliverable</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$no=1;
		$hari	= date('j', strtotime(dc($_GET['tgl'])));
		$bulan	= date('n', strtotime(dc($_GET['tgl'])));
		$tahun	= date('Y', strtotime(dc($_GET['tgl'])));
		
		$query = mysql_query("SELECT	waktu_kerja2.nik,
										waktu_kerja2.id_gca,
										waktu_kerja2.`$hari`,
										wbs.aktivitas,
										wbs.cc,
										wbs.deliverable
								FROM
										waktu_kerja2
								INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca
								WHERE 
									waktu_kerja2.nik='$_SESSION[nik]'
									AND wbs.`pic` ='$_SESSION[nik]'
									AND wbs.`jenisGCA` ='2'
									AND waktu_kerja2.bulan='$bulan' 
									AND waktu_kerja2.`$hari`>='1' 
									AND waktu_kerja2.tahun='$tahun'
							");
		while($r=mysql_fetch_array($query)){
			echo"
			<tr>
				<td>$no</td>
				<td><input type='checkbox' value='$r[id_gca]' name='id_gca[]'></td>
				<td>$r[aktivitas]</td>
				<td>$r[cc]</td>
				<td>$r[$hari]</td>
				<td>$r[deliverable]</td>
			</tr>
			";
			$no++;	
		}
	?>
		<tr>
			<td colspan="6"><input type="submit" value="Pilih" name="Pilih" class="btn btn-sm btn-primary" ></td>
		</tr>
	</tbody>
</table>
<?php
}
?>
