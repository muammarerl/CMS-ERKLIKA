<?php
//error_reporting(0);
 echo $js_grid; ?>
<!--input type="button" value="Tambah" onclick="window.location = '<?//= base_url() ?>index.php/ms_con/add'"/-->
<script type="text/javascript">
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
	if(com=='view'){
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
      if (com=='approve')
    {
           if($('.trSelected',grid).length>0){
			   if(confirm('Approve ' + $('.trSelected',grid).length + ' items?')){
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
					   url: "<?php echo site_url($this->utama."/approve");?>",
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
function search(){


}
</script>
         <form>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group row">
                                      <label for="idregister" class="col-sm-2 col-form-label">ID Register</label>
                                      <div class="col-sm-10">
                                          <input type="input" class="form-control" id="idregister" value="<?php echo ($this->input->get('id_register')?$this->input->get('id_register'):'')?>" name="id_register" placeholder="input ID Register">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="jenis_resiko" class="col-sm-2 col-form-label">Jenis Resiko</label>
                                      <div class="col-sm-10">
                                          <?php echo form_dropdown('jenis_resiko',$opt_risk,($this->input->get('jenis_resiko')?$this->input->get('jenis_resiko'):''),'class="form-control" id="jenis_resiko"')?>
                                        
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="divisi" class="col-sm-2 col-form-label">Divisi</label>
                                      <div class="col-sm-10">
                                          <?php echo form_dropdown('divisi',$opt_divisi,($this->input->get('divisi')?$this->input->get('divisi'):''),'class="form-control" id="divisi"')?>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary"><i class="ti-search"></i>&nbsp;Search</button>
                                        <button class=" btn btn-warning smalltext" type="reset"><i class="ti-reload"></i>&nbsp;Reset</button>
                                      </div>
                                    </div>
                                  </form>
<div class="form-group row">
    <div class="col-12">
       <a href="<?php echo base_url()?>risk_data/download_xls?id_register=<?php echo $this->input->get('id_register') ?>&jenis_resiko=<?php echo $this->input->get('jenis_resiko') ?>&divisi=<?php echo $this->input->get('divisi') ?>" class="btn btn-success pull-right"><i class="ti-download"></i>&nbsp;Download to Excel</a>
    </div>
</div>
<div class="col-md-12">
<div class="layout-grid">
	<table id="flex1" style="display:none; "></table>
</div>
</div>