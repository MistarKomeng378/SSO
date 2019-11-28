			<h1 class="page-header"> Penilaian Kerja Karyawan
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">
					<?php
						if($_GET['opt']=="detail_aktifitas" || $_GET['opt']=="aktifitas"){
							$exIDname	= explode("-",$_GET['id']);
							$Nikname	= dc($exIDname[1]);
							echo"Penilaian Kerja Karyawan :: $Nikname - ".name($Nikname)."";
						}else{
							echo"Penilaian Kerja Karyawan";
						}
					?>
					</h4>
			    </div>
			    <div class="panel-body">
			
			<?php
			if(isset($_REQUEST['delete'])){
				mysql_query("DELETE FROM pencapaian WHERE id_pencapaian='$_GET[delete]'");
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
                        <i class='fa fa-remove'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Failed!</b> Terjadi Kesalahan.
                    </div>";
			}
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
		if($_GET['opt']=="form_penilaian"){
		?>
		<table class="table table-hover table-expandable table-bordered">
			<thead>
				<tr>
					<th>Tanggal.</th>
					<th>Aktifitas/ Hasil Aktifitas</th>
					<th>Jam Mulai</th>
					<th>Jam Selesai</th>
					<th>Total Jam</th>
					<th>Faktor Kontribusi</th>
					<th>Progress</th>
					<th>Lampiran</th>
					<th>Validasi Progress</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = mysql_query("SELECT DISTINCT	m_karyawan.`name` as nama,
														pencapaian.nik,
														pencapaian.cc
														FROM
														pencapaian
														INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
														WHERE pencapaian.laporan='$_SESSION[nik]'
														AND pencapaian.jo_gca='".dc($_GET['jo_gca'])."' 
														AND pencapaian.nik='".dc($_GET['nik'])."' 
														AND pencapaian.aprove='1'
														ORDER BY pencapaian.id_pencapaian DESC");

			
			while($r=mysql_fetch_array($query)){
				echo"<tr>
						<td> (FOTO)</td>
						<td>$r[nik] /$r[nama]</td>
						<td colspan='6'>$r[cc]</td>
					</tr>";
						$query2 = mysql_query("SELECT 	m_karyawan.`name`as nama,
												pencapaian.id_pencapaian,
												pencapaian.nik,
												pencapaian.jo_gca,
												pencapaian.tgl_aktifitas,
												pencapaian.jam_mulai,
												pencapaian.jam_akhir,
												pencapaian.total_jam,
												pencapaian.aktifitas,
												pencapaian.hasil_akhir,
												pencapaian.laporan,
												pencapaian.cc,
												pencapaian.faktor_k,
												pencapaian.progress,
												pencapaian.file,
												pencapaian.ket
												FROM
												pencapaian
												INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
												WHERE pencapaian.laporan='$_SESSION[nik]' 
												AND pencapaian.jo_gca=".dc($_GET['jo_gca'])."
												AND pencapaian.nik=$r[nik] 
												AND pencapaian.aprove='1'
												ORDER BY pencapaian.id_pencapaian DESC");
						
					
					echo"<form method='POST' action='page/mod_penilaian/aksi_penilaian.php' id='formku'>";
					while($r2=mysql_fetch_array($query2)){
					echo"<tr >
							<td>".tgl_indo($r2['tgl_aktifitas'])."</td>
							<td>$r2[jo_gca]";
							
							$idParent=$r2['jo_gca'];
							for($ak=1;$ak<=99;$ak++){
									$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
									if($ak==1){
										$fontColor="blue";
									}else{
										$fontColor="black";
									}
									if($i!=1){
										echo"-> ";
									}
									echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
									$idParent=$gca['parentId'];
									$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
									if ($idParent==$cek_id['id_tahun'])
									  {
									  break;
									  }
							}
							
							echo"</td>
							<td>$r2[jam_mulai]</td>
							<td>$r2[jam_akhir]</td>
							<td bgcolor='#b3e0ff'>$r2[total_jam]</td>
							<td bgcolor='#b3e0ff'>$r2[faktor_k]</td>
							<td bgcolor='#b3e0ff'>$r2[progress]</td>
							<td bgcolor='#b3e0ff'><a href='upload/$r2[file]'>$r2[ket]</a></td>
							<td bgcolor='#ffcccc' align='center'>
								<input type='hidden' name='id_pencapaian[]' value='$r2[id_pencapaian]' size='2'>
								<input type='hidden' name='progress_lama[]' value='$r2[progress]' size='2' required>
								<input type='text' name='progress[]' value='' size='2' required>
							</td>
						</tr>";
					}
					echo"<tr>
							<td colspan='9' align='right'>";
							if($getInsert==1){
								echo"<button type='submit' name='simpan' value='simpan' class='btn btn-xs btn-primary'>Submit</button>";
							}
						echo"</td>
						</tr>
					</form>";
			}
			?>
			</tbody>
		</table>	
		
<?php }elseif($_GET['opt']=="aktifitas"){?>
	<table id="example1" class="table table-bordered table-striped table-hover" >
		<thead>
			<th width="3%">No.</th>
			<th width="40%">Aktifitas</th>
			<th width="10%">Tanggal Aktifitas</th>
			<th width="10%">Total Jam Cost Center</th>
			<th width="5%">Status</th>
			<th width="8%"></th>
		</thead>
		<tbody>
			<?php
				$exID	= explode("-",$_GET['id']);
				$getNik	= dc($exID[1]);
				$getCC	= dc($exID[0]);
				$bulan	= date("m");
				$query = mysql_query("SELECT  id_pencapaian,aktifitas,hasil_akhir,jo_gca,nik,faktor_k,progress,aprove,status_nilai,file,tgl_aktifitas FROM pencapaian WHERE nik='$getNik' AND status='1' AND progress='100' AND aprove!='3' AND aprove!='0' AND laporan='$_SESSION[nik]'  AND cc='$getCC' ORDER BY aprove,id_pencapaian ASC");
				$no=1;
				while($r=mysql_fetch_array($query)){
					if($r['aprove']==0){
						$aprove="Belum dilaporkan";
					}elseif($r['aprove']==1){
						$aprove="<lable class='btn-xs btn-primary' title='Aktifitas Belum Aprove'>Open</lable>";
						$disabled2 ="";
					}elseif($r['aprove']==2){
						$aprove="<lable class='btn-xs btn-success' title='Aktifitas Sudah Aprove'>Aprove</lable>";
						$disabled2 ="disabled";
					}
					if(empty($r['file'])){
						$disabled ="disabled";
					}else{
						$disabled ="";
					}
					$jam 	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total_jam FROM pencapaian WHERE jo_gca='$r[jo_gca]'"));
					$menit 	= mysql_fetch_array(mysql_query("SELECT SUM(total_menit) as total_menit FROM pencapaian WHERE jo_gca='$r[jo_gca]'"));
							
					$jamDetik 	= $jam['total_jam'] * 3600;
					$menitDetik = $menit['total_menit'] * 60;
					$totalDetik	= $jamDetik + $menitDetik;
							
					$x		= $totalDetik;
					$sisa	= $x % 86400;
					$jml_jam	= floor($sisa / 3600);
								
					$sisa	= $sisa % 3600;
					$jml_menit	= floor($sisa / 60);
							
					$data		= mysql_query("SELECT parentId FROM wbs WHERE id='$r[jo_gca]'");
					$hitdata	= mysql_num_rows($data);
					$cekdata	= mysql_fetch_array($data);
					$idParent	= $cekdata['parentId'];						
					echo"
					<tr>
						<td>$no</td>
						<td>";
						if($hitdata <= 0){
							echo"$r[jo_gca] -> <b><font color='blue'>$r[aktifitas]</font></b>";
						}else{
							echo "<span style=\"color:blue\"><b>$r[jo_gca] : $r[aktifitas]</b></span> -> ";
							for($ak=1;$ak<=99;$ak++){
								$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
									$fontColor="black";
									if($ak!=1){
										echo"-> ";
									}
									echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
										$idParent=$gca['parentId'];
										$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
										if ($idParent==$cek_id['id_tahun']){
											break;
										}
							}
						}
					echo"</td>
						<td>".tgl_indo($r['tgl_aktifitas'])."</td>
						<td>$jml_jam Jam $jml_menit Menit</td>
						<td>$aprove</td>
						<td>
							<a href='#modal-message' class='edit-record btn btn-xs btn-primary' data-id='$bulan+$tahun_aktif+$getCC+$getNik+$r[jo_gca]+$_SESSION[nik]+$r[id_pencapaian]+$_GET[opt]' data-toggle='modal' title='Form Penilaian' $disabled2 ><i class='fa fa-pencil'></i></a>
							<a href='#modal-history' class='edit-history btn btn-xs btn-primary' data-id='$bulan+$tahun_aktif+$getCC+$getNik-$r[jo_gca]+$_SESSION[nik]' data-toggle='modal' title='Detail Aktifitas' ><i class='fa fa-table'></i></a>
							<a target='_blank' href='page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-success' title='$r[ket]' $disabled><i class='fa fa-xs fa-download'></i></a>
						</td>
					</tr>
					";
				$no++;
				}
			?>
		</tbody>
	</table>
<?php	
}elseif($_GET['opt']=="detail_aktifitas"){
	// if(isset($_GET['act'])){
		// $exID			= explode("-",$_GET['id']);
		// $getProgress	= dc($exID[1]);
		// $getId			= dc($exID[0]);
		// if($getProgress==100){
			// mysql_query("UPDATE pencapaian SET aprove='1' WHERE id_pencapaian='$getId' ");
		// }else{
			// mysql_query("UPDATE pencapaian SET aprove='0' WHERE id_pencapaian='$getId' ");
		// }
		// header('Location: ../../page.php?page=penilaian_kerja&succes=1');
	// }else{
		$exID	= explode("-",$_GET['id']);
		$getNik	= dc($exID[1]);
		$getCC	= dc($exID[0]);
		$app	= $exID[2];
		$bulan	= date("m");
		echo"<a href='#modal-message2' class='edit-record2 btn btn-sm btn-primary' data-id='$getCC+$getNik+$_SESSION[nik]+$_GET[opt]' data-toggle='modal' title='Form Penilaian' ><i class='fa fa-pencil'></i> Approve All</a><hr>";
	?>
	<table id="example1" class="table table-bordered table-striped table-hover" >
		<thead>
			<th width="3%">No.</th>
			<th width="40%">Aktifitas</th>
			<th width="10%">Tanggal Aktifitas</th>
			<th width="10%">Total Jam / ID GCA</th>
			<th width="5%">Status</th>
			<th width="8%"></th>
		</thead>
		<tbody>
			<?php
				
				if($app == 4){
					$query = mysql_query("SELECT  id_pencapaian,aktifitas,hasil_akhir,jo_gca,nik,faktor_k,progress,aprove,status_nilai,file,tgl_aktifitas FROM pencapaian WHERE nik='$getNik' AND status='1' AND aprove='$app' AND laporan='$_SESSION[nik]' AND cc='$getCC' ORDER BY tgl_aktifitas,jam_mulai DESC");
				}elseif($app == 5){
					$query = mysql_query("SELECT  id_pencapaian,aktifitas,hasil_akhir,jo_gca,nik,faktor_k,progress,aprove,status_nilai,file,tgl_aktifitas FROM pencapaian WHERE nik='$getNik' AND status='1' AND aprove='$app' AND laporan='$_SESSION[nik]' AND cc='$getCC' ORDER BY tgl_aktifitas,jam_mulai DESC");
				}else{
					$query = mysql_query("SELECT  id_pencapaian,aktifitas,hasil_akhir,jo_gca,nik,faktor_k,progress,aprove,status_nilai,file,tgl_aktifitas FROM pencapaian WHERE nik='$getNik' AND status='1' AND progress='100' AND laporan='$_SESSION[nik]' AND aprove='$app' AND cc='$getCC' ORDER BY tgl_aktifitas,jam_mulai DESC");
				}
				$no=1;
				while($r=mysql_fetch_array($query)){
					if($r['aprove']==0){
						$aprove="Belum dilaporkan";
					}elseif($r['aprove']==1){
						$aprove="<lable class='btn-xs btn-primary' title='Aktifitas Belum Aprove'>Open</lable>";
						$disabled2 ="";
					}elseif($r['aprove']==2){
						$aprove="<lable class='btn-xs btn-success' title='Aktifitas Sudah Aprove'>Aprove</lable>";
						$disabled2 ="disabled";
					}elseif($r['aprove']==4){
						$aprove="<lable class='btn-xs btn-danger' title='Dikembalikan'>Return</lable>";
						$disabled2 ="disabled";
					}elseif($r['aprove']==5){
						$aprove="<lable class='btn-xs btn-danger' title='Pengajuan Dispensasi'>Dispensation</lable>";
						$disabled2 ="disabled";
					}
					
					if(empty($r['file'])){
						$disabled ="disabled";
						$color ="danger";
					}else{
						$disabled ="";
						$color ="success";
					}
					$jam 	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total_jam FROM pencapaian WHERE jo_gca='$r[jo_gca]'"));
					$menit 	= mysql_fetch_array(mysql_query("SELECT SUM(total_menit) as total_menit FROM pencapaian WHERE jo_gca='$r[jo_gca]'"));
							
					$jamDetik 	= $jam['total_jam'] * 3600;
					$menitDetik = $menit['total_menit'] * 60;
					$totalDetik	= $jamDetik + $menitDetik;
							
					$x		= $totalDetik;
					$sisa	= $x % 86400;
					$jml_jam	= floor($sisa / 3600);
								
					$sisa	= $sisa % 3600;
					$jml_menit	= floor($sisa / 60);
							
					$data		= mysql_query("SELECT parentId FROM wbs WHERE id='$r[jo_gca]'");
					$hitdata	= mysql_num_rows($data);
					$cekdata	= mysql_fetch_array($data);
					$idParent	= $cekdata['parentId'];					
					echo"
					<tr>
						<td width='3%'>$no</td>
						<td>";
						if($hitdata <= 0){
							echo"$r[jo_gca] -> <b><font color='blue'>$r[aktifitas]</font></b>";
						}else{
							echo "<span style=\"color:blue\"><b>$r[jo_gca] : $r[aktifitas]</b></span> -> ";
							for($ak=1;$ak<=99;$ak++){
								$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
									$fontColor="black";
									if($ak!=1){
										echo"-> ";
									}
									echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
										$idParent=$gca['parentId'];
										$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
										if ($idParent==$cek_id['id_tahun']){
											break;
										}
							}
						}
					echo"</td>
						<td>".tgl_indo($r['tgl_aktifitas'])."</td>
						<td>$jml_jam Jam $jml_menit Menit</td>
						<td>$aprove</td>
						<td>";
						if($r['aprove']==5){
						echo"<a href='?page=penilaian_kerja&opt=detail_aktifitas&act=approve_disepan&id=".ec($r['progress'])."-".ec($r['id_pencapaian'])."' class='btn btn-xs btn-primary' title='Aprove Dispensation'><i class='fa fa-pencil'></i></a>
							<a href='#modal-history' class='edit-history btn btn-xs btn-primary' data-id='$bulan-$tahun_aktif-$getCC-$getNik-$r[jo_gca]-$_SESSION[nik]' data-toggle='modal' title='Detail Aktifitas' ><i class='fa fa-table'></i></a>
							<a target='_blank' href='page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-$color' title='$r[ket]' $disabled><i class='fa fa-xs fa-download'></i></a>";
						}elseif($r['aprove']==4){
							// echo"<a href='#modal-message' class='edit-record btn btn-xs btn-primary' data-id='$bulan-$tahun_aktif-$getCC-$getNik-$r[jo_gca]-$_SESSION[nik]-$r[id_pencapaian]' data-toggle='modal' title='Aprove Dispensation'><i class='fa fa-pencil'></i></a>";
							echo"<a href='#modal-history' class='edit-history btn btn-xs btn-primary' data-id='$bulan+$tahun_aktif+$getCC+$getNik+$r[jo_gca]+$_SESSION[nik]' data-toggle='modal' title='Detail Aktifitas' ><i class='fa fa-table'></i></a>";
						}else{
							echo"<a href='#modal-message' class='edit-record btn btn-xs btn-primary' data-id='$bulan+$tahun_aktif+$getCC+$getNik+$r[jo_gca]+$_SESSION[nik]+$r[id_pencapaian]+$_GET[opt]' data-toggle='modal' title='Form Penilaian' $disabled2 ><i class='fa fa-pencil'></i></a>
							<a href='#modal-history' class='edit-history btn btn-xs btn-primary' data-id='$bulan+$tahun_aktif+$getCC+$getNik+$r[jo_gca]+$_SESSION[nik]' data-toggle='modal' title='Detail Aktifitas' ><i class='fa fa-table'></i></a>
							<a target='_blank' href='page/mod_penilaian/download.php?id=".ec($r['id_pencapaian'])."' class='btn btn-xs btn-$color' title='$r[ket]' $disabled><i class='fa fa-xs fa-download'></i></a>";
						}
						echo"</td>
					</tr>
					";
				$no++;
				}
			?>
		</tbody>
	</table>
<?php	
	// }
}else{ ?>
<link href="assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">

		<table class="table table-hover table-expandable table-bordered" id="example1">
			<thead>
				<tr>
					<th>No.</th>
					<th>NIK</th>
					<th>Nama</th>
					<th>Cost Center</th>
					<th>Belum Divalidasi</th>
					<th>Validasi</th>
					<th>Jumlah Laporan</th>
					<th>Dikembalikan</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = mysql_query("SELECT DISTINCT	pencapaian.nik,
														pencapaian.cc,
														pencapaian.uraian
														FROM
														pencapaian
														WHERE laporan='$_SESSION[nik]' AND aprove='1'");
				// $query = mysql_query("SELECT distinct jo_gca,nik,laporan,aprove FROM pencapaian WHERE nik='$_SESSION[nik]'  ORDER BY tgl_aktifitas,jam_mulai DESC");
			$no=1;
			while($r=mysql_fetch_array($query)){
				$uraian = mysql_fetch_array(mysql_query("SELECT DISTINCT(uraian) as uraian FROM pencapaian WHERE cc='$r[cc]' "));
				$hit = mysql_fetch_array(mysql_query("SELECT count(jo_gca) as jml FROM pencapaian WHERE nik='$r[nik]' AND status='1' AND progress='100' AND laporan='$_SESSION[nik]' AND cc='$r[cc]' "));
				$non = mysql_fetch_array(mysql_query("SELECT count(jo_gca) as jml FROM pencapaian WHERE nik='$r[nik]' AND status='1' AND aprove='1' AND progress='100' AND laporan='$_SESSION[nik]' AND cc='$r[cc]' "));
				$val = mysql_fetch_array(mysql_query("SELECT count(jo_gca) as jml FROM pencapaian WHERE nik='$r[nik]' AND status='1' AND aprove='2' AND progress='100' AND laporan='$_SESSION[nik]' AND cc='$r[cc]' "));
				$return = mysql_fetch_array(mysql_query("SELECT count(jo_gca) as jml FROM pencapaian WHERE nik='$r[nik]' AND status='1' AND aprove='4' AND cc='$r[cc]' "));
				echo"<tr>
						<td>$no</td>
						<td>$r[nik]</td>
						<td>".name($r['nik'])."</td>
						<td ><i class='fa fa-info-circle' data-tp-title='$r[cc]' data-tp-desc='$uraian[uraian]'></i> $r[cc]</td>
						<td align='center'><a href='?page=penilaian_kerja&opt=detail_aktifitas&id=".ec($r['cc'])."-".ec($r['nik'])."-1' class='btn btn-xs btn-warning' title='Jumlah aktifitas yang belum divalidasi'>$non[jml] Aktifitas</a></td>
						<td align='center'><a href='?page=penilaian_kerja&opt=detail_aktifitas&id=".ec($r['cc'])."-".ec($r['nik'])."-2' class='btn btn-xs btn-success' title='Jumlah aktifitas yang sudah divalidasi'>$val[jml] Aktifitas</a></td>
						<td align='center'><a href='?page=penilaian_kerja&opt=aktifitas&id=".ec($r['cc'])."-".ec($r['nik'])."' class='btn btn-xs btn-primary' title='Jumlah aktifitas yang telah selesai dikerjakan'>$hit[jml] Aktifitas</a></td>
						<td align='center'><a href='?page=penilaian_kerja&opt=detail_aktifitas&id=".ec($r['cc'])."-".ec($r['nik'])."-4' class='btn btn-xs btn-danger'  title='Jumlah aktifitas yang dikembalikan'>$return[jml] Aktifitas</a></td>
					</tr>";
					
			$no++;	
			}
			?>
			</tbody>
		</table>
<script src="assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("i").adapTip({
	  "placement": "top"
	});
</script>		

<?php } ?>
		</div>
	</div>

<script>
        $(function(){
            $(document).on('click','.edit-record',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_penilaian/form_penilaian2.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
		$(function(){
            $(document).on('click','.edit-record2',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_penilaian/form_penilaian3.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
		$(function(){
            $(document).on('click','.edit-history',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_penilaian/history_penilaian.php',
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
				<h4 class="modal-title">Penilaian Kinerja Karyawan :: <?=$Nikname?> - <?=name($Nikname)?></h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-message2 fade" id="modal-message2">
	<div class="modal-dialog-full">
		<div class="modal-content-full">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Penilaian Kinerja Karyawan  :: <?=$Nikname?> - <?=name($Nikname)?></h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-message fade" id="modal-history">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Detail Aktifitas Berdasarkan GCA Yang Sama</h4>
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