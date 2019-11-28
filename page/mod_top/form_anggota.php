

		<script type="text/javascript" src="js-add/jquery-1.8.2.min.js"></script>
		<form method="POST" action="page/mod_top/aksi_anggota.php?opt=<?=$_GET['opt']?>"  id="formku">
		<script type="text/javascript">
		
		$(document).ready(function() {
            var count = 0;
 
            $("#add_btn").click(function(){
                  count += 1;
                $('#container').append(
                         '<tr class="records" align="left">'
							 
                         + '<td style="text-align:right"><div id="'+count+'">' + count + '</div></td> <td>&nbsp;</td>'
						 
                         + '<td width="10%"> <input id="nik_'+count+'" name="nik'+ count +'" type="text" class="form-control" size="10" onClick="showList('+count+')" placeholder="NIK" required /></td> <td>&nbsp;</td>'
                       
 					     + '<td width="25%"><input id="nama_' + count + '" name="nama_' + count + '" type="text" class="form-control" size="25" placeholder="Nama Karyawan"/></td> <td>&nbsp;</td>'
                        
						 + '<td width="25%"><input id="jabatan'+ count+'" name="jabatan'+count+'" class="form-control" type="text" size="30" onClick="showJabatan('+count+')" placeholder="Jabatan Proyek" required readonly/></td> <td>&nbsp;</td>'
						 
						 + '<td width="20%"><input id="ket'+ count+'" name="ket'+count+'" class="form-control" type="text" size="10" placeholder="Keterangan Jabatan"/></td> <td>&nbsp;</td>'
						 
						 + '<td width="10%"><input id="absen' + count + '" name="hk' + count + '" type="text" class="form-control" size="10" placeholder="Jumlah Hari Kerja"/></td> <td>&nbsp;</td>'
						 
						 + '<td width="10%"><input id="sla' + count + '" name="sla' + count + '" type="text" class="form-control" size="10" placeholder="SLA"/></td> <td>&nbsp;</td>'
						 
						+ '<td><a class="remove_item" href="#" ><button name="remove_item" class="btn btn-sm btn-danger"   id="remove_item">Delete</button></a>'
                        
                    );
					// alert(count);
					$('#jum').val(count);
				});
											// alert('a');
										$(".remove_item").live('click', function (ev) {
											if (ev.type == 'click') {
												$(this).parents(".records").fadeOut();
												$(this).parents(".records").remove();
												count -= 1;
												$('#jum').val(count);
											}
										});
									});
			function showList(no) {
										window.open("lookup/anggota.php?no="+no+"&cc=<?=dc($_GET['cc'])?>", "list", "width=1000,height=500");
										// window.open("lookup/anggota.php?no="+no+"", "list", "width=1000,height=600");
										
									}
			function showJabatan(no) { window.open("lookup/jabatan_proyek.php?no="+no+"", "list", "width=1000,height=600");
									}
									
		</script>
		
		<?php
		// $unit = mysql_fetch_array(mysql_query("SELECT * FROM proyek WHERE id_srko='".mysql_real_escape_string(dc($_GET['id']))."'"));
		// $tahun_srko = $_COOKIE['tahun_srko'];
		
			
		if($_GET['opt']=="tambah"){
			$getId		= mysql_real_escape_string(dc($_GET['idp']));
			$tahun		= mysql_real_escape_string(dc($_GET['tahun']));
			$bulan		= mysql_real_escape_string(dc($_GET['bulan']));
			$cc			= mysql_real_escape_string(dc($_GET['cc']));
			$namaproyek = mysql_fetch_array(mysql_query("SELECT * FROM proyek WHERE id_proyek='$getId'")); 
			
		}
		// elseif($_GET['opt']=="edit"){
			// $getId		= dc($_GET['id']);		
			// $id			= mysql_real_escape_string($getId);
			// $edit		= mysql_fetch_array(mysql_query("SELECT * FROM proyek WHERE id_proyek='$id'")); 
		// }
			
		?>
		
		<h1 class="page-header">Form Anggota T O P
			<small><?=$_SESSION['nm_level']?></small>
		</h1>
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				</div>
				<h4 class="panel-title">Tunjangan Operasional Proyek <?=$namaproyek['nama_proyek']?></h4>
			</div>
			<div class="panel-body">
				
					<div class="form-group col-lg-12" id="formku">
						<input type="hidden" name="id" value="<?=$kd_baru?>"  placeholder="id">
						<input type="hidden" name="id_proyek" value="<?=$getId?>" placeholder="id_proyek">
						<input type="hidden" name="tahun" value="<?=$tahun?>" placeholder="tahun">
						<input type="hidden" name="bulan" value="<?=$bulan?>" placeholder="bulan">
						<input type="hidden" name="cc" value="<?=$cc?>" placeholder="cc">
						<div class="form-group  col-lg-12">
							<input type="hidden" name="test" id="jum" value="0" />
							<input type="button" name="add_btn"  class="btn btn-primary" value="Tambah Anggota" id="add_btn">
							<hr>
							<div id="container"> </div>
						</div>
					</div>
					<div id="record"></div>
					<div class="form-group  col-lg-12">
						<hr>
						<button type="submit" name="simpan" value="simpan" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-danger">Reset</button>
					</div>
		</form>
		
			</div>
		</div>
        