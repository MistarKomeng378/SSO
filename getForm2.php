<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($_GET['jenis'] == "2"){
?>
	<input type="text" name="jam" value="" placeholder="Jam Perhari" class="form-control required"/>
<?php
}
?>
<?php
if($_GET['jenis'] == "1"){
?>
	<input type="text" name="jam" value="" placeholder="Jam Perhari" class="form-control " readonly />
<?php
}
?>
<?php
if($_GET['jenis'] == ""){
?>
	<input type="text" name="jam" value="" placeholder="Jam Perhari" class="form-control " readonly />
<?php
}
?>