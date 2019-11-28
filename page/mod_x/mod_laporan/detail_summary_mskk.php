<?php 
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_rupiah.php";
// echo $_POST['id'];
$ex				= explode("-",$_POST['id']);
$getBulan		= $ex[0];
$tahun_aktif	= $ex[1];
$unit			= $ex[2];
$getNik			= $ex[3];
$querylvl 		= mysql_fetch_array(mysql_query("SELECT level,name FROM `user` WHERE nik='$getNik'"));
$lvl			= $querylvl['level'];
?>
<h5><b><?=$getNik?></b> - <?=$querylvl['name']?> .::. <b>Bulan</b> : <?=bulan($getBulan)?> <b>Tahun</b> : <?=$tahun_aktif?></h5>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" >
				<thead>
					<tr>
					<?php
						if($lvl==4){
							echo'<th width="3%" >No.</th>
								<th >Rencana Kerja</th>
								<th >Bobot Awal</th>
								<th >Bobot Akhir</th>
								<th >Target</th>
								<th >Realisasi</th>
								<th >Pencapaian</th>
								<th >Score</th>
								<th >Bobot X Score</th>';
						}else{
							echo'
								<th width="3%" >No.</th>
								<th >Rencana Kerja</th>
								<th >Bobot Awal</th>
								<th >Bobot Akhir</th>
								<th >Target</th>
								<th >Realisasi</th>
								<th >Pencapaian</th>
								<th >Score</th>
								<th >Bobot X Score</th>
								';
						}
					?>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						$totalBA 	= 0;
						$totalB 	= 0;
						$totalBXS 	= 0;
						$query = mysql_query("SELECT	mskk.*,
														wbs.aktivitas
														FROM
														mskk
														INNER JOIN wbs ON mskk.id_gca = wbs.id 
														WHERE mskk.nik='$getNik' AND mskk.bulan='$getBulan' AND mskk.tahun='$tahun_aktif'
														ORDER BY id_srko ASC
														");
						if($lvl==4){
							if(isset($_GET['opt'])){
								
							}else{
								while($r=mysql_fetch_array($query)){
								echo"<tr>
										<td>$no</td>
										<td>$r[aktivitas]</td>
										<td>".desimal($r['bobotA'])."</td>
										<td>".desimal($r['bobot'])."</td>
										<td>".desimal($r['target'])."</td>
										<td>".desimal($r['realisasi'])."</td>
										<td>".desimal($r['pencapaian'])."</td>
										<td>$r[score]</td>
										<td>".desimal($r['bxs'])."</td>
									</tr>";
								$no++;
								$totalBA += $r['bobotA'];
								$totalB += $r['bobot'];
								$totalBXS += $r['bxs'];
								}
								echo"
								<td colspan='2' align='center'><b>Total</b></td>
								<td>".desimal($totalBA)."</td>
								<td>".desimal($totalB)."</td>
								<td colspan='4'></td>
								<td>".desimal($totalBXS)."</td>
								";
								
							}
						}else{
							if(isset($_GET['opt'])){
								
							}else{
								while($r=mysql_fetch_array($query)){
									echo"
									<tr>
										<td>$no</td>
										<td>$r[aktivitas]</td>
										<td>".desimal($r['bobotA'])."</td>
										<td>".desimal($r['bobot'])."</td>
										<td>".desimal($r['target'])."</td>
										<td>".desimal($r['realisasi'])."</td>
										<td>".desimal($r['pencapaian'])."</td>
										<td>$r[score]</td>
										<td>".desimal($r['bxs'])."</td>
									</tr>";
								$no++;
								$totalBA += $r['bobotA'];
								$totalB += $r['bobot'];
								$totalBXS += $r['bxs'];
								}
								echo"
								<td colspan='2' align='center'><b>Total</b></td>
								<td>".desimal($totalBA)."</td>
								<td>".desimal($totalB)."</td>
								<td colspan='4'></td>
								<td>".desimal($totalBXS)."</td>
								";
							}
						}
					?>
				</tbody>
			</table>
		</div>