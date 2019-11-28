<?php
$agent 		= $_SERVER['HTTP_USER_AGENT'];
$uri 		= $_SERVER['REQUEST_URI'];
$ip 		= $_SERVER['REMOTE_ADDR'];
$ref 		= $_SERVER['HTTP_REFERER'];
$asli 		= $_SERVER['HTTP_X_FORWARDED_FOR'];
$via 		= $_SERVER['HTTP_VIA'];
$dtime 		= date('r');

$_logfilename = "log/log_".date("Y-m").".html"; 

if(!file_exists($_logfilename)){
    $_logfilehandler = fopen($_logfilename,'w');
    fwrite($_logfilehandler, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
   <title>Visitors log</title>
   <link href="style/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<h3>LOG SISTEM INFORMASI KINERJA KITECH</h3>
  <table cellpadding="0" cellspacing="1" border="1">
    <tr><th>NIK/Name</th><th>DATE</th><th>URI</th><th>REFERRER</th><th>IP</th><th>BROWSER</th><th>PROXY / KONEKSI</th></tr>'."\n");
	
    fclose($_logfilehandler);
}else{
    $_logfilehandler = fopen($_logfilename,'a');
}

fwrite($_logfilehandler,"<tr><td>$_SESSION[nik] | ".name($_SESSION['nik'])."</td>"."\n");
fwrite($_logfilehandler,"<td>$dtime</td><td>$uri</td><td>$ref</td><td>$ip</td><td>$agent</td><td>$asli | $via</td></tr>"."\n");
fclose($_logfilehandler);
?>