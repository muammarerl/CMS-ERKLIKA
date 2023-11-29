<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : January 2021
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.3.1.1
*************************************/	

class Admin extends CI_Controller {
	
	var $utama ='admin';
	var $title ='Akun Admin';

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
            $colModel['username'] = array('Userame',110,TRUE,'left',2);
            $colModel['name'] = array('Name',110,TRUE,'left',2);
            $colModel['role'] = array('Role',110,TRUE,'left',2);
            $colModel['is_active'] = array('Status',110,TRUE,'left',2);
            $colModel['create_date'] = array('Date Registered',110,TRUE,'left',2);
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
        
           $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
             $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
            $buttons[] = array('separator');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select("a.id,a.id idnya,a.username,a.name,a.is_active,a.create_date,b.title role",false)->from($this->utama." a");
            $this->db->join("sv_admin_grup b","b.id=a.id_admin_grup","left");
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
			$del=$this->db->delete($this->utama,array('id'=>$country_id));
                        if($del)$flag='ok';
                        else $flag='nook';
		}
                echo $flag;
	}
	function form($id=null){
		//izin();
		izin();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
		$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
                $data['opt']=GetOptAll('admin_grup');
		//$data['opt_marketing']=GetOptAll('master_sales','-Marketing-',array(),'name');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		//End Global
		
		//Attendance
		
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
	if($id!=$this->session->userdata('webmaster_id')){	
		if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		else{$data['is_active']='Active';}
	}
		
		##image nih
		if (!empty($_FILES['avatar']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/ace/avatars/';
			$config['allowed_types'] = 'gif|jpg|png|ico';
			$config['max_size']	= '10000';
			$config['max_width']  = '1900';
			$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if($id != NULL && $id != ''){
			unlink('./assets/ace/avatars/'.GetValue('avatar','admin',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('avatar')) {
				$upload_error = $this->upload->display_errors();
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				$data['avatar']=$config['file_name'].substr($file,-4);
				//echo json_encode($file_info);
       		}
		}
		##image nih
		
		
		if($id != NULL && $id != '')
		{
			if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			if (empty($_FILES['avatar']['name'])) {unset($data['avatar']);}
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			$profil['name']=$data['name'];
			$profil['email']=$this->input->post('email');
                        if(isset($data['avatar'])){
                            $profil['avatar']=$data['avatar'];
                        }
			$profil['modify_user_id'] = $webmaster_id;
			$profil['modify_date'] = $data['create_date'];
                        $this->db->where('useradmin',$id);
			$this->db->update('sv_admin_profile',$profil);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			if (empty($_FILES['avatar']['name'])) {$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			$profil['useradmin']=$id;
			$profil['name']=$data['name'];
			$profil['email']=$this->input->post('email');
			$profil['avatar']=$data['avatar'];
			$profil['create_user_id'] = $webmaster_id;
			$profil['create_date'] = $data['create_date'];
			$this->db->insert('sv_admin_profile',$profil);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect($this->utama);
		
	}
	function profile($id=null){
		
		
		//izin();
		permissionFormUser($id);
		if($id!=NULL){
			$filter=array('useradmin'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll('sv_admin_profile',$filter);
		}
		else{
			$data['type']='New';
		}
		$data['opt']=GetOptAll('admin_grup');
		$data['content'] = 'contents/'.$this->utama.'/profile';
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	function submit_profile(){
		$webmaster_id=$this->session->userdata('webmaster_id');
		$id = $this->input->post('id');
		$GetColumns = GetColumns('sv_admin_profile');
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		/* if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		else{$data['is_active']='Active';} */
		
		##image nih
		if (!empty($_FILES['avatar']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/ace/avatars/';
			$config['allowed_types'] = 'gif|jpg|png|ico';
			$config['max_size']	= '10000';
			$config['max_width']  = '1900';
			$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if($id != NULL && $id != ''){
					$foto=GetValue('avatar','admin_profile',array('useradmin'=>'where/'.$id));
					if($foto!='default.png'){
						unlink('./assets/ace/avatars/'.GetValue('avatar','admin_profile',array('id'=>'where/'.$id)));
					}
			}
			
			if (!$this->upload->do_upload('avatar')) {
				$upload_error = $this->upload->display_errors();
				echo json_encode($upload_error);
                                die();
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				$data['avatar']=$config['file_name'].substr($file,-4);
				//echo json_encode($file_info);
       		}
		}
		##image nih
		
		
		if($id != NULL && $id != '')
		{
			if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){unset($data['avatar']);}
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_admin_profile', $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_admin_profile', $data);
			$id = $this->db->insert_id();
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect('admin/form/'.$id);
		
	}
	function delete($id){
	$this->db->where('id',$id);
	$this->db->delete('sv_'.$this->utama);	
			$this->session->set_flashdata("message", 'Sukses dihapus');
		redirect($this->utama);
		
	}
	
}
?>