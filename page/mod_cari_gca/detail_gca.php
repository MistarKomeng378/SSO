<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_name.php";
	$ex		= explode("-",$_POST['id']);
	$id_gca	= mysql_real_escape_string($ex[0]);
	$tahun	= mysql_real_escape_string($ex[1]);
	$pic	= mysql_real_escape_string($ex[2]);
	// echo"$id_gca - $tahun - $pic";
	$getgca		= mysql_fetch_array(mysql_query("SELECT aktivitas FROM wbs WHERE id='$id_gca' AND pic='$pic'"));
	$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$id_gca'"));
	$idParent	= $data['parentId'];
	echo"$id_gca -> <b><font color='blue'>$getgca[aktivitas]</font></b> ->";
	for($ak=1;$ak<=99;$ak++){
		$gca = mysql_fetch_array(mysql_query("SELECT parentId,aktivitas,tahun FROM wbs WHERE id='$idParent'"));
		$fontColor="black";
		if($ak!=1){
			echo"-> ";
		}
		echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
			$idParent=$gca['parentId'];
			$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
		if ($idParent==$cek_id['id_tahun']){
			break;
		}
	}
?>
<h4><b>Rencana Kerja GCA</b></h4>
<table id="example1" class="table table-striped table-bordered table-hover nowrap mytable" width="100%">
	<thead>
		<tr>
			<td align="center" colspan="12"><b>Rencana Jam Kerja Perbulan</b></td>
		</tr>
		<tr>
			<?php
				for($i=1;$i<=12;$i++){
					echo"<th>$i</th>";
				}
			?>
		</tr>
	</thead>
	<tbody>
		<tr>
		<?php
			for($b=1;$b<=12;$b++){
				$wk = mysql_fetch_array(mysql_query("SELECT SUM(`1`)+SUM(`2`)+SUM(`3`)+SUM(`4`)+SUM(`5`)+SUM(`6`)+SUM(`7`)+SUM(`8`)+SUM(`9`)+SUM(`10`)+
						SUM(`11`)+SUM(`12`)+SUM(`13`)+SUM(`14`)+SUM(`15`)+SUM(`16`)+SUM(`17`)+SUM(`18`)+SUM(`19`)+SUM(`20`)+
						SUM(`21`)+SUM(`22`)+SUM(`23`)+SUM(`24`)+SUM(`25`)+SUM(`26`)+SUM(`27`)+SUM(`28`)+SUM(`29`)+SUM(`30`)+
						SUM(`31`)+SUM(`32`) as jum FROM waktu_kerja2 
						WHERE `nik`='$pic' 
						AND `bulan`='$b' 
						AND `tahun`='$tahun' 
						AND `id_gca`='$id_gca'
						")) ;
					echo"<td><a href='?page=gca_load_detail&id=".ec($pic)."-".ec($b)."-".ec($tahun)."' target='_blank' title='Buka GCA Load'>$wk[jum]</a></td>";
			}
		?>
		</tr>
		<tr>
			<td align="center" colspan="12"><b>Realisasi Jam Kerja Perbulan</b></td>
		</tr>
		<tr>
		<?php
			for($b=1;$b<=12;$b++){
				$aktual = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jam FROM pencapaian WHERE nik='$pic' AND jo_gca='$id_gca' AND date_format( tgl_aktifitas, '%c %Y' ) = '$b $tahun'"));				
				echo"<td title='Aktualisasi'>$aktual[jam]</td>";
			}
		?>
		</tr>
	</tbody>
</table>
<h4><b>Rincian Aktifitas GCA</b></h4>
<table id="example1" class="table table-bordered table-striped table-hover" >
	<thead>
		<th width="5%">No.</th>
		<th>Aktifitas</th>
		<th></th>
		<th>Tanggal Aktifitas</th>
		<th>Progress</th>
		<th>Status</th>
		<th width="8%"></th>
	</thead>
	<tbody>
	<?php
		
		$query = mysql_query("SELECT distinct * FROM pencapaian WHERE nik='$pic' AND jo_gca='$id_gca' AND status='1' ORDER BY id_pencapaian DESC");
		$no=1;
		while($r=mysql_fetch_array($query)){
			// $aprove = mysql_fetch_array(mysql_query("SELECT aprove FROM pencapaian WHERE jo_gca=$r[jo_gca] AND nik='$r[nik]'"));
			if($r['aprove']==0){
				$aprove="Belum dilaporkan";
			// $aksi="<a href='?page=pencapaian_kerja&send=".ec($r['jo_gca'])."&nik=".ec($r['nik'])."' class='btn btn-xs btn-primary' data-toggle='modal'  title='Kirim Keatasan'><i class='fa fa-upload'></i></a>";
				$aksi="<a href='' class='btn btn-xs btn-primary' data-toggle='modal'  title='Dalam Proses Pengerjaan'><i class='fa fa-refresh'></i></a>";
			}elseif($r['aprove']==1){
				$aprove="Sudah dilaporkan";
				$aksi="<a href='' class='btn btn-xs btn-warning' data-toggle='modal'  title='Dalam Proses Penilaian'><i class='fa fa-refresh'></i></a>";
			}elseif($r['aprove']==2){
				$aprove="Aprove";
				$aksi="<a href='' class='btn btn-xs btn-success' data-toggle='modal'  title='Telah dinilai'><i class='fa fa-check'></i></a>";
			}elseif($r['aprove']==3){
				$aprove="Tidak dilaporkan";
				$aksi="<a href='' class='btn btn-xs btn-primary' data-toggle='modal'  title='Data ini tidak untuk dilaporkan'><i class='fa fa-check'></i></a>";
			}elseif($r['aprove']==4){
				$aprove="Dikembalikan Untuk diperbaiaki";
				$aksi="<a href='' class='btn btn-xs btn-danger' data-toggle='modal'  title='Hasil Kerja dikembaliakan Harap pebaiki kekurangan'><i class='fa fa-refresh'></i></a>";
			}
				echo"
					<tr>
						<td>$no</td>
						<td>$r[jo_gca]-> <span style=\"color:blue\">$r[aktifitas]</span><br>$r[hasil_akhir]</td>
						<td>$r[status_nilai]</td>
						<td>".tgl_indo($r['tgl_aktifitas'])."<br>Pukul $r[jam_mulai] - $r[jam_akhir] <br> Selama $r[total_jam] Jam $r[total_menit] Menit </td>
						<td>$r[progress] %</td>
						<td>$aprove<br><b>Dilaporkan Kepada : ".name($r['laporan'])."</b></td>
						<td>";
						echo"$aksi</td>
						</tr>
					";
				$no++;
				}
			?>
		</tbody>
	</table>