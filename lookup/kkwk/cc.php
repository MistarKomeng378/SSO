	<table id="" class="display table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>No.</th>
				<th>CostCenter</th>
				<th>Uraian</th>
			</tr>
		</thead>
		<tbody>
			<?php
				include"../../config/koneksi.php";
				if($_POST['id']=="project"){
					$mysql_host2 		= "10.0.1.233";
					$mysql_database2 	= "epm";
					$mysql_user2 		= "root123";
					$mysql_password2 	= "sso123";
					@$conn2 = mysql_connect($mysql_host2,$mysql_user2,$mysql_password2)or die("Can not connect to database!");
					@mysql_select_db($mysql_database2,$conn2);
					$query = mysql_query("SELECT cc as CostCenter, uraian FROM pro_kontrak");
				}else{
					$query = mysql_query("SELECT * FROM mskko WHERE id!='' AND id!='1.6' AND id!='2.1' AND id !='4' order by id");
				}
				$no = 1;
				while($r=mysql_fetch_array($query)){
			?>
				<tr class="pilih" data-cc="<?php echo $r['CostCenter']; ?>" data-uraian="<?php echo $r['uraian']; ?>">
					<td><?=$no?></td>
					<td><?=$r['CostCenter']?></td>
					<td><?=$r['uraian']?></td>
				</tr>
			<?php
					$no++;
				}
			?>
		</tbody>
	</table>

<script type="text/javascript">
	$(document).ready(function() {
		$('table.display').DataTable();
	} );
</script>