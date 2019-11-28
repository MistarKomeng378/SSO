<style>
/*    css disini*/
 
    .mytable th{
        background-color: #ccd9ff
    }
</style>

			<h1 class="page-header">GCA Load
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Beban Karyawan Berdasarkan GCA</h4>
			    </div>
			    <div class="panel-body">
					<div class="table-responsive">
					<form method="GET" action="<?=$_SERVER['PHP_SELF']?>">
							<div class="form-group  col-lg-12 row">
								<div class="form-group  col-lg-3">
									<input type="hidden" name="page" value="gca_load">
									<select name="unit" class="form-control">
										<option value="">Pilih Unit</option>
										<?php
											if(isset($_GET['unit'])){
												$getUnit = dc($_GET['unit']);
											}else{
												$getUnit = $_SESSION['cc'];
											}
											$qunit = mysql_query("SELECT * FROM mskko WHERE id !='1.6' AND id != '4' order by id");
											while($unit=mysql_fetch_array($qunit)){
												echo"<option value='".ec($unit['CostCenter'])."' ";if($unit['CostCenter']==$getUnit){echo"selected";} echo">$unit[uraian]</option>";
											}
										?>
									</select>
								</div>
								<div class="form-group  col-lg-4">
									<input type="submit" value="Pilih" class="btn btn-primary">
									<a target="_blank" href="print/print_gca_load_excel.php?id=<?=ec($getUnit)."-".ec($tahun_aktif)?>" class="btn btn-success"><i class="fa fa-print" ></i> Cetak Excel</a>
								</div>
							</div>
						</form>
						<table id="example1" class="table table-striped table-bordered table-hover nowrap mytable" width="100%">
							<thead>
								<tr>
									<th rowspan="2">No.</th>
									<th rowspan="2">NIK</th>
									<th rowspan="2">NAMA</th>
									<th rowspan="2">JABATAN</th>
									<th rowspan="2">DIVISI</th>
									<th colspan="12">BULAN</th>
									<th rowspan="2">TOTAL</th>
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
								<?php
									$tahun = $tahun_aktif;
									$no=1;
									if(isset($_GET['unit'])){
										$query = mysql_query("SELECT	m_jabatan.posdesc,
																		m_karyawan.regno,
																		m_karyawan.`name`,
																		m_karyawan.poscode,
																		m_karyawan.email,
																		mskko.uraian,
																		mskko.CostCenter,
																		m_jabatan.poscode
																		FROM
																		m_karyawan
																		LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																		INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																		WHERE m_karyawan.dept='".dc($_GET['unit'])."' AND m_karyawan.status='0'
																		ORDER BY m_karyawan.regno");

									}else{
										$query = mysql_query("SELECT	m_jabatan.posdesc,
																		m_karyawan.regno,
																		m_karyawan.`name`,
																		m_karyawan.poscode,
																		m_karyawan.email,
																		mskko.uraian,
																		mskko.CostCenter,
																		m_jabatan.poscode
																		FROM
																		m_karyawan
																		LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																		INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																		WHERE m_karyawan.dept='$_SESSION[cc]' AND m_karyawan.status='0'
																		ORDER BY m_karyawan.regno");
									}
									while($r=mysql_fetch_array($query)){
										echo"
										<tr>
											<td>$no</td>
											<td>$r[regno]</td>
											<td>$r[name]</td>
											<td>$r[posdesc]</td>
											<td>$r[uraian]</td>";
											$start    = new DateTime("$tahun_aktif-01-01");
											$start->modify('first day of this month');
											$end      = new DateTime("$tahun_aktif-12-01");
											$end->modify('first day of next month');
											$interval = DateInterval::createFromDateString('1 month');
											$period   = new DatePeriod($start, $interval, $end);
											$b=1;
											foreach ($period as $dt) {
												$year 		= $dt->format("Y");
												$month 		= $dt->format("m");
												$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$month,$year);						
												
												$i		= 0;
												$x   	= 0;
												$endz   = 1;

												$mulai	="$year-$month-01";
												$akhir	="$year-$month-$lastDay";
												$date1 	= date_create($mulai);
												$s 		= strtotime($mulai);
												$e 		= strtotime($akhir);
												$diff 	= ($e-$s)/86400;
												// echo"$year-$month<br>";
												for($k=0;$k<=$diff;$k++){  
													$tgl_kerja = date_format($date1,"Y-m-d");
													
													$ex		= explode("-",$tgl_kerja);
													$tahun	= $ex[0]; 
													$bulan	= $ex[1]; 
													$hari	= $ex[2];
													
													if(date("D",mktime (0,0,0,$month,$hari,$year)) == "Sun") {
														
													}elseif(date("D",mktime (0,0,0,$month,$hari,$year)) == "Sat") {
														 
													}
													else{
														$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%d %m %Y' ) = '$hari $bulan $tahun'"));
														if($liburaNas['tanggal'] == $tgl_kerja){
															
														}else{
															// echo"$tgl_kerja<br>";
															$x += $endz-$i;
														}
													}
													date_add($date1, date_interval_create_from_date_string('1 days'));
												}
												
												$jumHariKerja 	= $x;
												$jumJamKerja	= $jumHariKerja * 8;
												$wk = mysql_fetch_array(mysql_query("SELECT SUM(`total_jam`) as jum FROM waktu_kerja2 
																							WHERE nik='$r[regno]' AND bulan='$month' AND tahun='$year'"));
												if($wk['jum'] > $jumJamKerja){
													$fontColor="red"; 
												}elseif($wk['jum'] < $jumJamKerja){
													$fontColor="blue"; 
												}else{
													$fontColor="black"; 
												}
												echo"<td><a href='?page=gca_load_detail&id=".ec($r['regno'])."-".ec($b)."-".ec($tahun)."-".ec($_SESSION['cc'])."' target='_blank'><span style=\"color:$fontColor\"><b>".desimal2($wk['jum'])." </b></span></a></td>";
												$b++;
											}
											$tot_jam = mysql_fetch_array(mysql_query("SELECT SUM(`total_jam`) as total FROM waktu_kerja2 
																							WHERE nik='$r[regno]' AND tahun='$year'"));
									echo"	<td>$tot_jam[total]</td>
										</tr>
										";
									$no++;
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>