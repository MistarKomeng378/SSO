<?php
	include"../config/koneksi.php";
	include"../config/fungsi_indotgl.php";
	include"../config/encript.php";
	$ex 	= explode("-",$_GET['id']);
	$nik	= mysql_real_escape_string(dc($ex[0]));
	$lapor	= mysql_real_escape_string(dc($ex[1]));
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
			<link href="../assets/plugins/toltip/jquerysctipttop.css" rel="stylesheet" type="text/css">
			<link href="../assets/plugins/toltip/style.adaptip.css" rel="stylesheet" type="text/css">
				<table id="example1" class="table table-bordered table-striped  table-hover">
					<thead>
						<tr>
							<th ></th>
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
						
						$query = mysql_query("SELECT DISTINCT pencapaian.jo_gca as id FROM pencapaian WHERE nik='$nik' AND laporan='$lapor' AND status_dispen='0' AND faktor_k='A'");
						while($r=mysql_fetch_array($query)){							
							$wbs = mysql_fetch_array(mysql_query("SELECT aktivitas,hasil_akhir,mulai,akhir,cc,deliverable FROM wbs WHERE id=$r[id]"));
							$data		= mysql_fetch_array(mysql_query("SELECT parentId FROM wbs WHERE id='$r[id]'"));
							$idParent	= $data['parentId'];
						echo'<tr onclick="javascript:pilih(this);" >
								<td>';
								echo "<z class='glyphicon glyphicon-info-sign' data-tp-title='Cost Center : <b>$wbs[cc]</b>' data-tp-desc='$r[id] : <b>$wbs[aktivitas]</b> -> ";
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
								<td>'.$wbs['aktivitas'].'</td>
								<td>'.$wbs['hasil_akhir'].'</td>
								<td>'.tgl_indo($wbs['mulai']).'</td>
								<td>'.tgl_indo($wbs['akhir']).'</td>
								<td>'.$wbs['cc'].'</td>
								<td>'.$wbs['deliverable'].'</td>';
								$cekJam = mysql_fetch_array(mysql_query("SELECT `$now` FROM waktu_kerja2 WHERE id_gca='$r[id]' AND bulan='".date("n")."' AND tahun='".date("Y")."' "));
								if($cekJam[$now]<1){
									$fc="red";
								}else{
									$fc="";
								}								
								echo"<td align='center'><span style=\"color:$fc\">$cekJam[$now]</span></td>";
						echo'</tr>';
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
