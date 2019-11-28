<script type="text/Javascript">
	function cc(){
		var x = window.open("lookup/cc3.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
	function nik(){
		var x = window.open("lookup/nik.php", "nik", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
</script>

<h1 class="page-header">Kinerja Bulanan
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Kinerja Bulanan</h4>
	</div>
	<div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
		
		<?php
		include"config/fungsi_timeline.php";
		@$getBulan	= mysql_real_escape_string($_POST['bulan']);
		@$getTahun	= mysql_real_escape_string($_POST['tahun']) ;
		@$getUnit	= mysql_real_escape_string($_POST['unit']);
		@$getNik	= mysql_real_escape_string($_POST['nik']);
		if(isset($_POST['tahun'])){
			$thKJ = $_POST['tahun'];
		}else{
			$thKJ = date("Y");
		}
		
		echo"<form method='POST' action='page.php?page=kinerja_bulanan' id='formku'>
				<div class='form-group  col-lg-12 row'>
					<div class='form-group  col-lg-2'>
						<input type='hidden' name='page' value='kinerja_bulanan'>
						<input type='hidden' name='opt' value='cari'>
						<select name='bulan' class='form-control required'>
							<option value=''>Pilih Bulan</option>";
									for($i=1;$i<=12;$i++){
										echo"<option value='$i'"; if($getBulan==$i){echo"selected";} echo">".bulan($i)."</option>";
									}
					echo"</select>
					</div>
					<div class='form-group  col-lg-2'>
						<select name='tahun' class='form-control '>
								<option value=''>Pilih Tahun</option>";
									$qsbdth = mysql_query("SELECT * FROM tahun");
									while($r=mysql_fetch_array($qsbdth)){
										echo"<option value='$r[tahun]'"; if($thKJ==$r['tahun']){echo"selected";} echo">$r[tahun]</option>";
									}
					echo"</select>
					</div>";
					echo"<div class='form-group  col-lg-3'>
						<div class='input-group input-group'>
							<input type='text' name='unit' class='form-control' value='".mysql_real_escape_string($_POST['unit'])."' id='cc' placeholder='Kode Proyek / Cost Center'>
							<input type='hidden' name='uraian' class='form-control required' value='' id='uraian' placeholder='Kode Proyek / Cost Center'  autocomplete='off' readonly>
							<span class='input-group-btn'>
								 <i class='glyphicon glyphicon-search btn btn-primary btn-flat edit-record' onclick='cc()'></i>
							</span>
						</div>
					</div>
					<div class='form-group  col-lg-2'>
						<div class='input-group input-group'>
							<input type='text' name='nik' class='form-control' value='".mysql_real_escape_string($_POST['nik'])."' placeholder='NIK' id='nik'>
							<span class='input-group-btn'>
								<i class='glyphicon glyphicon-search btn btn-primary btn-flat edit-record' onclick='nik()'></i>
							</span>
						</div>
					</div>";
				echo"<div class='form-group  col-lg-3'>
						<input type='submit' value='Pilih' class='btn btn-primary'>
					</div>
				</div>
			</form>";
		?>
		<hr>
			<table id="example1" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th>NIK</th>
						<th>Nama</th>
						<th>Divisi</th>
						<th>Jabatan</th>
						<th>Jumlah Hari</th>
						<th>Jumlah Jam</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						if($_POST['opt']=="cari"){
								if(empty($_POST['unit']) && empty($_POST['nik'])){
									$query = mysql_query("SELECT DISTINCT	pencapaian.nik,
																m_karyawan.`name`,
																	m_karyawan.`poscode`,
																	m_karyawan.`dept`
																FROM
																pencapaian
																LEFT JOIN m_karyawan ON pencapaian.nik = m_karyawan.regno
																WHERE m_karyawan.regno NOT LIKE '%DM%'
																ORDER BY m_karyawan.regno
																");
								}elseif(empty($_POST['nik'])){
										$query = mysql_query("SELECT DISTINCT	pencapaian.nik,
																	m_karyawan.`name`,
																	m_karyawan.`poscode`,
																	m_karyawan.`dept`
																	FROM
																	pencapaian
																	LEFT JOIN m_karyawan ON pencapaian.nik = m_karyawan.regno
																WHERE (m_karyawan.dept='$_POST[unit]' OR pencapaian.cc='$_POST[unit]')
																AND m_karyawan.regno NOT LIKE '%DM%'
																ORDER BY m_karyawan.regno
																");
								}elseif(empty($_POST['unit'])){
										$query = mysql_query("SELECT DISTINCT	pencapaian.nik,
																	m_karyawan.`name`,
																	m_karyawan.`poscode`,
																	m_karyawan.`dept`
																	FROM
																	pencapaian
																	LEFT JOIN m_karyawan ON pencapaian.nik = m_karyawan.regno
																WHERE pencapaian.nik='$_POST[nik]'
																AND m_karyawan.regno NOT LIKE '%DM%'
																ORDER BY m_karyawan.regno
																");
								}else{
									$query = mysql_query("SELECT DISTINCT	pencapaian.nik,
																	m_karyawan.`name`,
																	m_karyawan.`poscode`,
																	m_karyawan.`dept`
																	FROM
																	pencapaian
																	LEFT JOIN m_karyawan ON pencapaian.nik = m_karyawan.regno
																WHERE pencapaian.nik='$_POST[nik]'
																AND (m_karyawan.dept='$_POST[unit]' OR pencapaian.cc='$_POST[unit]')
																AND m_karyawan.regno NOT LIKE '%DM%'
																ORDER BY m_karyawan.regno
																");
								}
							timeline($_SESSION['nik'],"cari","pecarian Kinerja Bulanan berdasrkan nik : ".$_POST['nik']." CostCenter : $getUnit bulan : ".bulan($getBulan)." Tahun: $getTahun");
						}
						while($r=mysql_fetch_array($query)){
							if(empty($_POST['unit'])){
								$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND status='1' AND date_format( tgl_aktifitas, '%c %Y' ) = '$getBulan $getTahun'"));
								$jml_jam 	= mysql_query("SELECT total_jam,total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$getBulan $getTahun'");
							}else{
								$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND status='1' AND date_format( tgl_aktifitas, '%c %Y' ) = '$getBulan $getTahun' AND pencapaian.cc='$_POST[unit]'"));
								$jml_jam 	= mysql_query("SELECT total_jam,total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$getBulan $getTahun' AND pencapaian.cc='$_POST[unit]'");
							}
							while($jj=mysql_fetch_array($jml_jam)){
								if($jj['total_menit']>30){
									$sisa_jam = 1;
								}else{
									$sisa_jam = 0;
								}
								$jum_jam	+= $jj['total_jam']+$sisa_jam;
							}								
							echo"
								<tr>
									<td>$no</td>
									<td>$r[nik] </td>
									<td>$r[name] </td>
									<td>$r[dept]</td>
									<td>".jab($r['poscode'])."</td>
									<td align='center'>$jml_hari[jum_hari]</td>
									<td align='center'>".$jum_jam."</td>
									<td><a href='#modal-message' class='edit-record btn btn-xs btn-primary' data-id='".ec($_POST['bulan'])."-".ec($_POST['tahun'])."-".ec($_POST['unit'])."-".ec($r['nik'])."' data-toggle='modal'>Show</a></td>
								</tr>
							";
						$no++;
						$jum_jam =0;
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
                $.post('page/mod_laporan/detail_kinerja_bulanan.php',
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
				<h4 class="modal-title">Detail Kinerja Bulanan</h4>
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