<!--code by harviacode.com-->
<style>
/*    css disini*/
    *{
        font-family: arial;font-size: small;
    }
    .mytable th{
        background-color: black;color: white;
    }
    .mytable tr:hover{
        background-color: lightblue;cursor: pointer;
    }
    .mytable td, th{
        padding: 5px
    }
</style>

<table class="mytable" width="100%" border="1">
    <thead>
        <tr>
			<th >No</th>
			<th >Cost Center</th>
			<th >Uraian</th>
			<th >pilih</th>
        </tr>
    </thead>
    <tbody>
	<?php
		include"../config/koneksi.php";

		$query = mysql_query("SELECT * FROM mskko WHERE id!='0' AND id!='' AND uraian NOT LIKE '%Divisi%' order by id");
		$no = 1;
		while($r=mysql_fetch_array($query)){
		echo'<tr  align="center" onclick="javascript:pilih(this);">
			<td>'.$no.'</td>
			<td>'.$r['CostCenter'].'</td>
			<td>'.$r['uraian'].'</td>
			<td></td>
		</tr>
		';
		$no++;
		}
	?> 
    </tbody>
</table>

<script>
    function pilih(row){
//        mendapatkan nama integrasi
        var integrasi=row.cells[1].innerHTML;
        var uraian_2=row.cells[2].innerHTML;
//        memasukkan nama integrasi dalam form
        window.opener.parent.document.getElementById("integrasi").value = integrasi;
        window.opener.parent.document.getElementById("uraian_2").value = uraian_2;
//        menutup pop up
        window.close();
    }
</script>