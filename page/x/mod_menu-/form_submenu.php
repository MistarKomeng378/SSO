			<h1 class="page-header">Management
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Management Submenu</h4>
			    </div>
			    <div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
<?php
if($_REQUEST['opt']=="edit"){
	$edit = mysql_fetch_array(mysql_query("SELECT * FROM m_menu WHERE id_menu='$_REQUEST[id]' "));
	$id 		= $edit['id_menu'];
	$perentId	= $edit['perentId'];
	$submenu	= $edit['menu'];
	$url 		= $edit['link'];
	$dir 		= $edit['dir'];
	$file 		= $edit['file'];
	$icon 		= $edit['icon'];
	$opt 		= "edit";
}elseif($_REQUEST['opt']=="tambah"){
	$id 		= "";
	$perentId	= mysql_real_escape_string(dc($_GET['id']));
	$menu 		= "";
	$submenu 	= "";
	$url 		= "";
	$dir 		= "";
	$file 		= "";
	$icon 		= "";
	$opt		= "tambah";
}
?>
<div class="col-lg-6">
<div class="box box-primary">
    <!-- form start -->
    <form role="form" method="POST" action="page/mod_menu/query_submenu.php?opt=<?=$_REQUEST['opt']?>" id="formku">
        <div class="box-body ">
            <div class="form-group">
                <label for="menu">Menu</label>
                    <select name="parentId" class="form-control">
							<option value="">-Pilih Menu Utama-</option>
						<?php
							$selectMenu = mysql_query("SELECT * FROM m_menu WHERE parentId='0' AND view='1'");
							while($optMenu=mysql_fetch_array($selectMenu)){
								echo"
									<option value='$optMenu[id_menu]'"; if($optMenu['id_menu'] == $perentId){echo"selected";} echo">$optMenu[menu]</option>
								";
							}
						?>
					</select>
            </div>
			<div class="form-group">
                <label for="submenu">Nama Submenu</label>
                    <input type="hidden" class="form-control required" name="id" value="<?=$id?>" >
                    <input type="text" class="form-control required " name="submenu" id="submenu" placeholder="Nama Submenu" value="<?=$submenu?>" >
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                    <input type="text" class="form-control" name="url" id="url" placeholder="URL" value="<?=$url?>">
            </div>
			<div class="form-group">
                <label for="dir">Direktori</label>
                    <input type="text" class="form-control" name="dir" id="dir" placeholder="Direktori" value="<?=$dir?>">
            </div>
			<div class="form-group">
                <label for="file">File</label>
                    <input type="text" class="form-control" name="file" id="file" placeholder="File" value="<?=$file?>">
            </div>
			<div class="form-group">
                <label for="icon">Icon</label>
                    <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" value="<?=$icon?>">
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" name="Simpan" value="Simpan" class="btn btn-primary">Simpan</button>
        </div>
    </form>
<!--------------------------------------------------------------------------------------------------------------------->
</div>
</div>
		</div>
	</div>