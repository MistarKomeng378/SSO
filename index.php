<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Login Page | SSO : KRAKATAU INFROMATION TECHNOLOGY</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="favicon.ico" rel="shortcut icon"  type="image/vnd.microsoft.icon"/>
	<link href="./assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="./assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="./assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="./assets/css/animate.min.css" rel="stylesheet" />
	<link href="./assets/css/style.min.css" rel="stylesheet" />
	<link href="./assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="./assets/css/theme/blue.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ==================== -->
	<style>
		.logo-kit {
			max-width: 100%;
		}
	</style>
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="./assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->

</head>
<body class="pace-top bg-white">
	<!--<div id="page-loader" class="fade in"><span class="spinner"></span></div>-->
	<div id="page-container" class="fade">
        <div class="login login-with-news-feed">
            <div class="news-feed">
                <div class="news-image">
                    <img src="assets/img/login-bg/bg-6.jpg" data-id="login-cover-image" alt="">
                </div>
                <div class="news-caption">
                    <h4 class="caption-title"><i class="fa fa-sign-in text-primary"></i> Single Sign On</h4>
                    <p>
                        PT. KRAKATAU INFORMATION TECHNOLOGY
                    </p>
                </div>
            </div>
            <div class="right-content">
                <div class="login-header">
                    <div class="brand">
                        <img src="assets/img/logo.png" height="40px" class="logo-kit">
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </div>
                <div class="login-content">
					<?php
						if(isset($_GET['msg1'])){
							echo"<div class='alert alert-danger alert-dismissable'>
									<i class='fa fa-remove'></i>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
									<b>Failed!</b> Error Conection.
								</div>";
						}elseif(isset($_GET['msg2'])){
							echo"<div class='alert alert-danger alert-dismissable'>
									<i class='fa fa-remove'></i>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
									<b>Failed!</b> Wrong Username or Password.
								</div>";
						}elseif(isset($_REQUEST['msg3'])){
							echo"<div class='alert alert-danger alert-dismissable'>
									<i class='fa fa-remove'></i>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
									<b>Failed!</b> Empty Username or Password.
								</div>";
						}
					?>
                    <form action="proses_login.php" method="POST" class="margin-bottom-0">
                        <div class="form-group m-b-15">
                            <input type="text" name="email" class="form-control  input-lg" placeholder="Email">
                        </div>
                        <div class="form-group m-b-15">
                           <input type="password" name="password" class="form-control input-lg" placeholder="Password">
                        </div>
                        <div class="checkbox m-b-30">
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Sign me in</button>
                        </div>
                        <div class="m-t-20 m-b-40 p-b-40">
                            <br>
                        </div>
                        <hr />
                        <p class="text-center text-inverse">
                            
                        </p>
                    </form>
                </div>
            </div>
        </div>
	</div>
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="./assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="./assets/plugins/jquery/jquery-migrate-1.4.1.min.js"></script>
	<script src="./assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="./assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="assets/crossbrowserjs/html5shiv.js"></script>
		<script src="assets/crossbrowserjs/respond.min.js"></script>
		<script src="assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="./assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="./assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="./assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>

</html>
