<script type="text/Javascript">
	function cc(){
		var x = window.open("lookup/cc3.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
	}
</script>

			<h1 class="page-header">Summary KKWK Per Cost Center
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Summary KKWK Per Cost Center</h4>
			    </div>
			    <div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
		
		<?php
		echo"<form method='POST' action='page.php?page=summary_kkwk_cc' id='formku'>
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
					<div class='form-group  col-lg-1'>
						<input type='text' name='tahun' class='form-control required' value='".date("Y")."' placeholder='Tahun'>
					</div>";
					// if($_SESSION['level']!=5 AND $_SESSION['level']!=4){	
					echo"<div class='form-group  col-lg-3'>
						<div class='input-group input-group'>
							<input type='text' name='cc' class='form-control' value='$_POST[cc]' id='cc' placeholder='Kode Proyek / Cost Center' >
							<input type='hidden' name='uraian' class='form-control required' value='' id='uraian' placeholder='Kode Proyek / Cost Center'  autocomplete='off' readonly>
							<span class='input-group-btn'>
								 <i class='glyphicon glyphicon-search btn btn-primary btn-flat edit-record' onclick='cc()'></i>
							</span>
						</div>
					</div>";
					// }
				echo"
					<div class='form-group  col-lg-3'>
						<input type='submit' value='Pilih' class='btn btn-primary'>
						<a target='_blank' href='print/print_summary_kkwk_cc_pdf.php?id=".ec($_POST['bulan'])."-".ec($_POST['tahun'])."&cc=".ec($_POST['cc'])."' class='btn btn-danger'><i class='fa fa-file-pdf-o'></i> PDF</a>
						<a target='_blank' href='print/print_summary_kkwk_cc_excel.php?id=".ec($_POST['bulan'])."-".ec($_POST['tahun'])."&cc=".ec($_POST['cc'])."' class='btn btn-success'><i class='fa fa-file-excel-o'></i> EXCEL</a>
					</div>
				</div>
			</form>";
		?>
		<hr>
			<table class="table table-bordered table-striped" id="example1">
				<thead>
					<tr align="center">
						<th width="3%">No</th>
						<th width="4%">NIK</th>
						<th width="20%">Nama</th>
						<th width="11%">Cost Center</th>
						<th >Uraian</th>
						<th  width="12%">Total Waktu (Jam)</th>
						<th  width="10%">Presentase (%)</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						if($_POST['opt']=="cari"){
							$month 	= mysql_real_escape_string($_POST['bulan']);
							$year 	= mysql_real_escape_string($_POST['tahun']);
									
							if(!empty($_POST['cc'])){
								$cc="AND pencapaian.cc='$_POST[cc]' ";
							}
							$query = mysql_query("SELECT DISTINCT	pencapaian.cc,
																	pencapaian.nik,
																	pencapaian.uraian,
																	m_karyawan.dept
																	FROM
																	pencapaian
																	LEFT JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
																	WHERE pencapaian.nik!='' AND pencapaian.cc!='' $cc
																	ORDER BY pencapaian.nik");
						}
						while($r=mysql_fetch_array($query)){
							$jml_jam 	= mysql_query("SELECT total_jam,total_menit FROM pencapaian WHERE cc='$r[cc]' AND nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$month $year'");
							while($jj=mysql_fetch_array($jml_jam)){
								if($jj['total_menit']>=30){
									$sisa_jam = 1;
								}else{
									$sisa_jam = 0;
								}
								$jum_jam	+= $jj['total_jam']+$sisa_jam;
							}
							
							$jam_bulan 	= mysql_query("SELECT total_jam,total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$month $year'");
							while($jb=mysql_fetch_array($jam_bulan)){
								if($jb['total_menit']>=30){
									$sisa_jam = 1;
								}else{
									$sisa_jam = 0;
								}
								$jum_jam_bulan	+= $jb['total_jam']+$sisa_jam;
							}
							$prosen			= ($jum_jam/$jum_jam_bulan)*100;
							
							echo"
								<tr>
									<td>$no</td>
									<td>$r[nik]</td>
									<td>".name($r['nik'])."</td>
									<td>$r[cc]</td>
									<td>$r[uraian]</td>
									<td align='center'>$jum_jam</td>
									<td align='center'>".desimal2($prosen)."</td>
								</tr>
							";
						$no++;
						$jum_jam = 0;
						$jum_jam_bulan = 0;
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