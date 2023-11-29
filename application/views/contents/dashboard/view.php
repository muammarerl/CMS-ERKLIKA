<!-- 
<div class="row">
    <div class="col-lg-12 mt-12">
        <div class="card">
            <div class="card-body">
                <h3>Welcome To Erlangga Video Solution Apps!</h3>
                <br>
                <?php echo date('Y-m-d H:i:s')?>
                <div id="ambarchart1"></div>
            </div>
        </div>
    </div>
</div> -->
<style>
.tab-cuy {
    width: 100%;
    height: 350px;
    max-width: 100%
}
</style>

<div class="main-content-inner">
    <!-- <h3>Welcome To Erlangga Video Solution Apps!</h3> -->
    <!-- <br> -->
    <!-- <?php echo date('Y-m-d H:i:s')?> -->
    <div class="row">
        <div class="col-sm-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4 class="header-title">Penggunaan Harian</h4>
                        <div class="trd-history-tabs">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#users" role="tab">Users</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#redeem" role="tab">Reedem</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#video" role="tab">VIdeo</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#payment" role="tab">Transaksi</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                         <?php echo date('Y-m-d H:i:s')?>
                        </div>
                    </div>
                    <div class="trad-history mt-4">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="users" role="tabpanel">
                                <?php
                                    $queryCustomers = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_users WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data pengguna
                                    $resultCustomers = $queryCustomers->result();

                                    $dataPointsCustomers = [];
                                    foreach ($resultCustomers as $row) {
                                        $dataPointsCustomers[] = [
                                            'date' => $row->date,
                                            'value' => $row->count
                                        ];
                                    }
                                    $jsonChartDataUsers = json_encode($dataPointsCustomers);
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-cuy" id="customers"></div>
                                    </div>
                                    <div style="text-align: right;">
                                        <a href="https://localhost/erl-video-solution-cms-master/customer" >Detail Data  <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                                <script>
                                    var chartDataUsers = <?= $jsonChartDataUsers ?>;

                                    // AmCharts Configuration
                                    am4core.ready(function() {
                                        // Themes begin
                                        am4core.useTheme(am4themes_animated);
                                        // Themes end

                                        // Create chart instance
                                        var chart = am4core.create("customers", am4charts.XYChart);
                                        // var chart = am4core.create("redeem", am4charts.XYChart);

                                        // Add data
                                        chart.data = chartDataUsers;

                                        // Create axes
                                        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                                        dateAxis.renderer.minGridDistance = 50;
                                        dateAxis.title.text = "Date";
                                        
                                        chart.exporting.menu = new am4core.ExportMenu();
                                        chart.exporting.filePrefix = "chart-export";
                                        chart.exporting.useWebFonts = false;
                                        chart.exporting.adapter.add("data", function(data) {
                                            data.data = data.data.filter(function(item) {
                                                return item.category !== undefined;
                                            });
                                            return data;
                                        });

                                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                                        valueAxis.title.text = "Users";

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
                            </div>
                            <div class="tab-pane fade" id="redeem" role="tabpanel">
                                <?php
                                    $queryRedeem = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_redeem_history WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data redeem
                                    $resultRedeem = $queryRedeem->result(); // Mendapatkan hasil query

                                    $dataPointsRedeem = [];
                                    foreach ($resultRedeem as $row) {
                                        $dataPointsRedeem[] = [
                                            'date' => $row->date,
                                            'value' => $row->count
                                        ];
                                    }
                                    $jsonChartDataRedeem = json_encode($dataPointsRedeem);
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-cuy" id="redeem-chart"></div>
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
                            </div>
                            <div class="tab-pane fade" id="video" role="tabpanel">
                                <?php
                                    $queryVideo = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_videos WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data video
                                    $resultVideo = $queryVideo->result(); // Mendapatkan hasil query

                                    $dataPointsVideo = [];
                                    foreach ($resultVideo as $row) {
                                        $dataPointsVideo[] = [
                                            'date' => $row->date,
                                            'value' => $row->count
                                        ];
                                    }
                                    $jsonChartDataVideo = json_encode($dataPointsVideo);
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-cuy" id="video-chart"></div>
                                    </div>
                                </div>
                                <script>
                                    var chartDataVideo = <?= $jsonChartDataVideo ?>;

                                    // AmCharts Configuration
                                    am4core.ready(function() {
                                        // Themes begin
                                        am4core.useTheme(am4themes_animated);
                                        // Themes end

                                        // Create chart instance
                                        var chart = am4core.create("video-chart", am4charts.XYChart);
                                        // var chart = am4core.create("redeem", am4charts.XYChart);

                                        // Add data
                                        chart.data = chartDataVideo;

                                        // Create axes
                                        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                                        dateAxis.renderer.minGridDistance = 50;
                                        dateAxis.title.text = "Date";

                                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                                        valueAxis.title.text = "Video";

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
                            </div>
                            <div class="tab-pane fade" id="payment" role="tabpanel">
                                <?php
                                    $queryPayment = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_payment_details WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data video
                                    $resultPayment = $queryPayment->result(); // Mendapatkan hasil query

                                    $dataPointsPayment = [];
                                    foreach ($resultPayment as $row) {
                                        $dataPointsPayment[] = [
                                            'date' => $row->date,
                                            'value' => $row->count
                                        ];
                                    }
                                    $jsonChartDataPayment = json_encode($dataPointsPayment);
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-cuy" id="payment-chart"></div>
                                    </div>
                                </div>
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
                            </div>
                            <div class="tab-pane fade" id="sell_order" role="tabpanel">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4 class="header-title">User Transaksi</h4>
                        <div class="trd-history-tabs">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#satu" role="tab">Retail/Sekolah</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#langganan" role="tab">Sub/Voc</a>
                                </li>
                                <!-- <li>
                                    <a data-toggle="tab" href="#video" role="tab">Video</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="trad-history mt-4">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="satu" role="tabpanel">
                                <div class="card">
                                    <div id="ampiechart1"></div>
                                </div>
                                <?php
                                // Ambil data dari database
                                $query_enum_1 = $this->db->query("SELECT COUNT(*) AS count_enum_1 FROM sv_payment WHERE consumer = 'retail'");
                                $result_enum_1 = $query_enum_1->row();
                                $count_enum_1 = $result_enum_1->count_enum_1;

                                $query_enum_2 = $this->db->query("SELECT COUNT(*) AS count_enum_2 FROM sv_payment WHERE consumer = 'school'");
                                $result_enum_2 = $query_enum_2->row();
                                $count_enum_2 = $result_enum_2->count_enum_2;
                                ?>

                                <script>
                                    // Gunakan data PHP yang didapat ke dalam script JavaScript
                                    var countEnum1 = <?php echo $count_enum_1; ?>;
                                    var countEnum2 = <?php echo $count_enum_2; ?>;

                                    // Buat grafik menggunakan AmCharts
                                    am4core.ready(function() {
                                        var chart = am4core.create("ampiechart1", am4charts.PieChart);

                                        // Atur data grafik
                                        chart.data = [{
                                            "transaksi": "Retail",
                                            "jumlah": <?php echo $count_enum_1; ?>
                                        }, {
                                            "transaksi": "Sekolah",
                                            "jumlah": <?php echo $count_enum_2; ?>
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
                            </div>
                            <div class="tab-pane fade" id="langganan" role="tabpanel">
                                <div class="card">
                                    <div id="ampiechart2"></div>
                                </div>
                                <?php
                                // Ambil data dari database
                                $query_enum_1 = $this->db->query("SELECT COUNT(*) AS count_enum_1 FROM  sv_user_packages WHERE activation = 'sub'");
                                $result_enum_1 = $query_enum_1->row();
                                $count_enum_1 = $result_enum_1->count_enum_1;

                                $query_enum_2 = $this->db->query("SELECT COUNT(*) AS count_enum_2 FROM  sv_user_packages WHERE activation = 'voc'");
                                $result_enum_2 = $query_enum_2->row();
                                $count_enum_2 = $result_enum_2->count_enum_2;
                                
                                ?>

                                <script>
                                    // Gunakan data PHP yang didapat ke dalam script JavaScript
                                    var countEnum1 = <?php echo $count_enum_1; ?>;
                                    var countEnum2 = <?php echo $count_enum_2; ?>;

                                    // Buat grafik menggunakan AmCharts
                                    am4core.ready(function() {
                                        var chart = am4core.create("ampiechart2", am4charts.PieChart);

                                        // Atur data grafik
                                        chart.data = [{
                                            "transaksi": "Subscribe",
                                            "jumlah": <?php echo $count_enum_1; ?>
                                        }, {
                                            "transaksi": "Voucher",
                                            "jumlah": <?php echo $count_enum_2; ?>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 ">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex flex-wrap justify-content-between mb-4 align-items-center">
                        <h4 class="header-title mb-0">Team Admin</h4>
                        <!-- <form class="team-search">
                            <input type="text" name="search" placeholder="Search Here">
                        </form> -->
                    </div>
                    <div class="member-box">
                        <?php
                        $query = $this->db->query('
                            SELECT sv_admin.*, sv_admin_grup.title
                            FROM sv_admin
                            INNER JOIN sv_admin_grup ON sv_admin.id_admin_grup = sv_admin_grup.id
                            LIMIT 4
                        ');
                        $result = $query->result();

                        foreach ($result as $row) {
                        ?>
                        <div class="s-member">
                            <div class="media align-items-center">
                                <img src="<?php echo base_url()?>assets/ace/avatars/<?php echo $row->avatar ?>" class="d-block ui-w-30 rounded-circle" alt="">
                                <div class="media-body ml-5">
                                    <p><?php echo $row->name ?></p>
                                    <span><?php echo $row->title ?></span>
                                </div>
                                <div class="tm-social">
                                    <a href="#"><i class="fa fa-phone"></i></a>
                                    <a href="#"><i class="fa fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                    <div style="text-align: right;">
                        <a href="https://localhost/erl-video-solution-cms-master/admin" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 mt-3">
            <div class="col mt-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="menu-icon fa fa-video-camera"></i> Videos</div>
                            <h2>
                                <?php 
                                    $query = $this->db->query('SELECT * FROM sv_videos');
                                    $result = $query->result();
                                    $rowCount = $query->num_rows();
                                    echo $rowCount;
                                ?>
                            </h2>
                        </div>
                        <!-- <canvas id="seolinechart1" height="50"></canvas> -->
                    </div>
                </div>
            </div>
            <div class="col mt-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="ti-user"></i> Customer</div>
                                <h2>
                                    <?php 
                                        $query = $this->db->query('SELECT * FROM sv_users');
                                        $result = $query->result();
                                        $rowCount = $query->num_rows();
                                        echo $rowCount;
                                    ?>
                                </h2>
                        </div>
                        <!-- <canvas id="seolinechart2" height="50"></canvas> -->
                    </div>
                </div>
            </div>
            <div class="col mt-3">
                <div class="card">
                    <div class="seo-fact sbg3">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="menu-icon fa fa-ticket"></i> Vouchers</div>
                            <h2>
                                <?php 
                                    $query = $this->db->query('SELECT * FROM sv_packages');
                                    $result = $query->result();
                                    $rowCount = $query->num_rows();
                                    echo $rowCount;
                                ?>
                            </h2>
                        </div>
                        <!-- <canvas id="seolinechart2" height="50"></canvas> -->
                    </div>
                </div>
            </div>
            <div class="col mt-3">
                <div class="card">
                    <div class="seo-fact sbg4">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="fa fa-cart-arrow-down"></i> Transaksi</div>
                            <h2>
                                <?php 
                                    $query = $this->db->query('SELECT * FROM sv_payment');
                                    $result = $query->result();
                                    $rowCount = $query->num_rows();
                                    echo $rowCount;
                                ?>
                            </h2>
                        </div>
                        <!-- <canvas id="seolinechart2" height="50"></canvas> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Video Terbaru</h4>
                    <div class="letest-news mt-2">
                        <div class="single-post mb-xs-40 mb-sm-40">
                            <?php
                                $query = $this->db->query('SELECT * FROM sv_videos ORDER BY createdAt DESC, thumbnail_id, name_id, description_id DESC LIMIT 2');
                                $result = $query->result();

                                foreach ($result as $row) {
                                    ?>
                                    <div class="lts-thumb">
                                        <img src="<?php echo base_url()?>assets/upload_thumbnail/<?php echo $row->thumbnail_id ?>" alt="post thumb">
                                    </div>
                                    <div class="lts-content">
                                        <span><?php echo $row->name_id ?></span>
                                        <br>
                                        <!-- <span><?php echo $row->id ?></span> -->
                                        <p><?php echo $row->description_id ?></p>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div style="text-align: right;">
                            <a href="https://localhost/erl-video-solution-cms-master/videos" >Semua Data Video  <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-8 ">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h4 class="header-title">Top Transaksi</h4>
                        </div>
                        <div class="col">
                            <h4 class="header-title">
                            <?php
                                $query = $this->db->query('SELECT SUM(price) AS total_price FROM sv_user_packages');
                                $result = $query->row(); // Menggunakan row() untuk satu baris hasil

                                if ($result) {
                                    $total_price = $result->total_price;

                                    // Mengubah nilai ke format Rupiah
                                    $formatted_price = number_format($total_price, 0, ',', '.');
                                    echo "Total Transaksi: Rp $formatted_price"; // Menampilkan total price dalam format Rupiah
                                } else {
                                    echo "No results found";
                                }
                            ?>
                            </h4>
                        </div>
                    </div>
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div class="trd-history-tabs">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#banyak" role="tab">Jumlah Transaksi</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#nominal" role="tab">Nilai Transaksi</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="trad-history mt-2">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="banyak" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <h4 class="header-title">With Badges</h4> -->
                                        <ul class="list-group">
                                        <?php
                                            $query = $this->db->query('
                                                SELECT up.uid, COUNT(up.uid) AS total_uid, u.full_name
                                                FROM sv_user_packages up
                                                LEFT JOIN sv_users u ON up.uid = u.id
                                                GROUP BY up.uid
                                                ORDER BY COUNT(up.uid) DESC
                                                LIMIT 9
                                            ');

                                            $result = $query->result();

                                            foreach ($result as $row) {
                                            ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?php echo $row->full_name ?>
                                                <span class="badge badge-primary badge-pill"><?php echo $row->total_uid ?></span>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                    <div style="text-align: right;">
                                        <a href="https://localhost/erl-video-solution-cms-master/admin" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nominal" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <h4 class="header-title">With Badges</h4> -->
                                        <ul class="list-group">
                                            <?php
                                            $query = $this->db->query('
                                                SELECT up.uid, SUM(up.price) AS total_price, u.full_name
                                                FROM sv_user_packages up
                                                LEFT JOIN sv_users u ON up.uid = u.id
                                                GROUP BY up.uid, u.full_name
                                                ORDER BY SUM(up.price) DESC
                                                LIMIT 9
                                            ');

                                            $result = $query->result();

                                            foreach ($result as $row) {
                                                $formatted_price = number_format($row->total_price, 0, ',', '.'); // Mengonversi ke format Rupiah
                                            ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <?php echo $row->full_name ?>
                                                    <span class="badge badge-primary badge-pill">Rp <?php echo $formatted_price ?></span>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div style="text-align: right;">
                                        <a href="https://localhost/erl-video-solution-cms-master/admin" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">History User</h4>
                    <div class="timeline-area">
                        <?php 
                            $query = $this->db->query('
                                SELECT sv_user_history.*, sv_users.full_name
                                FROM sv_user_history
                                INNER JOIN sv_users ON sv_user_history.uid = sv_users.id
                                ORDER BY sv_user_history.updatedAt DESC 
                                LIMIT 20
                            ');
                            $result = $query->result();

                            foreach ($result as $row) {
                        ?>
                        <div class="timeline-task">
                            <div class="icon bg2">
                                <i class="fa fa-history"></i>
                            </div>
                            <div class="tm-title">
                                <h4><?php echo $row->full_name ?></h4>
                                <span class="time"><i class="ti-time"></i><?php echo $row->updatedAt ?></span>
                                <p><?php echo $row->action ?></p>
                            </div>
                        </div>
                        <?php 
                            }
                        ?> 
                    </div> 
                </div>
                <div style="text-align: right;">
                    <a href="https://localhost/erl-video-solution-cms-master/admin" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>    
</div>




<!-- jquery latest version -->
<script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/popper.min.js"></script>
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    

    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <!-- start amcharts -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <!-- all line chart activation -->
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/pie-chart.js"></script>
    <!-- all bar chart -->
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/bar-chart.js"></script>
    <!-- all map chart -->
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/maps.js"></script>
    <!-- others plugins -->
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/plugins.js"></script>
    <script src="<?php echo base_url('assets')?>/srtdash/assets/js/scripts.js"></script>


  