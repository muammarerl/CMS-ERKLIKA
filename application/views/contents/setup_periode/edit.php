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
        <h2><i class="<?php echo GetValue('icon','sv_menu',array('filez'=>'where/'.$this->utama))?>"></i> <?php echo $this->title;?></h2>

    	<div class="box-content">
       <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit">
           <div class="form-group">
            
           <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
           
            <?php $nm_f="title";?>
                        <label for="<?php echo $nm_f?>">Periode</label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
    		
             </div>
           <div class="form-group">
            
            <?php $nm_f="duration";?>
                        <label for="<?php echo $nm_f?>">Durasi (Hari)</label>
                        <input type="number" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
    		
             </div>
           <div class="form-group">
            
            <?php $nm_f="status";?>
                        <label for="<?php echo $nm_f?>">Status</label>
                        <input type="checkbox" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="1" <?php echo (isset($val[$nm_f]) && $val[$nm_f]==1 ? 'checked' : '') ?> class="form-control">
    		
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