<?php
include"../../config/koneksi.php";
include"../../config/encript.php";
include"../../config/fungsi_name.php";
include"../../config/fungsi_timeline.php";

	$timezone = "Asia/Jakarta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$id_pencapaian		= mysql_real_escape_string($_POST['id_pencapaian']);
	$nik				= mysql_real_escape_string($_POST['nik']);
	$jo_gca				= mysql_real_escape_string($_POST['jo_gca']);
	$cc					= mysql_real_escape_string($_POST['cc']);
	$cekId				= mysql_fetch_array(mysql_query("SELECT max(id_pencapaian) as maxid FROM pencapaian WHERE jo_gca='$jo_gca' "));
	if(empty($_POST['uraian'])){
		$ur = mysql_query("SELECT uraian FROM pencapaian WHERE cc='$cc'");
		$cekur = mysql_num_rows($ur);
		if($cekur == 0){
			$ur2 = mysql_query("SELECT uraian FROM mskko WHERE CostCenter='$cc'");
			$cekur2 = mysql_num_rows($ur2);
			if($cekur2 == 0){
				$mysql_host2 		= "10.0.1.233";
				$mysql_database2 	= "epm";
				$mysql_user2 		= "root123";
				$mysql_password2 	= "sso123";
				@$conn2 = mysql_connect($mysql_host2,$mysql_user2,$mysql_password2);
				@mysql_select_db($mysql_database2,$conn2);
				$ur3 = mysql_query("SELECT uraian FROM pro_kontrak WHERE cc='$cc' ");
				$urr3		= mysql_fetch_array($ur3);	
				$uraian		= mysql_real_escape_string($urr3['uraian']);
				include"../../config/koneksi.php";
			}else{
				$urr2		= mysql_fetch_array($ur2);	
				$uraian		= mysql_real_escape_string($urr2['uraian']);
			}			
		}else{
			$urr		= mysql_fetch_array($ur);	
			$uraian		= mysql_real_escape_string($urr['uraian']);
		}
	}else{
		$uraian			= mysql_real_escape_string($_POST['uraian']);
	}	
	@$h_aktifitas		= mysql_real_escape_string($_POST['h_aktifitas']);
	@$progress			= mysql_real_escape_string($_POST['progress']);
	@$ket				= mysql_real_escape_string($_POST['ket']);
	
if(!is_numeric($progress)){
	echo"<SCRIPT language='javascript'>alert('Progress yang anda inputkan bukan angka');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
}else{
	if($progress > 100){
		echo"<SCRIPT language='javascript'>alert('Progress Tidak Boleh Lebih Dari 100 %');document.location='../../page.php?page=pencapaian_kerja'</SCRIPT>";
	}else{	
	
			if($progress==100){
				$aprove = 1;
			}else{
				$aprove = 0;
			}
			@$file 		= $_FILES['lampiran'];
			@$info		= pathinfo($file['name']);
			@$name 		= $info['filename'];
			@$ext2 		= $info['extension'];
			@$fileName	= $_FILES['lampiran']['name'];  
			@$type 		= $_FILES['lampiran']['type'];
			@$size 		= $_FILES['lampiran']['size'];
			@$temp 		= $_FILES['lampiran']['tmp_name'];
			$dir 		= "../../upload/";
			$date		= date("ymdHis");
			@$newName 	= $name.'('.$date.').'.$ext2;
			
			$maxsize = 1024 * (1024*5) ;
			$valid_ext 	= array('jpg','jpeg','png','doc','docx','xls','xlsx','pdf','rar','zip','ppt','pptx');
			$ext = strtolower(end(explode('.', $_FILES['lampiran']['name'])));
			
	if(empty($fileName)){
			// if($progress==100){
				// $progress = 99;
			// }else{
				// $progress = $progress;
			// }		
				mysql_query("UPDATE `pencapaian`	SET `id_pencapaian`		='$id_pencapaian' ,
														`hasil_akhir`		='Update : $h_aktifitas' ,
														`cc`				='$cc' ,
														`uraian`			='$uraian' ,
														`progress`			='$progress' ,
														`status`			='1',
														`tgl_update`		='".date("Y-m-d H:i:s")."',
														`aprove`			='$aprove'
												WHERE 	`id_pencapaian`		='$id_pencapaian' AND nik='$nik'");
				
				$realisasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM pencapaian WHERE jo_gca='$jo_gca' AND nik='$nik' "));
				if($id_pencapaian == $cekId['maxid']){
					mysql_query("UPDATE wbs SET `prog-b`='$progress',`prog-l`='$progress' WHERE id='$jo_gca' AND pic='$nik'");
				}
				timeline($nik,"edit","update KKWK pada aktifitas dengan id_kkwk $id_pencapaian dan hasil aktifitas $h_aktifitas dengan progress $progress");
				header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
	}else{
		if($fileName == ".htaccess"){
			echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..??');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
		}else{
			if($fileType == "php"){
				echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..??');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
			}else{
				// if (file_exists($folder)) {
					// echo"<SCRIPT language='javascript'>alert('Maaf file yang anda upload sudah ada ..!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
				// }else{
					if($size <= $maxsize ){	
						if(in_array($ext, $valid_ext)){
							mysql_query("UPDATE `pencapaian`	SET `id_pencapaian`		='$id_pencapaian' ,
																	`hasil_akhir`		='Update : $h_aktifitas' ,
																	`cc`				='$cc' ,
																	`uraian`			='$uraian' ,
																	`progress`			='$progress' ,
																	`file`				='$newName' ,
																	`type`				='$type' ,
																	`size`				='$size' ,
																	`ket`				='$ket',
																	`status`			='1',
																	`tgl_update`		='".date("Y-m-d H:i:s")."',
																	`aprove`			='$aprove'
															WHERE 	`id_pencapaian`		='$id_pencapaian' AND nik='$nik'");
															
							$realisasi	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jum FROM pencapaian WHERE jo_gca='$jo_gca' AND nik='$nik' "));
							if($id_pencapaian == $cekId['maxid']){
								mysql_query("UPDATE wbs SET `prog-b`='$progress',`prog-l`='$progress' WHERE id='$jo_gca' AND pic='$nik'");
							}
							move_uploaded_file($temp,$dir.$newName);
							timeline($nik,"edit","update KKWK pada aktifitas dengan id_kkwk $id_pencapaian dan hasil aktifitas $h_aktifitas dengan progress $progress");
							header("Location: ../../page.php?page=pencapaian_kerja&succes=1");
							
						}else{
							echo"<SCRIPT language='javascript'>alert('Format file tidak dikenal..!!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
						}
					}else{
						echo"<SCRIPT language='javascript'>alert('Maaf file yang anda upload terlalu besar, maksimal 5 Mb ..!');document.location='../../page.php?page=pencapaian_kerja&failed=1'</SCRIPT>";
					}
				// }
			}
		}
	}
		
	}
}
?>