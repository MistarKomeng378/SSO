<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_name.php";
	$ex			= explode("-",$_POST['id']);
	$id_gca		= mysql_real_escape_string($ex[0]);
	$tahun		= mysql_real_escape_string($ex[1]);
	$pic		= mysql_real_escape_string($ex[2]);

	$r			= mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$id_gca'"));
	$ex2		= explode(" ",$r['tgl_isi']);
	$getgca		= mysql_fetch_array(mysql_query("SELECT aktivitas FROM wbs WHERE id='$id_gca' AND pic='$pic'"));
	$idParent	= $r['parentId'];
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
	if($r['jenisAktf']==1){
		$statusAktf = "Rutin";
	}elseif($r['jenisAktf']==2){
		$statusAktf = "Non Rutin";
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
						SUM(`31`)+SUM(`32`) as jum,cc,parentId FROM waktu_kerja2 
						WHERE `nik`='$pic' 
						AND `bulan`='$b' 
						AND `tahun`='$tahun' 
						AND `id_gca`='$id_gca'
						")) ;
					// echo"<td><a href='?page=gca_load_detail&id=".ec($pic)."-".ec($b)."-".ec($tahun)."' target='_blank' title='Buka GCA Load'>$wk[jum]</a></td>";
					echo"<td><a href='lookup/detail-gca-load.php?id=".ec($id_gca)."-".ec($pic)."-".ec($tahun)."-".ec($r['cc_id'])."-".ec($r['parentId'])."' class='popup' >$wk[jum]</a></td>";
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
				echo"<td title='Aktualisasi'><a href='lookup/detail-kkwk2.php?id=".ec($id_gca)."-".ec($r['parentId'])."&bln=".ec($b)."&thn=".ec($tahun)."&pic=".ec($pic)."&cc=".ec($r['cc_id'])."' class='popup' >$aktual[jam]</a></td>";
			}
		?>
		</tr>
	</tbody>
</table>
<h4><b>Informasi GCA</b></h4>
<table class="table" style="color:black">
	<tr>
		<td><b>ParentId -> Id SRKO -> Level</b></td>
		<td>:</td>
		<td><?=$r['parentId']?> -> <?=$r['id_srko']?> -> <?=$r['level']?></td>
	</tr>
	<tr>
		<td width="30%"><b>Tanggal Mulai</b> </td>
		<td width="5%">:</td>
		<td width="65%"><?=tgl_indo($r['mulai'])?> <b>S/D</b> <?=tgl_indo($r['akhir'])?>   <b>Durasi</b> : <?=$r['durasi']?> Jam <b>Realisasi</b> : <?=$r['realisasi']?> Jam</td>
	</tr>
	<tr>
		<td><b>Cost Center / Kode Proyek</b></td>
		<td>:</td>
		<td><?=$r['cc']?></td>
	</tr>
	<tr>
		<td><b>Penanggung Jawab</b></td>
		<td>:</td>
		<td><?=$r['pic']?> :-: <?=name($r['pic'])?></td>
	</tr>
	<tr>
		<td><b>Target</b></td>
		<td>:</td>
		<td><?=$r['deliverable']?></td>
	</tr>
	<tr>
		<td><b>Jenis Aktifitas</b></td>
		<td>:</td>
		<td><?=$statusAktf?></td>
	</tr>
	<tr>
		<td><b>Tanggal Isi GCA</b></td>
		<td>:</td>
		<td><?=tgl_indo($ex2[0])?> <?=$ex2[1]?> Oleh : <?=name($r['gca_by'])?></td>
	</tr>
</table>
<!-------------------------------awal dari color box------------------------------------>
<script type="text/javascript" src="assets/plugins/jquerycolorbox/jquery.colorbox.js"></script>
<link  rel="stylesheet" type="text/css" href="assets/plugins/jquerycolorbox/colorbox/colorbox.css" />
<!-------------------------------akhir dari color box------------------------------------>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".popup").colorbox({ 		iframe:true		,width:"80%"		,height:"100%"	});
	});
</SCRIPT>