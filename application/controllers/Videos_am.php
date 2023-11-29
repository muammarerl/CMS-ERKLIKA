<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/*************************************
  * Created : January 2021
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class Videos extends CI_Controller {
	
		var $utama ='videos';
		var $title ='Videos';
	function __construct()
	{
		parent::__construct();
                izin();
				
		$this->load->library('flexigrid');
		$this->load->helper('flexigrid');
		// $this->load->model('Video_model');
	}
	// public function __construct() {
    //     parent::__construct(); izin();
    //     $this->load->model('video_model');
    // }
	
	
	function index()
	{
		$this->main();
		// $this->load->view('datatable/index');
		
	}
	function getconfig(){
		$a=getAuth();
		print_mz($a);
	}
	function getlabel(){
		$a=getLabel();
		print_mz($a);
	}
	function main()
	{
        $data['type']='View';
		$data['content'] = 'contents/'.$this->utama.'/view';
		$data['js_grid']=$this->get_column();
		
		$this->load->view('layout/main',$data);
		// $this->load->model('Videos_model',$data);
		// $this->Videos_model->getVideos();
	}

	function dataX()
    {
		$db = $this->load->database();
        $videos = $db->table('sv_videos');
        $videos->select('id, video_id');
		return $videos;
    }
	function data(){
		$this->load->model('video_model');
		$data = $this->video_model->get_data();
        echo json_encode($data);
	}
	public function checkDatabaseConnection()
    {
        $db = $this->load->database(); // Menginisialisasi objek database

        if ($db->db_connect()) {
            echo "Database connection successful!";
        } else {
            echo "Failed to connect to the database!";
        }
    }
        function listcol(){
            
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['ingest_status_id'] = array('Video Status (ID)',180,TRUE,'left',2);
            $colModel['ingest_status_en'] = array('Video Status (EN)',180,TRUE,'left',2,TRUE);
            $colModel['video_id'] = array('Video (ID)',180,TRUE,'left',2);
            $colModel['video_en'] = array('Video (EN)',180,TRUE,'left',2,TRUE);
            $colModel['name_id'] = array('Judul Video',180,TRUE,'left',2);
            $colModel['name_en'] = array('Name (EN)',180,TRUE,'left',2,TRUE);
            $colModel['tags_'] = array('Video Tags',150,TRUE,'left',2);
            $colModel['labels_'] = array('Video Labels',150,TRUE,'left',2);
            $colModel['createdAt'] = array('Create Date',110,TRUE,'left',2);
            $colModel['publish_'] = array('Publish Status',100,TRUE,'left',2);
            return $colModel;
        }
	
	function get_column(){
	$colModel=$this->listcol();
        
			$judul=rawurlencode($this->input->get('title'));
			$tag=rawurlencode($this->input->get('tags'));
			$label=rawurlencode($this->input->get('labels'));

            $gridParams = array(
                'rp' => 30,
                'rpOptions' => '[50,100,150,200]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE,
				'height'=>600
		);
        
            //$buttons[] = array('select','check','btn');
            //$buttons[] = array('deselect','uncheck','btn');
            //$buttons[] = array('separator');
            $buttons[] = array('create new video','add','btn');
            $buttons[] = array('delete video','delete','btn');
            $buttons[] = array('separator');
            $buttons[] = array('edit metadata','edit','btn');
            $buttons[] = array('edit in brightcove','edit','btn');
            $buttons[] = array('separator');
            $buttons[] = array('upload caption','upload','btn');
            $buttons[] = array('separator');
            $buttons[] = array('upload video (ID)','idn','btn');
            $buttons[] = array('upload poster (ID)','idn','btn');
            $buttons[] = array('upload thumbnail (ID)','idn','btn');
            //$buttons[] = array('upload video (EN)','uk','btn');
            //$buttons[] = array('upload poster (EN)','uk','btn');
            //$buttons[] = array('upload thumbnail (EN)','uk','btn');
            $buttons[] = array('separator');
            $buttons[] = array('preview','check','btn');
            $buttons[] = array('separator');
            $buttons[] = array('publish','check','btn');
            $buttons[] = array('unpublish','delete','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record?title=$judul&tags=$tag&labels=$label"),$colModel,'a.id','desc',$gridParams,$buttons);
	}
	
	function get_flexigrid($title,$tags,$labels)
        {

            //Build contents query
			
			if(!empty($title))$this->db->like('a.name_id',$title);
			//if(!empty($labels))$this->db->where('c.label_id',$labels);
            $this->db->select("a.id idnya,a.*,
			GROUP_CONCAT(DISTINCT bc.tags ORDER BY b.id) tags_,
			GROUP_CONCAT(DISTINCT cc.label ORDER BY c.id) labels_,
			IF(publish=1,'Publish','Not Publish') AS publish_ ",false)->from($this->utama." a");
			$this->db->join("sv_video_tags b","b.vid=a.id","left");
			$this->db->join("sv_tags bc","b.tag_id=bc.id AND bc.deletedAt IS NULL","left");
			$this->db->join("sv_video_labels c","c.vid=a.id","left");
			$this->db->join("sv_labels cc","c.label_id=cc.id AND cc.deletedAt IS NULL","left");
            $this->db->group_by('a.id');
			if(!empty($tags))$this->db->having("Find_In_Set('$tags',tags_) > 0 ");
			if(!empty($labels))$this->db->having("Find_In_Set('$labels',labels_) > 0 ");
			//if(!empty($labels))$this->db->where('c.label_id',$labels);
            //$this->db->group_by('b.vid');
            //$this->db->group_by('b.id');
            //$this->db->group_by('c.vid');
            //$this->db->group_by('c.id');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();
			//lastq();
            //Build count query
			if(!empty($title))$this->db->like('a.name_id',$title);
			//if(!empty($tags))$this->db->where('b.tag_id',$tags);
			//if(!empty($labels))$this->db->where('c.label_id',$labels);
            $this->db->select("count(a.id) as record_count,
			GROUP_CONCAT(DISTINCT bc.tags ORDER BY b.id) tags_,
			GROUP_CONCAT(DISTINCT cc.label ORDER BY c.id) labels_")->from($this->utama." a");
			$this->db->join("sv_video_tags b","b.vid=a.id","left");
			$this->db->join("sv_tags bc","b.tag_id=bc.id AND bc.deletedAt IS NULL","left");
			$this->db->join("sv_video_labels c","c.vid=a.id","left");
			$this->db->join("sv_labels cc","c.label_id=cc.id AND cc.deletedAt IS NULL","left");
            $this->db->group_by('a.id');
			if(!empty($tags))$this->db->having("Find_In_Set('$tags',tags_) > 0 ");
			if(!empty($labels))$this->db->having("Find_In_Set('$labels',labels_) > 0 ");
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->num_rows();

            //Get Record Count
            $return['record_count'] = (empty($row)?0:$row);

            //Return all
            return $return;
        }
		function getlabelparent(){
			$id=$this->input->post('parents');
			$a=GetValue('label','labels',array('id'=>'where/'.$id));
			echo ($a!='0' ? $a : '');
		}
	
	function get_record(){
            $colModel=$this->listcol();
            $z=0;
            foreach($colModel as $key=>$cm){
		$valid_fields[$z]=$key;
		$z++;
            }

			$title=rawurldecode($this->input->get('title'));
			$tags=rawurldecode($this->input->get('tags'));
			$labels=rawurldecode($this->input->get('labels'));

            $this->flexigrid->validate_post('a.id','DESC',$valid_fields);
            $records = $this->get_flexigrid($title,$tags,$labels);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();
            $a=0;
            $coloring='black';
            foreach ($records['records']->result() as $row)
            {
                $record_items[$a][]=$row->id;
		$record_items[$a][]=$row->id;
		$b=2;
		foreach($colModel as $key=>$cm){
                    if($key!='id'){
                        $record_items[$a][$b]="<span style='color:$coloring'>".$row->$key."</span>";
			$b++;
                    }
		}
                $a++;
            }

            return $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));;
	}  
	function deletec()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			$label=GetValue('video_id','videos',array('id'=>'where/'.$country_id));
			$labelen=GetValue('video_en','videos',array('id'=>'where/'.$country_id));
			$delete=delVideo($label);
			$deleteen=delVideo($labelen);
			
			if($delete['httpcode']==204 && $deleteen['httpcode']==204){
				$deltag=$this->db->delete('sv_video_tags',array('vid'=>$country_id));
				$dellabel=$this->db->delete('sv_video_labels',array('vid'=>$country_id));
				$del=$this->db->delete($this->utama,array('id'=>$country_id));
            		if($del)$flag='ok';
                    else $flag='nook';
			}else{
				
				$flag='nook';
			}
		}
                echo $flag;
	}
	function publish()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
				$this->db->where(array('id'=>$country_id));
				$del=$this->db->update($this->utama,array('publish'=>1));
            		if($del)$flag='ok';
                    else $flag='nook';
			
		}
                echo $flag;
	}
	function unpublish()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
				$this->db->where(array('id'=>$country_id));
				$del=$this->db->update($this->utama,array('publish'=>0));
            		if($del)$flag='ok';
                    else $flag='nook';
			
		}
                echo $flag;
	}
	function form($id=null,$lang){
		izin();
		if($lang=='en' || $lang=='id'){
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Upload Media ('.strtoupper($lang).')';
                        $data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
            redirect('videos');
		}
		$data['lang']=$lang;
		$data['opt']=GetOptAll('admin_grup');
		$data['opt_labels']=GetOptLabels('labels','-Tanpa Parents-');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		
		
		$this->load->view('layout/main',$data);
		}else{
			redirect($this->utama);
		}
	}

	function form_poster($id=null,$lang){
		izin();
		if($lang=='en' || $lang=='id'){
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Upload Media ('.strtoupper($lang).')';
                        $data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
            redirect('videos');
		}
		$data['lang']=$lang;
		$data['content'] = 'contents/'.$this->utama.'/edit_poster';
		
		
		$this->load->view('layout/main',$data);
		}else{
			redirect($this->utama);
		}
	}

	function form_caption($id=null,$lang){
		izin();
		if($lang=='en' || $lang=='id'){
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Upload Media ('.strtoupper($lang).')';
                        $data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
            redirect('videos');
		}
		$data['lang']=$lang;
		$data['content'] = 'contents/'.$this->utama.'/edit_caption';
		
		
		$this->load->view('layout/main',$data);
		}else{
			redirect($this->utama);
		}
	}
	function form_thumbnail($id=null,$lang){
		izin();
		if($lang=='en' || $lang=='id'){
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Upload Media ('.strtoupper($lang).')';
                        $data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
            redirect('videos');
		}
		$data['lang']=$lang;
		$data['content'] = 'contents/'.$this->utama.'/edit_thumbnail';
		
		
		$this->load->view('layout/main',$data);
		}else{
			redirect($this->utama);
		}
	}
	function submit(){
        //print_mz($this->input->post());
		$lang=$this->input->post('lang');
        $webmaster_id=$this->session->userdata('webmaster_id');
        $id = $this->input->post('id');
		$GetColumns = GetColumns('sv_'.$this->utama);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");

			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		//if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		//else{$data['is_active']='Active';}
		/*
		##poster nih
		if (!empty($_FILES['posterz']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/upload_poster/';
			$config['allowed_types'] = 'jpg';
			//$config['max_size']	= '10000';
			//$config['max_width']  = '1400';
			//$config['max_height']  = '1400';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if(!empty($id)){
			unlink('./assets/upload_poster/'.GetValue('poster_'.$lang,'videos',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('posterz')) {
				$upload_error['error'] = $this->upload->display_errors();
                $upload_error['status_job'] ="fail";
				$data['poster_'.$lang]='';
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				//$data['filez']=$config['file_name'].substr($file,-4);
                $file_info['status_job']="done";
				$data['poster_'.$lang]=$file_info['file_name'];
				//echo json_encode($file_info);
       		}
		}
		##poster nih
		##thumbnail nih
		if (!empty($_FILES['thumbnailz']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/upload_thumbnail/';
			$config['allowed_types'] = 'jpg';
			//$config['max_size']	= '10000';
			//$config['max_width']  = '160';
			//$config['max_height']  = '90';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if(!empty($id)){
			unlink('./assets/upload_thumbnail/'.GetValue('thumbnail','videos',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('thumbnailz')) {
				$upload_error['error'] = $this->upload->display_errors();
                $upload_error['status_job'] ="fail";
				$data['thumbnail']='';
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				//$data['filez']=$config['file_name'].substr($file,-4);
                $file_info['status_job']="done";
				$data['thumbnail']=$file_info['file_name'];
				//echo json_encode($file_info);
       		}
		}
		##thumbnail nih
		*/
		
		if(!$this->input->post('autocaption')){$auto=null;}
		if($id != NULL && $id != '')
		{
			//$oldlabel=GetValue('label','labels',array('id'=>'where/'.$id));
            //$data['filename_'.$lang]=$url=base_url().'assets/upload_video/'.$data['filename_'.$lang];
            //$data['poster_'.$lang]=$poster_url=base_url().'assets/upload_poster/'.$data['poster_'.$lang];
			$data['filename_'.$lang]=$url=base_url().'assets/upload_video/'.$data['filename_'.$lang];
            $thumb_url=base_url().'assets/upload_thumbnail/'.$data['thumbnail'];
			$ingestvideo=ingestVideo($data['video_'.$lang],$url,null,null,null,null,$auto);
			//print_mz($updatelabel);
            
			if($ingestvideo['httpcode']==201 || $ingestvideo['httpcode']==200){
				$data['updatedBy'] = $webmaster_id;
				$data['updatedAt']=date("Y-m-d");
				$data['ingest_status_'.$lang]="processing";
				$this->db->where("id", $id);
				$this->db->update('sv_'.$this->utama, $data);
				//$q="UPDATE sv_labels SET label=REPLACE(label, '$oldlabel', '".$data['label']."') WHERE label LIKE '$oldlabel%' ";
				//$this->db->query($q);
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Video Berhasil di Upload, mohon tunggu sampai video berhasil di proses');
			}else{
				//print_mz($ingestvideo);
				$this->session->set_flashdata("err_code", $ingestvideo['response'][0]->error_code);
				$this->session->set_flashdata("message", $ingestvideo['response'][0]->message);

			}
		}
                
		
		redirect($this->utama);
		
	}


	function submit_poster(){
        //print_mz($this->input->post());
		$lang=$this->input->post('lang');
        $webmaster_id=$this->session->userdata('webmaster_id');
        $id = $this->input->post('id');
		$GetColumns = GetColumns('sv_'.$this->utama);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");

			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		
		if($id != NULL && $id != '')
		{
			//$oldlabel=GetValue('label','labels',array('id'=>'where/'.$id));
            //$data['poster_'.$lang]=
			$url=base_url().'assets/upload_poster/'.$data['poster_'.$lang];
            //$data['poster_'.$lang]=$poster_url=base_url().'assets/upload_poster/'.$data['poster_'.$lang];
            //$thumb_url=base_url().'assets/upload_thumbnail/'.$data['thumbnail'];
			$ingestvideo=ingestVideo($data['video_'.$lang],null,$url,null);
			//print_mz($updatelabel);
            
			if($ingestvideo['httpcode']==201 || $ingestvideo['httpcode']==200){
				$data['updatedBy'] = $webmaster_id;
				$data['updatedAt']=date("Y-m-d");
				//$data['ingest_status_'.$lang]="processing";
				$this->db->where("id", $id);
				$this->db->update('sv_'.$this->utama, $data);
				//$q="UPDATE sv_labels SET label=REPLACE(label, '$oldlabel', '".$data['label']."') WHERE label LIKE '$oldlabel%' ";
				//$this->db->query($q);
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Poster Berhasil di Upload');
			}else{
				//print_mz($ingestvideo);
				$this->session->set_flashdata("err_code", $ingestvideo['response'][0]->error_code);
				$this->session->set_flashdata("message", $ingestvideo['response'][0]->message);

			}
		}
                
		
		redirect($this->utama);
		
	}

	function submit_thumbnail(){
        //print_mz($this->input->post());
		$lang=$this->input->post('lang');
        $webmaster_id=$this->session->userdata('webmaster_id');
        $id = $this->input->post('id');
		$GetColumns = GetColumns('sv_'.$this->utama);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");

			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		
		if($id != NULL && $id != '')
		{
			//$oldlabel=GetValue('label','labels',array('id'=>'where/'.$id));
            //$data['thumbnail_'.$lang]=
			$url=base_url().'assets/upload_thumbnail/'.$data['thumbnail_'.$lang];
            //$data['poster_'.$lang]=$poster_url=base_url().'assets/upload_poster/'.$data['poster_'.$lang];
            //$thumb_url=base_url().'assets/upload_thumbnail/'.$data['thumbnail'];
			$ingestvideo=ingestVideo($data['video_'.$lang],null,null,$url);
			//print_mz($updatelabel);
            
			if($ingestvideo['httpcode']==201 || $ingestvideo['httpcode']==200){
				$data['updatedBy'] = $webmaster_id;
				$data['updatedAt']=date("Y-m-d");
				//$data['ingest_status_'.$lang]="processing";
				$this->db->where("id", $id);
				$this->db->update('sv_'.$this->utama, $data);
				//$q="UPDATE sv_labels SET label=REPLACE(label, '$oldlabel', '".$data['label']."') WHERE label LIKE '$oldlabel%' ";
				//$this->db->query($q);
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Thumbnail Berhasil di Upload');
			}else{
				//print_mz($ingestvideo);
				$this->session->set_flashdata("err_code", $ingestvideo['response'][0]->error_code);
				$this->session->set_flashdata("message", $ingestvideo['response'][0]->message);

			}
		}
                
		
		redirect($this->utama);
		
	}

	function submit_caption(){
        //print_mz($this->input->post());
		$lang=$this->input->post('lang');
        $webmaster_id=$this->session->userdata('webmaster_id');
        $id = $this->input->post('id');
		$GetColumns = GetColumns('sv_'.$this->utama);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");

			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		//$data['caption_'.$lang]=$this->input->post('filename');
		
		if($id != NULL && $id != '')
		{
			$vid=GetAll('sv_videos',array('id'=>'where/'.$id))->row_array();
			//$oldlabel=GetValue('label','labels',array('id'=>'where/'.$id));
            $data['caption_'.$lang]=$url=base_url().'assets/captions/'.$this->input->post('filename');
            //$data['poster_'.$lang]=$poster_url=base_url().'assets/upload_poster/'.$data['poster_'.$lang];
            //$thumb_url=base_url().'assets/upload_thumbnail/'.$data['thumbnail'];
			$ingestvideo=ingestVideo($vid['video_id'],null,null,null,$data['caption_'.$lang],$lang);
			$ingestvideo=ingestVideo($vid['video_en'],null,null,null,$data['caption_'.$lang],$lang);
			//print_mz($updatelabel);
            
			if(substr($ingestvideo['httpcode'],0,1)==2){
				$data['updatedBy'] = $webmaster_id;
				$data['updatedAt']=date("Y-m-d");
				//$data['ingest_status_'.$lang]="processing";
				$this->db->where("id", $id);
				$this->db->update('sv_'.$this->utama, $data);
				//$q="UPDATE sv_labels SET label=REPLACE(label, '$oldlabel', '".$data['label']."') WHERE label LIKE '$oldlabel%' ";
				//$this->db->query($q);
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Caption Berhasil di Upload');
			}else{
				echo "<pre>";
				print_r($data);
				echo "</pre>";
				print_mz($ingestvideo);
				$this->session->set_flashdata("err_code", $ingestvideo['response'][0]->error_code);
				$this->session->set_flashdata("message", $ingestvideo['response'][0]->message);

			}
		}
                
		
		redirect($this->utama);
		
	}

	function create($id=null){
		izin();
        $filter=array();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
            $data['list']=GetAll($this->utama,$filter);
			$filters=array('vid'=>'where/'.$id);
            $listags=GetAll('sv_video_tags',$filters)->result();
			foreach($listags as $lt){
				$is_deleted=GetValue('deletedAt','sv_tags',array('id'=>'where/'.$lt->tag_id));
				if(empty($is_deleted)){
					$data['tags'][]=$lt->tag_id;
				}
			}
            $listlabel=GetAll('sv_video_labels',$filters)->result();
			foreach($listlabel as $ll){
				$is_deleted=GetValue('deletedAt','sv_labels',array('id'=>'where/'.$ll->label_id));
				if(empty($is_deleted)){
					$data['labels'][]=$ll->label_id;
				}
			}
                        //redirect('videos');
		}
		else{
			$data['type']='New';
		}
                
		$data['opt']=GetOptAll('admin_grup');
		$data['opt_tags']=GetOptTags('tags','-Tags-');
		$data['opt_labels']=GetOptLabels('labels','-Labels-');
		$data['opt_jenjang']=GetOptLabels('labels','-Labels-',array('parent'=>'where/1'));
		$data['opt_topik']=GetOptLabels('labels','-Labels-',array('parent'=>'where/2'));
		$data['opt_konten']=GetOptLabels('labels','-Labels-',array('parent'=>'where/3'));
		$data['opt_khusus']=GetOptLabels('labels','-Labels-',array('parent'=>'where/4'));
        unset($data['opt_labels']['']);
        unset($data['opt_tags']['']);
		$data['content'] = 'contents/'.$this->utama.'/create';
		
		
		$this->load->view('layout/main',$data);
	}
	function create_submit(){
        $webmaster_id=$this->session->userdata('webmaster_id');
        $id = $this->input->post('id');
		$GetColumns = GetColumns('sv_'.$this->utama);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");

			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		if(!$this->input->post('free')){$data['free']=0;}
		if(!$this->input->post('recommended')){$data['recommended']=0;}
		if(!$this->input->post('show_homepage')){$data['show_homepage']=0;}
		//hide english
		$data['name_en']=$data['name_id'];
		$data['description_en']=$data['description_id'];
		//$data['video_id']=$data['video_en'];
		//
		//else{$data['is_active']='Active';}
        $label=$tags=$datalabel=$datatag=array();
        foreach($this->input->post('labels') as $lbl){
            $label[]=GetValue('label','labels',array('id'=>'where/'.$lbl));
        }
        foreach($this->input->post('jenjang') as $lbl){
            $label[]=GetValue('label','labels',array('id'=>'where/'.$lbl));
        }
        foreach($this->input->post('konten') as $lbl){
            $label[]=GetValue('label','labels',array('id'=>'where/'.$lbl));
        }
        foreach($this->input->post('topik') as $lbl){
            $label[]=GetValue('label','labels',array('id'=>'where/'.$lbl));
        }
        foreach($this->input->post('tags') as $tag){
            $tags[]=GetValue('tags','tags',array('id'=>'where/'.$tag));
        }
            if(!empty($id) && $id>0){
                $updatevideo_id=insertVideo('PATCH',$data['name_id'],$data['description_id'],$label,$data['video_id'],$tags);
                $updatevideo_en=insertVideo('PATCH',$data['name_en'],$data['description_en'],$label,$data['video_en'],$tags);
                //print_mz($updatevideo_id);
                if(substr($updatevideo_id['httpcode'],0,1)==2 && substr($updatevideo_en['httpcode'],0,1)==2){
				    $data['labels'] = json_encode($data['labels']);
                    $data['updatedBy'] = $webmaster_id;
                    $data['updatedAt']=date("Y-m-d");
                    $this->db->where("id", $id);
                    $this->db->update('sv_'.$this->utama, $data);
					
                    $this->db->where("vid", $id);
					$this->db->delete('video_tags');
					
                    $this->db->where("vid", $id);
					$this->db->delete('video_labels');
					$a=$b=0;
					foreach($this->input->post('labels') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					foreach($this->input->post('jenjang') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					foreach($this->input->post('konten') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					foreach($this->input->post('topik') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					foreach($this->input->post('labels') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					$this->db->insert_batch('video_labels', $datalabel); 
					
					foreach($this->input->post('tags') as $tag){
						$datatag[$b]['vid']=$id;
						$datatag[$b]['tag_id']=$tag;
						$b++;
					}
					$this->db->insert_batch('video_tags', $datatag); 

                    $this->session->set_flashdata("err_code", '0');
                    $this->session->set_flashdata("message", 'Sukses diupdate');
                }else{
                    $this->session->set_flashdata("err_code", $updatevideo_id['response'][0]->VALIDATION_ERROR);
                    $this->session->set_flashdata("message", $updatevideo_id['response'][0]->message);
    
                }
                
                redirect($this->utama);
            }else{
                $insertvideotobc_id=insertVideo('POST',$data['name_id'],$data['description_id'],$label,null,$tags);
                $insertvideotobc_en=insertVideo('POST',$data['name_en'],$data['description_en'],$label,null,$tags);
			    
			    if(substr($insertvideotobc_id['httpcode'],0,1)==2 && substr($insertvideotobc_en['httpcode'],0,1)==2){
				    $data['labels'] = json_encode($data['labels']);
				    $data['video_id'] = $insertvideotobc_id['response'][0]->id;
				    $data['video_en'] = $insertvideotobc_en['response'][0]->id;
				    $data['ingest_status_id']="not upload yet";
				    $data['ingest_status_en']="not upload yet";
				    $data['createdBy'] = $webmaster_id;
				    $data['createdAt'] = date("Y-m-d H:i:s");
				    $this->db->insert('sv_'.$this->utama, $data);
				    $id = $this->db->insert_id();

					$a=$b=0;
					foreach($this->input->post('jenjang') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					foreach($this->input->post('konten') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					foreach($this->input->post('topik') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					foreach($this->input->post('labels') as $lbl){
						$datalabel[$a]['vid']=$id;
						$datalabel[$a]['label_id']=$lbl;
						$a++;
					}
					$this->db->insert_batch('video_labels', $datalabel); 
					
					foreach($this->input->post('tags') as $tag){
						$datatag[$b]['vid']=$id;
						$datatag[$b]['tag_id']=$tag;
						$b++;
					}
					$this->db->insert_batch('video_tags', $datatag); 
					
				    $this->session->set_flashdata("err_code", '0');
				    $this->session->set_flashdata("message", 'Video Berhasil Dibuat, Silakan Upload Media yang Dibutuhkan');
                    redirect($this->utama);
			    }else{
				    $this->session->set_flashdata("err_code", $insertvideotobc_id['response'][0]->VALIDATION_ERROR.' - '.$insertvideotobc_en['response'][0]->VALIDATION_ERROR);
				    $this->session->set_flashdata("message", $insertvideotobc_id['response'][0]->message.' - '.$insertvideotobc_en['response'][0]->message);
                    redirect($this->utama);

			    }
            }
		
                
		
		
	}

	function delete($id){
            $this->db->where('id',$id);
            $this->db->delete('sv_'.$this->utama);	
            $this->session->set_flashdata("message", 'Sukses dihapus');
            redirect($this->utama);
		
	}
    function upload_poster(){
        
		##image nih
		if (!empty($_FILES['filez']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/upload_poster/';
			$config['allowed_types'] = 'jpeg|jpg';
			//$config['max_size']	= '10000';
			//$config['max_width']  = '1900';
			//$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			//if(!empty($id)){
			//unlink('./assets/ace/avatars/'.GetValue('avatar','admin',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('filez')) {
				$upload_error['error'] = $this->upload->display_errors();
                $upload_error['status_job'] ="fail";
				echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				//$data['filez']=$config['file_name'].substr($file,-4);
				$this->load->library('image_lib');
				$configer = array(
					'image_library' => 'gd2',
					'source_image' => $file_info['full_path'],
					'create_thumb' => FALSE,//tell the CI do not create thumbnail on image
					'maintain_ratio' => FALSE,
					'quality' => '100%', //tell CI to reduce the image quality and affect the image size
					'width' => 1488,//new size of image
					'height' => 536,//new size of image
				);
				$this->image_lib->clear();
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();

                $file_info['status_job']="done";
				echo json_encode($file_info);
       		}
		}
		##image nih
		
    }
    function upload_caption(){
        
		##image nih
		if (!empty($_FILES['filez']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/captions/';
			$config['allowed_types'] = 'vtt';
			//$config['max_size']	= '10000';
			//$config['max_width']  = '1900';
			//$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			//if(!empty($id)){
			//unlink('./assets/ace/avatars/'.GetValue('avatar','admin',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('filez')) {
				$upload_error['error'] = $this->upload->display_errors();
                $upload_error['status_job'] ="fail";
				echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				//$data['filez']=$config['file_name'].substr($file,-4);

                $file_info['status_job']="done";
				echo json_encode($file_info);
       		}
		}
		##image nih
		
    }

    function upload_thumbnail(){
        
		##image nih
		if (!empty($_FILES['filez']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/upload_thumbnail/';
			$config['allowed_types'] = 'jpeg|jpg';
			//$config['max_size']	= '10000';
			//$config['max_width']  = '1900';
			//$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			//if(!empty($id)){
			//unlink('./assets/ace/avatars/'.GetValue('avatar','admin',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('filez')) {
				$upload_error['error'] = $this->upload->display_errors();
                $upload_error['status_job'] ="fail";
				echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				//$data['filez']=$config['file_name'].substr($file,-4);
				$this->load->library('image_lib');
				$configer = array(
					'image_library' => 'gd2',
					'source_image' => $file_info['full_path'],
					'create_thumb' => FALSE,//tell the CI do not create thumbnail on image
					'maintain_ratio' => FALSE,
					'quality' => '100%', //tell CI to reduce the image quality and affect the image size
					'width' => 364,//new size of image
					'height' => 165,//new size of image
				);
				$this->image_lib->clear();
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();
                $file_info['status_job']="done";
				echo json_encode($file_info);
       		}
		}
		##image nih
		
    }
    function upload_video(){
        
			ini_set("memory_limit", "10056M");
			set_time_limit(0);
			ini_set('max_execution_time', '0');
		##image nih
		if (!empty($_FILES['filez']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/upload_video/';
			$config['allowed_types'] = 'mp4';
			//$config['max_size']	= '10000';
			//$config['max_width']  = '1900';
			//$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			//if(!empty($id)){
			//unlink('./assets/upload_video/'.GetValue('video','admin',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('filez')) {
				$upload_error['error'] = $this->upload->display_errors();
                $upload_error['status_job'] ="fail";
				echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				//$data['filez']=$config['file_name'].substr($file,-4);
                $file_info['status_job']="done";
				echo json_encode($file_info);
       		}
		}
		##image nih
		
    }

	function player($id=null,$lang='en'){
		izin();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Upload Media ('.strtoupper($lang).')';
                        $data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		$data['lang']=$lang;
		$data['content'] = 'contents/'.$this->utama.'/player';
		
		
		$this->load->view('layout/main',$data);
		
	}
	
}
?>