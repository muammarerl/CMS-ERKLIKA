
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='<?php echo base_url()?>assets/ckeditor/ckeditor.js'></script> 
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
            
          <div class="tab-content">
            <div id="id" class="tab-pane fade in active">
           <div class="form-group">
            
            <?php $nm_f="title";?>
                        <label for="<?php echo $nm_f?>">Judul</label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" required>
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="description";?>
                        <label for="<?php echo $nm_f?>">Deskripsi</label>
                        <?php echo form_textarea($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="desc_id"')?>
    		
            </div>

            <div class="form-group">
            
            <?php $nm_f="filez_id";?>
                        <label for="<?php echo $nm_f?>">Image (format JPG, 328px x 185px) <?php if(!empty($val['id'])) echo "*( Kosongkan bila tidak ingin mengganti Image"?></label>
                        <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control"   onchange="showPreview(event);">
    		
             </div>
             
             <div class="preview" style="display:none">
              Preview Image
              <div class="row">
                <div class="col-md-4">
                <img id="file-ip-1-preview" style="max-width:100%">
                </div>
              </div>
              </div>

          </div>
    
          </div>
          <hr>
          <div class="form-group">
            
            <?php $nm_f="android_url";?>
                        <label for="<?php echo $nm_f?>">Android URL</label>
                        <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
          </div>

          <div class="form-group">
            
            <?php $nm_f="ios_url";?>
                        <label for="<?php echo $nm_f?>">iOS URL</label>
                        <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
            </div>
          <div class="form-group">
            
            <?php $nm_f="other_url";?>
                        <label for="<?php echo $nm_f?>">Other URL</label>
                        <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
            </div>
            <div class="form-group">
            <?php $nm_f="status";?>
                        <label for="<?php echo $nm_f?>">Status</label>
                        <?php echo form_checkbox($nm_f,1,(isset($val[$nm_f]) && $val[$nm_f]==1 ? TRUE : FALSE),'class="" id="'.$nm_f.'" ')?>
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
  for (var i in CKEDITOR.instances) {
               
               CKEDITOR.instances[i].on('change', function() { CKEDITOR.instances[i].updateElement() });
              
      }
CKEDITOR.replace( 'desc_id',
{
  /*
toolbar :
[
['Source','-','Copy','Paste','Bold','Italic','Underline','Strike','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Subscript','Superscript','PasteFromWord']
]*/
});
function showPreview(event){
  if(event.target.files.length > 0){
    $('.preview').show();
    var src = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("file-ip-1-preview");
    preview.src = src;
    preview.style.display = "block";
  }else{
    $('.preview').hide();
  }
}
function showPreview_en(event){
  if(event.target.files.length > 0){
    $('.preview_en').show();
    var src = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("file-ip-1-preview_en");
    preview.src = src;
    preview.style.display = "block";
  }else{
    $('.preview_en').hide();
  }
}
</script>