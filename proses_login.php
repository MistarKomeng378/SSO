<?php
ob_start();
include "config/koneksi.php";
include"config/fungsi_name.php";
include"config/fungsi_timeline.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$email 		= anti_injection($_POST['email']);
$pass     	= anti_injection(md5($_POST['password']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($pass)){
  header('location:index.php?msg=1');
}else{
	if(empty($email) || empty($pass)){
		header('location:index.php?msg3=1');
		// header('location:login.php?msg3=1');
	}else{
		$login=mysql_query("SELECT DISTINCT mskko.CostCenter as cc,
											`user`.id,
											`user`.nik,
											`user`.name,
											`user`.email,
											`user`.grup_id,
											`user`.`password`,
											`user`.`id_session`,
											`level`.`level`,
											`level`.`id_level`
											FROM
											`user`
											INNER JOIN mskko ON mskko.id = `user`.grup_id
											INNER JOIN level ON level.id_level = `user`.level
											WHERE user.email='$email@krakatau-it.co.id' and user.password='$pass'	");
		$qtahun	= mysql_fetch_array(mysql_query("SELECT id_tahun,tahun FROM tahun WHERE status='1'"));
		$ketemu=mysql_num_rows($login);
		$r=mysql_fetch_array($login);

		// echo "$email-$pass-$ketemu-$r[nik]";

		// Apabila username dan password ditemukan
		if ($ketemu > 0){
			  session_start();
			  include "timeout.php";

			  $_SESSION['nik']    		= $r['nik'];
			  $_SESSION['email']    	= $r['email'];
			  $_SESSION['name']  		= $r['name'];
			  $_SESSION['password']    	= $r['password'];
			  $_SESSION['grup_id']    	= $r['grup_id'];
			  $_SESSION['nm_level']    	= $r['level'];
			  $_SESSION['level']    	= $r['id_level'];
			  $_SESSION['cc']    		= $r['cc'];
			  $_SESSION['session']    	= $r['id_session'];
			  $_SESSION['id_tahun']    	= $qtahun['id_tahun'];
			  $_SESSION['tahun']    	= $qtahun['tahun'];
			  $timelogin				= date("Y-m-d H:i:s");
			  // session timeout
			  $_SESSION['login'] = 1;
			  timer();

				$sid_lama = session_id();	
				session_regenerate_id();
				$sid_baru = session_id();
				mysql_query("UPDATE user SET id_session='$sid_baru' WHERE nik='$r[nik]'");
				timeline("$_SESSION[nik]","login","Telah login pada jam $timelogin");
			  // header('location:indexApp.php');
			 header('location:page.php?page=dashboard');
		}else{
			header('location:index.php?msg2=1');
			// header('location:login.php?msg2=1');
		}
	}
}
ob_end_flush();
?>
