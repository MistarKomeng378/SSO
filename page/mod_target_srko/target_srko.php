<h1 class="page-header">Target SRKO
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Target SRKO</h4>
	</div>
	<div class="panel-body">
		<div class='col-lg-12'>
			<?php
				// $tahun_tsrko = $_COOKIE['tahun_tsrko'];
				// $idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
				$thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun ='".date('Y')."'"));
								
				if($_COOKIE['tahun_tsrko']==""){
					$tahun_tsrko 	= $thn['tahun'];
					$idtahun_tsrko 	= $thn['id_tahun'];
				}else{
					$tahun_tsrko = $_COOKIE['tahun_tsrko'];
					$idtahun_tsrko = $_COOKIE['idtahun_tsrko'];
				}
				
				
				echo"
					<form method='POST' action='page/mod_target_srko/aksi_tahun.php'>
						<div class='col-lg-4'>
							<select name='tahun' class='form-control'>
								<option value=''>-Pilih Tahun-</option>";
								$qtahun = mysql_query("SELECT * FROM tahun");
								while($t=mysql_fetch_array($qtahun)){
									echo"<option value='$t[id_tahun]'"; if($idtahun_tsrko==$t['id_tahun']){echo"selected";} echo">$t[tahun]</option>";
								}
							echo"</select>
						</div>
						<div class='col-lg-4'>
							<button type='submit' name='simpan' value='simpan' class='btn btn-primary'>Submit</button>
						</div>
					</form>
				";
			?>
		</div>
		<br>
		<br>
		<br>
		<div class='col-lg-12'>
			<table class="table table-bordered table-striped table-hover" >
				<thead>
					<th>No.</th>
					<th>Cost Center</th>
					<th>Uraian</th>
					<th width="8%"></th>
					<th width="8%"></th>
					<th width="8%"></th>
				</thead>
				<tbody>
					<?php
						$no=1;
						$query = mysql_query("SELECT * FROM mskko WHERE  id!='1.6' AND id!='4' AND id!='1.5' AND id!='5' AND id!='6'");
						while($r=mysql_fetch_array($query)){
							echo"
							<tr>
								<td>$no</td>
								<td>$r[CostCenter]</td>
								<td>$r[uraian]</td>
								<td>
									<a href='?page=data_target_srko&unit=".ec($r['CostCenter'])."' class='btn btn-xs btn-primary' title='Detail'><i class='glyphicon glyphicon-list'></i> Target</a>
								</td>";
								// <td>
									// <a href='?page=hitung_progress&act=hitung&unit=".ec($r['CostCenter'])."' class='btn btn-xs btn-primary' title='Detail'><i class='glyphicon glyphicon-list'></i> Hitung Progress</a>
								// </td>
								// <td>
									// <a href='?page=hitung_progress&act=view&unit=".ec($r['CostCenter'])."' class='btn btn-xs btn-primary' title='Detail'><i class='glyphicon glyphicon-list'></i> View Progress</a>
								// </td>
								echo"
								<td>
									<a href='?page=data_progress_srko&unit=".ec($r['CostCenter'])."' class='btn btn-xs btn-primary' title='Detail'><i class='glyphicon glyphicon-list'></i> Progress</a>
								</td>";
								if($r['id']=='1.1' OR $r['id']=='1.2' OR $r['id']=='1.3' OR $r['id']=='1.4'){
									echo"
										<td>
											<a href='?page=data_margin&unit=".ec($r['CostCenter'])."' class='btn btn-xs btn-success' title='Detail'><i class='glyphicon glyphicon-list'></i> Margin</a>
										</td>";
								}else{
									echo "<td> &nbsp; </td>";
								}
								
							echo"
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