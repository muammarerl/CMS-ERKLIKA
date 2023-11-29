<style>
    
#button-bar {
    min-width: 310px;
    max-width: 800px;
    margin: 0 auto;
}
#modals{
    min-width:80%!important;
}
.highcharts-container{
  width: 100% !important;
}

.highcharts-root{
  width: 100% !important;
}
.highcharts-exporting-group {
    display: block !important; 
}
</style>

<!-- Modal -->
<div class="modal fade" id="bd-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" id="modals" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="contentmodal">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-lg-6 mt-3">
        <div class="card">
            <div class="card-body">
                <h3>Total Risk 2021</h3>
                <div id="ambarchart1"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mt-3">
        <div class="card">
            <div class="card-body">
            <h3>Total by Severity in 2021</h3>
                <div id="ambarchart2"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-body">
            <h3>Daily Total Risk</h3>
                <div id="ambarchart3"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--script src="https://code.highcharts.com/modules/export-data.js"></script-->
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<!--<script src="<?php echo base_url()?>assets/srtdash/assets/js/amchart/amcharts.js"></script>
<script src="<?php echo base_url()?>assets/srtdash/assets/js/amchart/serial.js"></script>
<script src="<?php echo base_url()?>assets/srtdash/assets/js/amchart/light.js"></script>
<script src="<?php echo base_url()?>assets/srtdash/assets/js/amchart/export.min.js"></script>
-->
<script>
    Highcharts.chart('ambarchart1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Yearly Risk Data'
    },
    exporting: {
      enabled: true
    },
    xAxis: {
        categories: [
            '<?php echo date('Y')?>'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Data'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },series: {
            cursor: 'pointer',
            point: {
                events: {
                    click: function () {
                        datayear();
                    }
                }
            }
        }
    },
    series: [{
        name: 'Total Risk Data',
        data: [<?php echo $yearly?>]

    }]
});

