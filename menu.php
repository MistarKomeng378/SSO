<ul class="nav">
	<li class="nav-header">Navigation</li>
	<li class="has-sub <?php if($_GET['page']=="dashboard"){echo"active";}?>">
			<a href="page.php?page=dashboard">
			<i class="fa fa-dashboard"></i>
				<span>Dashboard</span>
			</a>
	</li>
		<?php
			$menu = mysql_query("SELECT m_menu.id_menu, m_menu.menu, m_menu.link, m_menu.icon
								FROM
								m_menu
								INNER JOIN role_menu ON m_menu.id_menu = role_menu.id_menu
								WHERE m_menu.status='1' 
								AND m_menu.view='1' 
								AND m_menu.parentId='0' 
								AND level='$_SESSION[level]' 
								AND nik='$_SESSION[nik]' order by m_menu.`order`
								");
								
			while($m=mysql_fetch_array($menu)){
				$qsub = mysql_query("SELECT m_menu.id_menu, m_menu.menu, m_menu.link
									FROM
									m_menu
									INNER JOIN role_menu ON m_menu.id_menu = role_menu.id_menu
									WHERE m_menu.status='1' 
									AND m_menu.view='1' 
									AND m_menu.parentId='$m[id_menu]' 
									AND level='$_SESSION[level]' 
									AND nik='$_SESSION[nik]' 
									order by m_menu.`id_menu`
									");
				
				$count = mysql_num_rows($qsub);
				$ac	= mysql_fetch_array(mysql_query("SELECT parentId FROM m_menu WHERE link='$_GET[page]' "));
				/////////////////////////////////////////////////////
				if($m['id_menu']==$ac['parentId']){
					$active2="active";
				}else{
					$active2="";
				}
				///////////////////////////////////////////////////////////
				if($_GET['page']==$m['link']){
					$active="active";
				}else{
					$active="";
				}			
				/////////////////////////////////////////////////////////////
				if($count >= 1){
					$sub="has-sub";
					$jav="javascript:;";
					$caret="<b class='caret pull-right'></b>";
				}else{
					$sub="";
					$jav="?page=$m[link]";
					$caret="";
				}
				if($m['id_menu']==23){
					$qnotif = mysql_num_rows(mysql_query("SELECT DISTINCT	pencapaian.nik,
																			pencapaian.cc
																			FROM
																			pencapaian
																			WHERE laporan='$_SESSION[nik]' AND aprove='1' "));
					// if($qnotif >=1){
						// $notif = $qnotif;
					// }else{
						// $notif = "";
					// }
				}else{
					$notif ="";
				}
				
				///////////////////////////////////////////////////////////////
				echo"<li  class='$sub $active $active2'>
						<a href='$jav'>
							$caret <span class='badge pull-right'>$notif</span>
							<i class='fa fa-$m[icon]'></i> 
							<span> $m[menu]</span>
						</a>
							<ul class='sub-menu'>";
									while($s=mysql_fetch_array($qsub)){
										if($_GET['page']==$s['link']){
											$active="active";
										}else{
											$active="";
										}
										$con2	= "?page=$s[link]";
										echo"<li class='$active'><a href='$con2'>$s[menu] </a></li>";
								}
						echo"</ul>
					
					</li>";
			}
		?>
		<li class="has-sub">
			<a href="logout.php">
			<i class="fa fa-sign-out"></i>
				<span>Logout</span>
			</a>
	</li>
	<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>

</ul>