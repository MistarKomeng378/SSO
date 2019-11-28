<?php
include"../../function/sambung.php";
include"../../function/fungsi_query.php";

$table 		="users";
$first 		= mysql_real_escape_string($_POST['first']);
$last 		= mysql_real_escape_string($_POST['last']);
$email 		= mysql_real_escape_string($_POST['email']);
$password 	= mysql_real_escape_string(md5($_POST['password']));

$exp		= explode("@",$_POST['email']);
$username	= $exp[0];
$create		= date("Y-m-d H:i:s");
$update		= date("Y-m-d H:i:s");

// echo "$first-$last-$email-$password";

	if($_GET['opt']=="edit"){
		if(isset($_POST['Simpan'])){
			
			$value = "
						`first_name`	='".$first."',
						`last_name`		='".$last."',
						`username`		='".$username."',
						`email`			='".$email."',
						`password`		='".$password."',
						`status`		='1',
						`date_update`	='$update'
						WHERE `id`		='".$_POST['id']."'
					";
			edit($table,$value);
			header("location:../../control.php?content=user&succes=1");
		}
	}elseif($_GET['opt']=="simpan"){
		if($hit >= 1){
			echo"<SCRIPT language='javascript'>alert('Email atau username sudah digunakan..!!');document.location='../../control.php?content=form_user'</SCRIPT>";
		}else{
				if(isset($_POST['Simpan'])){
				$field = "`id`, `first_name`, `last_name`, `username`, `email`, `password`, `status`, `date_create`, `date_update`";
				$value = "
							'',
							'".$first."',
							'".$last."',
							'".$username."',
							'".$email."',
							'".$password."',
							'1',
							'$create',
							'$update'
						";
				simpan($table,$field,$value);
				header("location:../../control.php?content=user&succes=1");
				}
		}
	}elseif($_GET['opt']=="input_privil"){
		if(isset($_POST['Simpan'])){
			mysql_query("DELETE * FROM role_user WHERE id_user='$_POST[user]'");
			$jum1 = count($_POST['role']);
				for($i=0; $i<$jum1; $i++){

					$role = $_POST['role'][$i];
					$field = "`id_user`, `id_role`";
					$value = "
								'$_POST[user]',
								'$role'
								";
					simpan('role_user',$field,$value);
									
				}			
			header("location:../../control.php?content=user&succes=1");
		}
	}elseif($_GET['opt']=="update_sts"){
		if($_REQUEST['sts']==1){
			mysql_query("UPDATE users SET status='0' WHERE  id='".$_REQUEST['id']."' ");
			header("location:../../control.php?content=user&succes2=1");
			
		}elseif($_REQUEST['sts']==0){
			mysql_query("UPDATE users SET status='1' WHERE  id='".$_REQUEST['id']."' ");
			header("location:../../control.php?content=user&succes2=1");
		}
	}
?>