			<h1 class="page-header">Management Level
				<small><?=$_SESSION['nm_level']?></small>
			</h1>
			<!-- end page-header -->
			
			<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
			        <h4 class="panel-title">Management Level</h4>
			    </div>
			    <div class="panel-body">
<!--------------------------------------------------------------------------------------------------------------------->
<?php
if(isset($_REQUEST['edit'])){
	$edit = mysql_fetch_array(mysql_query("SELECT * FROM level WHERE id_level='$_REQUEST[edit]' "));
	$id 		= $edit['id_level'];
	$lvl 		= $edit['level'];
	$opt		= "edit";
}else{
	$id 		= "";
	$lvl 		= "";
	$opt		= "simpan";
}
?>
<div class="col-lg-6">
<div class="box box-primary">
    <!-- form start -->
    <form role="form" method="POST" action="page/mod_user/query_user.php?opt=<?=$opt?>" id="formku">
        <div class="box-body">
            <div class="form-group">
                <label for="nama_lvl">Level</label>
					<input type="hidden" class="form-control required" name="id" value="<?=$id?>" >
                    <input type="text" class="form-control required" name="nama_lvl" id="last" placeholder="Nama Level" value="<?=$lvl?>">
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