<link rel="stylesheet" href="css/bootstrap.min.css">	
<link rel="stylesheet" href="css/dataTables.bootstrap.css">

<style>
/*    css disini*/
    *{
        font-family: arial;font-size: 11px;
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

<br>
<?php
session_start();
include"../config/koneksi.php";
include"../config/encript.php";
include"../config/fungsi_indotgl.php";
include"../config/fungsi_bulan.php";
include"../config/fungsi_name.php";
include"../config/fungsi_timeline.php";

	$ex			= explode("-",$_GET['id']);
	$id_gca		= mysql_real_escape_string(dc($ex[0]));
	$tahun		= mysql_real_escape_string(dc($ex[2]));
	$pic		= mysql_real_escape_string(dc($ex[1]));
	$cc			= mysql_real_escape_string(dc($ex[3]));
	$parentId	= mysql_real_escape_string(dc($ex[4]));
	$data		= mysql_fetch_array(mysql_query("SELECT aktivitas,pic,gca_by FROM wbs WHERE id='$id_gca'"));
	
			$tgl_mulai	= date("$tahun-01-01");
			$tgl_akhir	= date("$tahun-12-01");
			$start    = new DateTime($tgl_mulai);
			$start->modify('first day of this month');
			$end      = new DateTime($tgl_akhir);
			$end->modify('first day of next month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			if(!isset($_GET['update_gca_load'])){
				if($pic==$_SESSION['nik']){
					echo"<a href='?update_gca_load=1&id=".ec($id_gca)."-".ec($pic)."-".ec($tahun)."-".ec($cc)."-".ec($parentId)."' class='btn btn-sm btn-primary'><i class='fa fa-pencil'></i> Update GCA Load</a><br>";
				}elseif($_SESSION['level']==1){
					echo"<a href='?update_gca_load=1&id=".ec($id_gca)."-".ec($pic)."-".ec($tahun)."-".ec($cc)."-".ec($parentId)."' class='btn btn-sm btn-primary'><i class='fa fa-pencil'></i> Update GCA Load</a><br>";
				}elseif($_SESSION['level']==4 AND $_SESSION['cc']==$cc){
					echo"<a href='?update_gca_load=1&id=".ec($id_gca)."-".ec($pic)."-".ec($tahun)."-".ec($cc)."-".ec($parentId)."' class='btn btn-sm btn-primary'><i class='fa fa-pencil'></i> Update GCA Load</a><br>";
				}elseif($_SESSION['level']==5){
					$atasan1 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$parentId' "));
					$atasan2 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$atasan1[parentId]' "));
					$atasan3 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$atasan2[parentId]' "));
					if($_SESSION['nik']==$data['pic'] OR $_SESSION['nik']==$data['gca_by'] OR $_SESSION['nik']==$atasan1['pic'] OR $_SESSION['nik']==$atasan2['pic'] OR $_SESSION['nik']==$atasan3['pic'] ){
						echo"<a href='?update_gca_load=1&id=".ec($id_gca)."-".ec($pic)."-".ec($tahun)."-".ec($cc)."-".ec($parentId)."' class='btn btn-sm btn-primary'><i class='fa fa-pencil'></i> Update GCA Load</a><br>";
					}
				}
			}
			echo"<form method='POST' action='' >
					<input type='hidden' name='id_gca' value='$id_gca'>
					<input type='hidden' name='parentId' value='$parentId'>
					<input type='hidden' name='cc' value='$cc'>
					<input type='hidden' name='pic' value='$pic'>
					<input type='hidden' name='tahun' value='$tahun'>
			";
			foreach ($period as $dt) {
				$year 	= $dt->format("Y");
				$month 	= $dt->format("m");
				$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$month,$year);
				echo"<b>".bulan($month)." - $tahun</b><br>
					<input type='hidden' name='bulan[]' value='$month'>";
				echo'
				<table width="100%" border="1" cellpadding="3" style="color:#000000" >
					<thead>
						<tr align="center" bgcolor="#ccd9ff">
							';
							for ($tgl=1;$tgl<=$lastDay;$tgl++){
								$tgl_kerja 	= $year."-".$month."-".$tgl;
								$fontColor="#000000"; 
								if (date("D",mktime (0,0,0,$month,$tgl,$year)) == "Sun") {
									$fontColor="red"; 
								}
								if (date("D",mktime (0,0,0,$month,$tgl,$year)) == "Sat") {
									$fontColor="red"; 
								}
								$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$tgl $month $year'"));
								$tglLibur		= $liburaNas['tanggal'];
								$libur	 		= date('Y-m-d', strtotime($tgl_kerja));
								if($tglLibur == $libur){
									$fontColor="red";
								}
								if($fontColor=="red"){
									$bgcolor="ffad99";
								}else{
									$bgcolor="";
								}
								echo "<td bgcolor='$bgcolor' width='3%'> <span style=\"color:$fontColor\"><b>$tgl</b></span></td>"; 								
							}
						if(!isset($_GET['update_gca_load'])){		
						echo'<td width="10%">Total</td>';
						}
						echo'
						</tr>
					</thead>
					<tbody>';
					echo'<tr align="center" bgcolor="#b3ffb3">
							';
							for ($tgl=1;$tgl<=$lastDay;$tgl++){
								$tgl_kerja 	= $year."-".$month."-".$tgl;
								$fontColor="#000000"; 
								if (date("D",mktime (0,0,0,$month,$tgl,$year)) == "Sun") {
									$fontColor="red"; 
								}
								if (date("D",mktime (0,0,0,$month,$tgl,$year)) == "Sat") {
									$fontColor="red"; 
								}
								$liburaNas 		= mysql_fetch_array(mysql_query("SELECT tanggal FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$tgl $month $year'"));
								$tglLibur		= $liburaNas['tanggal'];
								$libur	 		= date('Y-m-d', strtotime($tgl_kerja));
								if($tglLibur == $libur){
									$fontColor="red";
								}
								if($fontColor=="red"){
									$bgcolor="ffad99";
								}else{
									$bgcolor="";
								}
								$jml_wk = mysql_fetch_array(mysql_query("SELECT `$tgl` as jum_jam FROM waktu_kerja2 WHERE `nik`='$pic' AND `bulan`='$month' AND `tahun`='$year' AND id_gca='$id_gca' "));
								if(isset($_GET['update_gca_load'])){
									echo "<td bgcolor='$bgcolor' width='20px'>
											<input type='text' name='jam_kerja_$tgl-$month' value='$jml_wk[jum_jam]' style=\"width:25px;\" />
										</td>";
								}else{
									echo "<td bgcolor='$bgcolor'> <span style=\"color:$fontColor\">$jml_wk[jum_jam]</span></td>"; 								
								}
							}
						if(!isset($_GET['update_gca_load'])){
							$wk = mysql_fetch_array(mysql_query("SELECT SUM(`1`)+SUM(`2`)+SUM(`3`)+SUM(`4`)+SUM(`5`)+SUM(`6`)+SUM(`7`)+SUM(`8`)+SUM(`9`)+SUM(`10`)+
									SUM(`11`)+SUM(`12`)+SUM(`13`)+SUM(`14`)+SUM(`15`)+SUM(`16`)+SUM(`17`)+SUM(`18`)+SUM(`19`)+SUM(`20`)+
									SUM(`21`)+SUM(`22`)+SUM(`23`)+SUM(`24`)+SUM(`25`)+SUM(`26`)+SUM(`27`)+SUM(`28`)+SUM(`29`)+SUM(`30`)+
									SUM(`31`)+SUM(`32`) as jum FROM waktu_kerja2 
									WHERE `nik`='$pic' 
									AND `bulan`='$month' 
									AND `tahun`='$tahun' 
									AND `id_gca`='$id_gca' ")) ;
						echo"
							<td>$wk[jum]</td>";
						}
						echo"
						</tr>
					</tbody>
				</table>";
			}
			if(isset($_GET['update_gca_load'])){
				echo"<div class='col-lg-12'><br><input type='submit' value='Simpan' name='Simpan' class='btn btn-sm btn-primary'></div>";
			}
		?>
		</form>
<br>
<br>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.js"></script>
<?php
if(isset($_POST['Simpan'])){
	$id_gca 	= mysql_real_escape_string($_POST['id_gca']);
	$parentId 	= mysql_real_escape_string($_POST['parentId']);
	$cc 		= mysql_real_escape_string($_POST['cc']);
	$pic 		= mysql_real_escape_string($_POST['pic']);
	$tahun 		= mysql_real_escape_string($_POST['tahun']);
	$month 		= mysql_real_escape_string(count($_POST['bulan']));
	$durasi 	= 0;
	mysql_query("DELETE FROM waktu_kerja2 WHERE nik='$pic' AND id_gca='$id_gca' AND parentId='$parentId' AND tahun='$tahun' AND cc='$cc'");
	timeline($_SESSION['nik'],"edit","Telah melakukan update GCA Load milik ".name($pic)." dengan id $id_gca : $data[aktivitas] ");
	
	for($i=0;$i<=$month-1;$i++){
		$bulan 		= $_POST['bulan'][$i];
		$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
		$tot_durasi = 0;
		$jumlahHari = 0;		
		// echo"$bulan -> $lastDay<br>";
		mysql_query("INSERT INTO waktu_kerja2(`nik`,`id_gca`,`parentId`,`cc`,`bulan`,`tahun`) 
									VALUES('$pic','$id_gca','$parentId','$cc','$bulan','$tahun') ");
		for ($tgl=1;$tgl<=$lastDay;$tgl++){
			$jam = mysql_real_escape_string($_POST['jam_kerja_'.$tgl.'-'.$bulan]);
			if(!empty($jam)){
				// echo"$tgl($jam)-";
				mysql_query("UPDATE waktu_kerja2 SET `$tgl`='$jam' WHERE nik='$pic' AND id_gca='$id_gca' AND parentId='$parentId' AND cc='$cc' AND tahun='$tahun' AND bulan='$bulan'  ");
				
				if($jam > 0){
					$hari_kerja = 1;
				}else{
					$hari_kerja = 0;
				}
				$tot_durasi += $jam;
				
				$jumlahHari += $hari_kerja;
			}		
		}
		$durasi 	+= $tot_durasi;
		// echo"<br>total durasi = $tot_durasi ($jumlahHari)";
		// echo"<br>";
		mysql_query("UPDATE waktu_kerja2 SET total_jam='$tot_durasi',total_hari='$jumlahHari' WHERE nik='$pic' AND id_gca='$id_gca' AND parentId='$parentId' AND cc='$cc' AND tahun='$tahun' AND bulan='$bulan'");
		
		$tot_durasi = 0;
		$jumlahHari = 0;
	}
		mysql_query("DELETE FROM waktu_kerja2 WHERE id_gca='$id_gca' AND total_jam='0' AND total_hari='0'");
		mysql_query("UPDATE wbs SET durasi='$durasi' WHERE id='$id_gca' AND parentId='$parentId' AND pic='$pic' AND cc_id='$cc' AND tahun='$tahun'");
	
	echo "<script language='javascript'>document.location='?id=".ec($id_gca)."-".ec($pic)."-".ec($tahun)."-".ec($cc)."-".ec($parentId)."'</script>";	
}

?>