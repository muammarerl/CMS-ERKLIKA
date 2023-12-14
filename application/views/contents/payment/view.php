<style>
.tab-cuy {
    width: 100%;
    height: 350px;
    max-width: 100%
}
.card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
</style>
</style>
</style>
<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">User Transaksi</h4>
				<div class="tab-cuy" id="payment-chart"></div>
			</div>
		</div>
	</div>
		
</div>
<div class="row mt-5">
	<div class="col-sm-5 ">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Type Platform</h4>
				<div id="ampiechart1"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-7">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Status Transaksi</h4>
				<div id="ampiechart2"></div>
			</div>
		</div>
	</div>
</div>
<!-- <div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-center">
                    <h4 class="header-title">Status Transaksi</h4>
                    <div class="trd-history-tabs">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#satu" role="tab">Settelment</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#pending" role="tab">Pending</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#expired" role="tab">Expired</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#cancel" role="tab">Cancel</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#refund" role="tab">Refund</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="trad-history mt-4">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="satu" role="tabpanel">		
                            <div class="data-tables">
                                <table id="dataTable" class="text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>Status</th>
                                            <th>Order Id</th>
                                            <th>Email</th>
                                            <th>Paket</th>
                                            <th>QTY</th>
                                            <th>Total Ammount</th>
                                            <th>Tipe Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($payment_details as $record): ?>
                                            <tr>
                                                <td><?php echo $record->transaction_status; ?></td>
                                                <td><?php echo $record->order_id; ?></td>
                                                <td><?php echo $record->email; ?></td>
                                                <td><?php echo $record->name; ?></td>
                                                <td><?php echo $record->qty; ?></td>
                                                <td><?php echo 'Rp ' . number_format($record->total_amount, 0, ',', '.'); ?></td>
                                                <td><?php echo $record->payment_type; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pending" role="tabpanel">
                            <div class="data-tables">
                                <table id="dataTablePending" class="text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Email</th>
                                            <th>Paket</th>
                                            <th>QTY</th>
                                            <th>Total Ammount</th>
                                            <th>Tipe Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pending_details as $record): ?>
                                            <tr>
                                                <td><?php echo $record->order_id; ?></td>
                                                <td><?php echo $record->email; ?></td>
                                                <td><?php echo $record->name; ?></td>
                                                <td><?php echo $record->qty; ?></td>
                                                <td><?php echo 'Rp ' . number_format($record->total_amount, 0, ',', '.'); ?></td>
                                                <td><?php echo $record->payment_type; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="expired" role="tabpanel">
                            <div class="data-tables">
                                <table id="dataTableExpired" class="text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Email</th>
                                            <th>Paket</th>
                                            <th>QTY</th>
                                            <th>Total Ammount</th>
                                            <th>Tipe Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($expired_details as $record): ?>
                                            <tr>
                                                <td><?php echo $record->order_id; ?></td>
                                                <td><?php echo $record->email; ?></td>
                                                <td><?php echo $record->name; ?></td>
                                                <td><?php echo $record->qty; ?></td>
                                                <td><?php echo 'Rp ' . number_format($record->total_amount, 0, ',', '.'); ?></td>
                                                <td><?php echo $record->payment_type; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cancel" role="tabpanel">
                            <div class="data-tables">
                                <table id="dataTableCancel" class="text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Email</th>
                                            <th>Paket</th>
                                            <th>QTY</th>
                                            <th>Total Ammount</th>
                                            <th>Tipe Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cancel_details as $record): ?>
                                            <tr>
                                                <td><?php echo $record->order_id; ?></td>
                                                <td><?php echo $record->email; ?></td>
                                                <td><?php echo $record->name; ?></td>
                                                <td><?php echo $record->qty; ?></td>
                                                <td><?php echo 'Rp ' . number_format($record->total_amount, 0, ',', '.'); ?></td>
                                                <td><?php echo $record->payment_type; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="refund" role="tabpanel">
                            <div class="data-tables">
                                <table id="dataTableRefund" class="text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Email</th>
                                            <th>Paket</th>
                                            <th>QTY</th>
                                            <th>Total Ammount</th>
                                            <th>Tipe Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($refund_details as $record): ?>
                                            <tr>
                                                <td><?php echo $record->order_id; ?></td>
                                                <td><?php echo $record->email; ?></td>
                                                <td><?php echo $record->name; ?></td>
                                                <td><?php echo $record->qty; ?></td>
                                                <td><?php echo 'Rp ' . number_format($record->total_amount, 0, ',', '.'); ?></td>
                                                <td><?php echo $record->payment_type; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->



<style>
.pSearch{
		display:none!important;
	}
</style>
<div class="row mt-5">
    <div class="col">
<div class="card">
    <div class="card-body">
    <h4 class="header-title">Data Semua Transaksi</h4>
