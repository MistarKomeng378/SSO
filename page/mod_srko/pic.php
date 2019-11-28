<form method="POST">
<table border="1" width="100%">
<tr align="center" bgcolor="#edc43b">
	<th >No</th>
	<th >Cost Center</th>
	<th >Uraian</th>
	<th >pilih</th>
</tr>
<?php
	include"../../config/koneksi.php";
	$query = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' AND uraian NOT LIKE '%Divisi%' order by id");
	$no = 1;
	while($r=mysql_fetch_array($query)){
	echo'<tr  align="center">
		<td>'.$no.'</td>
		<td>'.$r['CostCenter'].'</td>
		<td>'.$r['uraian'].'</td>
		<td><a href="javascript:void(0)" onClick="ada(\''.$r['CostCenter'].'\', \''.$r['uraian'].'\')">pilih</a></td>
	</tr>
	';
	$no++;
	}
?> 
</table>
</form>
<script>
	function ada(CostCenter, uraian){
		window.opener.document.getElementById('CostCenter').value=CostCenter;
		window.opener.document.getElementById('uraian').value=uraian;
		window.close();
	}
</script>