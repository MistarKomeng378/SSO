<h1 class="page-header">Summary KKWK
	<small><?=$_SESSION['nm_level']?></small>
</h1>
		
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Summary KKWK</h4>
	</div>
	<div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
		
		<?php
		include"config/fungsi_timeline.php";
		
		if(isset($_POST['tahun'])){
			$thKKWK = $_POST['tahun'];
		}else{
			$thKKWK = date("Y");
		}
		echo"<form method='POST' action='page.php?page=summary_kkwk' id='formku'>
				<div class='form-group  col-lg-12 row'>
					<div class='form-group  col-lg-2'>
						<input type='hidden' name='page' value='summary_kkwk'>
						<input type='hidden' name='opt' value='cari'>
						<select name='bulan' class='form-control required'>
							<option value=''>Pilih Bulan</option>";
									for($i=1;$i<=12;$i++){
										echo"<option value='$i'"; if($_POST['bulan']==$i){echo"selected";} echo">".bulan($i)."</option>";
									}
					echo"</select>
					</div>
					<div class='form-group  col-lg-2'>
						<select name='tahun' class='form-control '>
								<option value=''>Pilih Tahun</option>";
									$qsbdth = mysql_query("SELECT * FROM tahun");
									while($r=mysql_fetch_array($qsbdth)){
										echo"<option value='$r[tahun]'"; if($thKKWK==$r['tahun']){echo"selected";} echo">$r[tahun]</option>";
									}
					echo"</select>
					</div>";
					if($_SESSION['level']!=5 AND $_SESSION['level']!=4){	
					echo"<div class='form-group  col-lg-3'>
					<select name='unit' class='form-control'>
							<option value=''>Pilih Unit</option>";
									$qunit = mysql_query("SELECT * FROM mskko WHERE id!='1.6' AND id !='4' order by id");
									while($unit=mysql_fetch_array($qunit)){
										echo"<option value='$unit[CostCenter]'"; if($_POST['unit']==$unit['CostCenter']){echo"selected";} echo">$unit[uraian]</option>";
									}
					
					echo"</select>
					</div>";
					}
				echo"
					<div class='form-group  col-lg-3'>
						<input type='submit' value='Pilih' class='btn btn-primary'>";
						if($_SESSION['level']==5){
							echo" <a target='_blank' href='print/print_summary_kkwk.php?id=".ec($_POST['bulan'])."-".ec($thKKWK)."&unit=".ec($_POST['unit'])."&nik=".ec($_SESSION['nik'])."' class='btn btn-danger'><i class='fa fa-file-pdf-o'></i> PDF</a>
								<a target='_blank' href='print/print_summary_kkwk_excel.php?id=".ec($_POST['bulan'])."-".ec($thKKWK)."&unit=".ec($_POST['unit'])."&nik=".ec($_SESSION['nik'])."' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>";
						}elseif($_SESSION['level']==4){
							echo" <a target='_blank' href='print/print_summary_kkwk.php?id=".ec($_POST['bulan'])."-".ec($thKKWK)."&unit=".ec($_SESSION['cc'])."' class='btn btn-danger'><i class='fa fa-file-pdf-o'></i> PDF</a>
								<a target='_blank' href='print/print_summary_kkwk_excel.php?id=".ec($_POST['bulan'])."-".ec($thKKWK)."&unit=".ec($_SESSION['cc'])."' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>";
						}else{
							echo" <a target='_blank' href='print/print_summary_kkwk.php?id=".ec($_POST['bulan'])."-".ec($thKKWK)."&unit=".ec($_POST['unit'])."' class='btn btn-danger'><i class='fa fa-file-pdf-o'></i> PDF</a>
								<a target='_blank' href='print/print_summary_kkwk_excel.php?id=".ec($_POST['bulan'])."-".ec($thKKWK)."&unit=".ec($_POST['unit'])."' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>";
						}
						
					echo"</div>
				</div>
			</form>";
		?>
		<hr>
			<table width="100%" border="1" cellpadding="3" style="color:#000000">
				<thead>
					<tr align="center">
						<td width="3%"><b>No</b></td>
						<th width="4%"><b>NIK</b></th>
						<th width="18%"><b>Nama</b></th>
						
						<?php
							$month 	= mysql_real_escape_string($_POST['bulan']);
							$year 	= mysql_real_escape_string($_POST['tahun']);
							$day	= date("d");
							$no=1;
							$endDate=date("t",mktime(0,0,0,$month,$day,$year));
								for ($d=1;$d<=$endDate;$d++) { 
								$fontColor="#000000"; 
								if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") {
									$fontColor="red"; 
								}
								if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sat") {
									$fontColor="red"; 
									$bgcolor="red"; 
								}
								$liburaNas 		= mysql_fetch_array(mysql_query("SELECT * FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $month $year'"));
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
						?>
						<td ><b>Tot</b></td>
						<td ><b>Isi</b></td>
						<td ><b>Rt</b></td>
						<td ><b>RK</b></td>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						if($_POST['opt']=="cari"){
							
									
									if(!empty($_POST['unit'])){
										$nik_manager = mysql_fetch_array(mysql_query("SELECT nik FROM v_manager WHERE CostCenter='$_POST[unit]' "));
										$unit = "AND mskko.CostCenter='$_POST[unit]' AND m_karyawan.regno!='$nik_manager[nik]' ";										
									}
									if($_SESSION['level']==4){
										$query = mysql_query("SELECT m_karyawan.regno as nik,
																		m_karyawan.`name`,
																		m_karyawan.`status`,
																		mskko.CostCenter AS cc,
																		`user`.`level`
																		FROM
																		m_karyawan
																		INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																		LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																		INNER JOIN `user` ON `user`.nik = m_karyawan.regno
																		WHERE `user`.`level`!='2' 
																		AND `user`.`level`!='3' 
																		AND mskko.id !='1.6' 
																		AND mskko.CostCenter='$_SESSION[cc]' 
																		AND m_karyawan.regno NOT LIKE '%DM%' 
																		AND m_karyawan.status='0'
																		ORDER BY regno");
									}elseif($_SESSION['level']==5){
										$query = mysql_query("SELECT m_karyawan.regno as nik,
																		m_karyawan.`name`,
																		m_karyawan.`status`,
																		mskko.CostCenter AS cc,
																		`user`.`level`
																		FROM
																		m_karyawan
																		INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																		LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																		INNER JOIN `user` ON `user`.nik = m_karyawan.regno
																		WHERE  `user`.`level`!='2' 
																		AND `user`.`level`!='3' 
																		AND mskko.id !='1.6' 
																		AND m_karyawan.regno='$_SESSION[nik]' 
																		AND m_karyawan.status='0'
																		ORDER BY regno");

									}else{
										$query = mysql_query("SELECT m_karyawan.regno as nik,
																		m_karyawan.`name`,
																		m_karyawan.`status`,
																		mskko.CostCenter AS cc,
																		`user`.`level`
																		FROM
																		m_karyawan
																		INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
																		LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
																		INNER JOIN `user` ON `user`.nik = m_karyawan.regno
																		WHERE `user`.`level`!='2' 
																		AND `user`.`level`!='3' 
																		AND mskko.id !='1.6' 
																		AND m_karyawan.regno NOT LIKE '%DM%' 
																		AND m_karyawan.status='0' $unit 
																		ORDER BY regno");
									}
							timeline($_SESSION['nik'],"cari","pecarian Summary KKWK berdasrkan CostCenter : $_POST[unit] bulan : ".bulan($_POST['bulan'])." Tahun: $_POST[tahun] ");
						}						
						while($r=mysql_fetch_array($query)){
							
							echo"
								<tr>
									<td align='center'>$no</td>
									<td>$r[nik] </td>
									<td>$r[name] </td>";
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
											$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $month $year'"));
											$tglLibur		= $liburaNas['tanggal'];
											$formatLibur	= explode("-",$tglLibur);
											if($formatLibur[2] == $d){
												$fontColor="red";
												$bgcolor="#ffad99";
											}
											
											$wk = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total_jam, SUM(total_menit) as total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%e %c %Y' ) = '$d $month $year'"));
											if($wk['total_menit']>30){
												$sisa_jam = 1;
											}else{
												$sisa_jam = 0;
											}
											$jum_jam	= $wk['total_jam']+$sisa_jam;
											if($jum_jam>0){
												$jumlah_jam = $jum_jam;
											}else{
												$jumlah_jam = "";
											}
											echo "<td width='20px' align='center' bgcolor='$bgcolor'><span style=\"color:$fontColor\"><a href='#modal-message' class='edit-record ' data-id='".ec($d)."-".ec($_POST['bulan'])."-".ec($_POST['tahun'])."-".ec($r['cc'])."-".ec($r['nik'])."' data-toggle='modal'>".$jumlah_jam."</a></span></td>"; 
										}
											$jml_jam 	= mysql_query("SELECT total_jam,total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$month $year'");
											$jml_menit 	= mysql_fetch_array(mysql_query("SELECT sum(total_menit) as total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$month $year'"));
											$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$month $year' AND status='1'"));
											while($jj=mysql_fetch_array($jml_jam)){
												if($jj['total_menit']>30){
													$sisa_jam = 1;
												}else{
													$sisa_jam = 0;
												}
												$jum_jam	+= $jj['total_jam']+$sisa_jam;
											}
											$rata		= $jum_jam / $jml_hari['jum_hari'];
											$hari_kerja	= mysql_fetch_array(mysql_query("SELECT hari_kerja as hari FROM jam_bulanan WHERE bulan='$month' AND tahun='$year'"));
											$rk			= $jum_jam / $hari_kerja['hari'];
							
							echo"
									<td width='25px' align='center' title='Jumlah Jam' ><b>".$jum_jam."</b></td>
									<td width='25px' align='center' title='Jumlah Hari Pengisian KKWK' ><b>$jml_hari[jum_hari]</b></td>
									<td width='25px' align='center' title='Rata-Rata Jam Perhari' ><b>".desimal($rata)."</b></td>
									<td width='25px' align='center' title='Rata-Rata Jam Perbulan' ><b>".desimal($rk)."</b></td>	
								</tr>
							";
						$no++;
						
						}
					?>
				</tbody>
			</table>
<!--------------------------------------------------------------------------------------------------------------------->
		
		</div>
	</div>
 <script>
        $(function(){
            $(document).on('click','.edit-record',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_laporan/detail_summary_kkwk.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal modal-message fade" id="modal-message">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Detail Summary KKWK</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/ui-modal-notification.demo.min.js"></script>