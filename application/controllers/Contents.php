<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/*************************************
  * Created : January 2021
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class Contents extends CI_Controller {
	
		var $utama ='contents';
		var $title ='Contents';
	function __construct()
	{
		parent::__construct();
        izin();
		$this->load->library('flexigrid');
    	$this->load->helper('flexigrid');
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
                $data['type']='View';
		$data['content'] = 'contents/'.$this->utama.'/view';
		$data['js_grid']=$this->get_column();
		
		$this->load->view('layout/main',$data);
	}
        function listcol(){
            
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['title_en'] = array('Title (EN)',200,TRUE,'left',2);
            $colModel['title_id'] = array('Title (ID)',200,TRUE,'left',2);
            $colModel['createdAt'] = array('Create Date',110,TRUE,'left',2);
            return $colModel;
        }
	
	function get_column(){
	$colModel=$this->listcol();
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
           	//$buttons[] = array('select','check','btn');
            //$buttons[] = array('deselect','uncheck','btn');
            //$buttons[] = array('separator');
            //$buttons[] = array('add','add','btn');
            //$buttons[] = array('separator');
            $buttons[] = array('edit','edit','btn');
            //$buttons[] = array('delete','delete','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'id','desc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select("a.id idnya,a.*",false)->from($this->utama." a");
            //$this->db->join("setup_periode b","a.duration=b.id","left");
            //$this->db->join("labels c","a.jenjang_id=c.id","left");
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
            $colModel=$this->listcol();
            $z=0;
            foreach($colModel as $key=>$cm){
				$valid_fields[$z]=$key;
				$z++;
            }

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid();

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
					if($key=='jenjang_'){
                        $record_items[$a][$b]="<span style='color:$coloring'>".(empty($row->$key) ? 'All Video':$row->$key )."</span>";
						$b++;
					}
                    elseif($key!='id' && $key!='jenjang_'){
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
			$del=$this->db->delete($this->utama,array('id'=>$country_id));
                        if($del)$flag='ok';
                        else $flag='nook';
		}
                echo $flag;
	}
	function form($id=null){
		izin();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
                        $data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
                
		$data['opt_periode']=GetOptAll('setup_periode','-Periode-');
		$data['opt_jenjang']=GetOptAll('labels','All Video',array('parent'=>'where/1'));
		unset($data['opt_jenjang']['']);
		$data['opt_jenjang'][0]='All Video';
		ksort($data['opt_jenjang']);
		$data['content'] = 'contents/'.$this->utama.'/edit';
		
		
		$this->load->view('layout/main',$data);
	}
	function submit(){
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
		//if(!$this->input->post('status')){$data['status']='0';}
//		else{$data['is_active']='Active';}

		##image ID nih
		if (!empty($_FILES['filez_id']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/upload_contents/';
			$config['allowed_types'] = 'jpg';
			//$config['max_size']	= '10000';
			//$config['max_width']  = '1400';
			//$config['max_height']  = '1400';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if(!empty($id)){
			unlink('./assets/upload_contents/'.GetValue('image_id','contents',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('filez_id')) {
				$upload_error['error'] = $this->upload->display_errors();
                $upload_error['status_job'] ="fail";
				$data['image_id']='';

				$this->session->set_flashdata("err_code", '420');
				$this->session->set_flashdata("message", $this->upload->display_errors());
				redirect($this->utama);
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				//$data['filez']=$config['file_name'].substr($file,-4);
                $file_info['status_job']="done";
				$data['image_id']=base_url().'assets/upload_contents/'.$file_info['file_name'];
				//echo json_encode($file_info);
       		}
		}
		##image ID nih


		##image EN nih
		if (!empty($_FILES['filez_en']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/upload_contents/';
			$config['allowed_types'] = 'jpg';
			//$config['max_size']	= '10000';
			//$config['max_width']  = '1400';
			//$config['max_height']  = '1400';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if(!empty($id)){
				$photo_en=explode('/',GetValue('image_en','contents',array('id'=>'where/'.$id)));
				unlink('./assets/upload_contents/'.end($photo_en));
			}
			
			if (!$this->upload->do_upload('filez_en')) {
				$upload_error['error'] = $this->upload->display_errors();
                $upload_error['status_job'] ="fail";
				$data['image_en']='';

				$this->session->set_flashdata("err_code", '420');
				$this->session->set_flashdata("message", $this->upload->display_errors());
				redirect($this->utama);
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
                $file_info['status_job']="done";
				$data['image_en']=base_url().'assets/upload_contents/'.$file_info['file_name'];
				//echo json_encode($file_info);
       		}
		}
		##image EN nih
		
		if($id != NULL && $id != '')
		{
			if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			$data['updatedBy'] = $webmaster_id;
			$data['updatedAt']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
			$this->session->set_flashdata("err_code", '0');
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['createdBy'] = $webmaster_id;
			$data['createdAt']=date("Y-m-d");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			$this->session->set_flashdata("err_code", '0');
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect($this->utama);
		
	}

	function delete($id){
            $this->db->where('id',$id);
            $this->db->delete('sv_'.$this->utama);	
            $this->session->set_flashdata("message", 'Sukses dihapus');
            redirect($this->utama);
		
	}
	
}
?>