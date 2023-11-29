<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
$parentro=isset($val['id']) ? "disabled='disabled'":"";
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="row">
 <div class="col-lg-12 col-ml-12">
   <div class="row">
                            <!-- Textual inputs start -->
     <div class="col-12 mt-5">
      <div class="card">
       <div class="card-body">
        

    	<div class="box-content">
       <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/create_submit">
            <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
            <?php echo form_hidden('video_id',isset($val['video_id']) ? $val['video_id'] : '')?>
            <?php echo form_hidden('video_en',isset($val['video_en']) ? $val['video_en'] : '')?>
           
            
            <div class="form-group">
            
            <?php $nm_f="name_id";?>
                        <label for="<?php echo $nm_f?>">Video Name</label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control"  required>
    		
             </div>
             
            <div class="form-group">
            <?php $nm_f="description_id";?>
                        <label for="<?php echo $nm_f?>">Video Description</label>
                        <?php echo form_textarea($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" onkeyup="countdesc(this)" rows="2" maxlength="200" style="height:100%;" id="'.$nm_f.'" required')?>
                        Character :<span id="char_count">0/200</span>
             </div>
             <div class="form-group" style="display:none">
            
            <?php $nm_f="name_en";?>
                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" >
    		
             </div>
             
            <div class="form-group" style="display:none">
            <?php $nm_f="description_en";?>
                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                        <?php echo form_textarea($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" rows="2" style="height:100%;" id="'.$nm_f.'" ')?>
             </div>
            <!--div class="form-group">
            <?php $nm_f="labels";?>
                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                        <?php echo form_dropdown($nm_f.'[]',$opt_labels,(isset($labels) ? $labels : ''),'class="form-control select2" id="'.$nm_f.'" multiple')?>
             </div-->
             <div class="form-group">
            <?php $nm_f="jenjang";?>
                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                        <?php echo form_dropdown($nm_f.'[]',$opt_jenjang,(isset($labels) ? $labels : ''),'class="form-control select2" id="'.$nm_f.'" multiple required')?>
             </div>
             <div class="form-group">
            <?php $nm_f="topik";?>
                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                        <?php echo form_dropdown($nm_f.'[]',$opt_topik,(isset($labels) ? $labels : ''),'class="form-control select2" id="'.$nm_f.'" multiple required')?>
             </div>
             <div class="form-group">
            <?php $nm_f="konten";?>
                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                        <?php echo form_dropdown($nm_f.'[]',$opt_konten,(isset($labels) ? $labels : ''),'class="form-control select2" id="'.$nm_f.'" multiple required')?>
             </div>
            <div class="form-group">
            <?php $nm_f="tags";?>
                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                        <?php echo form_dropdown($nm_f.'[]',$opt_tags,(isset($tags) ? $tags : ''),'class="form-control select2" id="'.$nm_f.'" multiple')?>
             </div>
            <div class="form-group">
              <div class="row" style="text-align: center;">
                <div class="col-12 col-md-4">
                    <?php $nm_f="free";?>
                    <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?> ?</label>
                    <?php echo form_checkbox($nm_f,1,(isset($val[$nm_f]) && $val[$nm_f]==1 ? TRUE : FALSE),'class="" id="'.$nm_f.'" ')?>
                </div>
                <div class="col-12 col-md-4">
                    <?php $nm_f="recommended";?>
                    <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?> ?</label>
                    <?php echo form_checkbox($nm_f,1,(isset($val[$nm_f]) && $val[$nm_f]==1 ? TRUE : FALSE),'class="" id="'.$nm_f.'" ')?>
                </div>
                <div class="col-12 col-md-4">
                    <?php $nm_f="show_homepage";?>
                    <label for="<?php echo $nm_f?>">Show on homepage ?</label>
                    <?php echo form_checkbox($nm_f,1,(isset($val[$nm_f]) && $val[$nm_f]==1 ? TRUE : FALSE),'class="" id="'.$nm_f.'" ')?>
                </div>
              </div>
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
<script>
   $(document).ready(function(e){
         $('.select2').select2();
         countdesc();
   });
   function countdesc(){
    var v=$('#description_id').val().length;
    let numOfEnteredChars = v;
    //let counter = maxNumOfChars - numOfEnteredChars;
      $('#char_count').text(numOfEnteredChars +'/200') ;
    if(numOfEnteredChars==200){
      $('#char_count').css("color","red");
    }else{
      $('#char_count').css("color","black");
      
    }
   }
</script>
