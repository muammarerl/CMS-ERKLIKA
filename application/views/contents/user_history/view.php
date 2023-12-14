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
            <h4 class="header-title">
                <div class="row">
                    <div class="col">
                        Real Time
                    </div>
                    <div class="col text-right">
                        <?php
                            setlocale(LC_TIME, 'id_ID.UTF-8');
                            $date = date('d-m-Y - H:i');
                            $timestamp = strtotime($date);
                            $day = strftime('%A', $timestamp);

                            echo $day . ', ' . $date;
                        ?>
                    </div>
                </div>
            </h4>
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="fa fa-history"></i> Today</div>
                                    <h2><?php echo $total_data_hari; ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="seo-fact sbg2">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="fa fa-history"></i> This Month</div>
                                    <h2><?php echo $total_data_bulan; ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="seo-fact sbg3">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="fa fa-history"></i> This Year</div>
                                    <h2><?php echo $total_data_tahun; ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<h4 class="header-title"></h4>
					</div>
					<div class="col text-right">
						<button onclick="exportToExcel('dataTable')" class="btn btn-primary btn-xs">
							<i class="fa fa-file-excel-o" style="margin-right: 5px;"></i>
							<span>Export</span>
						</button>
						<button onclick="printData('dataTable')" class="btn btn-success btn-xs">
							<i class="fa fa fa-print" style="margin-right: 5px;"></i>
							<span>Print</span>
						</button>
					</div>
				</div>
				<br>		
				<div class="data-tables">
					<table id="dataTable" class="text-center">
						<thead class="bg-light text-capitalize">
							<tr>
								<th>Nama</th>
								<th>Email</th>
								<th>Action</th>
								<th>Update At</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($user_history as $record): ?>
								<tr>
									<td><?php echo $record->full_name; ?></td>
									<td><?php echo $record->email; ?></td>
									<td><?php echo $record->action; ?></td>
									<td><?php echo $record->updatedAt; ?></td>
									<td><?php echo $record->description; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- export -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<script>
    function exportToExcel(tableID) {
        var tableHTML = document.getElementById(tableID).outerHTML;

        // Specify file name
        var filename = 'exported_table.xls';

        // Create a blob data type for modern browsers
        var blob = new Blob([tableHTML], {
            type: 'application/vnd.ms-excel'
        });

        // For Internet Explorer
        if (navigator.msSaveOrOpenBlob) {
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // For other browsers
            // Create a temporary link element
            var downloadLink = document.createElement('a');
            if (window.URL && window.URL.createObjectURL) {
                var blobURL = window.URL.createObjectURL(blob);
                downloadLink.href = blobURL;
                downloadLink.download = filename;

                // Triggering the function
                downloadLink.click();

                // Cleanup
                window.URL.revokeObjectURL(blobURL);
            } else {
                // Fallback for browsers that don't support Blob URLs
                alert('Your browser does not support this feature. Please use a modern browser.');
            }
        }
    }
</script>

<script>
    function printData() {
        var table = document.getElementById("dataTable");
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><style>@media print{table{width:100%;border-collapse:collapse;}table, th, td{border:1px solid black;padding:8px;}}@page{size:landscape;}</style></head><body>');

        var rows = table.rows.length;
        var cols = table.rows[0].cells.length;

        newWin.document.write('<h2>Data Table</h2>');
        newWin.document.write('<table>');

        for (var i = 0; i < rows; i++) {
            newWin.document.write('<tr>');
            for (var j = 0; j < cols; j++) {
                newWin.document.write('<td>' + table.rows[i].cells[j].innerHTML + '</td>');
            }
            newWin.document.write('</tr>');
        }

        newWin.document.write('</table>');
        newWin.document.write('</body></html>');

        newWin.document.close();
        newWin.focus();
        newWin.print();
        newWin.close();
    }
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