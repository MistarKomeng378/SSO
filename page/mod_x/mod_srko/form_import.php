<h1 class="page-header">Import SRKO
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Import GCA</h4>
		</div>
		<div class="panel-body">
			<div class="col-lg-12">
				<div class="col-lg-8">
					<form name="myForm" id="myForm" onSubmit="return validateForm()" action="page/mod_srko/import.php" method="post" enctype="multipart/form-data">
						<div class="col-lg-6">
							<input type="file" id="fileSrko" name="fileSrko" class="form-control"/>
						</div>
						<div class="col-lg-6">
							<input type="submit" name="submit" value="Import" class="btn btn-primary"/>
						</div>
						<div class="col-lg-12">
							<label><input type="checkbox" name="drop" value="1" /> <u>Kosongkan tabel sql terlebih dahulu.</u> </label>
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-12">
			<p><br>Untuk saat ini file yang bisa diupload hanya untuk versi Excel 2003/ Berformat file.Xls</p>
			</div>
		</div>
	</div>

<script type="text/javascript">
//    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('fileSrko', ['.xls'])){
            alert("Hanya file xls (Excel 2003) yang diijinkan.");
            return false;
        }
    }
</script>