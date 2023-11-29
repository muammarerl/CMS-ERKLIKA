
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
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#id">ID</a></li>
              <li><a data-toggle="tab" href="#en">EN</a></li>
            </ul>
          <div class="tab-content">
            <div id="id" class="tab-pane fade in active">
           <div class="form-group">
            
            <?php $nm_f="title_id";?>
                        <label for="<?php echo $nm_f?>">Judul (ID)</label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" required>
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="desc_id";?>
                        <label for="<?php echo $nm_f?>">Deskripsi (ID)</label>
                        <?php echo form_textarea($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="desc_id"')?>
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="btn_txt_id";?>
                        <label for="<?php echo $nm_f?>">Button Text (ID)</label>
                        <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
            </div>

            <div class="form-group">
            
            <?php $nm_f="filez_id";?>
                        <label for="<?php echo $nm_f?>">Image (ID) (format JPG, 1400px x 1400px) <?php if(!empty($val['id'])) echo "*( Kosongkan bila tidak ingin mengganti Image"?></label>
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
            <?php if(!empty($val['image_id'])){?>
            <div class="current_img">
              Current Image
              <div class="row">
                <div class="col-md-4">
                <img id="file-ip-1-preview_en" style="max-width:100%" src="<?php echo $val['image_id']?>">
                </div>
              </div>
              </div><?php } ?>

          </div>
    <div id="en" class="tab-pane fade">
           <div class="form-group">
            
            <?php $nm_f="title_en";?>
                        <label for="<?php echo $nm_f?>">Title (EN)</label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="desc_en";?>
                        <label for="<?php echo $nm_f?>">Description (EN)</label>
                        <?php echo form_textarea($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
            </div>
           <div class="form-group">
            
            <?php $nm_f="btn_txt_en";?>
                        <label for="<?php echo $nm_f?>">Button Text (EN)</label>
                        <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
            </div>

            <div class="form-group">

            <?php $nm_f="filez_en";?>
            <label for="<?php echo $nm_f?>">Image (EN) (format JPG, 1400px x 1400px) <?php if(!empty($val['id'])) echo "*( Kosongkan bila tidak ingin mengganti Image"?></label>
            <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onchange="showPreview_en(event);" >
            
            <div class="preview_en" style="display:none">
              Preview Image
              <div class="row">
                <div class="col-md-4">
                <img id="file-ip-1-preview_en" style="max-width:100%">
                </div>
              </div>
              </div>

            </div>
          </div>
          </div>
          <hr>
          <div class="form-group">
            
            <?php $nm_f="var";?>
                        <label for="<?php echo $nm_f?>">Variable</label>
                        <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
          </div>
          <div class="form-group">
            
            <?php $nm_f="link_web";?>
                        <label for="<?php echo $nm_f?>">Link Web</label>
                        <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
          </div>

          <div class="form-group">
            
            <?php $nm_f="link_mobile";?>
                        <label for="<?php echo $nm_f?>">Link Mobile</label>
                        <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control"')?>
    		
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