<style>
.pSearch{
		display:none!important;
	}
	.tab-cuy {
    width: 100%;
    height: 350px;
    max-width: 100%
}
.card {
box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}
</style>
<div class="row mt-5">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="tab-cuy" id="redeem-chart"></div>
				<div style="text-align: right;">
					<a href="<?php echo base_url('redeem_history')?>" >Detail Data  <i class="fa fa-chevron-circle-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row mt-3">
	<div class="col-6 col-md-4">
		<div class="card">
			<div class="card-body">
			<h4 class="header-title">Top Redeem</h4>
				<div class="d-sm-flex justify-content-between align-items-center">
					<div class="trd-history-tabs">
						<ul class="nav" role="tablist">
							<li>
								<a class="active" data-toggle="tab" href="#banyak" role="tab">Jumlah</a>
							</li>
							<li>
								<a data-toggle="tab" href="#nominal" role="tab">Nilai</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="trad-history mt-2">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="banyak" role="tabpanel">
							<!-- <h4 class="header-title">With Badges</h4> -->
							<ul class="list-group">
								<?php foreach ($top_redeem as $row) { ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<?php echo $row->full_name ?>
										<span class="badge badge-primary badge-pill"><?php echo $row->jumlah_data ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
						<div class="tab-pane fade" id="nominal" role="tabpanel">
							<!-- <h4 class="header-title">With Badges</h4> -->
							<ul class="list-group">
								<?php foreach ($top_redeem_total_price as $row) {
									$formatted_price = number_format($row->total_price, 0, ',', '.'); // Formatting to Rupiah
								?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<?php echo $row->full_name ?>
										<span class="badge badge-primary badge-pill">Rp <?php echo $formatted_price ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<!-- <div style="text-align: right;">
					<a href="<?php echo base_url('payment')?>" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
				</div> -->
			</div>
		</div>
	</div>
	<div class="col-12 col-md-8">
		<div class="card">
			<div class="card-body">
			<h4 class="header-title">Top Package Redeem</h4>
				<div class="d-sm-flex justify-content-between align-items-center">
					<div class="trd-history-tabs">
						<ul class="nav" role="tablist">
							<li>
								<a class="active" data-toggle="tab" href="#top_package_redeem" role="tab">Jumlah</a>
							</li>
							<li>
								<a data-toggle="tab" href="#top_package_redeem_total_price" role="tab">Nilai</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="trad-history mt-2">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="top_package_redeem" role="tabpanel">
							<!-- <h4 class="header-title">With Badges</h4> -->
							<ul class="list-group">
								<?php foreach ($top_package_redeem as $row) { ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<?php echo $row->name ?>
										<span class="badge badge-primary badge-pill"><?php echo $row->jumlah_data ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
						<div class="tab-pane fade" id="top_package_redeem_total_price" role="tabpanel">
							<!-- <h4 class="header-title">With Badges</h4> -->
							<ul class="list-group">
								<?php foreach ($top_package_redeem_total_price as $row) {
									$formatted_price = number_format($row->total_price, 0, ',', '.'); // Formatting to Rupiah
								?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<?php echo $row->name ?>
										<span class="badge badge-primary badge-pill">Rp <?php echo $formatted_price ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
//error_reporting(0);
 echo $js_grid; ?>
<!--input type="button" value="Tambah" onclick="window.location = '<?//= base_url() ?>index.php/ms_con/add'"/-->
<script type="text/javascript">
$(document).ready(function(e){
         $('.select2').select2();
	  <?php 
	 if($this->input->get('search')){
		?>
		$('#expandsearch').click();
	 <?php }
	  ?>
   });
var _base_url = '<?php echo  base_url() ?>';
var controller = '<?php echo $this->utama?>/';
function del(id) { 
  i = confirm('Hapus : ' + id + ' ?');
  if (i) {
    window.location = _base_url + controller + 'delete/' + id;
  }
}
//$('.flex1').flexigrid({height:'auto',width:'auto',striped:false});

function edit(id) {
  window.location = _base_url + controller + 'input/' + id;
}

function detail(id) {
  window.location = _base_url + controller + 'form/' + id;
}
function btn(com,grid)
{
    if (com == 'add' ) {
		window.location = _base_url + controller + 'form/';
    }
	
    if (com == 'select' )
    {
		$('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com == 'deselect')
    {
		$('.bDiv tbody tr',grid).removeClass('trSelected');
    }
	if(com=='edit'){
		if($('.trSelected',grid).length==1){ 
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
		//var items = $('.trSelected',grid);
 		 window.location = _base_url + controller + 'form/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
			} else {
				return false;
			} 
	}
	if(com=='auth'){
		if($('.trSelected',grid).length==1){ 
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
		//var items = $('.trSelected',grid);
 		 window.location = _base_url + controller + 'auth/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
			} else {
				return false;
			} 
	}
	if(com=='reset password'){
		if($('.trSelected',grid).length>0){
			   if(confirm('Generate Link Reset Password?')){
		        var flex = $(grid).closest('.flexigrid');
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
    	
   				 $('.res').html('');//div.res - area for display result
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
					//itemlist+=items[i].id+",";
					//var iteming=$('td:"no_reg" >div', items[i]).text();
					itemlist+=$('td:nth-child('+ (1+$.inArray('email',abbr)) +')>div', items[i]).text()+",";
					}
					  	
					$.ajax({
					   type: "POST",
					   url: "<?php echo site_url($this->utama."/resetemail");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
						//alert(data);
						
						var balik=JSON.parse(data);
						if(balik.response.code==200){
							$('#linkforgot').attr('href',balik.response.link);
							//$('#linkforgot').text(balik.response.link);
							$('#modalgenerated').show();
						}else{
							alert('ERROR '+balik.response.code+'\n '+balik.response.message);
						}
					   }
					});
				}
			} else {
				return false;
			} 
	}
	if(com=='export'){
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
		//var items = $('.trSelected',grid);
 		 window.location = _base_url + controller + 'export/?email=<?php echo $this->input->get('email')?>&code=<?php echo $this->input->get('code')?>';
			
	}
	if (com=='delete')
    {
           if($('.trSelected',grid).length>0){
			   if(confirm('Delete ' + $('.trSelected',grid).length + ' items?')){
		        var flex = $(grid).closest('.flexigrid');
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
    	
   				 $('.res').html('');//div.res - area for display result
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
					//itemlist+=items[i].id+",";
					//var iteming=$('td:"no_reg" >div', items[i]).text();
					itemlist+=$('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', items[i]).text()+",";
					}
					  	
					$.ajax({
					   type: "POST",
					   url: "<?php echo site_url($this->utama."/deletec");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
						//alert(data);
						if(data=='ok'){
						alert('Sukses!');}
						else{
							alert('Failed to Delete Data');
						}
					   }
					});
				}
			} else {
				return false;
			} 
      }           
}
function dismissmodal(){
	
	$('#linkforgot').attr('href','#');
	$('#modalgenerated').hide();
}
setInterval("$('#flex1').flexReload()",50000 );
</script>
<div class="row mt-3">
    <div class="col">
		<div class="card">
			<div class="card-body">
			<h4 class="header-title">Data Histori Redeem</h4>
<div class="row">
<div class="col-sm-12 col-md-12">
<button data-toggle="collapse" id="expandsearch" data-target="#demo" class="btn-info btn"><i class="fa fa-plus"></i>&nbsp;Add Filter</button>
<fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 collapse <?php if(isset($_GET['search'])) echo "in"?>" id="demo">

	<form enctype="multipart/form-data" method="get" action="<?php echo base_url($this->utama) ?>">
            <div class="col-sm-12 col-md-12" style="margin-top:10px">
                           <div class="col-sm-6 col-md-6"  style="float:none!important;margin:0 auto;">
                               
							<div class="row" style="margin-bottom:2%;">
							<div class="col-sm-3 col-md-3">
								<label>Code Voucher</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_input('code',$this->input->get('code'),'class="form-control" style="margin-bottom:5px;"')?>
                           	</div>
							</div>
							<div class="row" style="margin-bottom:2%;">
							<div class="col-sm-3 col-md-3">
								<label>Email</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_input('email',$this->input->get('email'),'class="form-control" style="margin-bottom:5px;"')?>
                           	</div>
							</div>
							
                            
                            </div>
            </div>
			<?php //echo form_hidden('lastq',$lastq);?>
            <div class="col-sm-12 col-md-12"><div class="col-sm-12 col-md-12"><input type="submit" value="Search" class="btn-danger btn" name="search">&nbsp;<!--input type="reset" value="Clear" name="clear"--></div></div>
	<div class="col-sm-12" style="margin-top:10px"></div>
	
	</form>

</fieldset></div>
</div>
				<div class="layout-grid mt-3">
                    <table id="flex1" style="display:none; "></table>
                </div>
            </div>
        </div>      
    </div>
</div>

<script>
    var chartDataRedeem = <?= $jsonChartDataRedeem ?>

    // AmCharts Configuration
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("redeem-chart", am4charts.XYChart);

        // Add data
        chart.data = chartDataRedeem;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
        dateAxis.title.text = "Date";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Redeem History";

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 10;

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;

        // Create a range to highlight weekends
        var weekends = new am4core.Column();
        weekends.fill = am4core.color("#F5F5F5");
        weekends.fillOpacity = 0.6;

        var range = dateAxis.axisRanges.create();
        range.date = new Date("2023-01-01");
        range.endDate = new Date("2023-12-31");
        range.axisFill = weekends;
        range.grid.stroke = am4core.color("#FFFFFF");
        range.grid.strokeOpacity = 0.8;
        range.grid.strokeWidth = 1;
    });
</script>