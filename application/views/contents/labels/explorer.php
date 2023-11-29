<style>
    /* Remove default bullets */
ul, #myUL {
  list-style-type: none;
}

/* Remove margins and padding from the parent ul */
#myUL {
  margin: 0;
  padding: 0;
  font-size:20pt;
}

/* Style the caret/arrow */
.caret {
  cursor: pointer;
  user-select: none; /* Prevent text selection */
}

/* Create the caret/arrow with a unicode, and style it */
.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

/* Rotate the caret/arrow icon when clicked on (using JavaScript) */
.caret-down::before {
  transform: rotate(90deg);
}

/* Hide the nested list */
.nested {
  display: none;
}

/* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
.active {
  display: block;
}
.nested >li{
    margin-left:50px;    
}

/* .i:hover{
  background-color: white;
} */

</style>
<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
$parentro=isset($val['id']) ? "disabled='disabled'":"";
?>

    <?php $getparents=GetAll('labels',array('parent'=>'where_is_null/1'));
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
    <div class="col-lg-12 mt-5">
      <div class="card">
        <div class="card-body">
          <nav>
              <div class="nav nav-tabs justify-content-end" id="nav-tab" role="tablist">
                  <?php foreach($getparents->result() as $parent) { ?>
                      <a class="nav-item nav-link" id="nav-<?php echo $parent->id ?>-tab" data-toggle="tab" href="#nav-<?php echo $parent->id ?>" role="tab" aria-controls="nav-<?php echo $parent->id ?>" aria-selected="true"><?php echo $parent->title ?></a>
                  <?php } ?>
              </div>
          </nav>
          <div class="tab-content mt-3" id="nav-tabContent">
              <?php foreach($getparents->result() as $parent) { ?>
                  <div class="tab-pane fade" id="nav-<?php echo $parent->id ?>" role="tabpanel" aria-labelledby="nav-<?php echo $parent->id ?>-tab">         
                      <div class="single-table">
                          <div class="table-responsive">
                              <table class="table table-hover progress-table">
                                  <thead class="text-uppercase">
                                      <tr>
                                          <th scope="col">labels</th>
                                          <th scope="col">Link</th>
                                          <th scope="col">action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php 
                                    $getchild = GetAll('labels', array('parent' => 'where/'.$parent->id, 'deletedAt' => 'where_is_null/1'));
                                    foreach($getchild->result() as $child) { ?>
                                      <tr>
                                          <td><?php echo $child->title ?></td>
                                          <td><?php echo $child->label ?></td>
                                          <td>
                                              <ul class="d-flex">
                                                  <!-- <li class="mr-3"><a href="<?php echo base_url('labels/form/').$child->id ?>" class="text-secondary"><i class="fa fa-edit"></i></a></li> -->
                                                  <li><a href="#" onclick="ondelete(<?php echo $child->id ?>)" class="text-danger"><i class="ti-trash"></i></a></li>
                                                    <li>
                                                        <button type="button" class="btn btn-primary btn-flat btn-lg mt-3" data-toggle="modal" data-target="#exampleModalCenter-<?php echo $child->id ?>">Launch demo modal</button>
                                                        <div class="modal fade" id="exampleModalCenter-<?php echo $child->id ?>">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <?php error_reporting(E_ALL ^ E_NOTICE);
                                                            if(isset($list)){	
                                                                $val=$list->row_array();
                                                            }
                                                            $parentro=isset($val['id']) ? "disabled='disabled'":"";
                                                            ?>
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Modal title</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit">
                                                                            <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
                                                                            <div class="form-group" style="display:none">
                                                                                <?php $nm_f="parent";?>
                                                                                <label for="parents">Parents</label>
                                                                                <?php echo form_dropdown($nm_f,$opt_labels,isset($val[$nm_f]) ? $val[$nm_f] : $parents," data-rel='chosen' class='form-control select2' onChange='gantiparents()' id='$nm_f' $parentro")?>
                                                                                <input type="text" name="parent_label"  id="parent_label" value="<?php echo (isset($val['id']) && GetValue('label','labels',array('id'=>'where/'.$val['parent']))!='0' ?  GetValue('label','labels',array('id'=>'where/'.$val['parent'])):'') ?>" class="form-control" style="display:none">            
                                                                            </div>
                                                                            <div class="form-group">
                                                                            <?php $nm_f="title";?>
                                                                                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                                                                                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required>
                                                                            
                                                                            </div>
                                                                            <div class="form-group">
                                                                            
                                                                            <?php $nm_f="label";?>
                                                                                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                                                                                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" readonly='readonly'>
                                                                            
                                                                            </div>
                                                                        <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                        <!-- <div class="form-group">
                                                                        <button type="submit" class="btn pull-right">Submit</button> -->
                                                                        </form>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                              </ul>
                                          </td>
                                      </tr><?php } ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      
                  </div>
              <?php } ?>
          </div>
      </div>
      </div>
    </div>

<script>
    var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}

function ondelete(id){
    if(confirm('Yakin Menghapus Item Ini?')){

                $.ajax({
					   type: "POST",
					   url: "<?php echo site_url($this->utama);?>/deletes/"+id,
					   success: function(data){
						//alert(data);
						if(data=='ok'){
						alert('Sukses!');}
						else{
							alert('Failed to Delete Data');
						}
                        window.location.reload();
					   }
					});
			} else {
				return false;
			} 
}
</script>
<script>
   function generatelabel(){
      var parentz = $('#parent_label').val();
      var f = $('#title').val();
      var strlabel=f.toLowerCase().replace(/[^a-z0-9_-]+/gi, '-');
      //alert(f);
      if(!parentz || parentz.length === 0){
         strlabel='/'+strlabel+'/';
        //console.log('parent empty');
      }else{
         strlabel=parentz+strlabel+'/';
        //console.log('parent not empty');
      }
      $('#label').val(strlabel);

   }
   $(document).ready(function(e){
      gantiparents();
   });
   function gantiparents(){
      var v=$('#parent').val();
      var titles=$('#title').val();
      var strlabel=titles.toLowerCase().replace(/[^a-z0-9_-]+/gi, '-')+'/';
      $.post('<?php echo base_url()?>labels/getlabelparent',{parents:v},function(e){
         if(e){
            strlabel=e+strlabel;
         }else{
            strlabel='/'+strlabel;
         }
         $('#parent_label').val(e);
         $('#label').val(strlabel);
      });
      
   }
</script>
