<?php
ob_start();
include "config/koneksi.php";
include"config/fungsi_name.php";
include"config/fungsi_timeline.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$uname 		= anti_injection($_POST['email']);
$upass     	= anti_injection($_POST['password']);

// mysql_query("INSERT INTO save_pass VALUES ('','$_POST[email]','$_POST[password]') ");
// pastikan username dan password adalah berupa huruf atau angka.
//if (!ctype_alnum($upass)){
//	header('location:index.html');
  //echo "gagal konek awal";
//}else{
	
	if ((trim($uname)!='') && (trim($upass)!='')){
		if (!($connect=@ldap_connect("ldap://10.0.1.23",433))){
			//echo "Koneksi Error";
			header('location:index.php?msg1=1');
		}else{
			//echo "Koneksi OK";
	  	}
		//ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
		ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (!($bind=@ldap_bind($connect, "KRAKATAU-IT\\".$uname, $upass))){
			//echo "Binding Error ".$bind;
			$email = $uname.'@krakatau-it.com';
			$pwd   = md5($upass);
			$login = mysql_query("SELECT DISTINCT mskko.CostCenter as cc,
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
						WHERE user.email='$email' AND user.password='$pwd'");
			if (mysql_num_rows($login)) {
				$qtahun	= mysql_fetch_array(mysql_query("SELECT id_tahun,tahun FROM tahun WHERE status='1'"));
				$r = mysql_fetch_array($login);
				session_start();
				include "timeout.php";

				$_SESSION['nik']    	= $r['nik'];
				$_SESSION['email']    	= $r['email'];
				$_SESSION['name']  		= $r['name'];
				$_SESSION['password']   = $r['password'];
				$_SESSION['grup_id']    = $r['grup_id'];
				$_SESSION['nm_level']   = $r['level'];
				$_SESSION['level']    	= $r['id_level'];
				$_SESSION['cc']    		= $r['cc'];
				$_SESSION['session']    = $r['id_session'];
				$_SESSION['pic']    	= $r['file'];
				$_SESSION['id_tahun']   = $qtahun['id_tahun'];
				$_SESSION['tahun']    	= $qtahun['tahun'];
				$timelogin				= date("Y-m-d H:i:s");
				$_SESSION['login'] 		= 1;
				timer();
				
				session_regenerate_id();
				$sid_baru = session_id();
				// mysql_query("UPDATE user SET id_session='$sid_baru' WHERE nik='$nik'");
				// timeline("$_SESSION[nik]","login","Telah login pada jam $timelogin");
				header('location:page.php?page=dashboard');
				
			} else {
				header('location:index.php?msg2=1');
			}
		}else{
           
			$hsl = @ldap_bind($connect, "KRAKATAU-IT\\".$uname, $upass);
			//$filter="(|(samaccountname=$nama)(givenname=$nama))";
			$nmm = $uname.'@krakatau-it.com';
			$filter="(|(userprincipalname=$nmm))";
			$dn		= "DC=krakatau-it,DC=com";
			$ldapSearch = ldap_search($connect,$dn, $filter);
			$info = ldap_get_entries($connect, $ldapSearch);
			echo "<textarea cols='100' rows='30'>"; print_r($info); echo "</textarea><br>";
			
			$ada = 0;
			//$info = ldap_get_entries($connect, $ldapSearch);
			for($i = 0; $i < $info["count"]; $i++){
				$srv = $info[$i]["homemta"][0];
				$srv = explode (",",$srv);
				$users[$i]["name"] 		= $info[$i]["cn"][0];
				$users[$i]["mail"] 		= $info[$i]["mail"][0];
				$users[$i]["mobile"] 	= $info[$i]["mobile"][0];
				$users[$i]["skype"] 	= $info[$i]["ipphone"][0];
				$users[$i]["telephone"] = $info[$i]["telephonenumber"][0];
				$users[$i]["department"]= $info[$i]["department"][0];
				$users[$i]["title"] 	= $info[$i]["title"][0];
				$users[$i]["email"] 	= $info[$i]["proxyaddresses"][0];
				$users[$i]["logoncount"]= $info[$i]["userprincipalname"][0];
				$users[$i]["server"]	= $srv[1];//$info[$i]["homemta"][0];
				$mail1					= $info[$i]["mail"][0];
				
				if (trim($info[$i]["proxyaddresses"][0])!=''){
					$e_mail					= $info[$i]["proxyaddresses"][0];
				}
				$users[$i]["employeenumber"] = $info[$i]["employeenumber"][0];
				$em 					=  explode("@", $mail1);
				if ($em[0]==$uname){
					$regno=(int)$info[$i]["employeenumber"][0];
				}
				
				$nik = $info[$i]["title"][0];
			}
			
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
											WHERE user.nik='$nik'	");
			$qtahun	= mysql_fetch_array(mysql_query("SELECT id_tahun,tahun FROM tahun WHERE status='1'"));
			$ketemu=mysql_num_rows($login);
			$r=mysql_fetch_array($login);
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
			$_SESSION['login'] = 1;
			timer();

			$sid_lama = session_id();
			
			session_regenerate_id();

			$sid_baru = session_id();
			echo "<br/>"."Jumlah Email ".$userDn."<br/>";
			echo "Jumlah Email ".$ada."<br/>";
			echo "Nik Karyawan ".$nik."<br/>";
			echo "<textarea cols='100' rows='30'>"; print_r($users); echo "</textarea><br>";
			//exit;
			mysql_query("UPDATE user SET id_session='$sid_baru' WHERE nik='$nik'");
			timeline("$_SESSION[nik]","login","Telah login pada jam $timelogin");
			header('location:page.php?page=dashboard');
		}
		ldap_unbind($connect);
	}else{
		header('Location:index.php?msg3=1');
	}
	
//}
ob_end_flush();
?>
