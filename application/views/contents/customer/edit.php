<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<style>
  label{
    font-weight:bold;
  }
  </style>
<div class="row">
 <div class="col-lg-12 col-ml-12">
   <div class="row">
                            <!-- Textual inputs start -->
     <div class="col-12 mt-5">
      <div class="card">
       <div class="card-body">

    	<div class="box-content">
       <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit">
            <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
           
           <div class="form-group">
            
            <?php $nm_f="name";?>
                        <label for="<?php echo $nm_f?>">Name</label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="description";?>
                        <label for="<?php echo $nm_f?>">Description</label>
                        <?php echo form_textarea($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="jenjang_id";?>
                        <label for="<?php echo $nm_f?>">Jenjang</label>
                        <?php echo form_dropdown($nm_f,$opt_jenjang,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" style="height:50px!important"')?>
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="method";?>
                        <label for="<?php echo $nm_f?>">Method</label>
                        <?php echo form_dropdown($nm_f,array(''=>'-Method-','voc'=>'Voucher','sub'=>'Subscription'),(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" style="height:50px!important"')?>
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="consumer";?>
                        <label for="<?php echo $nm_f?>">Consumer</label>
                        <?php echo form_dropdown($nm_f,array(''=>'-Consumer-','school'=>'School','retail'=>'Retail'),(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" style="height:50px!important"')?>
    		
            </div>
           <div class="form-group">
            
           <?php $nm_f="duration";?>
                        <label for="<?php echo $nm_f?>">Duration</label>
                        <?php echo form_dropdown($nm_f,$opt_periode,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" style="height:50px!important"')?>
    		
            </div>
            <div class="form-group">
            
            <?php $nm_f="price";?>
                        <label for="<?php echo $nm_f?>">Price</label>
                        <input type="number" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="status";?>
                        <label for="<?php echo $nm_f?>">Status</label>
                        <input type="checkbox" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="1" <?php echo (isset($val[$nm_f]) && $val[$nm_f]==1 ? 'checked' : '') ?>>
    		
             </div>
    		
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            </form>
             </div>
    	</div>
    	
    </div>
    </div>
</div>
   </div>
 </div>
</div>