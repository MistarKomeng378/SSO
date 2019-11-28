<script type="text/javascript">
	function show(linkinpark){
		if (linkinpark==""){
			document.getElementById("jab").innerHTML="";
			return;
		}
		if(window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("jab").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","get_jab.php?dept="+linkinpark,true);
		xmlhttp.send();
	}
</script>


			<h1 class="page-header">Management
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Management User</h4>
			    </div>
			    <div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
<?php
if(isset($_REQUEST['edit'])){
	$edit = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE id='".dc($_REQUEST['edit'])."' "));
	$id 		= $edit['id'];
	$nik 		= $edit['nik'];
	$name 		= $edit['name'];
	$grup_id 	= $edit['grup_id'];
	$level	 	= $edit['level'];
	$unit 		= "";
	$jab 		= "";
	$email 		= $edit['email'];
	$pass 		= $edit['nik'];
	$opt		= "edit";
}else{
	$query = mysql_query("SELECT m_karyawan.regno as nik,
								m_karyawan.`name`,
								m_karyawan.email,
								m_jabatan.posdesc,
								mskko.uraian,
								mskko.CostCenter as cc,
								mskko.id,
								m_jabatan.poscode as kd_jab
								FROM
								m_karyawan
								INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
								LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
								WHERE m_karyawan.regno='".dc($_REQUEST['nik'])."'
								");
	$data		= mysql_fetch_array($query);
	$nik 		= $data['nik'];
	$id 		= "";
	$name 		= $data['name'];
	$email 		= $data['email'];
	$unit 		= "";
	$jab 		= "";
	$level 		= $data['level'];
	$grup_id 	= $data['id'];
	$pass 		= $data['nik'];
	$opt		= "simpan";
}
?>
<div class="col-lg-6">
<div class="box box-primary">
    <!-- form start -->
    <form method="POST" action="page/mod_user/query_karyawan.php?opt=<?=$opt?>" id="formku">
        <div class="box-body">
            <div class="form-group">
                <label for="nik">NIK</label>
                    <input type="text" class="form-control required" name="nik" id="nik" placeholder="NIK" value="<?=$nik?>">
            </div>
			<div class="form-group">
                <label for="name">Nama</label>
                    <input type="text" class="form-control required" name="name" id="name" placeholder="Name" value="<?=$name?>" >
            </div>
			<div class="form-group">
                <label for="level">Unit</label>
                    <select class="form-control" name="unit" id="dept" onchange="show(this.value)">
						<option value="">-Pilih Unit-</option>
						<?php
							$mskko = mysql_query("SELECT * FROM mskko");
							while($r=mysql_fetch_array($mskko)){
								echo"<option value='$r[id]-$r[CostCenter]' "; if($r['id']==$unit){ echo"selected";} echo">$r[uraian] </option>";
							}
						?>
					</select>
            </div>
			<div class="form-group">
                <label for="level">Jabatan</label>
                    <select class="form-control" name="jab" id="jab" >
						<option value="">-Pilih Jabatan-</option>
						<?php
							// $jab = mysql_query("SELECT * FROM m_jabatan");
							// while($r=mysql_fetch_array($jab)){
								// echo"<option value='$r[poscode]' "; if($r['poscode']==$jab){ echo"selected";} echo">$r[posdesc] </option>";
							// }
						?>
					</select>
            </div>
			<div class="form-group">
                <label for="level">Level</label>
                    <select class="form-control" name="level" >
						<option value="">-Pilih Level-</option>
						<?php
							$qlvl = mysql_query("SELECT * FROM level");
							while($lvl=mysql_fetch_array($qlvl)){
								if($lvl['id_level']==$level){ $selected = "selected";}
								echo"<option value='$lvl[id_level]' "; if($lvl['id_level']==$level){ echo"selected";} echo">$lvl[level] </option>";
							}
						?>
					</select>
            </div>
			<div class="form-group">
                <label for="email">Email/ Username</label>
                    <input type="text" class="form-control email required" name="email" id="email" placeholder="Email" value="<?=$email?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control required" name="password" id="password" placeholder="Password" value="<?=$pass?>">
			</div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" name="Simpan" value="Simpan" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
</div>

<!--------------------------------------------------------------------------------------------------------------------->
		</div>
	</div>