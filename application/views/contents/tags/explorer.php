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
    margin-left:20px;
}
</style>
    <?php $getparents=GetAll('tags',array('parent'=>'where_is_null/1'));
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
    <!-- <div class="row">
        <div class="col-md-12">
      <div class="card">
       <div class="card-body">

    </div>
    </div>
    </div>
    </div> -->

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
                                          <th scope="col">Tags</th>
                                          <th scope="col">Link</th>
                                          <th scope="col">action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php 
                                    $getchild = GetAll('tags', array('parent' => 'where/'.$parent->id, 'deletedAt' => 'where_is_null/1'));
                                    foreach($getchild->result() as $child) { ?>
                                      <tr>
                                          <td><?php echo $child->title ?></td>
                                          <td><?php echo $child->tags ?></td>
                                          <td>
                                              <ul class="d-flex">
                                                  <li class="mr-3"><a href="<?php echo base_url('tags/form/').$child->id ?>" class="text-secondary"><i class="fa fa-edit"></i></a></li>
                                                  <li><a href="#" onclick="ondelete(<?php echo $child->id ?>)" class="text-danger"><i class="ti-trash"></i></a></li>
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