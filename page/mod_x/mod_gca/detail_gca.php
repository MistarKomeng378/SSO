<?php
ob_start();
session_start();
include"../../config/koneksi.php";
include"../../config/fungsi_indotgl.php";
include"../../config/fungsi_bulan.php";
include"../../config/fungsi_name.php";
include"../../config/encript.php";

// echo $_GET['id'];
$id			= mysql_real_escape_string($_GET['id']);
$data		= mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$id'"));

$idParent	= $id;
$parentId	= $data['parentId'];

$ex			= explode(" ",$data['tgl_isi']);
$cekpic		= mysql_fetch_array(mysql_query("SELECT pic FROM wbs WHERE id='$data[parentId]' "));

$sumchild	= mysql_num_rows(mysql_query("SELECT id FROM wbs WHERE parentId='$id'"));
if($sumchild == 0){
	mysql_query("UPDATE wbs SET icon='assets/img/file.png' WHERE id='$id'");
}else{
	mysql_query("UPDATE wbs SET icon='assets/img/folder.png' WHERE id='$id'");
}
if($data['jenisAktf']==1){
	$statusAktf = "Rutin";
}elseif($data['jenisAktf']==2){
	$statusAktf = "Non Rutin";
}

if($_SESSION['level']==1){
	echo"
		<a href='page.php?page=form_gca&opt=tambah&id=".ec($id)."&cc=".ec($data['cc_id'])."&id_srko=".ec($data['id_srko'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-primary' ><i class='fa fa-plus'></i> Tambah</a>
		<a href='page.php?page=form_gca&opt=edit&id=".ec($id)."&cc=".ec($data['cc_id'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-success' ><i class='fa fa-pencil'></i> Edit</a>
		<a href='page/mod_gca/destroy_gca.php?opt=delete&id=".ec($id)."-".ec($_SESSION['nik'])."-".ec($data['aktivitas'])."' class='btn btn-sm btn-danger' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-remove'></i> Hapus</a>
		<a href='page/mod_gca/update_gca.php' class='btn btn-sm btn-warning'><i class='fa fa-refresh'></i> Refresh</a>
			";
}elseif($_SESSION['level']==2){
	if($data['lock']==1){
		echo"
			<a href='#' class='btn btn-sm btn-primary' onClick=\"alert('Tidak dapat menambahkan KPM/ Unit Kerja.')\"><i class='fa fa-plus'></i> Tambah</a>
			<a href='#' class='btn btn-sm btn-success' onClick=\"alert('Tidak dapat merubah KPM/ Unit Kerja.')\"><i class='fa fa-pencil'></i> Edit</a>
			<a href='#' class='btn btn-sm btn-danger' onClick=\"alert('Tidak dapat menghapus KPM/ Unit Kerja.')\"><i class='fa fa-remove'></i> Hapus</a>
			";
	}else{
		echo"
			<a href='page.php?page=form_gca&opt=tambah&id=".ec($id)."&cc=".ec($data['cc_id'])."&id_srko=".ec($data['id_srko'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-primary' ><i class='fa fa-plus'></i> Tambah</a>
			<a href='page.php?page=form_gca&opt=edit&id=".ec($id)."&cc=".ec($data['cc_id'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-success' ><i class='fa fa-pencil'></i> Edit</a>
			<a href='page/mod_gca/destroy_gca.php?opt=delete&id=".ec($id)."-".ec($_SESSION['nik'])."-".ec($data['aktivitas'])."' class='btn btn-sm btn-danger' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-remove'></i> Hapus</a>
			";
	}
}elseif($_SESSION['level']==3){
	if($data['lock']==1){
		echo"
			<a href='#' class='btn btn-sm btn-primary' onClick=\"alert('Tidak dapat menambahkan KPM/ Unit Kerja.')\"><i class='fa fa-plus'></i> Tambah</a>
			<a href='#' class='btn btn-sm btn-success' onClick=\"alert('Tidak dapat merubah KPM/ Unit Kerja.')\"><i class='fa fa-pencil'></i> Edit</a>
			<a href='#' class='btn btn-sm btn-danger' onClick=\"alert('Tidak dapat menghapus KPM/ Unit Kerja.')\"><i class='fa fa-remove'></i> Hapus</a>
			";
	}else{
		echo"
			<a href='page.php?page=form_gca&opt=tambah&id=".ec($id)."&cc=".ec($data['cc_id'])."&id_srko=".ec($data['id_srko'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-primary' ><i class='fa fa-plus'></i> Tambah</a>
			<a href='page.php?page=form_gca&opt=edit&id=".ec($id)."&cc=".ec($data['cc_id'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-success' ><i class='fa fa-pencil'></i> Edit</a>
			<a href='page/mod_gca/destroy_gca.php?opt=delete&id=".ec($id)."-".ec($_SESSION['nik'])."-".ec($data['aktivitas'])."' class='btn btn-sm btn-danger' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-remove'></i> Hapus</a>
			";
	}
}elseif($_SESSION['level']==4){
	if($data['lock']==1){
	echo"
		<a href='#' class='btn btn-sm btn-primary' onClick=\"alert('Tidak dapat menambahkan KPM/ Unit Kerja.')\"><i class='fa fa-plus'></i> Tambah</a>
		<a href='#' class='btn btn-sm btn-success' onClick=\"alert('Tidak dapat merubah KPM/ Unit Kerja.')\"><i class='fa fa-pencil'></i> Edit</a>
		<a href='#' class='btn btn-sm btn-danger' onClick=\"alert('Tidak dapat menghapus KPM/ Unit Kerja.')\"><i class='fa fa-remove'></i> Hapus</a>
		";
	}else{
		// $getmanager = mysql_fetch_array(mysql_query("SELECT pic FROM wbs WHERE parentId='2' AND cc='$_SESSION[cc]'"));
		if($_SESSION['nik']!=$cekpic['pic'] AND $_SESSION['nik']!=$data['pic'] AND $_SESSION['nik']!=$data['gca_by'] AND $_SESSION['cc']!=$data['cc_id']){
			echo"
			<a href='#' class='btn btn-sm btn-primary' onClick=\"return alert('Tidak bisa akses GCA orang lain')\"><i class='fa fa-plus'></i> Tambah</a>
			<a href='#' class='btn btn-sm btn-success' onClick=\"return alert('Tidak bisa akses GCA orang lain')\"><i class='fa fa-pencil'></i> Edit</a>
			<a href='#' class='btn btn-sm btn-danger' onClick=\"return alert('Tidak bisa akses GCA orang lain')\"><i class='fa fa-remove'></i> Hapus</a>
			";
		}else{
			echo"
			<a href='page.php?page=form_gca&opt=tambah&id=".ec($id)."&cc=".ec($data['cc_id'])."&id_srko=".ec($data['id_srko'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-primary' ><i class='fa fa-plus'></i> Tambah</a>
			<a href='page.php?page=form_gca&opt=edit&id=".ec($id)."&cc=".ec($data['cc_id'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-success' ><i class='fa fa-pencil'></i> Edit</a>
			<a href='page/mod_gca/destroy_gca.php?opt=delete&id=".ec($id)."-".ec($_SESSION['nik'])."-".ec($data['aktivitas'])."' class='btn btn-sm btn-danger' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-remove'></i> Hapus</a>
			";
		}
	}
}elseif($_SESSION['level']==5){
	$atasan1 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$parentId' "));
	$atasan2 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$atasan1[parentId]' "));
	$atasan3 = mysql_fetch_array(mysql_query("SELECT pic,parentId FROM wbs WHERE id='$atasan2[parentId]' "));
	if($data['lock']==1){
	echo"
		<a href='#' class='btn btn-sm btn-primary' onClick=\"alert('Tidak dapat menambahkan KPM/ Unit Kerja.')\"><i class='fa fa-plus'></i> Tambah</a>
		<a href='#' class='btn btn-sm btn-success' onClick=\"alert('Tidak dapat merubah KPM/ Unit Kerja.')\"><i class='fa fa-pencil'></i> Edit</a>
		<a href='#' class='btn btn-sm btn-danger' onClick=\"alert('Tidak dapat menghapus KPM/ Unit Kerja.')\"><i class='fa fa-remove'></i> Hapus</a>
		";
	}else{
		if($_SESSION['nik']!=$cekpic['pic'] AND $_SESSION['nik']!=$data['pic'] AND $_SESSION['nik']!=$data['gca_by'] AND $_SESSION['nik']!=$atasan1['pic'] AND $_SESSION['nik']!=$atasan2['pic'] AND $_SESSION['nik']!=$atasan3['pic'] ){
			echo"
			<a href='#' class='btn btn-sm btn-primary' onClick=\"return alert('Tidak bisa akses GCA orang lain')\"><i class='fa fa-plus'></i> Tambah</a>
			<a href='#' class='btn btn-sm btn-success' onClick=\"return alert('Tidak bisa akses GCA orang lain')\"><i class='fa fa-pencil'></i> Edit</a>
			<a href='#' class='btn btn-sm btn-danger' onClick=\"return alert('Tidak bisa akses GCA orang lain')\"><i class='fa fa-remove'></i> Hapus</a>
			";
		}else{
			echo"
			<a href='page.php?page=form_gca&opt=tambah&id=".ec($id)."&cc=".ec($data['cc_id'])."&id_srko=".ec($data['id_srko'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-primary' ><i class='fa fa-plus'></i> Tambah</a>
			<a href='page.php?page=form_gca&opt=edit&id=".ec($id)."&cc=".ec($data['cc_id'])."&pic=".ec($data['pic'])."' class='btn btn-sm btn-success' ><i class='fa fa-pencil'></i> Edit</a>
			<a href='page/mod_gca/destroy_gca.php?opt=delete&id=".ec($id)."-".ec($_SESSION['nik'])."-".ec($data['aktivitas'])."' class='btn btn-sm btn-danger' onClick=\"return confirm('Yakin Hapus Data?')\"><i class='fa fa-remove'></i> Hapus</a>
			";
		}
	}
}
echo"
<a href='lookup/detail-kkwk.php?id=".ec($id)."' class='btn btn-sm btn-info popup' ><i class='fa fa-list'></i> KKWK</a>
<a href='lookup/detail-gca-load.php?id=".ec($id)."-".ec($data['pic'])."-".ec($data['tahun'])."-".ec($data['cc_id'])."-".ec($data['parentId'])."' class='btn btn-sm btn-info popup' ><i class='fa fa-list'></i> GCA Load</a>
";

