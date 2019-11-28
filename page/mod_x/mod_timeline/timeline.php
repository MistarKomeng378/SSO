<?php
if(isset($_GET['th'])){
	if($_GET['th']==""){
		$thGCA = ec($_SESSION['tahun']);
	}else{
		$thGCA = $_GET['th'];
	}
}else{
	$thGCA = ec($_SESSION['tahun']);
}
if(isset($_GET['id'])){	
	if($_GET['id']==""){		
		$postNik ="";
	}else{
		$getNik = dc($_GET['id']);
		$postNik = ec($getNik);
	}	
}else{
	$postNik = "";
}

?>
	<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.base.css" type="text/css" />
	<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.energyblue.css" type="text/css" />
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxscrollbar.js"></script>
	<script type="text/javascript" src="assets/plugins/jqwidgets/jqxlistbox.js"></script>
	<script type="text/javascript" src="assets/plugins/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxgrid.selection.js"></script>
	<script type="text/javascript" src="assets/plugins/jqwidgets/jqxgrid.filter.js"></script>	 
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxgrid.sort.js"></script>
	<script type="text/javascript" src="assets/plugins/jqwidgets/jqxgrid.pager.js"></script> 
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxgrid.columnsresize.js"></script>	
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/globalization/globalize.js"></script>
	
	<style type="text/css">
    .jqx-grid-column-header,
	.jqx-grid-cell {
	  font-size: 11px;
	}
	</style>
	<script type="text/javascript">
        $(document).ready(function () {
            var url = "page/mod_timeline/data3.php?th=<?=$thGCA?>&id=<?=$postNik?>";

            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'no_timeline' },
                    { name: 'nik' },
                    { name: 'aksi' },
                    { name: 'icon'},
                    { name: 'time2'},
                    { name: 'time'}
                ],
                id: 'no_timeline',
                url: url,
                root: 'data'
            };
            var dataAdapter = new $.jqx.dataAdapter(source);

            $("#jqxgrid").jqxGrid(
            {
                width: 1045,
                autoheight: true,
                source: dataAdapter,
                columnsresize: true,
				showfilterrow: true,
                filterable: true,
				pageable: true,
				showtoolbar: true,
                rendertoolbar: function (toolbar) {
                    var me = this;
                    var container = $("<div style='margin: 0px;'></div>");
                    toolbar.append(container);
                    container.append(' <input style="margin-top: 5px;" value="Remove Filter" id="clearfilteringbutton" type="button" />');
					$("#clearfilteringbutton").jqxButton();
					$('#clearfilteringbutton').click(function () {
						$("#jqxgrid").jqxGrid('clearfilters');
					});
                },
				theme: 'energyblue',
                columns: [
					{text: 'AKSI', dataField: 'icon', width: 50 , columntype: 'textbox', filtercondition: 'starts_with' },
					{text: 'RANGE', dataField: 'time2', filtertype: 'range', cellsalign: 'right', width: 140, cellsformat: 'd' },
					{text: 'AKTIFITAS', dataField: 'aksi', width: 880 , columntype: 'textbox', filtercondition: 'starts_with'}
                  
                ]
            });
			
        });
    </script>
<h1 class="page-header">Timeline User
	<small><?=$_SESSION['nm_level']?></small>
</h1>
<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Timeline</h4>
	</div>
	<div class="panel-body">
		<?php
			echo"<a href='?page=timeline&th=all&id=".$postNik."' class='btn btn-sm btn-primary'>All</a> ";
			$qthgca = mysql_query("SELECT tahun FROM tahun ORDER BY id_tahun ASC");
			while($i=mysql_fetch_array($qthgca)){
				echo"<a href='?page=timeline&th=".ec($i['tahun'])."&id=".$postNik."' class='btn btn-sm btn-primary'>$i[tahun]</a> ";
			}
		?>
		<br>
		<br>
		<div class="table-responsive">
			<div id='jqxWidget' style="font-size: 11px; font-family: Verdana; float: left;">			
				<div id="jqxgrid"></div>
			</div>
		</div>
    </div>
</div>