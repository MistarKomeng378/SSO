<?php
	$tahun_tsrko = $_COOKIE['tahun_tsrko'];
	$getUnit	= mysql_real_escape_string(dc($_GET['unit']));
	$unit		= mysql_fetch_array(mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$getUnit'"));
	$getParent	= mysql_fetch_array(mysql_query("SELECT min(id) as id FROM wbs WHERE cc='$getUnit' AND tahun='$tahun_tsrko'"));
	$getBulan	= mysql_real_escape_string($_POST['bulan']);
	$getTahun	= mysql_real_escape_string($_POST['tahun']) ;
	$getLevel	= mysql_real_escape_string($_POST['level']) ;
	$getID		= mysql_real_escape_string($_POST['id']) ;
	
?>

<h1 class="page-header">Hitung Progress
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Sasaran/Rencana Kerja Organisasi <?=$unit['uraian']?> Tahun <?=$tahun_tsrko?></h4>
	</div>
	<div class="panel-body">
		<div class="form-group col-lg-12 ">	
			<?php
if($_GET['act']=="hitung"){
			$limitLV = mysql_fetch_array(mysql_query("SELECT MAX(level) as lv FROM wbs WHERE cc_id='$getUnit' AND tahun='$tahun_tsrko'"));
			echo"<form method='POST' action='page.php?page=hitung_progress&act=hitung&unit=".ec($getUnit)."&opt=hitung' id='formku'>
					<div class='form-group  col-lg-12 row'>
						<div class='form-group  col-lg-2'>
							<input type='hidden' name='page' value='hitung_progress'>
							<input type='hidden' name='opt' value='cari'>
							<select name='bulan' class='form-control required'>
								<option value=''>Pilih Bulan</option>";
										for($i=1;$i<=12;$i++){
											echo"<option value='$i'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
										}
						echo"</select>
						</div>
						<div class='form-group  col-lg-1'>
							<input type='text' name='tahun' class='form-control required' value='".$tahun_tsrko."' placeholder='Tahun'>
						</div>
						<div class='form-group  col-lg-2'>
							<select name='level' class='form-control required'>
								<option value=''>Pilih Level</option>";
										for($i=5;$i<=$limitLV['lv'];$i++){
											echo"<option value='$i'"; if($getLevel==$i){echo"selected";} echo">$i</option>";
										}
						echo"</select>
						</div>
						<div class='form-group  col-lg-3'>
							<input type='submit' value='Pilih' class='btn btn-primary'>
						</div>
					</div>
				</form>";
				if(isset($_GET['opt'])){
					
echo'
<table width="100%" border="1">
	<tr align="center">
		<td width="5%">ID</td>
		<td width="5%">ParentId</td>
		<td width="3%">Level</td>
		<td >DETAIL GCA</td>
		<td >Bobot</td>
		<td >Target</td>
		<td >Realisasi</td>
		<td >Konversi Target</td>
		<td >Konversi Realisasi</td>
		<td >Pencapaian</td>
	</tr>';
// $qparent = mysql_query("SELECT DISTINCT parentId FROM wbs WHERE level='$getLevel' AND hasil_akhir='P' AND cc_id='$getUnit' AND jenisAktf!='' AND tahun='$getTahun'");
$qparent = mysql_query("SELECT DISTINCT parentId FROM wbs WHERE level='$getLevel' AND hasil_akhir='P' AND cc_id='$getUnit' AND tahun='$getTahun'");
while($p=mysql_fetch_array($qparent)){
///////////////////////////////////////////////////////////
$ttarget 	= 0;
$treal		= 0;
$ttotal_jam	= 0;
$tjmlJam	= 0;
$tbobot		= 0;
$tot_real	= 0;
$query = mysql_query("SELECT id,parentId,aktivitas,pic,durasi,cc_id,level,tahun,jenisGCA,jenisAktf,
						ifnull((SELECT durasi FROM wbs WHERE id=a.parentId),'') as pdurasi
						FROM wbs a
						WHERE level='$getLevel' AND parentId='$p[parentId]' AND hasil_akhir='P' AND cc_id='$getUnit' AND tahun='$getTahun'");

while($d=mysql_fetch_array($query)){
///////////////////////////////////////////////////////////
	if($d['jenisGCA']==1){
		$wk 		= mysql_query("SELECT * FROM progress_pgca WHERE id='$d[id]' AND bulan='$getBulan'  AND tahun='$getTahun'");
		$r 			= mysql_fetch_array($wk);
		$qsumjam 	= mysql_fetch_array(mysql_query("SELECT SUM(totalJam) as sumjam FROM progress_pgca WHERE parentId='$p[parentId]' AND bulan='$getBulan' AND tahun='$getTahun'"));
		$pro 		= mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_pgca WHERE id='$d[id]' AND bulan < '$getBulan' AND tahun='$getTahun'"));
		$lreal 		= $lpro['realisasi']; //progress terakir sebelumnya
		// $lreal 		= 0; //progress terakir sebelumnya
		$real 		= $r['realisasi']; //progress perbulan		
		// $real 		= $r['pencapaian']; //progress perbulan		
		$total_jam 	= $r['totalJam']; //total jam perbulan
		$jmlJam 	= $d['durasi'];
		$jmlbln 	= $r['jmlbln'];
		$sumjam 	= $qsumjam['sumjam'];
	}else{
		$wk = mysql_query("select id,parentId,tahun,
								ifnull((SELECT count(bulan) FROM waktu_kerja2 WHERE id_gca='$d[id]' AND tahun='$getTahun' AND nik='$d[pic]' AND total_jam!='' AND total_jam!='0'),'') as bln,
								ifnull((SELECT total_jam FROM waktu_kerja2 WHERE id_gca='$d[id]' AND bulan='$getBulan' AND tahun='$getTahun' AND nik='$d[pic]'),'') as total_jam,
								ifnull((select SUM(total_jam) FROM waktu_kerja2 WHERE id_gca='$d[id]' AND tahun='$getTahun' AND nik='$d[pic]'),'') as jmlJam
								from wbs 
								WHERE id='$d[id]' AND pic='$d[pic]' AND cc_id='$d[cc_id]' AND tahun='$getTahun' ");
		
		
		$r			= mysql_fetch_array($wk);
		$qsumjam 	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as sumjam FROM waktu_kerja2 WHERE parentId='$p[parentId]' AND bulan='$getBulan' AND tahun='$getTahun'"));
		$pro 		= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca='$r[id]' AND `status`='1'  AND date_format( tgl_aktifitas,'%c %Y' ) = '$getBulan $getTahun' )"));
		$lpro		= mysql_fetch_array(mysql_query("SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca='$r[id]' AND `status`='1'  AND date_format( tgl_aktifitas,'%Y' ) = '$getTahun' AND date_format( tgl_aktifitas,'%c' ) < '$getBulan' )"));
		$lreal 		= $lpro['progress']; //progress terakir sebelumnya
		$real 		= $pro['progress']; //progress perbulan
		$total_jam 	= $r['total_jam']; //total jam perbulan
		$jmlJam 	= $r['jmlJam']; //total jam per id gca
		$jmlbln 	= $r['bln']; //jumlah bulan aktifitas
		$sumjam 	= $qsumjam['sumjam']; //jumlah jam parentId perbulan
	}
	
	///////////////////////////////////////////////
	if($d['jenisGCA']==1){
		$target 	= $r['target'];
		$tot_real	= $real-$lreal;
			
			if($tot_real <= 0){
				$tot_real = $real;
				// $tot_real = ($real*$target)/100;
			}else{
				$tot_real = $tot_real;
				// $tot_real = ($tot_real*$target)/100;
			}
	}else{
		if($d['jenisAktf']==1 ){
			if($total_jam==0){
				$target_awal = 0;
			}else{
				$target_awal = 100;
			}
			// $target_awal 	= 100;			
			$target			= $target_awal/$jmlbln;		
			$tot_real		= ($real*$target)/100;
			
		}else{
			if($total_jam==0){
				$target = 0;
			}else{
				$target = ($total_jam/$jmlJam)*100;
			}
			$tot_real			= $real-$lreal;
			if($tot_real <= 0){
				$tot_real = $real;
			}else{
				$tot_real = $tot_real;
			}
			
		}
	}
	
	$bobot 			= ($d['durasi']/$d['pdurasi'])*100;
	$jmlTarget		= ($target*$bobot)/100;
	$realisasi 		= ($tot_real*$bobot)/100;
	//////////////////////////////////////////////
	echo"
		<tr>
			<td align='center'>$d[id]</td>
			<td align='center'>$p[parentId]</td>
			<td align='center'>$d[level]</td>
			<td>$d[aktivitas]</td>
			<td align='center'>".desimal($bobot)."</td>
			<td align='center'>".desimal($target)."</td>
			<td align='center'>".desimal($tot_real)."</td>
			<td align='center'>".desimal($jmlTarget)."</td>
			<td align='center'>".desimal($realisasi)."</td>
			<td></td>
		</tr>
	";
	
	mysql_query("REPLACE INTO progress_gca SET 	id			='$d[id]',
												parentId	='$p[parentId]',
												cc			='$d[cc_id]',
												level		='$d[level]',
												bulan		='$getBulan',
												tahun		='$getTahun',
												bobot		='$bobot',
												target		='$target',
												progress	='$tot_real',
												realisasi	='$realisasi',
												jmlTarget	='$jmlTarget',
												statusAktf	='$d[jenisAktf]',
												jenisGCA	='$d[jenisGCA]'
				");
	$pencapaian = 0;
	$ttarget += $jmlTarget;
	$treal += $realisasi;
	$ttotal_jam += $total_jam;
	$tjmlJam += $jmlJam;
	$tbobot += $bobot;
///////////////////////////////////////////////////////////
}
$wbs 	= mysql_fetch_array(mysql_query("SELECT id,id_srko,parentId,aktivitas,durasi,cc_id,level,tahun,jenisGCA,jenisAktf FROM wbs WHERE id='$p[parentId]' "));						
@$total 	= ($treal/$ttarget)*100;
if($total > 120){
	$total=120;
}else{
	$total=$total;
}
if($ttarget<=0 AND $treal > 0){
	$total = 120;
}else{
	$total = $total;
}
echo"
		<tr bgcolor='yellow'>
			<td align='center'>$wbs[id]</td>
			<td align='center'>$wbs[parentId]</td>
			<td align='center'>$wbs[level]</td>
			<td>$wbs[aktivitas]</td>
			<td align='center'>".desimal($tbobot)."</td>
			<td></td>
			<td></td>
			<td align='center'>".desimal($ttarget)."</td>
			<td align='center'>".desimal($treal)."</td>
			<td align='center'>".desimal($total)."</td>
		</tr>
	";
// if($wbs['level']==4){
	// mysql_query("UPDATE target_srko SET target='$ttarget' WHERE id_srko='$wbs[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun' AND cc='$wbs[cc_id]' ");
// }
mysql_query("REPLACE INTO progress_pgca SET 	id			='$p[parentId]',
												parentId	='$wbs[parentId]',
												cc			='$wbs[cc_id]',
												level		='$wbs[level]',
												bulan		='$getBulan',
												tahun		='$getTahun',
												target		='$ttarget',
												realisasi	='$treal',
												pencapaian	='$total',
												totalJam	='$ttotal_jam',
												jmlbln		='$jmlbln',
												jmlJam		='$tjmlJam',
												statusAktf	='$wbs[jenisAktf]',
												jenisGCA	='$wbs[jenisGCA]'
				");
	
///////////////////////////////////////////////////////////
}
echo'</table>';
				}
}elseif($_GET['act']=="view"){
	
	function show($id = '',$bulan,$tahun,$cc){
		$where = '';
		if(strlen($id) > 0) $where = " AND parentId='$id'";
			$sql = "SELECT * FROM wbs WHERE cc_id='$cc'  $where";
			$res = mysql_query($sql);
			$num = mysql_num_rows($res);
			$i=0;
		while($row = mysql_fetch_assoc($res)){
			if($i == 0) echo "";
			$i++;
			$level = $row['level'];
			$qgca			= mysql_fetch_array(mysql_query("SELECT bobot,target,progress,realisasi,jmlTarget FROM progress_gca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
			$bobot			= desimal($qgca['bobot']);
			$target			= desimal($qgca['target']);
			$progress		= desimal($qgca['progress']);
			$jmlTarget		= desimal($qgca['jmlTarget']);
			$realisasi		= desimal($qgca['realisasi']);
			$pencapaian		= "";
			
			if($row['level']==4){
				$ar				= "";
				$bg				= "yellow";
				$qgca			= mysql_fetch_array(mysql_query("SELECT target,realisasi,pencapaian FROM progress_pgca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				$bobot			= "";
				$target			= "";
				$progress		= "";
				$jmlTarget		= desimal($qgca['target']);
				$realisasi		= desimal($qgca['realisasi']);
				$pencapaian		= desimal($qgca['pencapaian']);
			}elseif($row['level']==5){
				$ar				= "-";
				$bg				= "#ffd11a";
				// $qgca			= mysql_fetch_array(mysql_query("SELECT target,realisasi,pencapaian FROM progress_pgca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				// $bobot			= "";
				// $target			= "";
				// $progress		= "";
				// $jmlTarget		= desimal($qgca['target']);
				// $realisasi		= desimal($qgca['realisasi']);
				// $pencapaian		= desimal($qgca['pencapaian']);
			}elseif($row['level']==6){
				$ar				= "--";
				$bg				= "#99ff99";
				// $qgca			= mysql_fetch_array(mysql_query("SELECT * FROM progress_gca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				// $bobot			= $qgca['bobot'];
				// $target			= $qgca['target'];
				// $realisasi		= $qgca['realisasi'];
			}elseif($row['level']==7){
				$ar				= "---";
				$bg				= "#99d6ff";
				// $qgca			= mysql_fetch_array(mysql_query("SELECT * FROM progress_gca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				// $bobot			= $qgca['bobot'];
				// $target			= $qgca['target'];
				// $realisasi		= $qgca['realisasi'];
			}elseif($row['level']==8){
				$ar				= "----";
				$bg				= "#ffcce6";
				// $qgca			= mysql_fetch_array(mysql_query("SELECT * FROM progress_gca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				// $bobot			= $qgca['bobot'];
				// $target			= $qgca['target'];
				// $realisasi		= $qgca['realisasi'];
			}elseif($row['level']==9){
				$ar				= "-----";
				$bg				= "#ff8080";
				// $qgca			= mysql_fetch_array(mysql_query("SELECT * FROM progress_gca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				// $bobot			= $qgca['bobot'];
				// $target			= $qgca['target'];
				// $realisasi		= $qgca['realisasi'];
			}elseif($row['level']==10){
				$ar				= "-----";
				$bg				= "#00ccff";
				// $qgca			= mysql_fetch_array(mysql_query("SELECT * FROM progress_gca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				// $bobot			= $qgca['bobot'];
				// $target			= $qgca['target'];
				// $realisasi		= $qgca['realisasi'];
			}elseif($row['level']==11){
				$ar				= "------";
				$bg				= "#1aff1a";
				// $qgca			= mysql_fetch_array(mysql_query("SELECT * FROM progress_gca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				// $bobot			= $qgca['bobot'];
				// $target			= $qgca['target'];
				// $realisasi		= $qgca['realisasi'];
			}elseif($row['level']==12){
				$ar				= "-------";
				$bg				= "";
				// $qgca			= mysql_fetch_array(mysql_query("SELECT bobot,target,realisasi FROM progress_gca WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' AND cc='$cc' AND `level`='$level' "));
				// $bobot			= $qgca['bobot'];
				// $target			= $qgca['target'];
				// $realisasi		= $qgca['realisasi'];
			}
				
			echo "<tr bgcolor='$bg'>
					<td align='center'>$row[id]</td>
					<td align='center'>$row[parentId]</td>
					<td align='center'>$row[level]</td>
					<td>$ar $row[aktivitas]</td>
					<td align='center'>$bobot</td>
					<td align='center'>$target</td>
					<td align='center'>$progress</td>
					<td align='center'>$jmlTarget</td>
					<td align='center'>$realisasi</td>
					<td align='center'>$pencapaian</td>
				";
			echo"</tr>";
				show($row['id'],$bulan,$tahun,$cc);
			echo "";
			if($i == $num)echo "";
		}
	}
			echo"<form method='POST' action='page.php?page=hitung_progress&act=view&unit=".ec($getUnit)."&opt=view' id='formku'>
					<div class='form-group  col-lg-12 row'>
						<div class='form-group  col-lg-2'>
							<select name='bulan' class='form-control required'>
								<option value=''>Pilih Bulan</option>";
										for($i=1;$i<=12;$i++){
											echo"<option value='$i'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
										}
						echo"</select>
						</div>
						<div class='form-group  col-lg-1'>
							<input type='text' name='tahun' class='form-control required' value='".$tahun_tsrko."' placeholder='Tahun'>
						</div>
						<div class='form-group  col-lg-4'>
							<select name='id' class='form-control required'>
								<option value=''>Pilih Aktifitas</option>";
									$id_view = mysql_query("SELECT id,aktivitas FROM wbs WHERE level='3' AND hasil_akhir='P' AND cc_id='$getUnit' AND tahun='$tahun_tsrko' ");
									while($idv=mysql_fetch_array($id_view)){
											echo"<option value='$idv[id]'"; if($getID==$idv['id']){echo"selected";} echo">$idv[aktivitas]</option>";
										}
						echo"</select>
						</div>
						<div class='form-group  col-lg-3'>
							<input type='submit' value='Pilih' class='btn btn-primary'>
						</div>
					</div>
			</form>";
	
	if(isset($_GET['opt'])){
		echo'
		<table width="100%" border="1">
			<tr align="center">
				<td width="5%">ID</td>
				<td width="5%">ParentId</td>
				<td width="3%">Level</td>
				<td >DETAIL GCA</td>
				<td width="5%">Bobot</td>
				<td width="5%">Target</td>
				<td width="7%">Realisasi</td>
				<td width="10%">Konversi Target</td>
				<td width="10%">Konversi Realisasi</td>
				<td width="10%">Pencapaian</td>
			</tr>';
			show("$getID","$getBulan","$getTahun","$getUnit");
		echo '</table>';
	}
}			
?>
		</div>
	</div>
</div>