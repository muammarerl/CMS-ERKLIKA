<style>
.pSearch{
		display:none!important;
	}

.card {
box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
	}
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>
<!-- <div class="row mt-5">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Top Package</h4>
				<div id="chartdiv"></div>
			</div>
		</div>
	</div>
</div> -->

<div class="row mt-3">
	<div class="col-sm-5">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Type Activation</h4>
				<div id="ampiechart1"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-7 ">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Top 5 Package</h4>
				<div id="ampiechart2"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="modalgenerated" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reset Password User</h5>
      </div>
      <div class="modal-body">
		<div class="col-md-12">
        <a id="linkforgot" target="_blank">Click Here</a>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="dismissmodal()" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

	$('.datepicker').datepicker({
         format: 'yyyy-mm-dd',
         autoclose: true,
         todayHighlight:true
      });
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
 		 window.location = _base_url + controller + 'export/?email=<?php echo $this->input->get('email')?>&package=<?php echo $this->input->get('package')?>&status=<?php echo $this->input->get('status')?>&periode_start=<?php echo $this->input->get('periode_start')?>&periode_end=<?php echo $this->input->get('periode_end')?>';
			
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
<div class="card mt-3">
	<div class="card-body">
	<h4 class="header-title">User Package</h4>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<button data-toggle="collapse" id="expandsearch" data-target="#demo" class="btn-info btn"><i class="fa fa-plus"></i>&nbsp;Add Filter</button>
				<fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 collapse <?php if(isset($_GET['search'])) echo "in"?>" id="demo">
					<form enctype="multipart/form-data" method="get" action="<?php echo base_url($this->utama) ?>">
            			<div class="col-sm-12 col-md-12" style="margin-top:10px">
							<div class="col-sm-6 col-md-6"  style="float:none!important;margin:0 auto;">
                               
							<div class="row" style="margin-bottom:2%;">
								<div class="col-sm-3 col-md-3">
									<label>Email</label>
								</div>
								<div class="col-sm-4 col-md-4">
                           			<?php echo form_input('email',$this->input->get('email'),'class="form-control" style="margin-bottom:5px;"')?>
                           		</div>
							</div>

							<div class="row" style="margin-bottom:2%;">
							<div class="col-sm-3 col-md-3">
							<label>Package</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_dropdown('package',GetOptAll('packages','-All-',array('deletedAt'=>'where_is_null/1'),'name','id'),$this->input->get('package'),'class="form-control select2" style="margin-bottom:5px;width:100%;"')?>
                           	</div>
							</div>
							
							<div class="row">
							<div class="col-sm-3 col-md-3">
							<label>Status</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_dropdown('status',array(''=>'-All-','active'=>'Active','expired'=>'Expired'),$this->input->get('status'),'class="form-control select2" style="margin-bottom:5px;width:100%;"')?>
                           	</div>
							</div>

							<div class="row">
							<div class="col-sm-3 col-md-3">
							<label>Periode Mulai Berlangganan</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_input('periode_start',$_GET['periode_start'],' style="margin-bottom:5px;" class="form-control datepicker" placeholder="Start"')?>
                           		<?php echo form_input('periode_end',$_GET['periode_end'],' style="margin-bottom:5px;" class="form-control datepicker"  placeholder="End"')?>
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
		<div class="row mt-2">
			<div class="col-sm-12 col-md-12">
				<div class="layout-grid">
					<table id="flex1" style="display:none; "></table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- pie chart  -->
<script>
    // Gunakan data PHP yang didapat ke dalam script JavaScript
    var countEnum1 = <?php echo $count_actv_1; ?>;
    var countEnum2 = <?php echo $count_actv_2; ?>;

    // Buat grafik menggunakan AmCharts
    am4core.ready(function() {
        var chart = am4core.create("ampiechart1", am4charts.PieChart);

        // Atur data grafik
        chart.data = [{
            "transaksi": "Subscribe",
            "jumlah": <?php echo $count_actv_1; ?>
        }, {
            "transaksi": "Voucher",
            "jumlah": <?php echo $count_actv_2; ?>
        }];
        // chart.data = chartDataUsers;

        // Atur properti grafik
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "jumlah";
        pieSeries.dataFields.category = "transaksi";

        // Atur properti dan tema grafik (opsional)
        chart.paddingBottom = 30;
        chart.angle = 15;
        chart.innerRadius = am4core.percent(50);
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "chart-export";
        chart.exporting.useWebFonts = false;
        chart.exporting.adapter.add("data", function(data) {
            data.data = data.data.filter(function(item) {
                return item.category !== undefined;
            });
            return data;
        });

        // Jalankan/Render grafik
        chart.legend = new am4charts.Legend();
        chart.legend.position = "center";
        chart.legend.scrollable = true;
        chart.legend.itemContainers.template.events.on("hit", function(ev) {
            var series = ev.target.dataItem.dataContext.series;
            if (!series.isHidden) {
                series.hide();
            }
            else {
                series.show();
            }
        });
    });
