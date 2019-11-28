<?php
	include"../config/koneksi.php";
	include"../config/fungsi_indotgl.php";
	include"../config/encript.php";
	$nik	= dc($_GET['nik']);
?>

<html>
    <head>
        <title>Data GCA</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">	
        <link rel="stylesheet" href="css/dataTables.bootstrap.css">
<style>
/*    css disini*/
    *{
        font-family: arial;font-size: small;
    }
    .mytable th{
        background-color: black;color: white;
    }
    .mytable tr:hover{
        background-color: lightblue;cursor: pointer;
    }
    .mytable td, th{
        padding: 5px
    }
</style>
    </head>
    <body>
        <div class="container">
			<div class="box-body ">
			<h4>Data GCA</h4>
			<a href="job_order.php?nik=<?=ec($nik)?>" class="btn btn-primary"><i class='glyphicon glyphicon-plus'></i> Job Order</a>
			<?php
				if(isset($_GET['full'])){
					echo"<a href='?nik=".ec($nik)."' class='btn btn-primary'><i class='glyphicon glyphicon-search'></i>GCA</a><hr>";
				}else{
					echo"<a href='?nik=".ec($nik)."&full=1' class='btn btn-primary'><i class='glyphicon glyphicon-search'></i> Semua GCA</a><hr>";
				}
			?>
			<link href="../assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
			<link href="../assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
				<table id="example1" class="table table-bordered  table-hover">
					<thead>
						<tr>
							<th></th>
							<th >ID GCA</th>
							<th >Aktifitas</th>
							<th ></th>
							<th >Mulai</th>
							<th >Akhir</th>
							<th >CC</th>
							<th >Deliverable</th>
							<th >Jam</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$todayDate 	= date("Y-m-d");
						$now	 	= date('j', strtotime($todayDate));
						if(isset($_GET['full'])){
							$query = mysql_query("SELECT DISTINCT
															wbs.aktivitas,
															waktu_kerja2.nik,
															wbs.id,
															wbs.mulai,
															wbs.akhir,
															wbs.hasil_akhir,
															wbs.cc,
															wbs.deliverable,
															wbs.jenisAktf,
															ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=waktu_kerja2.id_gca AND `status`='1')),'') as maxpro
															FROM
															waktu_kerja2
															INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca AND wbs.pic = waktu_kerja2.nik
															WHERE wbs.pic='$nik'
															AND `jenisGCA` ='2'
															AND waktu_kerja2.tahun='".date("Y")."'
															ORDER BY wbs.mulai, wbs.id ");

						}else{
							$query = mysql_query("SELECT DISTINCT
															wbs.aktivitas,
															waktu_kerja2.nik,
															wbs.id,
															wbs.mulai,
															wbs.akhir,
															wbs.hasil_akhir,															
															wbs.cc,
															wbs.deliverable,
															wbs.jenisAktf,
															ifnull((SELECT progress FROM pencapaian WHERE id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=waktu_kerja2.id_gca AND `status`='1')),'') as maxpro
															FROM
															waktu_kerja2
															INNER JOIN wbs ON wbs.id = waktu_kerja2.id_gca AND wbs.pic = waktu_kerja2.nik
															WHERE wbs.pic='$nik' 
															AND `$now` !=''
															AND `jenisGCA` ='2'
															AND waktu_kerja2.bulan='".date("n")."' 
															AND waktu_kerja2.tahun='".date("Y")."'
															ORDER BY wbs.mulai, wbs.id");
						}
						while($r=mysql_fetch_array($query)){
							// if($r['jenisAktf']!=2 OR $r['maxpro']!=100){
								if($r['maxpro']==100){
									$bgcolor = "#b3e0ff";
								}else{
									$bgcolor = "";
								}
								$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$r[id]'"));
								$idParent	= $data['parentId'];
							echo'<tr onclick="javascript:pilih(this);" bgcolor="'.$bgcolor.'">
									<td>';
									echo "<z class='glyphicon glyphicon-info-sign' data-tp-title='Cost Center : <b>$r[cc]</b> Progress Terakhir : $r[maxpro] %' data-tp-desc='$r[id] : <b>$r[aktivitas]</b> -> ";
										for($ak=1;$ak<=99;$ak++){
											$gca = mysql_fetch_array(mysql_query("SELECT aktivitas,parentId,tahun FROM wbs WHERE id='$idParent'"));
												$fontColor="black";
												if($ak!=1){
													echo"-> ";
												}
												echo "$gca[aktivitas]";
													$idParent=$gca['parentId'];
													$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
													if ($idParent==$cek_id['id_tahun']){
														break;
													}
										}
									echo"'></z>";
									echo'</td>
									<td>'.$r['id'].'</td>
									<td>'.$r['aktivitas'].'</td>
									<td>'.$r['hasil_akhir'].'</td>
									<td>'.tgl_indo($r['mulai']).'</td>
									<td>'.tgl_indo($r['akhir']).'</td>
									<td>'.$r['cc'].'</td>
									<td>'.$r['deliverable'].'</td>';
									$cekJam = mysql_fetch_array(mysql_query("SELECT `$now` FROM waktu_kerja2 WHERE id_gca='$r[id]' AND bulan='".date("n")."' AND tahun='".date("Y")."' "));
									if($cekJam[$now]<1){
										$fc="red";
									}else{
										$fc="";
									}								
									echo"<td align='center'><span style=\"color:$fc\">$cekJam[$now]</span></td>";
							echo'</tr>';
							// }
						}
					?> 
					</tbody>
				</table>
			</div><!-- /.box-body -->
        </div>	
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.js"></script>	
        <script type="text/javascript">
            $(function() {
			$('#example1').dataTable({
				  "paging": true,
				  "lengthChange": true,
				  "searching": true,
				  "ordering": true,
				  "info": true,
				  "autoWidth": false
				});
            });
        </script>
    </body>
</html>
<script src="../assets/plugins/toltip/jquery.adaptip.js"></script>
<script>
	$("z").adapTip({
	  "placement": "right"
	});
</script>
<script>
    function pilih(row){
		
        var jo_gca=row.cells[1].innerHTML;
        var aktifitas=row.cells[2].innerHTML;
        var cc=row.cells[6].innerHTML;
        var deliverable=row.cells[7].innerHTML;
        var faktor= 'A';
		
        window.opener.parent.document.getElementById("jo_gca").value = jo_gca;
        window.opener.parent.document.getElementById("aktifitas").value = aktifitas;
        window.opener.parent.document.getElementById("deliverable").value = deliverable;
        window.opener.parent.document.getElementById("cc").value = cc;
        window.opener.parent.document.getElementById("faktor").value = faktor;
//        menutup pop up
        window.close();
    }
</script>
