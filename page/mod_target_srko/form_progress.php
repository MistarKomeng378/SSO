<?php
$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
// $tahun_tsrko = $_COOKIE['tahun_tsrko'];
// $idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
// $cc = dc($_GET['unit']);
$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun ='".date('Y')."'"));
// $ay  = date('Y');
// $Thnow = date('Y', strtotime('-1 year', strtotime($ay)));
// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".$Thnow."'"));
if($_COOKIE['tahun_tsrko']==""){
	$tahun_tsrko 	= $thn['tahun'];
	$idtahun_tsrko 	= $thn['id_tahun'];
}else{
	$tahun_tsrko = $_COOKIE['tahun_tsrko'];
	$idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
}

?>
			<h1 class="page-header">From Progress SRKO
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
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
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
		?>
		<form method="POST" action="page/mod_target_srko/query_progress.php">
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center' bgcolor="#b3d9ff">
						<td  rowspan="2"><b>No.</b></td>
						<td rowspan="2"><b>Sasaran/Rencana Kerja</td>
						<td rowspan="2"><b>Bobot</b></td>
						<td rowspan="2"><b>Target Tahunan</b></td>
						<td rowspan="2"><b></b></td>
						<td rowspan="2"><b></b></td>
						<td colspan="12"><b>Target Bulanan</b></td>
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
						// $query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$tahun_tsrko' AND id_srko='395'");
						$query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$tahun_tsrko' ");
						while($r=mysql_fetch_array($query)){							
							$d = mysql_fetch_array(mysql_query("SELECT jenis_pencapaian, jenis_resume FROM progress_srko WHERE tahun='$tahun_tsrko' AND id_srko='$r[id_srko]' LIMIT 1 "));								
							echo"							
							<input type='hidden' name='cc' value='$r[CostCenter]'>
							<input type='hidden' name='tahun' value='$tahun_tsrko'>
							<input type='hidden' name='id_srko2[]' value='$r[id_srko]' size='5'>							
							<tr bgcolor='$color'>
								<td rowspan='3' align='center'>$no</td>
								<td rowspan='3' >$r[rencana_kerja]</td>
								<td rowspan='3' align='center'>$r[bobot]</td>
								<td rowspan='3'>$r[target] $r[satuan]</td>
								<td rowspan='3'>";
								
								if($_SESSION['level']==1){
									
										echo "
										<select name='jp[]'>
											<option value=''>-Jenis Pencapaian-</option>
											<option value='1'"; if($r['jenis_pencapaian']==1){echo"selected";} echo">Positif</option>
											<option value='2'"; if($r['jenis_pencapaian']==2){echo"selected";} echo">Negatif</option>
											<option value='3'"; if($r['jenis_pencapaian']==3){echo"selected";} echo">Prof. Margin</option>
										</select>
										<p></p>
										<select name='jr[]' required>
											<option value='' >-Jenis Resume-</option>
											<option value='1'"; if($d['jenis_resume']==1){echo"selected";} echo">Bulan Terakhir</option>
											<option value='2'"; if($d['jenis_resume']==2){echo"selected";} echo">Kumulatif</option>
											<option value='3'"; if($d['jenis_resume']==3){echo"selected";} echo">Rata-rata</option>
											<option value='4'"; if($d['jenis_resume']==4){echo"selected";} echo">Prof. Margin</option>
										</select>";
									
								}
									echo"
								</td>
								<td bgcolor='#ffcccc'>T</td>";
																
								//TARGET ^^
								for($i=1;$i<=12;$i++){
									$prog = mysql_fetch_array(mysql_query("SELECT id_progress,id_srko,target,bulan FROM progress_srko WHERE bulan='$i' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
									
									$target = mysql_fetch_array(mysql_query("SELECT * FROM target_srko WHERE bulan='$i' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
									
									$qmar = mysql_fetch_array(mysql_query("SELECT margin FROM profit_margin WHERE id_srko='$r[id_srko]' AND bulan=$i AND tahun='$tahun_tsrko'")); 
									echo"<td bgcolor='#ffcccc' align='center'>
											<input type='hidden' name='hasil_akhir[]' value='$r[hasil_akhir]'>
											<input type='hidden' name='id_progress[]' value='$prog[id_progress]' size='5'>
											<input type='hidden' name='id_srko[]' value='$r[id_srko]' size='5'>
											<input type='hidden' name='parent_srko[]' value='$target[parent_srko]' size='5'>
											<input type='text' name='target[]' value='$target[target]' size='5' readonly>
											<input type='hidden' name='bulan[]' value='$i' size='5'>
											<input type='hidden' name='margin1[]' value='$qmar[margin]' size='5'>
										</td>";
								}
						echo"</tr>
							<tr bgcolor='#ffffb3'>
								<td>R</td>";
								
								//Realisiasi
								for($i=1;$i<=12;$i++){
									
									$qprog1 = mysql_query("SELECT realisasi,jenis_pencapaian,realisasi_pm FROM progress_srko WHERE bulan='$i' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'");
									$prog1 = mysql_fetch_array($qprog1);
									
									$qprog = mysql_query("SELECT margin FROM profit_margin WHERE id_srko='$r[id_srko]' AND bulan=$i AND tahun='$tahun_tsrko'");
									$prog = mysql_fetch_array($qprog);
									
									$hitprog = mysql_num_rows($qprog);
									if($r['jenis_pencapaian']==3){ // Nilai Margin
										echo"<td width='5%' align='center'><input type='text' name='realisasi[]' value='$prog[margin]' size='5' readonly></td>";
										
									}else{
										if($r['hasil_akhir']=="H"){
											$real = $prog1['realisasi'];
										}else{
											// $real = $prog1['pencapaian']; << awalnya begini
											$real = $prog1['realisasi'];
										}
										
										//REALIASI
										$bulan_skrng  = date('m');
										$lock = $bulan_skrng - 1; 
										
										if($_SESSION['level']==1){	
											$disable='';
										}else{
											if($lock <=$i){
												$disable='';
											}else{
												$disable='readonly';
											}
										}
										if($r['parent_srko']==''){
											if($r['sts']==''){
												$dis = 'readonly';
											}else{
												$dis = '';
											}
										}else{
											$dis = '';
										}
										//input realisasi
										echo"<td width='5%' align='center'><input type='text' name='realisasi[]' value='$real' size='5' $disable $dis></td>";
										
										////////////////
									}									
								}
						echo"</tr>
							<tr bgcolor='#b3ffb3'>
								<td>P</td>";
								//Pencapaian
								for($i=1;$i<=12;$i++){
									$prog = mysql_fetch_array(mysql_query("SELECT pencapaian,jenis_pencapaian,hpp FROM progress_srko WHERE bulan='$i' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
									// if($prog['jenis_pencapaian']==3){
											// echo"<td width='5%' align='center'>
												// <input type='hidden' name='pencapaian[]' value='$prog[pencapaian]' size='5'>
												// <input type='text' name='hpp[]' value='$prog[hpp]' size='5'>
										// </td>";
									// }else{
										echo"<td width='5%' align='center'>
												<input type='hidden' name='pencapaian[]' value='$prog[pencapaian]' size='5'>
												<input type='text' name='hpp[]' value='' size='5' readonly>								
										</td>";
									// }
								}
						echo"</tr>
							";
						$no++;
						$data++;
						}
					?>
				</tbody>
			</table>
			<h6><b> -> Jika tidak Ada Realisiasi Sasaran Kejra pada Bulan Tertentu Harap Di ISI dengan Angka 0 (NOL)</b></h6>
			<hr>
			<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
		</form>
		</div>
	</div>