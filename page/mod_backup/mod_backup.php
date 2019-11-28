<link href="assets/css/datepicker2.css" rel="stylesheet" id="theme" />

<h1 class="page-header">Manage Database
	<small><?=$_SESSION['nm_level']?></small>
</h1>
			
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Backup Database</h4>
	</div>
	<div class="panel-body">
			<?php
			
			if(isset($_REQUEST['delete'])){
				$id_tahun = mysql_real_escape_string(dc($_GET['delete']));
				mysql_query("DELETE FROM tahun WHERE id_tahun='$id_tahun'");
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Dihapus.
                    </div>";
			}
			if(isset($_REQUEST['succes'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Disimpan.
                    </div>";
			}
			if(isset($_REQUEST['failed'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-remove'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Failed!</b> Terjadi Kesalahan.
                    </div>";
			}
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}
			$database = $mysql_database;
			$file	  =	$database.'_'.date("DdMY").'_'.time().'.sql';
		?>
		<script>
                function pastikan(text){
                    confirm('Apakah Anda yakin akan '+text+'?')
                }
            </script>
		<form action="" method="post" name="postform" enctype="multipart/form-data" >
			<p>
				<strong>Backup</strong> semua data yang ada didalam database &quot;<strong><?= $database ?></strong>&quot;.</em>
			</p>
			<div class="asd">
				<button id="loading-btn" type="submit" class="btn btn-success" name="backup" onClick="return pastikan('Backup database')">Proses Backup</button>
			</div>

		</form>
		
		<?php

                //Download file backup ============================================
                if(isset($_GET['nama_file']))
                {
                    $file = $back_dir.$_GET['nama_file'];

                    if (file_exists($file))
                    {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename='.basename($file));
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: private');
                        header('Pragma: private');
                        header('Content-Length: ' . filesize($file));
                        ob_clean();
                        flush();
                        readfile($file);
                        exit;

                    }
                    else
                    {
                        echo "file {$_GET['nama_file']} sudah tidak ada.";
                    }

                }

                //Backup database =================================================
                if(isset($_POST['backup']))
                {
                    backup($file);
                   
					echo 'Backup database telah selesai <a style="cursor:pointer" href="'.$file.'" title="Download">Download file database</a>';

                    echo "<pre>";
                    print_r($return);
                    echo "</pre>";
                }else{
                    unset($_POST['backup']);
                }

            function backup($nama_file,$tables = '')
            {
                global $return, $tables, $back_dir, $database ;

                if($tables == '')
                {
                    $tables = array();
                    $result = @mysql_list_tables($database);
                    while($row = @mysql_fetch_row($result))
                    {
                        $tables[] = $row[0];
                    }
                }else{
                    $tables = is_array($tables) ? $tables : explode(',',$tables);
                }

                $return	= '';

                foreach($tables as $table)
                {
                    $result	 = @mysql_query('SELECT * FROM '.$table);
                    $num_fields = @mysql_num_fields($result);

                    //menyisipkan query drop table untuk nanti hapus table yang lama
                    $return	.= "DROP TABLE IF EXISTS ".$table.";";
                    $row2	 = @mysql_fetch_row(mysql_query('SHOW CREATE TABLE  '.$table));
                    $return	.= "\n\n".$row2[1].";\n\n";

                    for ($i = 0; $i < $num_fields; $i++)
                    {
                        while($row = @mysql_fetch_row($result))
                        {
                            $return.= 'INSERT INTO '.$table.' VALUES(';

                            for($j=0; $j<$num_fields; $j++)
                            {
                                $row[$j] = @addslashes($row[$j]);
                                $row[$j] = @ereg_replace("\n","\\n",$row[$j]);
                                if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                                if ($j<($num_fields-1)) { $return.= ','; }
                            }
                            $return.= ");\n";
                        }
                    }
                    $return.="\n\n\n";
                }

                $nama_file;

                $handle = fopen($back_dir.$nama_file,'w+');
                fwrite($handle, $return);
                fclose($handle);
            }
            ?>
	</div>
</div>
