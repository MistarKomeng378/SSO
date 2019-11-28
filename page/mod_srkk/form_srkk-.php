<?php
	$getUnit	= mysql_real_escape_string(dc($_GET['unit']));
	$getParent	= mysql_fetch_array(mysql_query("SELECT min(id) as id FROM wbs WHERE cc_id='$getUnit' AND tahun='$tahun_aktif'"));
	$uraian		= mysql_fetch_array(mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$getUnit'"));
?>

	<h1 class="page-header">Form SRKK
		<small><?=$_SESSION['nm_level']?></small>
	</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Form SRKK <?=$uraian['uraian']?> Tahun <?=$tahun_aktif?> </h4>
		</div>
		<div class="panel-body">
			<div class="form-group col-lg-12 ">	
				<form method="POST" action="page/mod_srkk/aksi_srkk.php?opt=<?=$_GET['opt']?>"  id="formku">
					<input type="hidden" name="tahun" value="<?=$tahun_aktif?>">
					<input type="hidden" name="unit" value="<?=$getUnit?>">
						<?php
							// echo"$getParent[id]";
							function show($id = '',$tahun_aktif,$getUnit){
								$where = '';
								if(strlen($id) > 0) $where = " AND parentId='$id' ";
									$sql = "SELECT * FROM wbs WHERE tahun='$tahun_aktif' AND hasil_akhir='P' $where";
									$res = mysql_query($sql);
									$num = mysql_num_rows($res);
									$i=0;
								while($row = mysql_fetch_assoc($res)){
									if($i == 0) echo "<ul>";
									$i++;
									$dir = mysql_fetch_array(mysql_query("SELECT nik FROM v_manager WHERE CostCenter='$getUnit'"));
									$r 	= mysql_num_rows(mysql_query("SELECT id_gca FROM srkk WHERE tahun='$tahun_aktif' AND id_gca='$row[id]' AND nik!='$dir[nik]' "));
									$s 	= mysql_fetch_array(mysql_query("SELECT rutin FROM srkk WHERE tahun='$tahun_aktif' AND id_gca='$row[id]' AND nik!='$dir[nik]' "));
									echo "<li>
											<input type='checkbox' name='srkk[]' value='$row[id]' "; if($r>=1){echo"checked";}echo">
											<input type='checkbox' name='rutin[$row[id]]' value='1' "; if($s['rutin']==1){echo"checked";}echo">
											LV$row[level]-($row[hasil_akhir])- <span>$row[aktivitas]</span>";
									// echo $i;
										show($row['id'],$tahun_aktif,$getUnit);
									echo "</li>";
									if($i == $num)echo "</ul>";
								}

							}

							show("$getParent[id]",$tahun_aktif,$getUnit);
						?>
					<hr>
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger">Reset</button>
				</form>
			</div>
		</div>
	</div>