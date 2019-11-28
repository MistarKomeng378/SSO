<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
<?php
	$id				= mysql_real_escape_string($_POST['id']);
	$parentId		= mysql_real_escape_string($_POST['parentId']);
	$jam			= mysql_real_escape_string($_POST['jam']);
	$id_srko 		= mysql_real_escape_string($_POST['id_srko']);
	$aktivitas		= mysql_real_escape_string($_POST['aktifitas']);
	/////////////////////////////////////////////////////////////
	$tanggal		= mysql_real_escape_string($_POST['tanggal']);
	$ex				= explode("-",$tanggal);
	$tgl_1			= explode("/",$ex[0]);
	$tgl_mulai		= trim($tgl_1[2])."-".trim($tgl_1[1])."-".trim($tgl_1[0]);
	$tgl_2			= explode("/",$ex[1]);
	$tgl_akhir		= trim($tgl_2[2])."-".trim($tgl_2[1])."-".trim($tgl_2[0]);
	$dt1 			= strtotime($tgl_mulai);
	$dt2 			= strtotime($tgl_akhir);
	$diff 			= abs($dt2-$dt1);
	$durasi 		= ($diff/86400); // 86400 detik sehari
	/////////////////////////////////////////////////////////////
	$pic_asli		= mysql_real_escape_string($_POST['pic_asli']);
	$cc				= mysql_real_escape_string($_POST['cc']);
	$cc_id			= mysql_real_escape_string($_POST['cc_id']);
	$deliverable	= mysql_real_escape_string($_POST['deliverable']);
	$tgl_isi		= mysql_real_escape_string($_POST['tgl_isi']);
	$gca_by			= mysql_real_escape_string($_POST['gca_by']);
	$nik			= mysql_real_escape_string($_POST['nik']);
	$tinjau			= mysql_real_escape_string($_POST['tinjau']);
	$hasil_akhir	= mysql_real_escape_string($_POST['hasil_akhir']);
	$lvl			= mysql_real_escape_string($_POST['level']);
	$jenisGCA		= mysql_real_escape_string($_POST['jenis']);
	$tahun_aktif	= mysql_real_escape_string($_POST['tahun_aktif']);
	$jenisAktf		= mysql_real_escape_string($_POST['jenisA']);
	
	$kpi			= mysql_fetch_array(mysql_query("SELECT kode_kpi,icon FROM wbs WHERE id='$parentId' "));
