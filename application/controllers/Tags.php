<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/*************************************
  * Created : January 2021
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class Tags extends CI_Controller {
	
		var $utama ='tags';
		var $title ='Tags';
	function __construct()
	{
		parent::__construct();
                izin();
		$this->load->library('flexigrid');
                $this->load->helper('flexigrid');
	}
	
	function index()
	{
		//$this->main();
		$this->explorer();
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
	}
        function listcol(){
            
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['parent_'] = array('Parent',180,TRUE,'left',2);
            $colModel['title'] = array('Name',180,TRUE,'left',2);
            $colModel['tags'] = array('Tags',180,TRUE,'left',2);
            $colModel['created_on'] = array('Create Date',110,TRUE,'left',2);
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
			$this->db->where('a.deletedAt IS NULL');
            $this->db->select("a.id idnya,a.*,b.title parent_",false)->from($this->utama." a");
			$this->db->join($this->utama." b","b.id=a.parent","left");
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
			$this->db->where('deletedAt IS NULL');
            $this->db->select("count(id) as record_count")->from($this->utama);
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
		function gettagsparent(){
			$id=$this->input->post('parents');
			$a=GetValue('tags','tags',array('id'=>'where/'.$id));
			echo ($a!='0' ? $a : '');
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
			$tags=GetValue('tags','tags',array('id'=>'where/'.$country_id));
			$delete=delTags($tags);
			
			if($delete['httpcode']==204){
				//$del=$this->db->delete($this->utama,array('id'=>$country_id));
				$this->db->where('id',$country_id);
				$del=$this->db->update($this->utama,array('deletedAt'=>date('Y-m-d H:i:s')));
            		if($del)$flag='ok';
                    else $flag='nook';
			}else{
				
				$flag='nook';
			}
		}
                echo $flag;
	}
	function form($id=null,$parents=0){
		izin();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
                        $data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
                
        $data['parents']=$parents;
		$data['opt']=GetOptAll('admin_grup');
		$data['opt_tags']=GetOptTags('tags','-Tanpa Parents-');
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
		//if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		//else{$data['is_active']='Active';}
		
		if($id != NULL && $id != '')
		{
			$oldtags=GetValue('tags','tags',array('id'=>'where/'.$id));
			//$updatetags=updtags($oldtags,$data['tags']);
			//print_mz($updatetags);
			$updatetags['httpcode']=200;
			if($updatetags['httpcode']==201 || $updatetags['httpcode']==200){
				$data['modify_by'] = $webmaster_id;
				$data['modify_on']=date("Y-m-d");
				$this->db->where("id", $id);
				$this->db->update('sv_'.$this->utama, $data);
				//$q="UPDATE sv_tags SET tags=REPLACE(tags, '$oldtags', '".$data['tags']."') WHERE tags LIKE '$oldtags%' ";
				//$this->db->query($q);
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Sukses diupdate');
			}else{
				print_mz($updatetags);
				$this->session->set_flashdata("err_code", $updatetags['response'][0]->VALIDATION_ERROR);
				$this->session->set_flashdata("message", $updatetags['response'][0]->message);

			}
		}
		else
		{
			//$inserttagstobc=inserttags($data['tags']);
			//print_mz($inserttagstobc);
			$inserttagstobc['httpcode']=201;
			if($inserttagstobc['httpcode']==201){
				$data['created_by'] = $webmaster_id;
				$data['created_on'] = date("Y-m-d H:i:s");
				$this->db->insert('sv_'.$this->utama, $data);
				$id = $this->db->insert_id();
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Sukses ditambahkan');
			}else{
				$this->session->set_flashdata("err_code", $inserttagstobc['response'][0]->VALIDATION_ERROR);
				$this->session->set_flashdata("message", $inserttagstobc['response'][0]->message);

			}
		}
                
		if($this->input->post('next')) redirect($this->utama.'/form/');
		else redirect($this->utama);
		
	}

	function delete($id){
            $this->db->where('id',$id);
            $this->db->delete('sv_'.$this->utama);	
            $this->session->set_flashdata("message", 'Sukses dihapus');
            redirect($this->utama);
		
	}
	function deletes($country_id)
	{		
		
		//return true;
		//if(izin('d')){
		//$countries_ids_post_array = explode(",",$this->input->post('items'));
		//array_pop($countries_ids_post_array);
		//foreach($countries_ids_post_array as $index => $country_id){
			$label=GetValue('label','labels',array('id'=>'where/'.$country_id));
			$delete=delLabel($label);
			
			if(substr($delete['httpcode'],0,1)==2){
				//$del=$this->db->delete($this->utama,array('id'=>$country_id));
				$this->db->where('id',$country_id);
				$del=$this->db->update($this->utama,array('deletedAt'=>date('Y-m-d H:i:s')));
            		if($del)$flag='ok';
                    else $flag='nook';
			}else{
				
				$flag='nook';
			}
			echo $flag;
		//}
	}
	function explorer()
	{
                $data['type']='View';
		$data['content'] = 'contents/'.$this->utama.'/explorer';
		$data['js_grid']=$this->get_column();
		
		$this->load->view('layout/main',$data);
	}
	
}
?>