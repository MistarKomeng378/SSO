<?php
$timezone = "Asia/Jakarta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
function cekJam($now,$maxJam,$minJam){
	
	$inputJam	= date('H:i', strtotime($now));
	$jam_mulai	= date('H:i', strtotime($minJam));
	$jam_akhir	= date('H:i', strtotime($maxJam));
	$start   	= new DateTime($jam_mulai);
	$end      	= new DateTime($jam_akhir);
	$interval 	= DateInterval::createFromDateString('1 minute');
	$period   	= new DatePeriod($start, $interval, $end);
	foreach ($period as $dt) {
		$jam	= $dt->format("H");
		$menit	= $dt->format("i");
		$jamTerpakai = date("$jam:$menit");
		
		if($inputJam == $jamTerpakai){
			$status = 1;
		}else{
			$status = 0;
		}
		if($status ==1){	
			break;
		}		
	}
	return $status;
}
?>