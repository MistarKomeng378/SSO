<h1 class="page-header">Summary MSKK
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Summary MSKK</h4>
	</div>
	<div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
		
		<?php
		include"config/fungsi_timeline.php";
		if(isset($_POST['tahun'])){
			$thMSKK = $_POST['tahun'];
		}else{
			$thMSKK = date("Y");
		}
		echo"<form method='POST' action='page.php?page=summary_mskk' id='formku'>
				<div class='form-group  col-lg-12 row'>
						<input type='hidden' name='page' value='summary_mskk'>
						<input type='hidden' name='opt' value='cari'>
					<div class='form-group  col-lg-2'>
						<select name='tahun' class='form-control '>
							<option value=''>Pilih Tahun</option>";
								$qsbdth = mysql_query("SELECT * FROM tahun");
								while($r=mysql_fetch_array($qsbdth)){
									echo"<option value='$r[tahun]'"; if($thMSKK==$r['tahun']){echo"selected";} echo">$r[tahun]</option>";
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
							echo" <a target='_blank' href='print/print_summary_mskk_excel.php?id=".ec($thMSKK)."-".$_SESSION['level']."-".ec($_SESSION['nik'])."&unit=".ec($_SESSION['cc'])."' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>";
						}elseif($_SESSION['level']==4){
							echo" <a target='_blank' href='print/print_summary_mskk_excel.php?id=".ec($thMSKK)."-".$_SESSION['level']."&unit=".ec($_SESSION['cc'])."' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>";
						}else{
							if($_POST['opt']=="cari"){	
								echo" <a target='_blank' href='print/print_summary_mskk_excel.php?id=".ec($thMSKK)."-".$_SESSION['level']."&unit=".ec($_POST['unit'])."' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>";
							}else{	
								echo" <a target='_blank' href='print/print_summary_mskk_excel.php?id=".ec($thMSKK)."-".$_SESSION['level']."&unit=' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>";
							}
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
						<td width="5%"><b>NIK</b></td>
						<td width="18%"><b>Nama</b></td>
						<?php
							for($i=1;$i<=12;$i++){
								echo"<td align='center' width='6%'>".bulan($i)."</td>";
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						if($_POST['opt']=="cari"){
							
									$getTahun = mysql_real_escape_string($_POST['tahun']);
									$getUnit = mysql_real_escape_string($_POST['unit']);
									if(!empty($_POST['unit'])){
										$unit="AND mskko.CostCenter='$_POST[unit]'";
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
							timeline($_SESSION['nik'],"cari","pecarian Summary MSKK berdasrkan CostCenter : $getUnit Tahun: $getTahun ");
						}
						while($r=mysql_fetch_array($query)){
							
							echo"
								<tr>
									<td align='center'>$no</td>
									<td>$r[nik] </td>
									<td>$r[name] </td>";
									for($i=1;$i<=12;$i++){
										$JmlMskk	= mysql_fetch_array(mysql_query("SELECT SUM(bxs) as bxs FROM mskk WHERE nik='$r[nik]' AND bulan='$i' AND tahun='$getTahun' "));
										echo"<td align='center'><a href='#modal-message' class='edit-record ' data-id='".ec($i)."-".ec($getTahun)."-".ec($getUnit)."-".ec($r['nik'])."' data-toggle='modal'>".desimal($JmlMskk['bxs'])."</a></td>";
									}
						$no++;
						echo"<tr>";
						}
						if($_SESSION['level']==5 AND $_POST['opt']=="cari"){
							$query2 = mysql_query("SELECT DISTINCT
													pencapaian.nik,
													m_karyawan.`name`,
													m_karyawan.dept as cc
													FROM
													pencapaian
													INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
													WHERE pencapaian.laporan='$_SESSION[nik]' ");
							while($r2=mysql_fetch_array($query2)){
								
								echo"
									<tr>
										<td align='center'>$no</td>
										<td>$r2[nik] </td>
										<td>$r2[name] </td>";
										for($i=1;$i<=12;$i++){
											$JmlMskk	= mysql_fetch_array(mysql_query("SELECT SUM(bxs) as bxs FROM mskk WHERE nik='$r2[nik]' AND bulan='$i' AND tahun='$getTahun' "));
											echo"<td align='center'><a href='#modal-message' class='edit-record ' data-id='".ec($i)."-".ec($getTahun)."-".ec($getUnit)."-".ec($r2['nik'])."' data-toggle='modal'>".desimal($JmlMskk['bxs'])."</a></td>";
										}
							$no++;
							echo"<tr>";
							}
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
                $.post('page/mod_laporan/detail_summary_mskk.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal  fade" id="modal-message">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Detail Summary MSKK</h4>
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