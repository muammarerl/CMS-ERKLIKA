<style>
.progress 
{
  display:none; 
  position:relative; 
  width:400px; 
  border: 1px solid #ddd; 
  padding: 1px; 
  border-radius: 3px; 
}
.bar 
{ 
  background-color: #B4F5B4; 
  width:0%; 
  height:20px; 
  border-radius: 3px; 
}
.percent 
{ 
  position:absolute; 
  display:inline-block; 
  top:3px; 
  left:48%; 
}
</style>
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
       <form method="post" id="formupload" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit">
            <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
            <?php echo form_hidden('lang',isset($lang) ? $lang : '')?>
           
            
            <div
  style="width: 960px; height: 540px;">
  <video-js
    data-account="6281094274001"
    data-player="default"
    data-embed="default"
    data-video-id="<?php echo $val['video_id']?>"
    controls=""
    data-application-id=""
    width="960" height="540"
    class="vjs-fill"></video-js>
  <script
    src="//players.brightcove.net/6281094274001/default_default/index.min.js">
  </script>
</div>
    	</div>
    	
    </div>
    </div>
</div>
   </div>
 </div>
</div>
<script>
function _(el) {
  return document.getElementById(el);
}

function uploadFile() {
  $('#progressBar').show();
  var file = _("filez").files[0];
  //let myForm = document.getElementById('formupload');
  //var formData = new FormData(myForm);
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData();
  formdata.append("filez", file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "<?php echo base_url()?>videos/upload_video/<?php echo $lang?>"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
  //use file_upload_parser.php from above url
  ajax.send(formdata);
}

function progressHandler(event) {
  _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
  //_("status").innerHTML = event.target.responseText;
  //_("progressBar").value = 0; //wil clear progress bar after successful upload
  //alert(event.target.responseText);
  //window.location = '<?php echo base_url()?>/videos';
  let balik=JSON.parse(event.target.responseText);
  if(balik.status_job=='done'){
    $("#filename").val(balik.file_name);
    $('#filez').attr('disabled', 'disabled');
    $("#formupload").submit(
      //function(){
     // 
      //return true;
      //}
    );
  }else{
    alert(balik.error);
  }
  $('#progressBar').hide();
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}

</script>