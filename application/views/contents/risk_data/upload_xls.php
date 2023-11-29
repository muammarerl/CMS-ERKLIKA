<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<div class="row">
 <div class="col-lg-12 col-ml-12">
   <div class="row">
                            <!-- Textual inputs start -->
     <div class="col-12 mt-5">
      <div class="card">
       <div class="card-body">
        

    	<div class="box-content">
       <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/upload_submit">
            <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
           <div class="row">
               <div class="col-md-12">
    		<div class="form-group">
            <a href="<?php echo base_url()?>assets/template/template.xlsx">Get Template</a>
             </div>
               </div>
           </div>
           <div class="row">
               <div class="col-md-12">
            <div class="form-group">
            
            <?php $nm_f="filez";?>
                <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="custom-file-input" required="required">
    		
                        <label for="<?php echo $nm_f?>" class="custom-file-label">Select xls Template</label>
             </div>
               </div>
           </div>
    		<div class="row">
    		<div class="form-group">
                    <button type="submit" class="btn pull-right">Upload</button>
                </div>
                </div>
            </form>
    	</div>
    	
    </div>
    </div>
</div>
   </div>
 </div>
</div>