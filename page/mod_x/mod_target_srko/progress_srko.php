<?php
$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
$tahun_tsrko = $_COOKIE['tahun_tsrko'];
$idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
?>

			<h1 class="page-header">Progress SRKO
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			        </div>
			        <h4 class="panel-title">Sasaran/Rencana Kerja Organisasi <?=$unit['uraian']?> Tahun <?=$tahun_tsrko?></h4>
			    </div>
			    <div class="panel-body">
			<?php
			
			if(isset($_REQUEST['delete'])){
				// mysql_query("DELETE FROM srko WHERE id_srko='$_GET[id_srko]'");
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
		?>
			<?php
			if($getInsert==1){
				echo"<a href='?page=form_progress&unit=".ec($unit['CostCenter'])."' class='btn btn-primary'><i class='fa fa-plus'></i> Input Progress</a>";
			}
			echo" <a href='print/print_data_srko.php?id=".ec($unit['CostCenter'])."-".ec($tahun_tsrko)."' target='_blank' class='btn btn-success'><i class='fa fa-download'></i> Download</a>";
			?>
			<hr>
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center' bgcolor="#b3d9ff">
						<td  rowspan="2"><b>No.</b></td>
						<td rowspan="2"><b>Sasaran/Rencana Kerja</td>
						<td rowspan="2"><b>Bobot</b></td>
						<td rowspan="2"><b>Target Tahunan</b></td>
						<td rowspan="2"><b></b></td>
						<td colspan="12"><b>Target Bulanan</b></td>
						<td rowspan="2"><b>Bulan Berjalan</b></td>
					</tr>
					<tr align='center' bgcolor="#b3d9ff">
						<?php
						for($i=1;$i<=12;$i++){
							echo"<td align='center'><b>$i</b></td>";
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						$data=0;
						$query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$tahun_tsrko' order by id_srko");
						while($r=mysql_fetch_array($query)){
							echo"
							<tr>
								<td align='center' rowspan='3'>$no</td>
								<td  rowspan='3'>$r[rencana_kerja]</td>
								<td  rowspan='3' align='center'>$r[bobot]</td>
								<td  rowspan='3'>$r[target] $r[satuan]</td>
								<td bgcolor='#ffcccc'>Target</td>
								";
								$jr = mysql_fetch_array(mysql_query("SELECT DISTINCT jenis_resume FROM progress_srko WHERE tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
								$jrbul = mysql_fetch_array(mysql_query("SELECT COUNT(realisasi) as bln FROM progress_srko WHERE tahun='$tahun_tsrko' AND id_srko='$r[id_srko]' AND realisasi!=''"));
								for($i=1;$i<=13;$i++){
									$target = mysql_fetch_array(mysql_query("SELECT * FROM target_srko WHERE bulan='$i' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
									if($i==13){
										if($jr['jenis_resume']==1){
											$jr1 = mysql_fetch_array(mysql_query("SELECT target FROM progress_srko WHERE bulan='$jrbul[bln]' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
											$tot_target =desimal3($jr1['target']);
										}elseif($jr['jenis_resume']==2){
											$jr2 = mysql_fetch_array(mysql_query("SELECT SUM(target) as sumtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
											$tot_target =desimal3($jr2['sumtarget']);
										}elseif($jr['jenis_resume']==3){
											$jr3 = mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
											$tot_target =desimal3($jr3['avgtarget']);
										}elseif($jr['jenis_resume']==4){
											$jr3 = mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
											$tot_target =desimal3($jr3['avgtarget']);
											
											// $pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
											// $hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
											// $tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100;														
											// $tot_target = desimal3($tpm);
										}
										echo"<td bgcolor='#ffcccc' align='center'>$tot_target</td>";
									}else{									
										echo"<td width='5%' bgcolor='#ffcccc' align='center'>$target[target]</td>";
									}
								}
						echo"</tr>";
								for($row=1;$row<=2;$row++){
									if($row==1){
										$rowname = "Realisasi";
										$rowcolor = "#ffffb3";
									}else{
										$rowname = "Pencapaian";
										$rowcolor = "#b3ffb3";
									}
									echo"<tr bgcolor='$rowcolor'>
											<td>$rowname</td>";
										for($cols=1;$cols<=13;$cols++){
											$prog = mysql_fetch_array(mysql_query("SELECT pencapaian,jenis_pencapaian,jenis_resume,target,realisasi FROM progress_srko WHERE bulan='$cols' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
											if($row==1){
												if($cols>=1 AND $cols<=12){
													if($prog['jenis_pencapaian']==3){
														$nilai = desimal2($prog['realisasi']);
													}else{
														$nilai = $prog['realisasi'];
													}													
												}else{
													if($jr['jenis_resume']==1){
														$jr1 = mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko WHERE bulan='$jrbul[bln]' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														$nilai = desimal3($jr1['realisasi']);
														$realprog = $jr1['realisasi'];
													}elseif($jr['jenis_resume']==2){
														$jr2 = mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as sumrealisasi FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														$nilai = desimal3($jr2['sumrealisasi']);
														$realprog = $jr2['sumrealisasi'];
													}elseif($jr['jenis_resume']==3){
														$jr3 = mysql_fetch_array(mysql_query("SELECT AVG(realisasi) as avgrealisasi FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														$nilai = desimal3($jr3['avgrealisasi']);
														$realprog = $jr3['avgrealisasi'];
													}elseif($jr['jenis_resume']==4){
														$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														$hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														$tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100;														
														$nilai = desimal2($tpm);
														$realprog = $nilai;
													}
												}
											}else{
												if($prog['jenis_pencapaian']==1){
													// if($prog['target']==0 AND $prog['realisasi']>0){
														// $hasil = 100;
													// }elseif($prog['target']==0 AND $prog['realisasi']==0){
														// $hasil = 0;
													// }else{
														// $hasil = ($prog['realisasi']/$prog['target'])*100;
													// }
													if($prog['target']==0 AND $prog['realisasi']>0){
														$hasil = 100;
													}elseif($prog['target']>0 AND $prog['realisasi']<=0){
														$hasil = 0;
													}elseif($prog['target']==0 AND $prog['realisasi']<=0){
														$hasil = 100;
													}else{
														$hasil = ($prog['realisasi']/$prog['target'])*100;
													}														
												}elseif($prog['jenis_pencapaian']==2){
													// if($prog['target']==0 AND $prog['realisasi']>0){
														// $hasil = 100;
													// }elseif($prog['target']==0 AND $prog['realisasi']==0){
														// $hasil = 0;
													// }else{
														// $hasil = (($prog['target'] - ($prog['realisasi']-$prog['target'])) / $prog['target']) * 100;
													// }
													if($prog['target']==0 AND $prog['realisasi']>0){
														$hasil = 100;
													}elseif($prog['target']>0 AND $prog['realisasi']<=0){
														$hasil = 0;
													}elseif($prog['target']==0 AND $prog['realisasi']<=0){
														$hasil = 100;
													}else{
														$hasil = (($prog['target'] - ($prog['realisasi']-$prog['target'])) / $prog['target']) * 100;
													}
												}elseif($prog['jenis_pencapaian']==3){
													// if($prog['target']==0 AND $prog['realisasi']>0){
														// $hasil = 100;
													// }elseif($prog['target']==0 AND $prog['realisasi']==0){
														// $hasil = 0;
													// }else{
														// $hasil = ($prog['realisasi']/$prog['target'])*100;
													// }
													if($prog['target']==0 AND $prog['realisasi']>0){
														$hasil = 100;
													}elseif($prog['target']>0 AND $prog['realisasi']<=0){
														$hasil = 0;
													}elseif($prog['target']==0 AND $prog['realisasi']<=0){
														$hasil = 100;
													}else{
														$hasil = ($prog['realisasi']/$prog['target'])*100;
													}														
												}
												if($hasil <= 0 AND ($cols>=1 AND $cols<=12)){
													$nilai=0;
												}elseif($hasil > 0 AND ($cols>=1 AND $cols<=12)){
													if($hasil>120){
														$nilai=120;
													}else{
														$nilai=desimal3($hasil);
													}
													
												}else{
													$prog2 = mysql_fetch_array(mysql_query("SELECT distinct jenis_pencapaian FROM progress_srko WHERE tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
													if($prog2['jenis_pencapaian']==1){
														if($tot_target==0 AND $realprog>0){
															$hasil = 100;
														}elseif($tot_target==0 AND $realprog==0){
															$hasil = 0;
														}else{
															$hasil = ($realprog/$tot_target)*100;
														}										
													}elseif($prog2['jenis_pencapaian']==2){
														if($tot_target==0 AND $realprog>0){
															$hasil = 100;
														}elseif($tot_target==0 AND $realprog==0){
															$hasil = 0;
														}else{
															$hasil = (($tot_target - ($realprog-$tot_target)) / $tot_target) * 100;
														}
													}elseif($prog2['jenis_pencapaian']==3){
														//ini untuk pencapaian jp 3
														$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as rpm, SUM(hpp) as hpp FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														
														if($tot_target==0 AND $realprog>0){
															$hasil = 100;
														}elseif($tot_target==0 AND $realprog==0){
															$hasil = 0;
														}else{
															$hasil = ($realprog/$tot_target)*100;
														}
													}
													if($hasil <= 0 AND $cols==13){
														$nilai=0;
													}elseif($hasil > 0 AND $cols==13){
														if($hasil>120){
															$nilai=120;
														}else{
															$nilai=desimal3($hasil);
														}
													}
													// $nilai = $tot_target."<>".$realprog;
													// $nilai = $prog2['jenis_pencapaian'];
												/////////////////////////////////////////////////////
													// if($jr['jenis_resume']==1){
														// $jr1 = mysql_fetch_array(mysql_query("SELECT pencapaian FROM progress_srko WHERE bulan='$jrbul[bln]' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														// $nilai = desimal3($jr1['pencapaian']);
													// }elseif($jr['jenis_resume']==2){
														// $jr2 = mysql_fetch_array(mysql_query("SELECT AVG(pencapaian) as avgpencapaian FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														// $nilai = desimal3($jr2['avgpencapaian']);
													// }elseif($jr['jenis_resume']==3){
														// $jr3 = mysql_fetch_array(mysql_query("SELECT SUM(pencapaian) as sumpencapaian FROM progress_srko WHERE (bulan BETWEEN '1' AND '$jrbul[bln]') AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
														// $nilai = desimal3($jr3['sumpencapaian']);
													// }
												}
											}
											echo"<td align='center'>$nilai</td>";
										}
									echo"
									</tr>";
								}
						$no++;
						$data++;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>