<div class="row">
<div class="col-sm-12 col-md-12">
<button data-toggle="collapse" id="expandsearch" data-target="#demo" class="btn-info btn"><i class="fa fa-plus"></i>&nbsp;Add Filter</button>
<fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 collapse <?php if(isset($_GET['search'])) echo "in"?>" id="demo">

	<form enctype="multipart/form-data" method="get" action="<?php echo base_url() ?>payment">
            <div class="col-sm-12 col-md-12" style="margin-top:10px">
                           <div class="col-sm-6 col-md-6"  style="float:none!important;margin:0 auto;">
                               
							<div class="row" style="margin-bottom:2%;">
							<div class="col-sm-3 col-md-3">
								<label>Consumer</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_dropdown('consumer',array(''=>'-All-','retail'=>'Retail','school'=>'School'),$this->input->get('consumer'),'class="select2" style="margin-bottom:5px;width:100%;"')?>
                           	</div>
							</div>

							<div class="row" style="margin-bottom:2%;">
							<div class="col-sm-3 col-md-3">
							<label>Platform</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_dropdown('method',array(''=>'-All-','midtrans'=>'Midtrans','other'=>'Other'),$this->input->get('method'),'class="select2" style="margin-bottom:5px;width:100%;"')?>
                           	</div>
							</div>
							
							<div class="row" style="margin-bottom:2%;">
							<div class="col-sm-3 col-md-3">
							<label>Periode</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_input('periode_start',$this->input->get('periode_start'),' style="margin-bottom:5px;" class="form-control datepicker" placeholder="Start"')?>
                           		<?php echo form_input('periode_end',$this->input->get('periode_end'),' style="margin-bottom:5px;" class="form-control datepicker"  placeholder="End"')?>
                           	</div>
							</div>
                            
                            </div>
            </div>
			<?php //echo form_hidden('lastq',$lastq);?>
            <div class="col-sm-12 col-md-12"><div class="col-sm-12 col-md-12"><input type="submit" value="Search" name="search" class="btn-danger btn">&nbsp;<!--input type="reset" value="Clear" name="clear"--></div></div>
	<div class="col-sm-12" style="margin-top:10px"></div>
	
	</form>

</fieldset></div></div>
<?php
//error_reporting(0);
 echo $js_grid; ?>
<!--input type="button" value="Tambah" onclick="window.location = '<?//= base_url() ?>index.php/ms_con/add'"/-->
<script type="text/javascript">
$(document).ready(function(){
	
	$('.select2').select2();
	
	$('.datepicker').datepicker({
         format: 'yyyy-mm-dd',
         autoclose: true,
         todayHighlight:true
      });
	  <?php 
	 if($this->input->get('period_start') || $this->input->get('period_end') || $this->input->get('method') || $this->input->get('consumer')){
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
	}if(com=='auth'){
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
	if(com=='export'){
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
		//var items = $('.trSelected',grid);
 		 window.location = _base_url + controller + 'export/?consumer=<?php echo $this->input->get('consumer')?>&method=<?php echo $this->input->get('method')?>&periode_start=<?php echo $this->input->get('periode_start')?>&periode_end=<?php echo $this->input->get('periode_end')?>';
			
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
setInterval("$('#flex1').flexReload()",50000 );
</script>

        <div class="layout-grid mt-3">
            <table id="flex1" style="display:none; "></table>
        </div>
    </div>
</div>      
</div>
</div>

<!-- line chart  -->
<script>
    var chartDataPayment = <?= $jsonChartDataPayment ?>;

    // AmCharts Configuration
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("payment-chart", am4charts.XYChart);

        // Add data
        chart.data = chartDataPayment;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
        dateAxis.title.text = "Date";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Transaksi";

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
<!-- pie chart -->
<script>
    // Gunakan data PHP yang didapat ke dalam script JavaScript
    var countApple = <?php echo $count_apple; ?>;
    var countMidtrans = <?php echo $count_midtrans; ?>;
    var countGoogle = <?php echo $count_google; ?>;

    // Buat grafik menggunakan AmCharts
    am4core.ready(function() {
        var chart = am4core.create("ampiechart1", am4charts.PieChart);

        // Atur data grafik
        chart.data = [{
            "transaksi": "Apple",
            "jumlah": <?php echo $count_apple; ?>
        }, {
            "transaksi": "Midtrans",
            "jumlah": <?php echo $count_midtrans; ?>
        }, {
            "transaksi": "Google",
            "jumlah": <?php echo $count_google; ?>
        }];
        // chart.data = chartDataUsers;

        // Atur properti grafik dengan menentukan warna berdasarkan kategori
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "jumlah";
        pieSeries.dataFields.category = "transaksi";

        // Menentukan warna untuk setiap kategori
        pieSeries.colors.list = [
            am4core.color("#3366FF"), // Warna untuk kategori "Apple"
            am4core.color("#FF5733"), // Warna untuk kategori "Midtrans"
            am4core.color("#33FF57")  // Warna untuk kategori "Google"
            // Tambahkan warna lain jika diperlukan
        ];


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

<!-- all bar chart -->
<script src="<?php echo base_url('assets')?>/srtdash/assets/js/bar-chart.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>


<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>


<script src="<?php echo base_url('assets')?>/assets/js/plugins.js"></script>
    <script src="<?php echo base_url('assets')?>/assets/js/scripts.js"></script>
