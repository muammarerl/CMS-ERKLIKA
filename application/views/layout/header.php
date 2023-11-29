<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Equity Application</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/font-awesome.css" />

		<link rel="stylesheet" href="<?php echo base_url('assets')?>/validation/css/validationEngine.jquery.css" type="text/css"/>

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/chosen.css" />
<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/jquery.dataTables.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery and DataTables CSS and JS files -->
<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script> -->

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo base_url('assets')?>/ace/js/ace-extra.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo base_url('assets')?>/ace/js/html5shiv.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/respond.js"></script>
		<![endif]-->
		<!--[if !IE]> -->
<script type="text/javascript">
	window.jQuery || document.write("<script src='<?php echo base_url('assets')?>/ace/js/jquery.js' >"+"<"+"/script>");
</script>
<script src="<?php echo base_url('assets')?>/validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>
<?php $this->load->view('layout/validator');?>
<!--script src="<?php echo base_url('assets')?>/validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script-->
<link type="text/css" href="<?php echo base_url();?>assets/flexigrid/css/flexigrid.css" rel="stylesheet" />
<script src="<?php echo base_url('assets')?>/ace/js/jquery.maskedinput.js"></script>
	</head>
	<style>
	.bDiv{
		max-height:350px!important;
	}
	</style>