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
            
            <?php $nm_f="due";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?> Date</label>
                        <input type="number" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
    		
             </div>
           <div class="form-group">
            
            <?php $nm_f="notif";?>
                        <label for="<?php echo $nm_f?>">Send <?php echo ucfirst($nm_f)?> Date</label>
                        <input type="number" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
    		
             </div>
    		<div class="form-group">
            <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
            
            <?php $nm_f="subject";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
    		
             </div>
            <div class="form-group">
            <?php $nm_f="content";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <?php echo form_textarea($nm_f, (isset($val[$nm_f]) ? $val[$nm_f] : ''),'row="4" class="form-control"')?>
                        <!--input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control"-->
    		
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