<?php
	$getUnit	= mysql_real_escape_string(dc($_GET['unit']));
	$unit		= mysql_fetch_array(mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$getUnit'"));
	$getParent	= mysql_fetch_array(mysql_query("SELECT min(id) as id FROM wbs WHERE cc='$getUnit' AND tahun='$tahun_aktif'"));
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
			        <h4 class="panel-title">Sasaran/Rencana Kerja Organisasi <?=$unit['uraian']?> Tahun <?=$tahun_aktif?></h4>
			    </div>
			    <div class="panel-body">
			<div class="form-group col-lg-12 ">	
			<?php
if($_GET['act']=="hitung"){
			$limitLV = mysql_fetch_array(mysql_query("SELECT MAX(level) as lv FROM wbs WHERE cc_id='$getUnit'"));
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
							<input type='text' name='tahun' class='form-control required' value='".date("Y")."' placeholder='Tahun'>
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
							<td >DETIL GCA</td>
							<td >Durasi AK</td>
							<td >Durasi Parent</td>
							<td >Progress</td>
							<td >Progress KPM</td>
						</tr>
					';

					$qparent = mysql_query("SELECT DISTINCT parentId FROM wbs WHERE level='$getLevel' AND hasil_akhir='P' AND cc_id='$getUnit'");
					while($p=mysql_fetch_array($qparent)){
						$wbs 		= mysql_fetch_array(mysql_query("SELECT id,parentId,aktivitas,durasi,cc_id,level,tahun FROM wbs WHERE id='$p[parentId]' "));
						$pdurasi	= mysql_fetch_array(mysql_query("SELECT durasi FROM wbs WHERE id='$wbs[parentId]'"));
						$pdur 		= $pdurasi['durasi'];
						if($pdur!=0){
							$p_brk 	= $wbs['durasi']/$pdur;
						}else{
							$p_brk 	= 0;
						}
						if($wbs['level']==4){
							$qprogress_rk 	= mysql_fetch_array(mysql_query("SELECT progress_rk FROM progress_tree WHERE id='$wbs[id]'  AND bulan='$getBulan' AND tahun='$getTahun'"));
							$progress_rk 	= desimal($qprogress_rk['progress_rk']);
						}else{
							$progress_rk	= "";
						}
						echo"
							<tr bgcolor='yellow'>
								<td align='center'>$wbs[id]</td>
								<td align='center'>$wbs[parentId]</td>
								<td align='center'>$wbs[level]</td>
								<td>$wbs[aktivitas]</td>
								<td colspan='3'></td>
								<td align='center'>$progress_rk</td>
							</tr>
						";
						$query = mysql_query("SELECT id,parentId,aktivitas,durasi,cc_id,level,tahun FROM wbs WHERE level='$getLevel' AND parentId='$p[parentId]' AND hasil_akhir='P' AND cc_id='$getUnit'");
						while($r=mysql_fetch_array($query)){
							$pro 	= mysql_fetch_array(mysql_query("SELECT max(progress) as progress FROM pencapaian WHERE jo_gca='$r[id]' AND date_format(tgl_aktifitas,'%c %Y')='$getBulan $getTahun' "));
							$prog 	= $pro['progress'];
							$durasi	= mysql_fetch_array(mysql_query("SELECT durasi FROM wbs WHERE id='$r[parentId]'"));
							$dur 	= $durasi['durasi'];
							echo"
								<tr>
									<td align='center'>$r[id]</td>
									<td align='center'>$r[parentId]</td>
									<td align='center'>$r[level]</td>
									<td>$r[aktivitas]</td>
									<td align='center'>$r[durasi]</td>
									<td align='center'>$dur</td>
									<td align='center'>$prog</td>
									<td></td>
								</tr>
								";
							if($dur!=0){
								$brk 	= ($r['durasi']/$dur)*100;
							}else{
								$brk 	= 0;
							}
							
							$cekpbrk 	= mysql_query("SELECT * FROM progress_tree WHERE id='$r[id]'  AND bulan='$getBulan' AND tahun='$getTahun'");
							$count		= mysql_num_rows($cekpbrk);
							if($count>0){
								$getBprk	= mysql_fetch_array($cekpbrk);
								$bprk		= $getBprk['bxprk'];
							}else{
								if($prog!=0){
									$bprk	= ($brk*$prog)/100;
								}else{
									$bprk	= 0;
								}
							}
							
							mysql_query("REPLACE INTO progress_subtree SET 	id			='$r[id]',
																			parentId	='$r[parentId]',
																			level		='$r[level]',
																			bulan		='$getBulan',
																			tahun		='$getTahun',
																			brk			='$brk',
																			progress	='$prog',
																			bprk		='$bprk'
							
							");
							@$prk	+= $bprk;
						}
						$bxprk	= $p_brk*$prk;
						
						if($wbs['level']==4){
							$progress_rk = mysql_fetch_array(mysql_query("SELECT SUM(bprk) AS jum FROM progress_subtree WHERE parentId='$wbs[id]' AND bulan='$getBulan' AND tahun='$getTahun'"));
							mysql_query("REPLACE INTO progress_tree SET 	id			='$wbs[id]',
																			parentId	='$wbs[parentId]',
																			level		='$wbs[level]',
																			bulan		='$getBulan',
																			tahun		='$getTahun',
																			rk			='$p_brk',
																			prk			='$prk',
																			bxprk		='$bxprk',
																			progress_rk	='$progress_rk[jum]'		
						");
						}else{
							mysql_query("REPLACE INTO progress_tree SET 	id			='$wbs[id]',
																			parentId	='$wbs[parentId]',
																			level		='$wbs[level]',
																			bulan		='$getBulan',
																			tahun		='$getTahun',
																			rk			='$p_brk',
																			prk			='$prk',
																			bxprk		='$bxprk'
							
						");
						}
						$prk = 0;
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
			if($row['level']==4){
				$ar				= "";
				$qprogress_rk 	= mysql_fetch_array(mysql_query("SELECT progress_rk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun' "));
				$progress_rk 	= desimal($qprogress_rk['progress_rk']);
				$brk 			= "";
				$progress 		= "";
				$bprk 			= "";
				$prk 			= "";
				$bxprk 			= "";
				$rk				= "";
				$bg				= "yellow";
			}elseif($row['level']==5){
				$ar				= "-";
				$progress_rk 	= "";
				$qbrk 			= mysql_fetch_array(mysql_query("SELECT brk,progress,bprk FROM progress_subtree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$brk 			= desimal($qbrk['brk']);
				$progress 		= $qbrk['progress'];
				$bprk 			= desimal($qbrk['bprk']);
				$qprotree 		= mysql_fetch_array(mysql_query("SELECT rk,prk,bxprk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$prk			= desimal($qprotree['prk']);
				$bxprk			= desimal($qprotree['bxprk']);
				$rk				= desimal($qprotree['rk']);
				$bg				= "#ffd11a";
			}elseif($row['level']==6){
				$ar				= "--";
				$progress_rk 	= "";
				$qbrk 			= mysql_fetch_array(mysql_query("SELECT brk,progress,bprk FROM progress_subtree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$brk 			= desimal($qbrk['brk']);
				$progress 		= $qbrk['progress'];
				$bprk 			= desimal($qbrk['bprk']);
				$qprotree 		= mysql_fetch_array(mysql_query("SELECT rk,prk,bxprk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$prk			= desimal($qprotree['prk']);
				$bxprk			= desimal($qprotree['bxprk']);
				$rk				= desimal($qprotree['rk']);
				$bg				= "#99ff99";
			}elseif($row['level']==7){
				$ar				= "---";
				$progress_rk 	= "";
				$qbrk			= mysql_fetch_array(mysql_query("SELECT brk,progress,bprk FROM progress_subtree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$brk 			= desimal($qbrk['brk']);
				$progress 		= $qbrk['progress'];
				$bprk 			= desimal($qbrk['bprk']);
				$qprotree 		= mysql_fetch_array(mysql_query("SELECT rk,prk,bxprk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$prk			= desimal($qprotree['prk']);
				$bxprk			= desimal($qprotree['bxprk']);
				$rk				= desimal($qprotree['rk']);
				$bg				= "#99d6ff";
			}elseif($row['level']==8){
				$ar				= "----";
				$progress_rk 	= "";
				$qbrk 			= mysql_fetch_array(mysql_query("SELECT brk,progress,bprk FROM progress_subtree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$brk 			= desimal($qbrk['brk']);
				$progress 		= $qbrk['progress'];
				$bprk 			= desimal($qbrk['bprk']);
				$qprotree 		= mysql_fetch_array(mysql_query("SELECT rk,prk,bxprk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$prk			= desimal($qprotree['prk']);
				$bxprk			= desimal($qprotree['bxprk']);
				$rk				= desimal($qprotree['rk']);
				$bg				= "#ffcce6";
			}elseif($row['level']==9){
				$ar				= "-----";
				$progress_rk 	= "";
				$qbrk 			= mysql_fetch_array(mysql_query("SELECT brk,progress,bprk FROM progress_subtree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$brk 			= desimal($qbrk['brk']);
				$progress 		= $qbrk['progress'];
				$bprk 			= desimal($qbrk['bprk']);
				$qprotree 		= mysql_fetch_array(mysql_query("SELECT rk,prk,bxprk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$prk			= desimal($qprotree['prk']);
				$bxprk			= desimal($qprotree['bxprk']);
				$rk				= desimal($qprotree['rk']);
				$bg				= "#ff8080";
			}elseif($row['level']==10){
				$ar				= "-----";
				$progress_rk 	= "";
				$qbrk 			= mysql_fetch_array(mysql_query("SELECT brk,progress,bprk FROM progress_subtree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$brk 			= desimal($qbrk['brk']);
				$progress 		= $qbrk['progress'];
				$bprk 			= desimal($qbrk['bprk']);
				$qprotree 		= mysql_fetch_array(mysql_query("SELECT rk,prk,bxprk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$prk			= desimal($qprotree['prk']);
				$bxprk			= desimal($qprotree['bxprk']);
				$rk				= desimal($qprotree['rk']);
				$bg				= "#00ccff";
			}elseif($row['level']==11){
				$ar				= "------";
				$progress_rk 	= "";
				$qbrk 			= mysql_fetch_array(mysql_query("SELECT brk,progress,bprk FROM progress_subtree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$brk 			= desimal($qbrk['brk']);
				$progress 		= $qbrk['progress'];
				$bprk 			= desimal($qbrk['bprk']);
				$qprotree 		= mysql_fetch_array(mysql_query("SELECT rk,prk,bxprk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$prk			= desimal($qprotree['prk']);
				$bxprk			= desimal($qprotree['bxprk']);
				$rk				= desimal($qprotree['rk']);
				$bg				= "#1aff1a";
			}elseif($row['level']==12){
				$ar				= "-------";
				$progress_rk 	= "";
				$qbrk 			= mysql_fetch_array(mysql_query("SELECT brk,progress,bprk FROM progress_subtree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$brk 			= desimal($qbrk['brk']);
				$progress 		= $qbrk['progress'];
				$bprk 			= desimal($qbrk['bprk']);
				$qprotree 		= mysql_fetch_array(mysql_query("SELECT rk,prk,bxprk FROM progress_tree WHERE id='$row[id]' AND bulan='$bulan' AND tahun='$tahun'"));
				$prk			= desimal($qprotree['prk']);
				$bxprk			= desimal($qprotree['bxprk']);
				$rk				= desimal($qprotree['rk']);
				$bg				= "";
			}
			echo "<tr bgcolor='$bg'>
					<td>$row[id]</td>
					<td>$row[parentId]</td>
					<td>$row[level]</td>
					<td>$ar $row[aktivitas]</td>
					<td>$row[durasi]</td>
					<td>$brk</td>
					<td></td>
					<td>$progress</td>
					<td>$prk</td>
					<td>$bprk</td>
					<td>$bxprk</td>
					<td>$progress_rk</td>
					<td>$progress_rk</td>
					
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
							<input type='text' name='tahun' class='form-control required' value='".date("Y")."' placeholder='Tahun'>
						</div>
						<div class='form-group  col-lg-2'>
							<select name='id' class='form-control required'>
								<option value=''>Pilih Aktifitas</option>";
									$id_view = mysql_query("SELECT id,aktivitas FROM wbs WHERE level='3' AND hasil_akhir='P' AND cc_id='$getUnit' ");
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
		echo '
		<table width="100%" border="1">
			<tr>
				<td rowspan=2 width="5%">ID</td>
				<td rowspan=2 width="5%">ParentID</td>
				<td rowspan=2 width="3%">LV</td>
				<td rowspan=2 >DETIL GCA</td>
				<td rowspan=2 width="5%" align="center">Jml JAM</td>
				<td colspan=2 align="center">Bobot</td>
				<td rowspan=2 width="7%" align="center">Progress User<br>(KKWK)</td>
				<td rowspan=2 width="7%" align="center">Progress RK</td>
				<td rowspan=2 align="center">Bobot x Progress<br>(Aktivitas)</td>				
				<td rowspan=2 width="6%" align="center">Bobot x Progress<br>(RK)</td>
				<td rowspan=2 width="6%" align="center">Progress<br>Renc Kerja</td>
				<td rowspan=2 width="6%" align="center">Progress<br>KPM</td>
			</tr>
			<tr >
				<td width="5%" align="center">Akt RK</td>
				<td width="5%" align="center">RK</td>
			</tr>';
			show("$getID","$getBulan","$getTahun","$getUnit");
		echo '</table>';
	}
}			
?>
			</div>
		</div>
	</div>