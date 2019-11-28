<?php
$ex			= explode("-",$_GET['id']);
$getId		= mysql_real_escape_string(dc($ex[0]));
$getTahun	= mysql_real_escape_string(dc($ex[1])) ;
$getBulan	= mysql_real_escape_string(dc($ex[2])) ;
$kpi		= mysql_fetch_array(mysql_query("SELECT `kpi`,`v_rkap`, `v_real`, `v_rkap_kom`, `v_real_kom`, `v_prosen_real`, `v_prosen_kom`,`t_rkap`, `t_real`, `t_rkap_kom`, `t_real_kom`, `t_prosen_real`, `t_prosen_kom`, `scale`, `satuan`, `rumus` FROM kpku_kpi WHERE id_kpi='$getId'"));
if($kpi['rumus']==1){
	$arrow ="<i class='fa fa-3x fa-arrow-up'></i>";
}else{
	$arrow ="<i class='fa fa-3x fa-arrow-down'></i>";
}
?>
	<h1 class="page-header">Grafik Key Performance Indicators & Target
		<small><?=$_SESSION['nm_level']?></small>
	</h1>
			
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Grafik Key Performance Indicators & Target Tahun <?=$getTahun?></h4>
		</div>
		<div class="panel-body">

<script>
	var myLabels=[
	<?php 
		for($bln=1;$bln<=12;$bln++){
			echo $bln.",";
		}
	?>
	];
	var kom_rkap=[
	<?php
	if($kpi['v_rkap_kom']==1){
		for($b=1;$b<=12;$b++){
			if($b==1){
				$kom_rkap	= mysql_fetch_array(mysql_query("SELECT target_rkap as rkap FROM target_rkap WHERE tahun='$getTahun' AND (bulan BETWEEN '1' AND '$b') AND id_kpi='$getId'"));
			}else{
				$kom_rkap	= mysql_fetch_array(mysql_query("SELECT sum(target_rkap) as rkap FROM target_rkap WHERE tahun='$getTahun' AND (bulan BETWEEN '1' AND '$b') AND id_kpi='$getId'"));
			}
				echo $kom_rkap['rkap'].",";
		}
	}
	?>
	];
	var kom_real=[
	<?php
	if($kpi['v_real_kom']==1){
		$kom_real	= mysql_query("SELECT kom_real FROM v_target_kpi2 WHERE tahun='$getTahun' AND id_kpi='$getId'");
		while($info=mysql_fetch_array($kom_real)){
			echo $info['kom_real'].",";
		}
	}
	?>
	];
	var real=[
	<?php
	if($kpi['v_real']==1){
		$real	= mysql_query("SELECT realisasi_bulan FROM v_target_kpi2 WHERE tahun='$getTahun' AND id_kpi='$getId'");
		while($info=mysql_fetch_array($real)){
			echo $info['realisasi_bulan'].",";
		}
	}
	?>
	];
	var rkap=[
	<?php
	if($kpi['v_rkap']==1){
		$rkap	= mysql_query("SELECT target_rkap FROM target_rkap WHERE tahun='$getTahun' AND (bulan BETWEEN '1' AND '12') AND id_kpi='$getId'");
		while($info=mysql_fetch_array($rkap)){
			echo $info['target_rkap'].",";
		}
	}
	?>
	];
	var prosen_real=[
	<?php
	if($kpi['v_prosen_real']==1){
		$rkap	= mysql_query("SELECT prosen_real FROM v_target_kpi2 WHERE tahun='$getTahun' AND id_kpi='$getId'");
		while($info=mysql_fetch_array($rkap)){
			echo $info['prosen_real'].",";
		}
	}
	?>
	];
	var prosen_kom=[
	<?php
	if($kpi['v_prosen_kom']==1){
		$rkap	= mysql_query("SELECT prosen_kom FROM v_target_kpi2 WHERE tahun='$getTahun' AND id_kpi='$getId'");
		while($info=mysql_fetch_array($rkap)){
			echo $info['prosen_kom'].",";
		}
	}
	?>
	];
	
</script>
<script src="assets/js/zingchart.min.js"></script>
	<div id="myChart"></div>
