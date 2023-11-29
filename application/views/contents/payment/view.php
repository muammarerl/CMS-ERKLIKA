<style>
.pSearch{
		display:none!important;
	}
</style>
<div class="row">
<div class="col-sm-12 col-md-12">
<button data-toggle="collapse" id="expandsearch" data-target="#demo" class="btn-warning btn"><i class="fa fa-plus"></i>&nbsp;Add Filter</button>
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
<div class="layout-grid">
	<table id="flex1" style="display:none; "></table>
</div>