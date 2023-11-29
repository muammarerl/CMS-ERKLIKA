<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
$parentro=isset($val['id']) ? "disabled='disabled'":"";
?>
<?php if($this->session->flashdata('message')){?>
<div class="row">
	<div class="col-md-12">
      <div class="card">
       <div class="card-body">
        

    	<div class="box-content">
  			<div class="alert alert-<?php echo ($this->session->flashdata('err_code')=='0')? 'success':'danger'?>" role="alert">
  			<?php echo $this->session->flashdata('message')?>
		</div>
	</div>
	</div>
	</div>
</div>
  			</div><?php }?>
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
           
            
    		   <div class="form-group" style="display:none">
            			<?php $nm_f="parent";?>
                        <label for="parents">Parents</label>
             			<?php echo form_dropdown($nm_f,$opt_tags,isset($val[$nm_f]) ? $val[$nm_f] : $parents," data-rel='chosen' class='form-control select2' onChange='gantiparents()' id='$nm_f' $parentro")?>
                        <input type="text" name="parent_label"  id="parent_label" value="<?php echo (isset($val['id']) && GetValue('tags','tags',array('id'=>'where/'.$val['parent']))!='0' ?  GetValue('tags','tags',array('id'=>'where/'.$val['parent'])):'') ?>" class="form-control" style="display:none">
                        
             </div>
            <div class="form-group">
            
            <?php $nm_f="title";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required>
    		
             </div>
            <div class="form-group">
            
            <?php $nm_f="tags";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" readonly='readonly'>
    		
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
   function generatelabel(){
      var parentz = $('#parent_label').val();
      var f = $('#title').val();
      var strlabel=f.toLowerCase().replace(/[^a-z0-9_-]+/gi, '-');
      //alert(f);
      if(!parentz || parentz.length === 0){
         strlabel=''+strlabel+'';
        //console.log('parent empty');
      }else{
         strlabel=parentz+' - '+strlabel+'';
        //console.log('parent not empty');
      }
      $('#tags').val(strlabel);

   }
   $(document).ready(function(e){
      gantiparents();
   });
   function gantiparents(){
      var v=$('#parent').val();
      var titles=$('#title').val();
      var strlabel=titles.toLowerCase().replace(/[^a-z0-9_-]+/gi, '-')+'';
      $.post('<?php echo base_url()?>tags/gettagsparent',{parents:v},function(e){
         if(e){
            strlabel=e+' - '+strlabel;
         }else{
            strlabel=''+strlabel;
         }
         $('#parent_label').val(e);
         $('#tags').val(strlabel);
      });
      
   }
</script>