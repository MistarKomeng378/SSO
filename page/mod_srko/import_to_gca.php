<h1 class="page-header">Import SRKO Ke GCA
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Import SRKO Ke GCA</h4>
		</div>
	<div class="panel-body">
	<h5><b>DIVISI > KPM >  RENCANA KERJA To GCA</b></h5><hr>
	<!--<form method="POST" action="page/mod_srko/aksi_import_gca.php">-->
	<form method="POST" action="page/mod_srko/aksi_import_gca.php">
		<div class="form-group  col-lg-12">
		<div class="form-group  col-lg-12">
			<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
		</div>
		<?php
		echo"<input type='hidden' name='tahun' value='$tahun_aktif'>";
		//$query=mysql_query("select * from user a, mskko b where a.grup_id=b.id AND b.id!='0' AND b.id!='2.1' AND b.id!=1.6 AND b.id!=4 group by b.CostCenter");
		
		$query=mysql_query("SELECT 	mskko.id,
									mskko.CostCenter,
									mskko.uraian,
									mskko.kd_unit,
									v_manager.nik
									FROM
									mskko
									INNER JOIN v_manager ON v_manager.CostCenter = mskko.CostCenter
									WHERE mskko.id!='0' AND mskko.id!='2.1' AND mskko.id!=1.6 AND mskko.id!=4 AND mskko.status='1' ");
		
		$th_ak	= date('y', strtotime($tahun_aktif));
		$no=1;
		$i		='A';
		while($r=mysql_fetch_array($query)){
			$kode_baru 	= sprintf('%05s',1);
			$id_div		= $i.$th_ak.$kode_baru;
			echo"<input type='hidden' name='pic_div[]' value='$r[nik]' size='5'>";
			echo"<input type='hidden' name='cc_div[]' value='$r[CostCenter]' size='5'> ".$no++."";
			echo"<input type='hidden' name='id_div[]' value='$id_div' size='8'>";
			echo"<input type='hidden' name='parentId_div[]' value='$id_tahun' size='5'>";
			echo"<input type='text' name='aktivitas_div[]' value='$r[uraian] $tahun_aktif' class='form-control'>";
			
			$kpm = mysql_query("SELECT  kpm,id_kpi,CostCenter,hasil_akhir FROM srko WHERE CostCenter='$r[CostCenter]' AND tahun='$tahun_aktif' group by CostCenter");
			$jml_kpm = mysql_num_rows($kpm)+1;
			echo"<ul>";
			$no_kpm=$i;
			$n=1;
			$nokap=1;
			while($k=mysql_fetch_array($kpm)){
				$kode_kpm 	= sprintf('%05s',$nokap+1);
				$id_kpm		= $i.$th_ak.$kode_kpm;
				echo"<li>
						<input type='hidden' name='pic_kpm[]' value='$r[nik]' size='5'>
						<input type='hidden' name='cc_kpm[]' value='$k[CostCenter]' size='5'>
						<input type='hidden' name='kpi_kpm[]' value='$k[id_kpi]' size='5'>
						<input type='hidden' name='id_kpm[]' value='$id_kpm' size='8'>
						<input type='hidden' name='hasil_akhir_kpm[]' value='$k[hasil_akhir]' size='5'>
						<input type='hidden' name='parentId_kpm[]' value='$id_div' size='5'>
						<input type='hidden' name='aktivitas_kpm[]' value='$k[kpm]' size='75' class='form-control'>
						";
					echo"<ul>";
						$rkerja 	= mysql_query("SELECT distinct rencana_kerja, CostCenter,id_kpi,hasil_akhir FROM srko WHERE CostCenter='$k[CostCenter]' AND kpm='$k[kpm]' AND tahun='$tahun_aktif' ");
						while($rk=mysql_fetch_array($rkerja)){
						$id_srko2	= mysql_fetch_array(mysql_query("SELECT id_srko FROM srko WHERE rencana_kerja='$rk[rencana_kerja]' AND id_kpi='$rk[id_kpi]' AND CostCenter='$rk[CostCenter]' AND tahun='$tahun_aktif'"));
						if($nokap > 1){
							$jml_kpm = $jml_kpm - 1;
						}else{
							$jml_kpm = $jml_kpm;
						}
						$id_rk	= $i.$th_ak.sprintf('%05s',$n+$jml_kpm);
						
						echo"<li>
							<input type='hidden' name='pic_rk[]' value='$r[nik]' size='5'>
							<input type='hidden' name='cc_rk[]' value='$rk[CostCenter]' size='5'>
							<input type='hidden' name='srko_rk[]' value='$id_srko2[id_srko]' size='5'>
							<input type='hidden' name='kpi_rk[]' value='$rk[id_kpi]' size='5'>
							<input type='hidden' name='hasil_akhir_rk[]' value='$rk[hasil_akhir]' size='5'>
							<input type='hidden' name='id_rk[]' value='$id_rk' size='8'>
							<input type='hidden' name='parentId_rk[]' value='$id_kpm' size='5'>
							<input type='text' name='aktivitas_rk[]' value='$rk[rencana_kerja]' size='70' class='form-control'>
							</li>";
							$n++;
							$id_baru++;							
						}
					echo"</ul>
				</li>";
				$n++;
				$no_kpm++;
				$nokap++;
			}
			$i++;
			echo"</ul>";
		}
		?>
		</div>
	</form>
	</div>
	</div>