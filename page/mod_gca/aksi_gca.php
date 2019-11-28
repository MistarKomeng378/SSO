<?php
include"../../config/koneksi.php";

// $id				= mysql_real_escape_string($_POST['id']);
$parentId		= mysql_real_escape_string($_POST['parentId']);
$jam			= mysql_real_escape_string($_POST['jam']);
@$id_srko 		= mysql_real_escape_string($_POST['id_srko']);
$aktivitas		= mysql_real_escape_string($_POST['aktifitas']);
// $mulai			= mysql_real_escape_string($_POST['mulai']);
// $akhir			= mysql_real_escape_string($_POST['akhir']);
/////////////////////////////////////////////////////////////
$tanggal		= mysql_real_escape_string($_POST['tanggal']);
$ex				= explode("-",$tanggal);
$tgl_1			= explode("/",$ex[0]);
$tgl_mulai		= trim($tgl_1[2])."-".trim($tgl_1[1])."-".trim($tgl_1[0]);
$tgl_2			= explode("/",$ex[1]);
$tgl_akhir		= trim($tgl_2[2])."-".trim($tgl_2[1])."-".trim($tgl_2[0]);

$dt1 			= strtotime($tgl_mulai);
$dt2 			= strtotime($tgl_akhir);
$diff 			= abs($dt2-$dt1);
$durasi 		= ($diff/86400)+1; // 86400 detik sehari
/////////////////////////////////////////////////////////////
$cc				= mysql_real_escape_string($_POST['cc']);
$deliverable	= mysql_real_escape_string($_POST['deliverable']);
$tgl_isi		= mysql_real_escape_string($_POST['tgl_isi']);
$gca_by			= mysql_real_escape_string($_POST['gca_by']);
$nik			= mysql_real_escape_string($_POST['nik']);
/////////////////////////////////////////////////////////////
$count = count(explode(",",$_POST['pengecualian']));	
$total_durasi = $durasi-$count;
/////////////////////////////////////////////////////////////
				// $date1 = date_create($tgl_mulai);
				// $arr1 = explode('-',$tgl_mulai);
				// $arr2 = explode('-',$tgl_akhir);
				// $diff = gregoriantojd($arr2[1], $arr2[2], $arr2[0])- gregoriantojd($arr1[1], $arr1[2], $arr1[0]);
				// for($k=0;$k<=$diff;$k++){			
					// $tgl_kerja = date_format($date1,"Y-m-d");
					
					// $exp	= explode("-",$tgl_kerja);
					// $year	= $exp[0]; 
					// $month	= $exp[1]; 
					// $day	= $exp[2];
					
					// if(date("D",mktime (0,0,0,$month,$day,$year)) == "Sun") {
						
					// }elseif(date("D",mktime (0,0,0,$month,$day,$year)) == "Sat") {
						 
					// }
					// else{
						// echo"$tgl_kerja<br>";
					// }
					// date_add($date1, date_interval_create_from_date_string('1 days'));
					
				// }
				
	
/////////////////////////////////////////////////////////////
	// echo "<br>";
	// $count = count(explode(",",$_POST['pengecualian']));
	// $ex = explode(",",$_POST['pengecualian']);
	// for($i=0;$i<$count;$i++){
		// $ex2 = explode("/",$ex[$i]);
		// $tgl = $ex2[2]."-".$ex2[0]."-".$ex2[1];
		// echo "$tgl<br>";
	// }
	// echo "<br>";

// echo "<br>";
// echo "$id<br>";
// echo "$cc<br>";
// echo "$parentId<br>";
// echo "$aktivitas<br>";
// echo "$tgl_mulai<br>";
// echo "$tgl_akhir<br>";
// echo "$durasi<br>";
// echo "$total_durasi<br>";
// echo "$pic<br>";
// echo "$deliverable<br>";
// echo "$tgl_isi<br>";
// echo "$gca_by<br>";
// echo "$nik<br>";
// echo "$tanggal<br>";