if($jenisGCA==1){
	$icon = "assets/img/folder.png";
}else{
	$icon = "assets/img/file.png";
}
/////////////////////////////////////////////////////////////
	mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$parentId'");
	if($kpi['icon']=="assets/img/file.png"){
		mysql_query("UPDATE wbs SET icon='assets/img/folder.png' WHERE id='$parentId'");
	}	
	$id_baru	= mysql_fetch_array(mysql_query("SELECT max(id) as id FROM wbs  WHERE cc_id='$cc_id' ORDER by parentId DESC"));
	$id_lama	= $id_baru['id']+1;
	$jum1= count($_POST['pic']);
	$jmlpic = 0;
	for($a=0; $a<$jum1; $a++){
		$ppic = $_POST['pic'][$a];
		if($ppic==$pic_asli){
			$jpic = 1;
		}else{
			$jpic = 0;
		}
		$jmlpic += $jpic;
	}
	for($i=0; $i<$jum1; $i++){
		$pic = $_POST['pic'][$i];
		if($pic_asli!=$pic){
			if($jmlpic > 0){
				$idBaru = $id_lama;
			}else{
				if($i == 0){
					$idBaru = $id;
				}else{
					$idBaru = $id_lama;
				}
			}
		}else{
			$idBaru = $id;
		}
		if($_GET['opt']=="edit"){
			mysql_query("REPLACE INTO `wbs` SET `id`		='$idBaru',
											`parentId`		='$parentId',
											`id_srko`		='$id_srko',
											`aktivitas`		='$aktivitas',
											`mulai`			='$tgl_mulai',
											`akhir`			='$tgl_akhir',
											`cc`			='$cc',
											`pic`			='$pic',
											`deliverable`	='$deliverable',
											`kode_kpi`		='$kpi[kode_kpi]',
											`jam`			='$jam',
											`tgl_isi`		='$tgl_isi',
											`hasil_akhir`	='$hasil_akhir',
											`level`			='$lvl',
											`cc_id`			='$cc_id',
											`tahun`			='$tahun_aktif',
											`jenisGCA`		='$jenisGCA',
											`jenisAktf`		='$jenisAktf',
											`icon`			='$icon',
											`gca_by`		='$nik'");		
			
		}else{
			$pic = $_POST['pic'][$i];
			mysql_query("REPLACE INTO `wbs` SET `id`		='$id',
											`parentId`		='$parentId',
											`id_srko`		='$id_srko',
											`aktivitas`		='$aktivitas',
											`mulai`			='$tgl_mulai',
											`akhir`			='$tgl_akhir',
											`cc`			='$cc',
											`pic`			='$pic',
											`deliverable`	='$deliverable',
											`kode_kpi`		='$kpi[kode_kpi]',
											`jam`			='$jam',
											`tgl_isi`		='$tgl_isi',
											`hasil_akhir`	='$hasil_akhir',
											`level`			='$lvl',
											`cc_id`			='$cc_id',
											`tahun`			='$tahun_aktif',
											`jenisGCA`		='$jenisGCA',
											`jenisAktf`		='$jenisAktf',
											`icon`			='$icon',
											`gca_by`		='$nik'");
			
		}
		$start    = new DateTime("$tgl_mulai");
		$start->modify('first day of this month');
		$end      = new DateTime("$tgl_akhir");
		$end->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		$b=1;
		$jumlahJam = 0;
		foreach ($period as $dt) {
			$year 		= $dt->format("Y");
			$month 		= $dt->format("m");
			$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$month,$year);
			if($_GET['opt']=="edit"){
				/////////////////////////////////////////////////////////////////////////////////////////
				$awal_bulan	= date('m', strtotime($tgl_mulai));
				$akhir_bulan= date('m', strtotime($tgl_akhir));
				$min_bulan 	= mysql_fetch_array(mysql_query("SELECT min(bulan) as bulan FROM waktu_kerja2 WHERE id_gca='$idBaru' AND tahun='$year' "));
				$max_bulan 	= mysql_fetch_array(mysql_query("SELECT max(bulan) as bulan FROM waktu_kerja2 WHERE id_gca='$idBaru' AND tahun='$year' "));
				if($min_bulan['bulan'] < $awal_bulan){
					mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$idBaru' AND bulan='$min_bulan[bulan]' AND tahun='$year'");
				}
				if($max_bulan['bulan'] > $akhir_bulan){
					mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$idBaru' AND bulan='$max_bulan[bulan]' AND tahun='$year'");
				}				
				$cek_bulan 	= mysql_num_rows(mysql_query("SELECT bulan FROM waktu_kerja2 WHERE bulan='$month' AND id_gca='$idBaru' "));
				if($cek_bulan == 0){
					mysql_query("INSERT INTO waktu_kerja2(`nik`,`id_gca`,`parentId`,`cc`,`bulan`,`tahun`) VALUES('$pic','$idBaru','$parentId','$cc_id','$month','$year') ");
				}
				$durasi_gca	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$idBaru' AND nik='$pic' AND tahun='$year'"));
				mysql_query("UPDATE wbs SET durasi='$durasi_gca[jum]' WHERE id='$idBaru'");
			}else{/////////////////////////////////////////////////////////////////////////////////////////
				$d=1;
				// if($jam !==""){
					mysql_query("INSERT INTO waktu_kerja2(`nik`,`id_gca`,`parentId`,`cc`,`bulan`,`tahun`) VALUES('$pic','$id','$parentId','$cc_id','$month','$year') ");
					$jumlahHari = 0;
					
					for ($tgl=0;$tgl<$lastDay;$tgl++){				
						$tgl_kerja 	= $year."-".$month."-".$d;
						$tgl_baru 	= date('Y-m-d', strtotime($tgl_kerja));
						$bln	 	= date('n', strtotime($tgl_kerja));
						if(date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
							$time="";
						}elseif(date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
							$time="";
						}else{
							$delLibur = mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal,'%e %m %Y' ) = '$d $month $year' "));
							if($delLibur['tanggal']==$tgl_baru){
								$time="";
							}else{
								$time = 0;
								
								$status = 0;
								$exst = explode(",",$_POST['pengecualian']);
								for($del=0;$del<$count;$del++){
									$ex2 		= explode("/",$exst[$del]);
									@$tgl_expt 		= $ex2[2]."-".$ex2[0]."-".$ex2[1];
									if($tgl_expt == $tgl_baru){
										$status = 1;
									}
								}
								$date1 = date_create($tgl_mulai);
								for ($t=0;$t<=$durasi;$t++){
									$tgl_input = date_format($date1,"Y-m-d");
									if($tgl_input == $tgl_baru){
										$time = $jam;
									}
									date_add($date1, date_interval_create_from_date_string('1 days'));
								}
								
								if($status == 0){
									mysql_query("UPDATE waktu_kerja2 SET  `$d`='$time' WHERE `nik`='$pic' AND `id_gca`='$id' AND bulan='$bln' AND tahun='$year' ");
								}
								if($time > 0){
									$hari = 1;
								}else{
									$hari = 0;
								}
								$jumlahHari += $hari;
								$jumlahJam += $time;
							}						
						}
					$d++;
					}
					mysql_query("UPDATE waktu_kerja2 SET total_jam='$jumlahJam',total_hari='$jumlahHari' WHERE id_gca='$id' AND `parentId`='$parentId' AND nik='$pic' AND bulan='$month' AND tahun='$year' ");
					mysql_query("UPDATE wbs SET durasi='$jumlahJam' WHERE id='$id'");
					$jumlahHari = 0;
					$jumlahJam = 0;
					// $d2 =1;
					// $jumlahHari = 0;
					// for ($tgl=0;$tgl<$lastDay;$tgl++){
						// $jam_kerja = mysql_fetch_array(mysql_query("SELECT `$d2` FROM waktu_kerja2 WHERE `nik`='$pic' AND `id_gca`='$id' AND bulan='$bln' AND tahun='$year' "));
						// if($jam_kerja[$d2] > 0){
							// $hari = 1;
						// }else{
							// $hari = 0;
						// }
						// $jumlahHari += $hari;
						// $d2++;
					// }
					// mysql_query("UPDATE waktu_kerja2 SET total_hari='$jumlahHari' WHERE nik='$pic' AND bulan='$month' AND tahun='$year' AND id_gca='$id'");
					// $jumlahHari = 0;
				// }
				// $update_total_jam = mysql_query("SELECT distinct id_gca,nik,bulan FROM waktu_kerja2 WHERE id_gca='$id'");
				// while($rj=mysql_fetch_array($update_total_jam)){	
					// $durasi_wk	= mysql_fetch_array(mysql_query("SELECT SUM(`1`)+SUM(`2`)+SUM(`3`)+SUM(`4`)+SUM(`5`)+SUM(`6`)+SUM(`7`)+SUM(`8`)+SUM(`9`)+SUM(`10`)+
								// SUM(`11`)+SUM(`12`)+SUM(`13`)+SUM(`14`)+SUM(`15`)+SUM(`16`)+SUM(`17`)+SUM(`18`)+SUM(`19`)+SUM(`20`)+
								// SUM(`21`)+SUM(`22`)+SUM(`23`)+SUM(`24`)+SUM(`25`)+SUM(`26`)+SUM(`27`)+SUM(`28`)+SUM(`29`)+SUM(`30`)+
								// SUM(`31`) as jum FROM waktu_kerja2 WHERE id_gca='$rj[id_gca]' AND bulan='$rj[bulan]' AND nik='$rj[nik]' "));
					// mysql_query("UPDATE waktu_kerja2 SET total_jam='$durasi_wk[jum]' WHERE id_gca='$rj[id_gca]' AND bulan='$rj[bulan]' AND nik='$rj[nik]' ");
					// $durasi_gca	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM waktu_kerja2 WHERE id_gca='$rj[id_gca]' AND nik='$rj[nik]' AND tahun='$year'"));
					// mysql_query("UPDATE wbs SET durasi='$durasi_gca[jum]' WHERE id='$rj[id_gca]'");
				// }
			}/////////////////////////////////////////////////////////////////////////////////////////
		}
		$id_lama++;
		if($_GET['opt']!="edit"){
			$id++;
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////
		$deleteKosong = mysql_query("SELECT id_gca FROM waktu_kerja2 WHERE NOT EXISTS (SELECT id FROM wbs WHERE waktu_kerja2.id_gca=wbs.id) ");
		while($dK=mysql_fetch_array($deleteKosong)){
			mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$dK[id_gca]'");
		}
	/////////////////////////////////////////////////////////////////////////////////////////
if($tinjau==1){
?>

	<h1 class="page-header">GCA Load
		<small><?=$_SESSION['nm_level']?></small>
	</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
			    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Validasi GCA </h4>
		</div>
		<div class="panel-body">
		<form method="POST" action="page/mod_gca/aksi_update2.php" >
		<a href="page.php?page=data_gca" class="btn btn-sm btn-success">Lewati</a>
		<hr>
		<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <ul>
					<li>Jam Kerja perhari tidak boleh lebih dari 8 Jam</li>
					<li>Silahkan lakukan penyesuaian pada GCA dibawah ini</li>
				</ul>
        </div>
		<?php
			$start    = new DateTime($tgl_mulai);
			$start->modify('first day of this month');
			$end      = new DateTime($tgl_akhir);
			$end->modify('first day of next month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			
			foreach ($period as $dt) {
				$jml = count($_POST['pic']);
				for($i=0; $i<$jml; $i++){
					$pic	= $_POST['pic'][$i];
					// echo $pic . "<br>";
					$year 	= $dt->format("Y");
					$month 	= $dt->format("m");
					$day	= trim($tgl_1[1]);
				echo"<h5><b>Data GCA ".name($pic)." ".bulan($month)." $year</b></h5>";
				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			echo'
				<input type="hidden" value='.$year.' name="tahun2[]">
				<input type="hidden" value='.$month.' name="bulan2[]">
				<input type="hidden" value='.$pic.' name="pic[]">
				<table width="100%" border="1" cellpadding="3" style="color:#000000">
					<thead>
						<tr align="center" bgcolor="#ccd9ff">
							<td> <b >No.</b></td>
							<td> <b >Aktivitas</b></td>';
								
								$no=1;
								$endDate=date("t",mktime(0,0,0,$month,$day,$year));
										for ($d=1;$d<=$endDate;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
													$fontColor="red"; 
												}
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
													$fontColor="red"; 
												}
											$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %m %Y' ) = '$d $month $year'"));
											$tglLibur		= $liburaNas['tanggal'];
											$formatLibur	= explode("-",$tglLibur);
											if($formatLibur[2] == $d){
												$fontColor="red";
											}
											if($fontColor=="red"){
												$bgcolor="ffad99";
											}else{
												$bgcolor="";
											}
												echo "<td bgcolor='$bgcolor'> <span style=\"color:$fontColor\"><b>$d</b></span></td>"; 
										}
						echo'</tr>
					</thead>
					<tbody>';
						$query = mysql_query("SELECT 	wbs.aktivitas,
														wbs.id,
														wbs.cc,
														waktu_kerja2.nik,
														waktu_kerja2.bulan,
														waktu_kerja2.tahun,
														waktu_kerja2.`1`,
														waktu_kerja2.`2`,
														waktu_kerja2.`3`,
														waktu_kerja2.`4`,
														waktu_kerja2.`5`,
														waktu_kerja2.`6`,
														waktu_kerja2.`7`,
														waktu_kerja2.`8`,
														waktu_kerja2.`9`,
														waktu_kerja2.`10`,
														waktu_kerja2.`11`,
														waktu_kerja2.`12`,
														waktu_kerja2.`13`,
														waktu_kerja2.`14`,
														waktu_kerja2.`15`,
														waktu_kerja2.`16`,
														waktu_kerja2.`17`,
														waktu_kerja2.`18`,
														waktu_kerja2.`19`,
														waktu_kerja2.`20`,
														waktu_kerja2.`21`,
														waktu_kerja2.`22`,
														waktu_kerja2.`23`,
														waktu_kerja2.`24`,
														waktu_kerja2.`25`,
														waktu_kerja2.`26`,
														waktu_kerja2.`27`,
														waktu_kerja2.`28`,
														waktu_kerja2.`29`,
														waktu_kerja2.`30`,
														waktu_kerja2.`31`
														FROM
														waktu_kerja2
														INNER JOIN wbs ON waktu_kerja2.id_gca = wbs.id
														WHERE waktu_kerja2.nik='$pic' AND waktu_kerja2.bulan='$month' AND waktu_kerja2.tahun='$year'
														ORDER BY wbs.id
														");

						while($r=mysql_fetch_array($query)){
							$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$r[id]'"));
							$idParent	= $data['parentId'];
							echo"
								<input type='hidden' name='id_gca1[]' value='$r[id]' size='1'/>
								<tr>
									<td align='center' width='2%'>$no</td>
									<td width='25%'>
									<z class='' data-tp-title='Cost Center : <b>$r[cc]</b>' data-tp-desc='
									";
									
									echo "$r[id] : <b>$r[aktivitas]</b> -> ";
									for($ak=1;$ak<=99;$ak++){
										$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
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
									echo"'>$r[aktivitas]</z></td>";
										for ($d=1;$d<=$endDate;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
													$fontColor="#FF6347";
													$bgcolor="#ffad99";
											}else{
													$bgcolor="#b3ffb3";
											}
											if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
													$fontColor="#FF6347";
													$bgcolor="#ffad99"; 
												}
											$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %m %Y' ) = '$d $month $year'"));
											$tglLibur		= $liburaNas['tanggal'];
											$formatLibur	= explode("-",$tglLibur);
											if($formatLibur[2] == $d){
												$fontColor="red";
												$bgcolor="#ffad99";
											}
											echo "<td width='20px' align='center' bgcolor='$bgcolor'><span style=\"color:$fontColor\">
														<input type='hidden' name='nik' value='$pic' size='1'/>
														<input type='hidden' name='id_gca[]' value='$r[id]' size='1'/>
														<input type='hidden' name='tgl_kerja[]' value='$year-$month-$d' size='1'/>
														<input type='hidden' name='bulan' value='$month' size='1'/>
														<input type='hidden' name='tahun' value='$year' size='1'/>
														<input type='text' name='jam_kerja_$d-$month-$r[id]' value='$r[$d]' size='1'/>
													</span></td>"; 
										}
							echo"</tr>";
							$no++;
						}
						echo"
							<tr>
								<td colspan='2' align='center'><b>Jumlah</b></td>";
								for ($d=1;$d<=$endDate;$d++) {
									$jml_wk = mysql_fetch_array(mysql_query("SELECT sum(`$d`) as jum_jam FROM waktu_kerja2 WHERE `nik`='$pic' AND `bulan`='$month' AND `tahun`='$year'  "));
									if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
										$fontColor="red"; 
									}elseif(date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
										$fontColor="red";
									}else{
										if($jml_wk['jum_jam']>8){
										$fontColor="red";
										}elseif($jml_wk['jum_jam']<8){
											$fontColor="blue";
										}else{
											$fontColor="black";
										}
										$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %m %Y' ) = '$d $month $year'"));
										$tglLibur		= $liburaNas['tanggal'];
										$formatLibur	= explode("-",$tglLibur);
										if($formatLibur[2] == $d){
											$fontColor="red";
										}
									}
									echo "<td width='20px' align='center' bgcolor='#ffff4d'><span style=\"color:$fontColor\"><b>$jml_wk[jum_jam]</b></span></td>"; 
								}
					echo"</tr>
					</tbody>
				</table>";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				}
			}
		?>
			<button type="submit" name="simpan" value="simpan" class="btn btn-sm btn-primary" title="Simpan semua perubahan">Selesai</button>
		</form>
		</div>
	</div>
<?php
}else{
	header("Location: page.php?page=data_gca&succes=1");
}
?>
<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "right"
	});
</script>