<?php
$unit = mysql_fetch_array(mysql_query("SELECT * FROM mskko WHERE CostCenter='".mysql_real_escape_string(dc($_GET['unit']))."'"));
$tahun_tsrko = $_COOKIE['tahun_tsrko'];
$idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
?>

			<h1 class="page-header">From Target SRKO
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
		?>
			<?php
			if($getInsert==1){
				echo"<a href='?page=form_target&unit=$_GET[unit])' class='btn btn-primary'><i class='fa fa-plus'></i> Input Target</a>";
			}
			?>
			<hr>
			<table border='1' cellpadding='3' width="100%">
				<thead>
					<tr align='center'>
						<td  rowspan="2"><b>No.</b></td>
						<td rowspan="2"><b>Sasaran/Rencana Kerja</td>
						<td rowspan="2"><b>Bobot</b></td>
						<td rowspan="2"><b>Target Tahunan</b></td>
						<td colspan="12"><b>Target Bulanan</b></td>
					</tr>
					<tr align='center'>
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
						$query = mysql_query("SELECT DISTINCT * FROM srko WHERE CostCenter='$unit[CostCenter]' AND tahun='$tahun_tsrko'");
						while($r=mysql_fetch_array($query)){
							echo"
							<tr>
								<td align='center'>$no</td>
								<td>$r[rencana_kerja]</td>
								<td align='center'>$r[bobot]</td>
								<td>$r[target] $r[satuan]</td>";
								for($i=1;$i<=12;$i++){
									$target = mysql_fetch_array(mysql_query("SELECT * FROM target_srko WHERE bulan='$i' AND tahun='$tahun_tsrko' AND id_srko='$r[id_srko]'"));
									echo"<td width='5%'>$target[target]";
							}
						echo"</tr>
							";
						$no++;
						$data++;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>