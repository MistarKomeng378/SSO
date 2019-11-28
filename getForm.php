<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($_GET['jenis'] == "1"){
?>
	<select name="tinjau" class="form-control" disabled>
		<option value="">-Tinjau Ke GCA Load-</option>
		<option value="1">Ya</option>
		<option value="0" selected>Tidak</option>
	</select>
<?php
}
?>
<?php
if($_GET['jenis'] == "2"){
?>
	<select name="tinjau" class="form-control required" onchange="show(this.value)">
		<option value="">-Tinjau Ke GCA Load-</option>
		<option value="1" selected>Ya</option>
		<option value="0">Tidak</option>
	</select>
<?php
}
?>