<style>
.pSearch{
		display:none!important;
	}
</style>
<div class="modal" id="modalgenerated" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reset Password User</h5>
      </div>
      <div class="modal-body">
		<div class="col-md-12">
        <a id="linkforgot" target="_blank">Click Here To Reset Password</a>
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
	if(com=='export'){
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
		//var items = $('.trSelected',grid);
 		 window.location = _base_url + controller + 'export/?name=<?php echo $this->input->get('name')?>&email=<?php echo $this->input->get('email')?>&phone=<?php echo $this->input->get('phone')?>&school=<?php echo $this->input->get('school')?>&province=<?php echo $this->input->get('province')?>&city=<?php echo $this->input->get('city')?>';
			
	}           
}
function dismissmodal(){
	
	$('#linkforgot').attr('href','#');
	$('#modalgenerated').hide();
}
setInterval("$('#flex1').flexReload()",50000 );
</script>
<div class="row">
			  <div class="col-sm-12 col-md-12 mt-3">
<button data-toggle="collapse" id="expandsearch" data-target="#demo" class="btn-warning btn"><i class="fa fa-plus"></i>&nbsp;Add Filter</button>
<fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 collapse <?php if(isset($_GET['search'])) echo "in"?>" id="demo">

	<form enctype="multipart/form-data" method="get" action="<?php echo base_url($this->utama) ?>">
            <div class="col-sm-12 col-md-12" style="margin-top:10px">
                           <div class="col-sm-6 col-md-6"  style="float:none!important;margin:0 auto;">
                               
							<div class="row" style="margin-bottom:2%;">
								<?php $nm_f="name";?>
							<div class="col-sm-3 col-md-3">
								<label>Name</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_input($nm_f,$this->input->get($nm_f),'class="form-control" style="margin-bottom:5px;" placeholder="-'.strtoupper($nm_f).'-"')?>
                           	</div>
							</div>
							<div class="row" style="margin-bottom:2%;">
								<?php $nm_f="email";?>
							<div class="col-sm-3 col-md-3">
								<label>Email</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_input($nm_f,$this->input->get($nm_f),'class="form-control" style="margin-bottom:5px;" placeholder="-'.strtoupper($nm_f).'-"')?>
                           	</div>
							</div>
							<div class="row" style="margin-bottom:2%;">
								<?php $nm_f="phone";?>
							<div class="col-sm-3 col-md-3">
								<label>Phone</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_input($nm_f,$this->input->get($nm_f),'class="form-control" style="margin-bottom:5px;" placeholder="-'.strtoupper($nm_f).'-"')?>
                           	</div>
							</div>
							<div class="row" style="margin-bottom:2%;">
								<?php $nm_f="school";?>
							<div class="col-sm-3 col-md-3">
								<label>School</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_input($nm_f,$this->input->get($nm_f),'class="form-control" style="margin-bottom:5px;" placeholder="-'.strtoupper($nm_f).'-"')?>
                           	</div>
							</div>

							<div class="row" style="margin-bottom:2%;">
								<?php $nm_f="province";?>
							<div class="col-sm-3 col-md-3">
								<label>Province</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_dropdown($nm_f,GetOptAll('sv_provinces','-Province-',array(),'prov_name'),$this->input->get($nm_f),'class="form-control select2" style="margin-bottom:5px;width:100%;" id="'.$nm_f.'" placeholder="-'.strtoupper($nm_f).'-" onchange="gantiprov()"')?>
                           	</div>
							</div>

							<div class="row" style="margin-bottom:2%;">
								<?php $nm_f="city";?>
							<div class="col-sm-3 col-md-3">
								<label>City</label>
							</div>
							<div class="col-sm-4 col-md-4">
                           		<?php echo form_dropdown($nm_f,GetOptAll('sv_cities','-City-',array('prov_id'=>'where/'.$this->input->get('province')),'city_name'),$this->input->get($nm_f),'class="form-control select2" id="'.$nm_f.'" style="margin-bottom:5px;width:100%;" placeholder="-'.strtoupper($nm_f).'-"')?>
                           	</div>
							</div>

                            
                            </div>
            </div>
			<?php //echo form_hidden('lastq',$lastq);?>
            <div class="col-sm-12 col-md-12"><div class="col-sm-12 col-md-12"><input type="submit" value="Search" name="search" class="btn-danger btn">&nbsp;<!--input type="reset" value="Clear" name="clear"--></div></div>
	<div class="col-sm-12" style="margin-top:10px"></div>
	
	</form>

</fieldset></div>
</div>
<div class="row">
	<div class="col-md-12  mt-3">
      <div class="card">
       <div class="card-body">
        

    	<div class="box-content">
		<div class="layout-grid">
			<table id="flex1" style="display:none; "></table>
		</div>
		</div>
	</div>
	</div>
	</div>
</div>
<script>
	function gantiprov(){
		var prov=$('#province').val();
		if(prov){
			$('#city').empty();
			$.post('<?php echo base_url()?>customer/load_city',{p:prov},function(e){
			var data = {
				id: '',
				text: '-City-'
			};
			
			var newOption = new Option(data.text, data.id, false, false);
			$('#city').append(newOption).trigger('change');
			obj=JSON.parse(e);
			for (var i = 0; i < obj.length; i++) {
				var user = obj[i];
				var data = {
					id: user.id,
					text: user.city_name
				};
			
					var newOption = new Option(data.text, data.id, false, false);
					$('#city').append(newOption).trigger('change');
			}

			})
		}
	}
</script>