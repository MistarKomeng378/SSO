<?php
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_name.php";
include"../../config/encript.php";
	$ex 	= explode("-",$_POST['id']);
	$nik 	= $ex[0];
	$jo_gca = $ex[1];
	$hasil	= $ex[2];
if($hasil=="P"){
?>
<table id="example1" class="table table-bordered table-striped table-hover" >
	<thead>
		<th>No.</th>
		<th>Waktu Pelaksanaan</th>
		<th>GCA / JO</th>
		<th>Aktifitas</th>
		<th>Hasil</th>
		<th>FK</th>
		<th>Progress</th>
		<th>Ketrangan</th>
		<th>Status</th>
		<th width="8%"></th>
	</thead>
	<tbody>
		<?php
			$query = mysql_query("SELECT * FROM pencapaian WHERE nik='$nik' AND jo_gca='$jo_gca' AND status='1' ORDER BY id_pencapaian DESC");
			$i=1;
			while($r=mysql_fetch_array($query)){
				if($r['aprove']==0){
					$aprove="Belum dilaporkan";
				}elseif($r['aprove']==1){
					$aprove="Open";
				}elseif($r['aprove']==2){
					$aprove="Aprove";
				}elseif($r['aprove']==3){
					$aprove="Tidak dilaporkan";
				}elseif($r['aprove']==4){
					$aprove="Dikembalikan Untuk diperbaiaki";
				}
				if(empty($r['file'])){
					$disabled ="disabled";
				}else{
					$disabled ="";
				}
				echo"
					<tr>
						<td>$i</td>
						<td>".tgl_indo($r['tgl_aktifitas'])."<br>Pukul $r[jam_mulai] - $r[jam_akhir] <br> Selama $r[total_jam] Jam $r[total_menit] Menit </td>
						<td>$r[jo_gca]</td>
						<td>$r[aktifitas]</td>
						<td>$r[hasil_akhir]</td>
						<td>$r[faktor_k]</td>
						<td>$r[progress]</td>
						<td>$r[ket]</td>
						<td>$aprove</td>
						<td>
							<a target='_blank' href='page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-success' title='Download Lampiran' $disabled><i class='fa fa-xs fa-download'></i></a>
						</td>
					</tr>";
							$i++;
			}
		?>
	</tbody>
</table>
<?php
}elseif($hasil=="H"){
?>
<table id="example1" class="table table-bordered table-striped table-hover" >
	<thead>
		<th>No.</th>
		<th>Waktu Pelaksanaan</th>
		<th>GCA / JO</th>
		<th>Aktifitas</th>
		<th>Hasil</th>
		<th>FK</th>
		<th>Status</th>
	</thead>
	<tbody>
		<?php
			$query = mysql_query("SELECT * FROM pencapaian WHERE nik='$nik' AND jo_gca='$jo_gca'  ORDER BY tgl_aktifitas,jam_mulai DESC");
			$i=1;
			while($r=mysql_fetch_array($query)){
				if($r['aprove']==0){
					$aprove="Belum dilaporkan";
				}elseif($r['aprove']==1){
					$aprove="Open";
				}elseif($r['aprove']==2){
					$aprove="Aprove";
				}elseif($r['aprove']==3){
					$aprove="Tidak dilaporkan";
				}
				$tampilHasil = mysql_fetch_array(mysql_query("SELECT * FROM pencapaian_hasil WHERE id_pencapaian='$r[id_pencapaian]' "));
				
				echo"
					<tr>
						<td>$i</td>
						<td>".tgl_indo($r['tgl_aktifitas'])."<br>Pukul $r[jam_mulai] - $r[jam_akhir] <br> Selama $r[total_jam] Jam $r[total_menit] Menit </td>
						<td>$r[jo_gca]</td>
						<td>$r[aktifitas]</td>
						<td>$tampilHasil[hasil] $tampilHasil[satuan]</td>
						<td>$r[faktor_k]</td>
						<td>$aprove</td>
					</tr>";
							$i++;
			}
		?>
	</tbody>
</table>
<?php
}
?>