Highcharts.chart('ambarchart2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'By Severity <?php echo date('Y')?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Precentage',
        colorByPoint: true,
        data: [{
            name: 'Low',
            y: <?php echo $severity[1]?>,
            sliced: true,
            selected: true,
            color:'green'
        }, {
            name: 'Medium',
            y: <?php echo $severity[2]?>,
            color:'#ffcc29'
        }, {
            name: 'High',
            y: <?php echo $severity[3]?>,
            color:'red'
        }],
        point: {
                events: {
                    click: function () {
                        dataseverity(this.name);
                        //alert('Category: ' + this.name + ', value: ' + this.y);
                    }
                }
            }
    }]
});
Highcharts.chart('ambarchart3', {

    title: {
        text: 'Weekly Total Risk'
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: 'Risk Data'
        }
    },

    xAxis: {
        categories: [
        '<?php echo tglindo(date('Y-m-d'))?>',
        <?php for($a=1;$a<=6;$a++){
            $dates=date('Y-m-d',strtotime("-$a days"));
    ?>
    '<?php echo tglindo($dates)?>',<?php }?>]
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    plotOptions: {
       series: {
            cursor: 'pointer',
            point: {
                events: {
                    click: function () {
                        datadaily(this.category);
                        //alert('Category: ' + this.category + ', value: ' + this.y);
                    }
                }
            }
        }
    },

    series: [{
        name: 'Risk Data',
        data: [<?php
            echo $week[0].',';
            for($a=1;$a<=6;$a++){
            $dates=date('Y-m-d',strtotime("-$a days"));
             echo $week[$a]?>,
        <?php }?>]
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
              
    function datayear(){
        $('#bd-modal-lg').modal('show');
        
        $('#contentmodal').html('<img src="<?php echo base_url()?>assets/img/spinner.gif" width="100px" height="100px">');
        $('#modalTitle').html('Risk Data Yearly <?php echo date('Y')?>');
        $('#contentmodal').load('<?php echo base_url()?>dashboard/load_data',{y:<?php echo date('Y')?>},function(e){
        
        });
    }    
    function dataseverity(nm){
        
        $('#contentmodal').html('<img src="<?php echo base_url()?>assets/img/spinner.gif" width="100px" height="100px">');
        if(nm=='High'){
            var svr='3';
        }
        if(nm=='Medium'){
            var svr='2';
        }
        if(nm=='Low'){
            var svr='1';
        }
        $('#bd-modal-lg').modal('show');
        $('#modalTitle').html('Risk Data Severity '+nm+' <?php echo date('Y')?>');
        $('#contentmodal').load('<?php echo base_url()?>dashboard/load_data',{s:svr,y:<?php echo date('Y')?>},function(e){
        
        });
    }
           
    function datadaily(day){
        $('#contentmodal').html('<img src="<?php echo base_url()?>assets/img/spinner.gif" width="100px" height="100px">');
        $('#bd-modal-lg').modal('show');
        $('#modalTitle').html('Risk Data Daily '+day);
        $('#contentmodal').load('<?php echo base_url()?>dashboard/load_data',{d:day},function(e){
        
        });
    }    
    $('#bd-modal-lg').on('hidden.bs.modal', function (e) {
        $('#contentmodal').empty();
        $('#modalTitle').empty();
    })
//    
//if ($('#ambarchart11').length) {
//    var chart = AmCharts.makeChart("ambarchart1", {
//        "type": "serial",
//        "theme": "light",
//        "marginRight": 70,
//        "dataProvider": [{
//            "year": "<?php echo date('Y')?>",
//            "risknumber": <?php echo $yearly?>,
//            "color": "#007965"
//        }],
//        "valueAxes": [{
//            "axisAlpha": 0,
//            "position": "left",
//            "title": false
//        }],
//        "startDuration": 1,
//        "graphs": [{
//            "balloonText": "<b>year [[category]]: [[value]]</b>",
//            "fillColorsField": "color",
//            "fillAlphas": 0.9,
//            "lineAlpha": 0.2,
//            "type": "column",
//            "valueField": "risknumber"
//        }],
//        "chartCursor": {
//            "categoryBalloonEnabled": false,
//            "cursorAlpha": 0,
//            "zoomable": false
//        },
//        "categoryField": "year",
//        "categoryAxis": {
//            "gridPosition": "start",
//            "labelRotation": 45
//        },
//        "export": {
//            "enabled": false     
//        }                       
//
//    });
//}
//
//if ($('#ambarchart12').length) {
//    var chart = AmCharts.makeChart("ambarchart2", {
//        "type": "serial",
//        "theme": "light",
//        "marginRight": 70,
//        "dataProvider": [{
//            "severity": "High",
//            "jumlah": <?php echo $severity[3]?>,
//            "color": "#e21c1c"
//        }, {
//            "severity": "Medium",
//            "jumlah": <?php echo $severity[2]?>,
//            "color": "#ffcc29"
//        }, {
//            "severity": "Low",
//            "jumlah": <?php echo $severity[1]?>,
//            "color": "#007965"
//        }],
//        "startDuration": 1,
//        "graphs": [{
//            "balloonText": "<b>severity [[category]]: [[value]]</b>",
//            "fillColorsField": "color",
//            "fillAlphas": 0.9,
//            "lineAlpha": 0.2,
//            "type": "column",
//            "valueField": "jumlah"
//        }],
//        "chartCursor": {
//            "categoryBalloonEnabled": false,
//            "cursorAlpha": 0,
//            "zoomable": false
//        },
//        "categoryField": "severity",
//        "categoryAxis": {
//            "gridPosition": "start",
//            "labelRotation": 45
//        },
//        "export": {
//            "enabled": false
//        }
//
//    });
//}
//
//if ($('#ambarchart13').length) {
//    var chart = AmCharts.makeChart("ambarchart3", {
//        "type": "serial",
//        "theme": "light",
//        "marginRight": 70,
//        "dataProvider": [
//        {
//            "date": "<?php echo date('Y-m-d')?>",
//            "visits": <?php echo $week[0]?>,
//            "color": "#8918FE"
//        },
//        <?php for($a=1;$a<=6;$a++){
            $dates=date('Y-m-d',strtotime("-$a days"));
            //$data['severity'][$a]=$today=$this->chart->risk_weekly($dates);
                    
                ?>//
//        {
//            "date": "<?php echo $dates?>",
//            "visits": <?php echo $week[$a]?>,
//            "color": "#8918FE"
//        },
//    <?php
        }?>//
//        ],
//        "valueAxes": [{
//            "axisAlpha": 0,
//            "position": "left",
//            "title": false
//        }],
//        "startDuration": 1,
//        "graphs": [{
//            "balloonText": "<b>[[category]]: [[value]]</b>",
//            "fillColorsField": "color",
//            "fillAlphas": 0.9,
//            "lineAlpha": 0.2,
//            "type": "column",
//            "valueField": "visits"
//        }],
//        "chartCursor": {
//            "categoryBalloonEnabled": false,
//            "cursorAlpha": 0,
//            "zoomable": false
//        },
//        "categoryField": "date",
//        "categoryAxis": {
//            "gridPosition": "start",
//            "labelRotation": 45
//        },
//        "export": {
//            "enabled": false
//        }
//
//    });
//}
</script>
