<?php
if(isset($_GET['th'])){
	$thGCA = $_GET['th'];
}else{
	$thGCA = ec($_SESSION['tahun']);
}
?>

	<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.base.css" type="text/css" />
	<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.energyblue.css" type="text/css" />
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxdatatable.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxtreegrid.js"></script>
	<script type="text/javascript" src="assets/plugins/jqwidgets/jqxgrid.js"></script>
	<script type="text/javascript" src="assets/plugins/jqwidgets/jqxtree.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxmenu.js"></script>
	<style type="text/css">
    .jqx-grid-column-header,
	.jqx-grid-cell {
	  font-size: 11px;
	}
</style>
	<script type="text/Javascript">
		function cc(){
			var x = window.open("lookup/cc.php", "cc", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
		}
		function pic(){
			var x = window.open("lookup/pic.php", "pic", "toolbar=no,menubar=no,location=center,scrollbars=yes,width=800,height=500");
		}
		</script>
    <script type="text/javascript">
        $(document).ready(function () {          
            // prepare the data
            var source =
            {
                dataType: "json",
                dataFields: [
                    { name: 'id', type: 'number' },
                    { name: 'parentId', type: 'number' },
                    { name: 'id_srko', type: 'string' },
                    { name: 'aktivitas', type: 'string' },
                    { name: 'mulai', type: 'string' },
                    { name: 'akhir', type: 'string' },
                    { name: 'durasi', type: 'string' },
                    { name: 'realisasi', type: 'string' },
                    { name: 'picname', type: 'string' },
                    { name: 'cc', type: 'string' },
                    { name: 'jenisGCA', type: 'number' },
                    { name: 'deliverable', type: 'string' },
                    { name: 'icon', type: 'string' },
                    { name: 'pb', type: 'string' },
                    { name: 'pl', type: 'string' },
                    { name: 'hasil_akhir', type: 'string' }
                ],
                hierarchy:
                {
                    keyDataField: { name: 'id' },
                    parentDataField: { name: 'parentId' }
                },
                id: 'id',
                url: 'page/mod_gca/gca_getdata.php?th=<?=$thGCA?>'
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            // create Tree Grid
            $("#treeGrid").jqxTreeGrid(
            {
                width: 1045,
                height: 600,
                // autoheight: true,
                source: dataAdapter,
				theme: 'energyblue',
                pageable: false,
				filterable: true,
                filterMode: 'simple',
                columnsResize: true,
				icons: true,
				showtoolbar: true,
                rendertoolbar: function (toolbar) {
                    var me = this;
                    var container = $("<div style='margin: 5px;'></div>");
                    toolbar.append(container);
                    container.append('<input id="expand" type="button" value="Expand All" /> ');
                    container.append('<input id="colapse" type="button" value="Collapse All" /> ');
                    container.append('<input id="refresh" type="button" value="Refresh" />');
					//expand All//////////////////////////////////////////////
						$("#expand").jqxButton();
						$("#expand").on('click', function () {
							$("#treeGrid").jqxTreeGrid('expandAll');
						});
					//expand All//////////////////////////////////////////////
					//colapse All//////////////////////////////////////////////
						$("#colapse").jqxButton();
						$("#colapse").on('click', function () {
							$("#treeGrid").jqxTreeGrid('collapseAll');
						});
					//colapse All//////////////////////////////////////////////
					//refresh All//////////////////////////////////////////////
						$("#refresh").jqxButton();
						$("#refresh").on('click', function () {
							$("#treeGrid").jqxTreeGrid('updateBoundData');
						});
					//refresh All//////////////////////////////////////////////
					
                },
                ready: function()
                {
					////expand cookie setting///////////////////////////////////////////////////////
					
					<?php  
						if(isset($_COOKIE['level'])) { 
					?>
						$("#treeGrid").jqxTreeGrid('expandRow',<?=$id_tahun?>);
					<?php
						  $lv = $_COOKIE['level'];
							  for($i=1;$i<=$lv;$i++){
					?>
								$("#treeGrid").jqxTreeGrid('expandRow','<?=$_COOKIE["expandrow_$i"]?>');
					<?php
							  }
						}else{
					?>
							$("#treeGrid").jqxTreeGrid('expandRow',<?=$id_tahun?>);
					<?php
						} 
					?>
					///////////////////////////////////////////////////////////
                },
                columns: [
                  { text: 'Aktifitas', dataField: 'aktivitas', width: 400 },
                  { text: 'H/P',  dataField: 'hasil_akhir', width: 31 },
                  { text: 'Mulai',  dataField: 'mulai', width: 75 },
                  { text: 'Akhir', dataField: 'akhir', width: 75 },
                  { text: 'P-MH', dataField: 'durasi', width: 53 },
                  { text: 'R-MH', dataField: 'realisasi', width: 53 },
				  { text: 'CC', dataField: 'cc', width: 55 },
				  { text: 'Prog-M', dataField: 'pb', width: 50 },
				  { text: 'Prog-L', dataField: 'pl', width: 45 },
                  { text: 'PIC', dataField: 'picname', width: 200 },                  
                  { text: 'Deliverable', dataField: 'deliverable', width: 200 }
                ]
            });
			
			//untuk dobleklik
			$("#treeGrid").on('rowDoubleClick', function (event) {
                var args = event.args;
                var key = args.key;
                var row = args.row;               				
				$('#myModal').modal('show');
					$.post('page/mod_gca/detail_gca.php?id='+row.id,
						{id:$(this).attr(key)},
						function(html){
							$(".modal-body").html(html);
						}   
					);
				
            });
			//untuk dobleklik/////////////////////////////////////////////////////////
			
        });
    </script>
	<h1 class="page-header">Data GCA
		<small><?=$_SESSION['nm_level']?></small>
	</h1>
	
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
			<h4 class="panel-title">Data GCA</h4>
		</div>
		<div class="panel-body"> 
		<?php
			if(isset($_REQUEST['succes'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Data Berhasil Disimpan.
                    </div>";
			}
			if(isset($_REQUEST['failed'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Gagal !</b> Terjadi Kesalahan.
                    </div>";
			}
			if(isset($_REQUEST['succes2'])){
				echo"<div class='alert alert-success alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> Status telah berubah.
                    </div>";
			}if(isset($_REQUEST['succes3'])){
				echo"<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-check'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <b>Succes!</b> GCA telah dihapus.
                    </div>";
			}
		?>
			<?php
			if($_SESSION['cc']=="M4300"){
				echo"<a href='?page=import_gca' class='btn btn-sm btn-primary'><i class='fa fa-upload'></i> Import GCA</a> ";
			}
			echo"<a href='?page=data_gca&th=all' class='btn btn-sm btn-primary'>All</a> ";
			$qthgca = mysql_query("SELECT tahun FROM tahun ORDER BY id_tahun ASC");
			while($i=mysql_fetch_array($qthgca)){
				echo"<a href='?page=data_gca&th=".ec($i['tahun'])."' class='btn btn-sm btn-primary'>$i[tahun]</a> ";
			}
			?>
			<br>
			<br>
			<div class="table-responsive">
				<div id="treeGrid" > </div>
			</div>
		</div>
	</div>


<div class="modal modal-message fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Informasi GCA</h4>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>