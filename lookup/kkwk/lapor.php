	<table id="" class="display table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th >No</th>
				<th >NIK</th>
				<th >Nama</th>
				<th >Cost Center</th>
			</tr>
		</thead>
		<tbody>
		<?php
			include"../../config/koneksi.php";

			$query = mysql_query("SELECT * FROM m_karyawan WHERE status='0' ");
			$no = 1;
			while($r=mysql_fetch_array($query)){
			?>
				<tr class="select" data-nik="<?php echo $r['regno']; ?>" data-nama="<?php echo $r['name']; ?>">
					<td><?=$no?></td>
					<td><?=$r['regno']?></td>
					<td><?=$r['name']?></td>
					<td><?=$r['dept']?></td>
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