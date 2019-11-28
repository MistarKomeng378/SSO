<?php
ob_start();
session_start();
include"config.php";
error_reporting(0);
if($_SESSION['grup_id'] != ''){
		include"timeout.php";
		
			if($_SESSION['login']==1){
				if(!cek_login()){
					$_SESSION['login'] = 0;
				}
			}
			if($_SESSION['login']==0){
				header('location:index.php');
			}
	}
	if(empty($_SESSION['nik']) AND empty($_SESSION['password'])){
		echo "<script language='javascript'>alert('Silahkan login terlebih dahulu');document.location='index.php'</script>";
	}
		
	$level			= $_SESSION['level'];
	$id_tahun		= $_SESSION['id_tahun'];
	$tahun_aktif	= $_SESSION['tahun'];
	$getPage 		= anti_injection($_GET['page']);
	$getMod			= mysql_query("SELECT DISTINCT
									a.id_menu,
									a.menu,
									a.link,
									a.dir,
									a.file,
									ifnull((SELECT count(id_permission) FROM role_permission WHERE id_menu=a.id_menu AND id_permission='1' AND nik='$_SESSION[nik]' AND `level`='$_SESSION[level]'),'') as `c`,
									ifnull((SELECT id_menu FROM role_menu WHERE id_menu=a.id_menu AND nik='$_SESSION[nik]' AND `level`='$_SESSION[level]'),'') as `r`,
									ifnull((SELECT count(id_permission) FROM role_permission WHERE id_menu=a.id_menu AND id_permission='2' AND nik='$_SESSION[nik]' AND `level`='$_SESSION[level]'),'') as `u`,
									ifnull((SELECT count(id_permission) FROM role_permission WHERE id_menu=a.id_menu AND id_permission='4' AND nik='$_SESSION[nik]' AND `level`='$_SESSION[level]'),'') as `d`
									FROM
									m_menu a
									LEFT JOIN role_menu ON role_menu.id_menu = a.id_menu
									INNER JOIN role_permission ON role_permission.nik = role_menu.nik AND a.id_menu = role_menu.id_menu AND role_permission.`level` = role_menu.`level`
									WHERE role_permission.nik='$_SESSION[nik]' AND a.link='$getPage'
									");
	$module		= mysql_fetch_array($getMod);
	$getlink	= "page/".$module['dir']."/".$module['file'].".php";
	$getread	= $module['r'];
	$getInsert	= $module['c'];
	$getEdit	= $module['u'];
	$getDelete	= $module['d'];
	// timeline($_SESSION['nik'],"open","akses menu $module[menu]");
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title><?=strtoupper($module['menu'])?> | SSO : KRAKATAU INFROMATION TECHNOLOGY</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<link href="favicon.ico" rel="shortcut icon"  type="image/vnd.microsoft.icon"/>
	<link href='assets/css/opensans.css' rel='stylesheet' type='text/css'>
	<link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="assets/css/style.min.css" rel="stylesheet" />
	<link href="assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="assets/css/theme/blue.css" rel="stylesheet" id="theme" />
	<link href="assets/plugins/datatables2/dataTables.bootstrap.css" rel="stylesheet" />
	
	<script src="assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="assets/plugins/pace/pace.min.js"></script>
</head>
<body onload="">
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="?page=dashboard" class="navbar-brand"><img src="assets/img/logo.png" height="25px"></a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="nav navbar-nav navbar-right">
						<br>
						<a href="logout.php" class="btn btn-sm btn-danger"><i class="fa fa-sign-out"></i> Logout</a> 
				</div>
			</div>
		</div>
		
		<div id="sidebar" class="sidebar">
			<div data-scrollbar="true" data-height="100%">
				<ul class="nav">
					<li class="nav-profile">
						<div class="image">
							<a href='#modal-dialog' class='form-foto' data-id='<?=ec($_SESSION['nik'])?>' data-toggle='modal'>
							<?php
								if(foto($_SESSION['nik'])==""){
									echo'<img src="assets/img/no_foto.png" alt="" />';
								}else{
									echo"<img src='upload/thumbs/thumb_".$_SESSION['nik'].".jpeg' alt='' height='100%' width='50px'/>";
								}
							?>
							</a>
						</div>
						<div class="info">
							<br>
							<br>
							<?=$_SESSION['name']?>
							<br>
							<small><?=jabatan($_SESSION['nik'])?></small>
						</div>
					</li>
				</ul>
				<?php include"menu.php";?>
			</div>
		</div>
		<div class="sidebar-bg"></div>
			<div id="content" class="content">
					<?php
						include"$getlink";
					?>
			</div>
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	</div>
	
	<script src="assets/plugins/jquery/jquery-migrate-1.4.1.min.js"></script>
	<script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	
	<script src="assets/js/jquery.validate.js"></script>
	<script>
		$(document).ready(function(){
			$("#formku").validate();
			$("#formku2").validate();
			$.validator.format(8);
		});
	</script> 
	<style type="text/css">
		label.error {
			color: red;
			padding-left: .5em;
		}
	</style>
	<script src="assets/js/apps.min.js"></script>
	
	<script src="assets/plugins/datatables2/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatables2/dataTables.bootstrap.min.js"></script>
	
	<script>
	  $(function () {
		$("#example1").DataTable();
		$('#example2').DataTable({
		  "paging": true,
		  "lengthChange": false,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": false
		});
		$('#example3').DataTable({
		  "paging": true,
		  "lengthChange": false,
		  "searching": false,
		  "ordering": true,
		  "info": true,
		  "autoWidth": false
		});
	  });
	</script>
	
	<script>
		$(document).ready(function() {
			App.init();
		});
		
		$(function(){
            $(document).on('click','.form-foto',function(e){
                e.preventDefault();
                $("#myModals").modal('shows');
                $.post('page/mod_dashboard/form_foto.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
	</script>
	<div class="modal fade" id="modal-dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Upload Foto</h4>
				</div>
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
// include"config/fungsi_log.php";
// include"notifikasi.php";
?>
