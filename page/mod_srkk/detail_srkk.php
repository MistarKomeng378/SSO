<?php
	$getId		= explode("-",$_GET['id']);
	$getNik		= mysql_real_escape_string(dc($getId[0]));	
	$thSRKK		= mysql_real_escape_string(dc($getId[1]));
	$duser		= mysql_fetch_array(mysql_query("SELECT * FROM v_karyawan WHERE regno='$getNik' "));
?>

			<h1 class="page-header">SRKK
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Sasaran Rencana Kerja Karyawan - <?=name($getNik)?> Tahun <?=$thSRKK?></h4>
			    </div>
			    <div class="panel-body">
			<?php
			
			if(!isset($_GET['opt'])){
				if($_GET['lvl']!=4){
					if($getInsert==1){
						echo"<a href='page/mod_srkk/aksi_srkk_karyawan.php?id=".ec($duser['id'])."-".ec($duser['dept'])."-".ec($getNik)."-".ec($thSRKK)."&opt=tambah' class='btn btn-sm btn-success'><i class='fa fa-refresh'></i>  Generate</a><p></p>";
					}
				}else{
					if($getInsert==1){
						echo"<a href='page/mod_srkk/aksi_srkk_kepala2.php?id=".ec($duser['id'])."-".ec($duser['dept'])."-".ec($getNik)."-".ec($thSRKK)."&opt=tambah' class='btn btn-sm btn-success'><i class='fa fa-refresh'></i>  Generate</a><p></p>";
					}
				}
			}
				
			if(isset($_REQUEST['delete'])){
				// $getId	= dc($_GET['delete']);
				// mysql_query("DELETE FROM srko WHERE id_srko='$getId'");
				// mysql_query("DELETE FROM wbs WHERE id_srko='$getId'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Dihapus.
                    </div>";
			}
			if(isset($_REQUEST['succes'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Disimpan.
                    </div>";
			}
			if(isset($_REQUEST['failed'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Gagal, Terjadi Kesalahan.
                    </div>";
			}
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
			
		?>
		<div class="table-responsive">
			<form method="POST" action="page/mod_srkk/aksi_srkk_karyawan.php?opt=<?=$_GET['opt']?>&nik=<?=ec($getNik)?>&lvl=<?=$_GET['lvl']?>"  id="formku">
			<table class="table table-bordered table-striped table-hover" >
				<thead>
					<tr>
					<?php
						if($_GET['lvl']==4){
							echo'<th width="2%" rowspan="2">No.</th>
								<th rowspan="2">Rencana Kerja</th>
								<th rowspan="2">Bobot Awal</th>
								<th rowspan="2">Bobot Konversi</th>
								<th rowspan="2">Target Tahunan</th>
								<th colspan="12">Target Bulanan</th>';
						}else{
							echo'<th width="3%" rowspan="2">No.</th>
								<th rowspan="2">Rencana Kerja</th>
								<th rowspan="2">Bobot</th>
								<th rowspan="2">Target Tahunan</th>
								<th colspan="12">Target Bulanan</th>
								<th rowspan="2"></th>
								';
						}
						
						
					?>
					</tr>
					<tr>
						<?php
							for($b=1;$b<=12;$b++){
								echo"<th>$b</th>";
							}
							
						?>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						
						$query = mysql_query("SELECT	srkk.nik,
														srkk.id_srko,
														srkk.id_gca,
														srkk.bobot,
														srkk.nilai,
														wbs.aktivitas,
														wbs.hasil_akhir
														FROM
														srkk
														INNER JOIN wbs ON srkk.id_gca = wbs.id 
														WHERE srkk.nik='$getNik' AND srkk.tahun='$thSRKK'
														ORDER BY id_srko ASC
														");
						if($_GET['lvl']==4){
							if(isset($_GET['opt'])){
								// while($r=mysql_fetch_array($query)){
									// $target = mysql_fetch_array(mysql_query("SELECT bobot,satuan FROM srko WHERE id_srko='$r[id_srko]' AND tahun='$thSRKK' "));
									// echo"
									// <input type='hidden' name='id_srkk[]' value='$r[id_srkk]'>
									// <tr>
										// <td>$no</td>
										// <td>$r[aktivitas]</td>
										// <td>$target[bobot]</td>
										// <td>".desimal($r['bobot'])."</td>
										// <td>$target[target] $target[satuan]</td>";
										// for($b=1;$b<=12;$b++){
											// $bulanan	= mysql_fetch_array(mysql_query("SELECT * FROM srkk_bulanan WHERE bulan='$b' AND id_srkk='$r[id_srkk]' AND tahun='$thSRKK' "));
											// echo"<td>
													// <input type='hidden' name='id_srkk2[]' value='$r[id_srkk]'>
													// <input type='hidden' name='bulan[]' value='$b'>
													// <input type='hidden' name='satuan[]' value='$target[satuan]'>
													// <input type='text' name='tBulanan[]' value='$bulanan[target]' size='5' readonly>
												// </td>";
										// }
									// echo"</tr>";
									// $no++;
								// }
							}else{
								while($r=mysql_fetch_array($query)){
									$target = mysql_fetch_array(mysql_query("SELECT bobot,target,satuan FROM srko WHERE id_srko='$r[id_srko]' AND tahun='$thSRKK'"));
									// $nilai	= mysql_fetch_array(mysql_query("SELECT * FROM srkk_prioritas WHERE nilai='$r[nilai]'"));
									echo"
									<input type='hidden' name='id_srkk[]' value='$r[id_srkk]'>
									<tr>
										<td>$no</td>
										<td>$r[aktivitas]</td>
										<td>$target[bobot]</td>
										<td>".desimal($r['bobot'])."</td>
										<td>$target[target] $target[satuan]</td>";
										for($b=1;$b<=12;$b++){
											$bulanan	= mysql_fetch_array(mysql_query("SELECT target FROM target_srko WHERE bulan='$b' AND id_srko='$r[id_srko]' "));
											if($r['hasil_akhir']=="P"){
												echo"<td>".desimal($bulanan['target'])."</td>";
											}else{
												echo"<td>".$bulanan['target']."</td>";
											}
										}
								echo"</tr>";
								$no++;
								}
								
							}
						}else{
							if(isset($_GET['opt'])){
								while($r=mysql_fetch_array($query)){
									$target = mysql_fetch_array(mysql_query("SELECT * FROM srko WHERE id_srko='$r[id_srko]' AND tahun='$thSRKK'"));
									echo"
									<input type='hidden' name='id_srkk[]' value='$r[id_srkk]'>
									<tr>
										<td>$no</td>
										<td>$r[aktivitas]</td>
										<td>".desimal($r['bobot'])."</option></td>
										<td>$target[target] $target[satuan]</td>";
										for($b=1;$b<=12;$b++){
											$qId1	= mysql_query("SELECT DISTINCT id FROM wbs WHERE pic='$r[nik]' AND parentId='$r[id_gca]' AND tahun='$thSRKK'");
											while($d1=mysql_fetch_array($qId1)){
												$durasi1	= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM srkk_jam WHERE parentId='$r[id_gca]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$thSRKK'"));
												$sd1		= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM srkk_jam WHERE parentId='$r[id_gca]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
												$qId2	= mysql_query("SELECT DISTINCT id FROM wbs WHERE pic='$r[nik]' AND parentId='$d1[id]' AND tahun='$thSRKK'");
												while($d2=mysql_fetch_array($qId2)){
													$durasi2	= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM srkk_jam WHERE parentId='$d1[id]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$thSRKK'"));
													$sd2		= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM srkk_jam WHERE parentId='$d1[id]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
													// $qId3	= mysql_query("SELECT DISTINCT id FROM wbs WHERE pic='$r[nik]' AND parentId='$d1[id]'");
													// while($d3=mysql_fetch_array($qId3)){
														// $durasi3	= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM srkk_jam WHERE parentId='$d2[id_gca]' AND nik='$r[nik]' AND bulan='$b' AND tahun='$thSRKK'"));
														// $sd3		= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM srkk_jam WHERE parentId='$d2[id_gca]' AND nik='$r[nik]' AND tahun='$thSRKK'"));
														// $qId4	= mysql_query("SELECT id FROM wbs WHERE pic='$r[nik]' AND parentId='$d1[id]'");
														// while($d4=mysql_fetch_array($qId4)){
															// $durasi4	= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM waktu_kerja INNER JOIN wbs ON wbs.id = waktu_kerja.id_gca WHERE date_format(tgl_kerja, '%c %Y' ) = '$b $thSRKK' AND nik='$r[nik]' AND wbs.parentId='$d3[id]'"));
															// $qId5	= mysql_query("SELECT id FROM wbs WHERE pic='$r[nik]' AND parentId='$d1[id]'");
															// while($d5=mysql_fetch_array($qId5)){
																// $durasi5	= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM waktu_kerja INNER JOIN wbs ON wbs.id = waktu_kerja.id_gca WHERE date_format(tgl_kerja, '%c %Y' ) = '$b $thSRKK' AND nik='$r[nik]' AND wbs.parentId='$d4[id]'"));
																// $qId6	= mysql_query("SELECT id FROM wbs WHERE pic='$r[nik]' AND parentId='$d1[id]'");
																// while($d6=mysql_fetch_array($qId6)){
																	// $durasi6	= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM waktu_kerja INNER JOIN wbs ON wbs.id = waktu_kerja.id_gca WHERE date_format(tgl_kerja, '%c %Y' ) = '$b $thSRKK' AND nik='$r[nik]' AND wbs.parentId='$d5[id]'"));
																	// $qId7	= mysql_query("SELECT id FROM wbs WHERE pic='$r[nik]' AND parentId='$d1[id]'");
																	// while($d7=mysql_fetch_array($qId7)){
																		// $durasi7	= mysql_fetch_array(mysql_query("SELECT count(*) as jum FROM waktu_kerja INNER JOIN wbs ON wbs.id = waktu_kerja.id_gca WHERE date_format(tgl_kerja, '%c %Y' ) = '$b $thSRKK' AND nik='$r[nik]' AND wbs.parentId='$d6[id]'"));
																		$jml_durasi	= $sd1['jum']+$sd2['jum']+$sd3['jum'];
																		$durasi		= ($durasi1['jum']+$durasi2['jum']+$durasi3['jum'])*100/$jml_durasi;
																	// }
																// }
															// }
														// }
													// }
												}
											}
											echo"<td>
													<input type='hidden' name='id_srkk2[]' value='$r[id_srkk]'>
													<input type='hidden' name='id_gca2[]' value='$r[id_gca]'>
													<input type='hidden' name='bulan[]' value='$b'>
													<input type='hidden' name='satuan[]' value='$target[satuan]'>
													<input type='hidden' name='tBulanan[]' value='".$durasi."' size='5' readonly>".desimal($durasi)."
												</td>
												";
												
										}
										$totalDurasi+=$jml_durasi;
									echo"
											<td><input type='hidden' name='jml_durasi[]' value='$jml_durasi'>$jml_durasi</td>
										</tr>";
									$no++;
								}
								echo"<input type='hidden' name='totalDurasi' value='$totalDurasi'>";
							}else{
								while($r=mysql_fetch_array($query)){
									$target = mysql_fetch_array(mysql_query("SELECT * FROM srko WHERE id_srko='$r[id_srko]' AND tahun='$thSRKK'"));
									echo"
									<input type='hidden' name='id_srkk[]' value='$r[id_srkk]'>
									<tr>
										<td>$no</td>
										<td>$r[aktivitas]</td>
										<td>".desimal($r['bobot'])."</option></td>
										<td>$target[target] $target[satuan]</td>";
										for($b=1;$b<=12;$b++){
											
											$bulanan	= mysql_fetch_array(mysql_query("SELECT * FROM srkk_bulanan WHERE bulan='$b' AND nik='$r[nik]' AND id_gca='$r[id_gca]' AND tahun='$thSRKK' "));
											echo"<td>".desimal($bulanan['prosen'])."</td>";
										}
								echo"<td></td>
									</tr>";
								$no++;
								$totalBobot += $r['bobot'];
								}
								echo"
								<td colspan='2' align='center'><b>Total</b></td>
								<td>".desimal($totalBobot)."</td>
								<td colspan='14'></td>
								";
							}
						}
						
					?>
					
				</tbody>
				
			</table>
			<?php
				if(isset($_GET['opt'])){
					echo'<hr><button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>';
				}
			?>
			</form>
		</div>
		</div>
	</div>