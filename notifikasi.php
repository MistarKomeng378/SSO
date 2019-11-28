<?php
ob_start();
session_start();
include"config/koneksi.php";
	$jambul = mysql_query("SELECT * FROM jam_bulanan WHERE tahun='$_SESSION[tahun]'");
	$jml_merah= 0; 
	$countMerah= 0; 
	while($r=mysql_fetch_array($jambul)){
		$jml_wk = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum_jam FROM waktu_kerja2 WHERE nik='$_SESSION[nik]' AND bulan='$r[bulan]'  AND tahun='$_SESSION[tahun]'"));
		
		$jm7 		= 7 * $r['hari_kerja'];
		$jm7plus 	= 7 * $r['hari_kerja'];
		
		if($jml_wk['jum_jam'] < $jm7){
			$jml_merah= 1; 
		}elseif($jml_wk['jum_jam'] > $r['jam_bulanan']){
			$jml_merah= 1; 
		}else{
			$jml_merah= 0; 
		}
		// echo"$r[bulan]) $jml_merah - ($jm7 * $r[hari_kerja])<br>";
		$countMerah += $jml_merah;
	}
	// echo"$countMerah<br>";
	if($countMerah != 0){
?>
	<script>
		$(document).ready(function() {
			if (Notification.permission !== "granted")
			Notification.requestPermission();
		});
				 
		function notifikasi() {
		if (!Notification) {
			alert('Browser kamu belum mendukung web notifikasi.'); 
			return;
		}
			if (Notification.permission !== "granted")
				Notification.requestPermission();
			else {
				var notifikasi = new Notification('Setting GCA Load <?=$_SESSION['tahun']?>', {
					icon: 'assets/img/user-13.jpg',
					body: "Segera lakukan setting alokasi jam pada GCA Load untuk memudahkan sistem membuat SRKK dan MSKK anda.",
				});
				notifikasi.onclick = function () {
					window.open("http://sso.krakatau-it.co.id/page.php?page=gca_load");      
				};
				setTimeout(function(){
				notifikasi.close();
				}, 10000);
			}
		};
	</script>
<?php
	}else{
?>		
	<script>
		function notifikasi() {
			
		}
	</script>
<?php	
	}
?>