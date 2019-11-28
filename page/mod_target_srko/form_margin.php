<?php
$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));

$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun ='".date('Y')."'"));

if($_COOKIE['tahun_tsrko']==""){
	$tahun_tsrko 	= $thn['tahun'];
	$idtahun_tsrko 	= $thn['id_tahun'];
}else{
	$tahun_tsrko = $_COOKIE['tahun_tsrko'];
	$idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
}

?>
			<h1 class="page-header">Form Profit Margin 
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
		<form method="POST" action="page/mod_target_srko/query_margin.php">
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center' bgcolor="#b3d9ff">
						<td  rowspan="2"><b>No.</b></td>
						<td rowspan="2"><b>Uraian</td>
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
						
						// $query = mysql_query("SELECT * FROM mskko WHERE CostCenter='$unit[CostCenter]'");
						$query = mysql_query("SELECT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$tahun_tsrko' AND jenis_pencapaian='3'");
						while($r=mysql_fetch_array($query)){							
													
							echo"							
							<input type='hidden' name='cc' value='$r[CostCenter]'>
							<input type='hidden' name='tahun' value='$tahun_tsrko'>	
											
							<tr bgcolor='$color'>
								<td rowspan='3' align='center'>$no</td>
								<td rowspan='3' > $r[rencana_kerja]</td>
								<td bgcolor='#ffcccc'>Pendapatan</td>";
								
								for($i=1;$i<=12;$i++){
									$pend = mysql_fetch_array(mysql_query("select * from profit_margin where id_srko='$r[id_srko]' AND bulan='$i' AND tahun='$tahun_tsrko'"));
									echo"
										<td bgcolor='#ffcccc' align='center'>
											<input type='hidden' name='id_margin[]' value='$pend[id_margin]' size='5'>
											<input type='hidden' name='id_srko[]' value='$r[id_srko]' size='5'>
											<input type='text' name='pendapatan[]' value='$pend[pendapatan]' size='5'>
											<input type='hidden' name='bulan[]' value='$i' size='5'>
										</td>";
								}
						echo"</tr>
							<tr bgcolor='#ffffb3'>
								<td>HPP</td>";
								for($i=1;$i<=12;$i++){
									$hpp = mysql_fetch_array(mysql_query("select * from profit_margin where id_srko='$r[id_srko]' AND bulan='$i' AND tahun='$tahun_tsrko'"));
									echo"<td width='5%' align='center'>
											<input type='text' name='hpp[]' value='$hpp[hpp]' size='5'>
										</td>";						
								}
						echo"</tr>
							<tr bgcolor='#b3ffb3'>
								<td>Margin</td>";
								for($i=1;$i<=12;$i++){
									$margin = mysql_fetch_array(mysql_query("select * from profit_margin where id_srko='$r[id_srko]' AND bulan='$i' AND tahun='$tahun_tsrko'"));
									
									echo"<td width='5%' align='center'>
												<input type='text' name='margin[]' value='$margin[margin]' size='5' readonly>
										</td>";
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