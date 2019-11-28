<link href="../../assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="../../assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">		
	<table id="" class="display table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th></th>
				<th >ID GCA</th>
				<th >Aktifitas</th>
				<th >Mulai</th>
				<th >Akhir</th>
				<th >CC</th>
				<th >Deliverable</th>
				<?php
					include"../../config/koneksi.php";
					include"../../config/encript.php";
					include"../../config/fungsi_indotgl.php";
					$getId	= explode("-",$_POST['id']);
					$nik	= dc($getId[0]);
					$act	= $getId[1];
					
					$todayDate 	= date("Y-m-d");
					$now 		= strtotime(date("Y-m-d"));
					$kemarin 	= date('Y-m-d', strtotime('-5 day', $now));
					$besok 		= date('Y-m-d', strtotime('+5 day', $now));
					$date1 		= date_create($kemarin);
					$arr1 		= explode('-',$kemarin);
					$arr2 		= explode('-',$besok);
					$diff 		= gregoriantojd($arr2[1], $arr2[2], $arr2[0])- gregoriantojd($arr1[1], $arr1[2], $arr1[0]);
					for($k=0;$k<=$diff;$k++){  
						$tgl_kerja = date_format($date1,"Y-m-d");
						$ex		= explode("-",$tgl_kerja);
						$year	= $ex[0]; 
						$month	= $ex[1]; 
						$day	= $ex[2];
								
						if(date("D",mktime (0,0,0,$month,$day,$year)) == "Sun") {
							echo"<td><span style=\"color:red\"><b>$day</b></span></td>";
						}elseif(date("D",mktime (0,0,0,$month,$day,$year)) == "Sat") {
							 echo"<td><span style=\"color:red\"><b>$day</b></span></td>";
						}
						else{
							if($tgl_kerja==$todayDate){
								$fontColor="blue";
							}else{
								$fontColor="black";
							}
								echo"<td><span style=\"color:$fontColor\"><b>$day</b></span></td>";
							}
						date_add($date1, date_interval_create_from_date_string('1 days'));
								
					}			
				?>
			</tr>
		</thead>
		<tbody>
			<?php
						$daynow	 	= date('j', strtotime($todayDate));
						if($act=="full"){
							$query = mysql_query("SELECT DISTINCT
															wbs.aktivitas,
															waktu_kerja2.nik,
															wbs.id,
															wbs.mulai,
															wbs.akhir,
															wbs.hasil_akhir,
															wbs.cc,
															wbs.deliverable,
															wbs.jenisAktf,
															ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=waktu_kerja2.id_gca AND `status`='1')),'') as maxpro
															FROM
															waktu_kerja2
															INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca AND wbs.pic = waktu_kerja2.nik
															WHERE wbs.pic='$nik'
															AND wbs.`jenisGCA` ='2'
															AND waktu_kerja2.tahun='".date("Y")."'
															ORDER BY wbs.mulai, wbs.id ");

						}else{
							$query = mysql_query("SELECT DISTINCT
															wbs.aktivitas,
															waktu_kerja2.nik,
															wbs.id,
															wbs.mulai,
															wbs.akhir,
															wbs.hasil_akhir,															
															wbs.cc,
															wbs.deliverable,
															wbs.jenisAktf,
															ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=waktu_kerja2.id_gca AND `status`='1')),'') as maxpro
															FROM
															waktu_kerja2
															INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca AND wbs.pic = waktu_kerja2.nik
															WHERE wbs.pic='$nik' 
															AND `$daynow` !=''
															AND `jenisGCA` ='2'
															AND waktu_kerja2.bulan='".date("n")."' 
															AND waktu_kerja2.tahun='".date("Y")."'
															ORDER BY wbs.mulai, wbs.id");
						}
						while($r=mysql_fetch_array($query)){
							if($r['maxpro']==100){
								$bgcolor = "#b3e0ff";
							}else{
								$bgcolor = "";
							}
						echo'<tr class="selectgca" data-gca="'.$r['id'].'" data-aktivitas="'.$r['aktivitas'].'" data-cc="'.$r['cc'].'" data-deliverable="'.$r['deliverable'].'" data-faktor="A" bgcolor="'.$bgcolor.'">
								<td>';
									$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$r[id]'"));
									$idParent	= $data['parentId'];
									echo "<x class='glyphicon glyphicon-info-sign' data-tp-title='Cost Center : <b>$r[cc]</b> Progress Terakhir : $r[maxpro] %' data-tp-desc='$r[id] : <b>$r[aktivitas]</b> -> ";
										for($ak=1;$ak<=99;$ak++){
											$gca = mysql_fetch_array(mysql_query("SELECT aktivitas,parentId,tahun FROM wbs WHERE id='$idParent'"));
												$fontColor="black";
												if($ak!=1){
													echo"-> ";
												}
												echo "$gca[aktivitas]";
													$idParent=$gca['parentId'];
													$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
													if ($idParent==$cek_id['id_tahun']){
														break;
													}
										}
								echo"'></x>";
								echo'</td>
								<td>'.$r['id'].'</td>
								<td>'.$r['aktivitas'].'</td>
								<td>'.tgl_indo($r['mulai']).'</td>
								<td>'.tgl_indo($r['akhir']).'</td>
								<td>'.$r['cc'].'</td>
								<td>'.$r['deliverable'].'</td>';
								$todayDate 	= date("Y-m-d");
								$now 		= strtotime(date("Y-m-d"));
								$kemarin 	= date('Y-m-d', strtotime('-5 day', $now));
								$besok 		= date('Y-m-d', strtotime('+5 day', $now));
								$date1 		= date_create($kemarin);
								$arr1 		= explode('-',$kemarin);
								$arr2 		= explode('-',$besok);
								$diff 		= gregoriantojd($arr2[1], $arr2[2], $arr2[0])- gregoriantojd($arr1[1], $arr1[2], $arr1[0]);
								for($k=0;$k<=$diff;$k++){  
								$tgl_kerja = date_format($date1,"Y-m-d");
								$b = date_format($date1,"n");
								$d = date_format($date1,"j");
								$ex		= explode("-",$tgl_kerja);
								$year	= $ex[0]; 
								$month	= $ex[1]; 
								$day	= $ex[2];
								$jam	= mysql_fetch_array(mysql_query("SELECT `$d` FROM waktu_kerja2 WHERE  bulan='$month' AND tahun='$year' AND nik='$nik' AND id_gca='$r[id]'"));
									if(date("D",mktime (0,0,0,$month,$day,$year)) == "Sun") {
										echo"<td><span style=\"color:red\">$jam[$d]</span></td>";
									}elseif(date("D",mktime (0,0,0,$month,$day,$year)) == "Sat") {
										 echo"<td><span style=\"color:red\">$jam[$d]</span></td>";
									}
									else{
										if($tgl_kerja==$todayDate){
											$fontColor="blue";
										}else{
											$fontColor="black";
										}
										echo"<td><span style=\"color:$fontColor\">$jam[$d]</span></td>";
									}
								date_add($date1, date_interval_create_from_date_string('1 days'));
								
								}
						echo'</tr>';
						}
			?> 
		</tbody>
	</table>

<script type="text/javascript">
	$(document).ready(function() {
		$('table.display').DataTable();
	} );
</script>
<script src="../../assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("x").adapTip({
	  "placement": "right"
	});
</script>