<script>
var myConfig = {
    "graphset":[
        {
            "type":"line",
            "title":{
                "text":"<?=$kpi['kpi']?> <?=$arrow?>"
            },
            "scale-x":{
                "labels": myLabels
            },
			
			"scaleY":{
			  "label":{
			   "text":"<?=$kpi['satuan']?>"
			  },
			// "format": '$%v',
				
			},
			
			<?php
			if($kpi['scale']!="::"){
			?>
			"scale-y":{
			"values":"<?=$kpi['scale']?>",
			"guide":{
			  "line-style":"dashdot"
			}
			}
			,
			<?php
			}
			?>
            "series":[
                {
                    "values": kom_rkap
                },
				{
                    "values": kom_real
                },
				{
                    "values": real
                },
				{
                    "values": rkap
                },
				{
                    "values": prosen_real
                },
				{
                    "values": prosen_kom
                }
            ]
        }
    ]
};
 
zingchart.render({ 
	id : 'myChart', 
	data : myConfig, 
	height : 400, 
	width: "100%"
});
	
</script>
<div class="table-responsive">
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th><?=$arrow?></th>
			<?php
				for($i=1;$i<=12;$i++){
					
					echo"<th><a href='#modal-message2' class='analisa-kpi' data-id='".ec($getId)."-".ec($i)."-".ec($getTahun)."' data-toggle='modal'>".bulan($i)."</a></th>";
				}
			?>
		</tr>
	</thead>
	<tbody>
		
		
		<?php
				if($kpi['t_rkap']==1){
					$title[] = "<span style=\"color:#ff6600\"><b>RKAP/bln</b></span>";
					$field[] = "target_rkap";
					$alias[] = "target_rkap";
					$table[] = "target_rkap";
				}
				if($kpi['t_real']==1){
					$title[] = "<span style=\"color:#00b300\"><b>Real/bln</b></span>";
					$field[] = "realisasi_bulan";
					$alias[] = "realisasi_bulan";
					$table[] = "v_target_rkap_kpi";
				}
				if($kpi['t_rkap_kom']==1){
					$title[] = "<span style=\"color:#1a8cff\"><b>RKAP Kom</b></span> ";
					$field[] = "SUM(target_rkap)";
					$alias[] = "target_rkap";
					$table[] = "target_rkap";
				}
				if($kpi['t_real_kom']==1){
					$title[] = "<span style=\"color:#e60000\"><b>Real Kom</b></span>";
					$field[] = "kom_real";
					$alias[] = "kom_real";
					$table[] = "v_target_rkap_kpi";
				}
				if($kpi['t_prosen_real']==1){
					$title[] = "<span style=\"color:#990099\"><b>% Bulanan</b></span>";
					$field[] = "prosen_real";
					$alias[] = "prosen_real";
					$table[] = "v_target_rkap_kpi";
				}
				if($kpi['t_prosen_kom']==1){
					$title[] = "<span style=\"color:#804000\"><b>% Komulatif</b></span>";
					$field[] = "prosen_kom";
					$alias[] = "prosen_kom";
					$table[] = "v_target_rkap_kpi";
				}
			$rowEnd = $kpi['t_rkap_kom']+$kpi['t_real_kom']+$kpi['t_real']+$kpi['t_rkap']+$kpi['t_prosen_real']+$kpi['t_prosen_kom'];
			for($row=0;$row<=$rowEnd-1;$row++){
				echo"<tr>
						<td>$title[$row]</td>";
					for($i=1;$i<=12;$i++){
						$aliass = $alias[$row];
						$fields = $field[$row];
						$tables = $table[$row];
						if($fields=="target_rkap"){
							$ands   = "AND bulan='$i'";
						}elseif($fields=="realisasi_bulan"){
							$ands   = "AND bulan='$i'";
						}elseif($fields=="SUM(target_rkap)"){
							$ands   = "AND (bulan BETWEEN '1' AND '$i')";
						}elseif($fields=="kom_real"){
							$ands   = "AND bulan='$i'";
						}elseif($fields=="prosen_real"){
							$ands   = "AND bulan='$i'";
						}elseif($fields=="prosen_kom"){
							$ands   = "AND bulan='$i'";
						}
						$data = mysql_fetch_array(mysql_query("SELECT $fields AS $aliass FROM $tables WHERE tahun='$getTahun' AND id_kpi='$getId' $ands"));
						echo"<td>".desimal3($data[$aliass])."</td>";
					}
				echo"<tr>";				
			}		
		?>
	</tbody>
</table> 
		</div>
	</div>
</div>

<script>
        $(function(){
            $(document).on('click','.analisa-kpi',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('page/mod_kpi/analisa_bulan.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>
<div class="modal fade" id="modal-message2">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title"><?=$kpi['kpi']?></h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>