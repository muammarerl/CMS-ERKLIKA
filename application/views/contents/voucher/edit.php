<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
   if($val['printed']=='yes'){
      
      echo '<script type="text/javascript">'; 
      echo 'alert("Voucher Telah Terbit, Data Tidak Dapat Diubah Kembali");';  
      echo 'window.history.back();'; 
      echo '</script>';
          exit;
   }
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
           
            
            <div class="form-group">
            
            <?php $nm_f="title";?>
                        <label for="<?php echo $nm_f?>">Voucher Description</label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required>
    		
             </div>
    		   <div class="form-group" id="package_div">
            			<?php $nm_f="package";?>
                        <label for="<?php echo $nm_f?>">Package</label>
             			<?php echo form_dropdown($nm_f,$opt_package,isset($val[$nm_f]) ? $val[$nm_f] : ''," class='form-control select2' onchange='changepackage()' id='$nm_f'")?>
                        
             </div>
    		   <div class="form-group" id="package_name_div">
            			<?php $nm_f="package_name";?>
                        <label for="<?php echo $nm_f?>">Package Name</label>
             			<?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," class='form-control' id='$nm_f' readonly")?>
                        
             </div>
    		   <div class="form-group" id="package_ax_div">
            			<?php $nm_f="package_ax";?>
                        <label for="<?php echo $nm_f?>">Kode Produk AX</label>
             			<?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," class='form-control' id='$nm_f' readonly")?>
                        
             </div>
    		   <div class="form-group" id="harga_div">
            			<?php $nm_f="price";?>
                        <label for="<?php echo $nm_f?>">Price</label>
             			<?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," class='form-control' id='$nm_f' readonly")?>
                        
             </div>
    		   <div class="form-group" id="periode_div">
            			<?php $nm_f="periode";?>
                        <label for="<?php echo $nm_f?>">Periode</label>
             			<?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," class='form-control' id='$nm_f' readonly")?>
                        
             </div>
             <!--
    		   <div class="form-group" id="package_div">
            			<?php $nm_f="type";?>
                        <label for="<?php echo $nm_f?>">Tipe</label>
             			<?php echo form_dropdown($nm_f,$opt_type,isset($val[$nm_f]) ? $val[$nm_f] : ''," class='form-control select2' onchange='changetype()' id='$nm_f' required")?>
                        
             </div>
    		   <div class="form-group" id="periode_div">
            			<?php $nm_f="periode";?>
                        <label for="<?php echo $nm_f?>">Periode</label>
             			<?php echo form_dropdown($nm_f,$opt_periode,isset($val[$nm_f]) ? $val[$nm_f] : ''," class='form-control select2' id='$nm_f'")?>
                        
             </div>
            -->
            <?php if(empty($val['id'])){?>
    		   <div class="form-group">
            			<?php $nm_f="jumlah";?>
                        <label for="<?php echo $nm_f?>">Jumlah Voucher</label>
             			<?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='form-control' id='$nm_f' required")?>
                        
             </div>
             <?php }?>
    		   <div class="form-group">
            			<?php $nm_f="expiredAt";?>
                        <label for="<?php echo $nm_f?>">Tanggal Expired</label>
             			<?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='form-control datepicker'  autocomplete='off' id='$nm_f' required")?>
                        
             </div>
    		
    		<div class="form-group">
            <!--input type="submit" name="next" value="next" class="btn pull-right"-->
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
   $(document).ready(function(){
      $('.datepicker').datepicker({
         format: 'yyyy-mm-dd',
         autoclose: true,
         todayHighlight:true
      });
         //$('#package_div').hide();
         //$('#periode_div').hide();
      //changetype();
   });
   function changepackage(){
      var package=$('#package').val();
      $.post('<?php echo base_url()?>voucher/loadpackage',{p:package},function(e){
         let balik=JSON.parse(e);
         $('#package_name').val(balik.name);
         $('#package_ax').val(balik.kode_produk_ax);
         $('#price').val(balik.price);
         $('#periode').val(balik.periode);
      });
   }
   /*
   function changetype(){
      var tp=$('#type').val();
      if(tp=='retail'){
         $('#package_div').hide();
         $('#periode_div').show();
         $("#package").val(null).trigger('change');

         $("#periode").prop('required',true);
         $("#package").removeAttr('required');
      }else if(tp=='paket'){
         $('#periode_div').hide();
         $('#package_div').show();
         $("#periode").val(null).trigger('change');

         $("#package").prop('required',true);
         $("#periode").removeAttr('required');
      }
   }*/
</script>