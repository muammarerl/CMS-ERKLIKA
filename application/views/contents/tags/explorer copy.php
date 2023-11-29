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
    <div class="row">
        <div class="col-md-12">
      <div class="card">
       <div class="card-body">
<ul id="myUL" class="col-md-8" style="margin-top:5%">
    <?php foreach($getparents->result() as $parent){?>
  <li><span class="caret"><?php echo $parent->title ?></span>
     <a href="<?php echo base_url('tags/form/0/').$parent->id ?>"><i class="fa fa-plus" title="Add Tag"></i></a>
    <ul class="nested">
        
    <?php $getchild=GetAll('tags',array('parent'=>'where/'.$parent->id,'deletedAt'=>'where_is_null/1'));
    ?>
    <?php foreach($getchild->result() as $child){?>
      <li> <a href="<?php echo base_url('tags/form/').$child->id ?>"><i class="fa fa-edit" title="Edit Tag"></i></a>  <a href="#" onclick="ondelete(<?php echo $child->id ?>)"><i class="fa fa-trash"  title="Delete Tag"></i></a><span class="col-md-5"><?php echo $child->title?></span></li>
     <?php }?>
    </ul>
  </li><?php }?>
</ul>
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