?>


<table class="table" style="color:black">
	<tr>
		<td><b>ParentId -> Id SRKO -> Level</b></td>
		<td>:</td>
		<td><?=$data['parentId']?> -> <?=$data['id_srko']?> -> <?=$data['level']?></td>
	</tr>
	<tr>
		<td colspan="3">
		<?php
			echo "<span style=\"color:blue\"><b>$id : $data[aktivitas]</b></span> -> ";
			for($ak=1;$ak<=99;$ak++){
				$gca = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id='$idParent'"));
					$fontColor="black";
					if($ak!=1){
						echo"-> ";
					}
					echo "<span style=\"color:$fontColor\">$gca[aktivitas]</span>";
					setcookie("expandrow_$ak", $gca['id'], time() + (60 * 60), '/');
						$idParent=$gca['parentId'];
						$cek_id = mysql_fetch_array(mysql_query("SELECT * FROM tahun WHERE tahun='$gca[tahun]'"));
						if ($idParent==$cek_id['id_tahun']){
							break;
						}
			}
			if($data['level'] == 1){
				setcookie("level",'', 0, '/');
				for($i=1;$i<=12;$i++){
					setcookie("expandrow_$i", '', 0, '/');
				}				
			}else{
				setcookie("level", $ak, time() + (60 * 60), '/');
			}		
		?>
		</td>
	</tr>
	<tr>
		<td width="30%"><b>Tanggal Mulai</b> </td>
		<td width="5%">:</td>
		<td width="65%"><?=tgl_indo($data['mulai'])?> <b>S/D</b> <?=tgl_indo($data['akhir'])?>   <b>Durasi</b> : <?=$data['durasi']?> Jam</td>
	</tr>
	<tr>
		<td><b>Cost Center / Kode Proyek</b></td>
		<td>:</td>
		<td><?=$data['cc']?></td>
	</tr>
	<tr>
		<td><b>Penanggung Jawab</b></td>
		<td>:</td>
		<td><?=$data['pic']?> :-: <?=name($data['pic'])?></td>
	</tr>
	<tr>
		<td><b>Target</b></td>
		<td>:</td>
		<td><?=$data['deliverable']?></td>
	</tr>
	<tr>
		<td><b>Jenis Aktifitas</b></td>
		<td>:</td>
		<td><?=$statusAktf?></td>
	</tr>
	<tr>
		<td><b>Tanggal Isi GCA</b></td>
		<td>:</td>
		<td><?=tgl_indo($ex[0])?> <?=$ex[1]?> Oleh : <?=name($data['gca_by'])?></td>
	</tr>
</table>
<!-------------------------------awal dari color box------------------------------------>
<script type="text/javascript" src="assets/plugins/jquerycolorbox/jquery.colorbox.js"></script>
<link  rel="stylesheet" type="text/css" href="assets/plugins/jquerycolorbox/colorbox/colorbox.css" />
<!-------------------------------akhir dari color box------------------------------------>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".popup").colorbox({ 		iframe:true		,width:"90%"		,height:"100%"	});
	});
</SCRIPT>