</script>
<script>
    // Gunakan data PHP yang didapat ke dalam script JavaScript
    var countpending = <?php echo $count_pending; ?>;
    var countsettlement = <?php echo $count_settlement; ?>;
    var countcapture = <?php echo $count_capture; ?>;
    var countexpired = <?php echo $count_expired; ?>;
    var countcancel = <?php echo $count_cancel; ?>;
    var countdeny = <?php echo $count_deny; ?>;
    var countrefund = <?php echo $count_refund; ?>;

    // Buat grafik menggunakan AmCharts
    am4core.ready(function() {
        var chart = am4core.create("ampiechart2", am4charts.PieChart);

        // Atur data grafik
        chart.data = [{
            "transaksi": "pending",
            "jumlah": <?php echo $count_pending; ?>
        }, {
            "transaksi": "settlementr",
            "jumlah": <?php echo $count_settlement; ?>
        }, {
        }, {
            "transaksi": "capture",
            "jumlah": <?php echo $count_capture; ?>
        }, {
        }, {
            "transaksi": "expired",
            "jumlah": <?php echo $count_expired; ?>
        }, {
        }, {
            "transaksi": "cancel",
            "jumlah": <?php echo $count_cancel; ?>
        }, {
        }, {
            "transaksi": "deny",
            "jumlah": <?php echo $count_deny; ?>
        }, {
        }, {
            "transaksi": "refund",
            "jumlah": <?php echo $count_refund; ?>
        }];
        // chart.data = chartDataUsers;

        // Atur properti grafik
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "jumlah";
        pieSeries.dataFields.category = "transaksi";

        // Atur properti dan tema grafik (opsional)
        chart.paddingBottom = 30;
        chart.angle = 15;
        chart.innerRadius = am4core.percent(50);
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "chart-export";
        chart.exporting.useWebFonts = false;
        chart.exporting.adapter.add("data", function(data) {
            data.data = data.data.filter(function(item) {
                return item.category !== undefined;
            });
            return data;
        });

        // Jalankan/Render grafik
        chart.legend = new am4charts.Legend();
        chart.legend.position = "center";
        chart.legend.scrollable = true;
        chart.legend.itemContainers.template.events.on("hit", function(ev) {
            var series = ev.target.dataItem.dataContext.series;
            if (!series.isHidden) {
                series.hide();
            }
            else {
                series.show();
            }
        });
    });
</script>
<!-- line chart  -->
<script>
am5.ready(function() {
    var root = am5.Root.new("chartdiv");
    root.setThemes([
      am5themes_Animated.new(root)
    ]);
    
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: false,
      panY: false,
      wheelX: "panX",
      wheelY: "zoomX",
      paddingLeft:0,
      layout: root.verticalLayout
    }));
    
    var legend = chart.children.push(am5.Legend.new(root, {
      centerX: am5.p50,
      x: am5.p50
    }));
    
    // Data dari model PHP disimpan dalam variabel JavaScript
    var dataFromModel = <?= json_encode($Chart_model) ?>;
    
    var data = [];
    dataFromModel.forEach(function(item) {
        data.push({
            "year": item.name,
            "income": item.total_data,
            "expenses": 0
        });
    });

    var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
      categoryField: "year",
      renderer: am5xy.AxisRendererY.new(root, {
        inversed: true,
        cellStartLocation: 0.1,
        cellEndLocation: 0.9,
        minorGridEnabled: true
      })
    }));
    
    yAxis.data.setAll(data);
    
    var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
      renderer: am5xy.AxisRendererX.new(root, {
        strokeOpacity: 0.1,
        minGridDistance: 50
      }),
      min: 0
    }));
    
    function createSeries(field, name) {
      var series = chart.series.push(am5xy.ColumnSeries.new(root, {
        name: name,
        xAxis: xAxis,
        yAxis: yAxis,
        valueXField: field,
        categoryYField: "year",
        sequencedInterpolation: true,
        tooltip: am5.Tooltip.new(root, {
          pointerOrientation: "horizontal",
          labelText: "[bold]{name}[/]\n{categoryY}: {valueX}"
        })
      }));
    
      series.columns.template.setAll({
        height: am5.p100,
        strokeOpacity: 0
      });
    
      series.bullets.push(function () {
        return am5.Bullet.new(root, {
          locationX: 1,
          locationY: 0.5,
          sprite: am5.Label.new(root, {
            centerY: am5.p50,
            text: "{valueX}",
            populateText: true
          })
        });
      });
    
      series.bullets.push(function () {
        return am5.Bullet.new(root, {
          locationX: 1,
          locationY: 0.5,
          sprite: am5.Label.new(root, {
            centerX: am5.p100,
            centerY: am5.p50,
            text: "{name}",
            fill: am5.color(0xffffff),
            populateText: true
          })
        });
      });
    
      series.data.setAll(data);
      series.appear();
    
      return series;
    }
    
    createSeries("income", "Income");
    createSeries("expenses", "Expenses");
    
    var legend = chart.children.push(am5.Legend.new(root, {
      centerX: am5.p50,
      x: am5.p50
    }));
    
    legend.data.setAll(chart.series.values);
    
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
      behavior: "zoomY"
    }));
    cursor.lineY.set("forceHidden", true);
    cursor.lineX.set("forceHidden", true);
    
    chart.appear(1000, 100);
});
</script>


<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