if($_GET['opt']=="edit"){
	$pic 	= mysql_real_escape_string($_POST['pic']);
	$query 	= mysql_query("UPDATE wbs SET 	`id`			='$id',
											`parentId`		='$parentId',
											`id_srko`		='$id_srko',
											`aktivitas`		='$aktivitas',
											`mulai`			='$tgl_mulai',
											`akhir`			='$tgl_akhir',
											`cc`			='$cc',
											`pic`			='$pic',
											`deliverable`	='$deliverable',
											`durasi`		='$total_durasi',												
											`tgl_isi`		='$tgl_isi',												
											`gca_by`		='$nik'
									WHERE 	`id`			='$id'");
									
			mysql_query("DELETE FROM waktu_kerja WHERE id_gca='$id' ");
			$date1 = date_create($tgl_mulai);
			$arr1 = explode('-',$tgl_mulai);
			$arr2 = explode('-',$tgl_akhir);
			$diff = gregoriantojd($arr2[1], $arr2[2], $arr2[0])- gregoriantojd($arr1[1], $arr1[2], $arr1[0]);
			for($k=0;$k<=$diff;$k++){  
				$tgl_kerja = date_format($date1,"Y-m-d");
				echo"$tgl_kerja<br>";
				$ex		= explode("-",$tgl_kerja);
				$year	= $ex[0]; 
				$month	= $ex[1]; 
				$day	= $ex[2];
				
				if(date("D",mktime (0,0,0,$month,$day,$year)) == "Sun") {
					
				}elseif(date("D",mktime (0,0,0,$month,$day,$year)) == "Sat") {
					 
				}
				else{
					mysql_query("INSERT INTO waktu_kerja (`nik`, `id_gca`, `id_srko`, `tgl_kerja`, `jam_kerja`)
													VALUES ('$pic','$id','$id_srko','$tgl_kerja','$jam')");
					
				}
				date_add($date1, date_interval_create_from_date_string('1 days'));
			}
//////////////////////////////////////////////////////////////
			$ex = explode(",",$_POST['pengecualian']);
				for($del=0;$del<$count;$del++){
					$ex2 = explode("/",$ex[$del]);
					$tgl = $ex2[2]."-".$ex2[0]."-".$ex2[1];
					mysql_query("DELETE FROM waktu_kerja WHERE `nik`='$pic' AND `id_gca`='$id' AND `id_srko`='$id_srko' AND `tgl_kerja`='$tgl' AND `jam_kerja`='$jam'");
				}
			

}elseif($_GET['opt']=="tambah"){
	$jum1= count($_POST['pic']);
	for($i=0; $i<$jum1; $i++){
		$id	 = $_POST['id']+$i;
		$pic = $_POST['pic'][$i];
		echo "$pic <br>";
		echo "$id <br>";
		mysql_query("INSERT INTO `wbs` SET `id`		='$id',
												`parentId`		='$parentId',
												`id_srko`		='$id_srko',
												`aktivitas`		='$aktivitas',
												`mulai`			='$tgl_mulai',
												`akhir`			='$tgl_akhir',
												`cc`			='$cc',
												`pic`			='$pic',
												`deliverable`	='$deliverable',
												`durasi`		='$total_durasi',												
												`tgl_isi`		='$tgl_isi',												
												`gca_by`		='$nik'");
				$date1 = date_create($tgl_mulai);
				$arr1 = explode('-',$tgl_mulai);
				$arr2 = explode('-',$tgl_akhir);
				$diff = gregoriantojd($arr2[1], $arr2[2], $arr2[0])- gregoriantojd($arr1[1], $arr1[2], $arr1[0]);
				for($k=0;$k<=$diff;$k++){  
					$tgl_kerja = date_format($date1,"Y-m-d");
					
					$ex		= explode("-",$tgl_kerja);
					$year	= $ex[0]; 
					$month	= $ex[1]; 
					$day	= $ex[2];
					
					if(date("D",mktime (0,0,0,$month,$day,$year)) == "Sun") {
						
					}elseif(date("D",mktime (0,0,0,$month,$day,$year)) == "Sat") {
						 
					}
					else{
						mysql_query("INSERT INTO waktu_kerja (`nik`, `id_gca`, `id_srko`, `tgl_kerja`, `jam_kerja`)
														VALUES ('$pic','$id','$id_srko','$tgl_kerja','$jam')");
						
					}
					date_add($date1, date_interval_create_from_date_string('1 days'));
					
				}
	////////////////////////////////////////////////
				$ex = explode(",",$_POST['pengecualian']);
				for($del=0;$del<$count;$del++){
					$ex2 = explode("/",$ex[$del]);
					$tgl = $ex2[2]."-".$ex2[0]."-".$ex2[1];
					mysql_query("DELETE FROM waktu_kerja WHERE `nik`='$pic' AND `id_gca`='$id' AND `id_srko`='$id_srko' AND `tgl_kerja`='$tgl' AND `jam_kerja`='$jam'");
				}
	}
}
	// if($query){
		header('Location: ../../page.php?page=data_gca&succes=1');
	// }else{
		 // header('Location: ../../page.php?page=data_gca&failed=1');
	// }
 
?>