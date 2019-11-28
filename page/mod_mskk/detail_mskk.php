<?php
	$getId		= explode("-",$_GET['id']);
	$getNik		= mysql_real_escape_string(dc($getId[0]));
	$getBulan	= mysql_real_escape_string(dc($getId[1]));
	$getTahun	= mysql_real_escape_string(dc($getId[2]));
	$getLvl		= mysql_real_escape_string($_GET['lvl']);
	$duser		= mysql_fetch_array(mysql_query("SELECT * FROM v_karyawan WHERE regno='$getNik' "));
	$jmlData= mysql_fetch_array(mysql_query("SELECT COUNT(*) as data FROM mskk WHERE nik='$getNik' AND bulan='$getBulan' AND tahun='$getTahun'"));
	$lock 	= mysql_fetch_array(mysql_query("SELECT COUNT(`lock`) as `lock` FROM mskk WHERE `lock`='1' AND nik='$getNik' AND bulan='$getBulan' AND tahun='$getTahun'"));
?>

			<h1 class="page-header">MSKK
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Matrik Sasaran Kerja Karyawan - <?=name($getNik)?> Bulan <?=bulan($getBulan)?> Tahun <?=$getTahun?></h4>
			    </div>
			    <div class="panel-body">
			<?php
			if($jmlData['data']==$lock['lock']){
				if($jmlData['data']!=0){
					$disable = "disabled";
				}else{
					$disable = "";
				}
			}else{
				$disable = "";
			}
			if($_SESSION['level']==4 AND $_SESSION['cc']==$duser['dept']){
				if($_GET['lvl']!=4){
					echo"<a $disable href='page/mod_mskk/aksi_mskk_karyawan.php?tahun=$getTahun&id=".ec($duser['id'])."&unit=".ec($duser['dept'])."&nik=".ec($getNik)."&lvl=$getLvl&bulan=".ec($getBulan)."&opt=tambah' class='btn btn-sm btn-success'><i class='fa fa-refresh'></i>  Generate</a>";
				}else{
					echo"<a $disable href='page/mod_mskk/aksi_mskk_kepala.php?tahun=$getTahun&id=".ec($duser['id'])."&unit=".ec($duser['dept'])."&nik=".ec($getNik)."&lvl=$getLvl&bulan=".ec($getBulan)."&opt=tambah' class='btn btn-sm btn-success'><i class='fa fa-refresh'></i>  Generate</a>";
				}
			}elseif($_SESSION['level']==5 AND $_SESSION['nik']==$getNik){
				echo"<a $disable href='page/mod_mskk/aksi_mskk_karyawan.php?tahun=$getTahun&id=".ec($duser['id'])."&unit=".ec($duser['dept'])."&nik=".ec($getNik)."&lvl=$getLvl&bulan=".ec($getBulan)."&opt=tambah' class='btn btn-sm btn-success'><i class='fa fa-refresh'></i>  Generate</a>";
			}else{
				if($getInsert==1){
					if($_GET['lvl']!=4){
						echo"<a $disable href='page/mod_mskk/aksi_mskk_karyawan.php?tahun=$getTahun&id=".ec($duser['id'])."&unit=".ec($duser['dept'])."&nik=".ec($getNik)."&lvl=$getLvl&bulan=".ec($getBulan)."&opt=tambah' class='btn btn-sm btn-success'><i class='fa fa-refresh'></i>  Generate</a>";
					}else{
						echo"<a $disable href='page/mod_mskk/aksi_mskk_kepala.php?tahun=$getTahun&id=".ec($duser['id'])."&unit=".ec($duser['dept'])."&nik=".ec($getNik)."&lvl=$getLvl&bulan=".ec($getBulan)."&opt=tambah' class='btn btn-sm btn-success'><i class='fa fa-refresh'></i>  Generate</a>";
					}
				}
			}
			if($_SESSION['level']==1){
				if($getInsert==1){
					if($jmlData['data']==$lock['lock']){
						if($jmlData['data']!=0){
							echo" <a href='?page=detail_mskk&id=".ec($getNik)."-".ec($getBulan)."-".ec($getTahun)."&lvl=$getLvl&unlock=1' class='btn btn-sm btn-danger'><i class='fa fa-unlock'></i> Unlock</a>";
						}else{
							echo" <a href='?page=detail_mskk&id=".ec($getNik)."-".ec($getBulan)."-".ec($getTahun)."&lvl=$getLvl&lock=2' class='btn btn-sm btn-success'><i class='fa fa-lock'></i> Lock</a>";
						}					
					}else{
						echo" <a href='?page=detail_mskk&id=".ec($getNik)."-".ec($getBulan)."-".ec($getTahun)."&lvl=$getLvl&lock=2' class='btn btn-sm btn-success'><i class='fa fa-lock'></i> Lock</a>";
					}
				}
			}
			echo"<p></p>";
			if(isset($_REQUEST['lock'])){
				mysql_query("UPDATE mskk SET `lock`='1' WHERE nik='$getNik' AND bulan='$getBulan' AND tahun='$getTahun' ");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Kunci.
                    </div>";
					header('Location: page.php?page=detail_mskk&id='.ec($getNik).'-'.ec($getBulan).'-'.ec($getTahun).'&lvl='.$getLvl.'');
			}if(isset($_REQUEST['unlock'])){
				mysql_query("UPDATE mskk SET `lock`='0' WHERE nik='$getNik' AND bulan='$getBulan' AND tahun='$getTahun'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Kunci data telah dibuka.
                    </div>";
					header('Location: page.php?page=detail_mskk&id='.ec($getNik).'-'.ec($getBulan).'-'.ec($getTahun).'&lvl='.$getLvl.'');
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
			<table class="table table-bordered table-striped table-hover" >
				<thead>
					<tr>
					<?php
						if($_GET['lvl']==4){
							echo'<th width="3%" >No.</th>
								<th >Rencana Kerja</th>
								<th >Bobot Awal</th>
								<th >Bobot Konversi</th>
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
								<th >Bobot Konversi</th>
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
						$query = mysql_query("SELECT	mskk.*,
														wbs.aktivitas
														FROM
														mskk
														INNER JOIN wbs ON mskk.id_gca = wbs.id 
														WHERE mskk.nik='$getNik' AND mskk.bulan='$getBulan' AND mskk.tahun='$getTahun'
														ORDER BY id_srko ASC
														");
						if($_GET['lvl']==4){
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
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" >
				<tr align="center">
					<td><b>Pencapaian (%)</b></td>
					<td> 110 ></td>
					<td>110 >= x > 100</td>
					<td>100 >= x > 90</td>
					<td>90 >= x > 80</td>
					<td>80 >= x > 70</td>
					<td>70 >= x > 60</td>
					<td>60 >= x > 50</td>
					<td>50 >= x > 40</td>
					<td>40 >= x > 20</td>
					<td>20 >= x > 0</td>
					<td>0</td>
				</tr>
				<tr align="center">
					<td><b>Score</b></td>
					<td>10</td>
					<td>9</td>
					<td>8</td>
					<td>7</td>
					<td>6</td>
					<td>5</td>
					<td>4</td>
					<td>3</td>
					<td>2</td>
					<td>1</td>
					<td>0</td>
				</tr>
			</table>
		</div>
		</div>
	</div>