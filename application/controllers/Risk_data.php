<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : January 2021
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Risk_data extends CI_Controller {
	
		var $utama ='risk_data';
		var $title ='Risk Data';
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
                $divarr=array();
                //$userarr=array();
                if(!diaadmin()){
                    $divarr=array('id'=>'where/'.GetValue('divisi','sv_admin',array('id'=>'where/'.webmasterid())));
                    //$userarr=array('divisi'=>'where/'.GetValue('divisi','sv_admin',array('id'=>'where/'. webmasterid())));
                    
                }
                
                $id_register=(isset($_GET['id_register']) && $_GET['id_register']!=NULL ? $_GET['id_register']:'--');
                $jenis_risk=(isset($_GET['jenis_risk']) && $_GET['jenis_risk']!=NULL ? $_GET['jenis_risk']:'--');
                $divisi=(isset($_GET['divisi']) && $_GET['divisi']!=NULL ? $_GET['divisi']:'--');
                $data['type']='View';
		$data['content'] = 'contents/'.$this->utama.'/view';
		$data['js_grid']=$this->get_column($id_register,$jenis_risk,$divisi);
                $data['opt_risk']=GetOptAll('ref_risk','-Jenis Resiko-');
                $data['opt_divisi']=GetOptAll('ref_divisi','-Divisi-',$divarr);
		
		$this->load->view('layout/main',$data);
	}
        function listcol(){
            
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['status_risk'] = array('Open/Close',110,TRUE,'left',2);
            $colModel['id_register'] = array('ID Reg',110,TRUE,'left',2);
            $colModel['tgl_register_'] = array('Tgl Reg',110,TRUE,'left',2);
            $colModel['risk_desc'] = array('Risk Desc',110,TRUE,'left',2);
            $colModel['risk_owner_'] = array('Risk Owner',110,TRUE,'left',2);
            $colModel['risk_identifier_'] = array('Risk Identifier',110,TRUE,'left',2);
            $colModel['pic_'] = array('PIC User',110,TRUE,'left',2);
            $colModel['divisi_'] = array('Department',110,TRUE,'left',2);
            $colModel['created_on_'] = array('Create Date',110,TRUE,'left',2);
            $colModel['app_by_'] = array('Approved By',110,TRUE,'left',2);
            $colModel['app_date_'] = array('Approved Date',110,TRUE,'left',2);
            return $colModel;
        }
	
	function get_column($id_register,$jenis_risk,$divisi){
	$colModel=$this->listcol();
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
            if(!diaojk()){
            $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
            $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
            }else{
                $buttons[] = array('view','edit','btn');
            }
            if(diaadmin()){
                $buttons[] = array('separator');
                $buttons[] = array('approve','approve','btn');
            }
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record/$id_register/$jenis_risk/$divisi"),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid($id_register,$jenis_risk,$divisi)
        {

            //Build contents query
            $this->db->select("a.id idnya,a.*,DATE_FORMAT(a.tgl_register,'%d/%m/%Y') tgl_register_,DATE_FORMAT(a.created_on,'%d/%m/%Y') created_on_,b.title divisi_,c.name risk_owner_,d.name risk_identifier_,e.name pic_,f.name app_by_,DATE_FORMAT(a.app_date,'%d/%m/%Y') app_date_",false)->from($this->utama." a");
            $this->db->join("sv_ref_divisi b","b.id=a.divisi","left");
            $this->db->join("sv_admin c","c.id=a.risk_owner","left");
            $this->db->join("sv_admin d","d.id=a.risk_identifier","left");
            $this->db->join("sv_admin e","e.id=a.created_by","left");
            $this->db->join("sv_admin f","f.id=a.app_by","left");
            if(!diaadmin() && !diaojk())$this->db->where('a.created_by', webmasterid());
            if($id_register!='--')$this->db->like('a.id_register', $id_register);
            if($jenis_risk!='--')$this->db->where('a.jenis_risk', $jenis_risk);
            if($divisi!='--')$this->db->where('a.divisi', $divisi);
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
            if(!diaadmin() && !diaojk())$this->db->where('created_by', webmasterid());
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record($id_register,$jenis_risk,$divisi){
            $colModel=$this->listcol();
            $z=0;
            foreach($colModel as $key=>$cm){
		$valid_fields[$z]=$key;
		$z++;
            }

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid($id_register,$jenis_risk,$divisi);

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
        
	function upload($id=null){
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
		$data['content'] = 'contents/'.$this->utama.'/upload_xls';
		
		
		$this->load->view('layout/main',$data);
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
                $divarr=array();
                $userarr=array();
                if(!diaadmin()){
                    $divarr=array('id'=>'where/'.GetValue('divisi','sv_admin',array('id'=>'where/'.webmasterid())));
                    $userarr=array('divisi'=>'where/'.GetValue('divisi','sv_admin',array('id'=>'where/'. webmasterid())));
                    
                }
                
                $data['opt_user']=GetOptAll('sv_admin','-User-',$userarr,'name','id');
                $data['opt_user_owner']=GetOptAll('sv_admin','-User-',$userarr,'name','id');
                $data['opt_risk']=GetOptAll('ref_risk','-Jenis Resiko-');
                $data['opt_divisi']=GetOptAll('ref_divisi','-Divisi-',$divarr);
                $data['opt_impact']=GetOptAll('ref_impact','-Impact-',array(),'num_val','id','title');
                $data['opt_probability']=GetOptAll('ref_probability','-Probability-',array(),'num_val','id','title');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		
		
		$this->load->view('layout/main',$data);
	}
	function submit(){
                $webmaster_id=$this->session->userdata('webmaster_id');
                $id = $this->input->post('id');
		$GetColumns = GetColumns('sv_risk_data');
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");

			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		//if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		//else{$data['is_active']='Active';}
		$data['tgl_register']= tglsistem($this->input->post('tgl_register'));
                
                
		if($id != NULL && $id != '')
		{
			if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			$data['modify_by'] = $webmaster_id;
			$data['modify_on']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
                    
                        $data['id_register']=generatenumbering($this->input->post('divisi'));
			if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['created_by'] = $webmaster_id;
			$data['created_on'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
                        addnumbering($data['divisi']);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect($this->utama);
		
	}
        public function upload_submit(){
        //error_reporting(0);
        $data = array();
        $data['title'] = 'Import Excel Sheet | TechArise';
        $data['breadcrumbs'] = array('Home' => '#');
            // If file uploaded
        //die('disini');
            if(!empty($_FILES['filez']['name'])) { 
                // get file extension
                $extension = pathinfo($_FILES['filez']['name'], PATHINFO_EXTENSION);
 
                if($extension == 'csv'){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } elseif($extension == 'xlsx') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }
                // file path
                $spreadsheet = $reader->load($_FILES['filez']['tmp_name']);
                $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                unset($allDataInSheet[1]);
                unset($allDataInSheet[2]);
                unset($allDataInSheet[3]);
                //print_mz($allDataInSheet);
                //$start=4;
                foreach($allDataInSheet as $export){
                    //die($exportstart['A']);
                    $input['jenis_risk']=$export['A'];
                    $input['tgl_register']= tglfromxls($export['B']);
                    $input['risk_desc']=$export['C'];
                    $input['status_risk']=$export['D'];
                    $input['sebab']=$export['E'];
                    $input['akibat']=$export['F'];
                    $input['pengendalian_pencegahan']=$export['G'];
                    $input['ir_impact']=$export['H'];
                    $input['ir_probability']=$export['I'];
                    
                    $input['ir_x']=$input['ir_impact']*$input['ir_probability'];
                    
                    $input['ir_assessment']=GetValue('id','sv_assessment_formula',array('impact'=>'where/'.$input['ir_impact'],'probability'=>'where/'.$input['ir_probability']));
                    $input['ic_impact']=$export['J'];
                    $input['ic_probability']=$export['K'];
                    $input['ic_x']=$input['ic_impact']*$input['ic_probability'];
                    
                    $input['ic_assessment']=GetValue('id','sv_assessment_formula',array('impact'=>'where/'.$input['ic_impact'],'probability'=>'where/'.$input['ic_probability']));
                    $input['rr_impact']=$input['ir_impact']-$input['ic_impact'];
                    $input['rr_probability']=$input['ir_probability']-$input['ic_probability'];
                    
                    $input['rr_x']=$input['rr_impact']*$input['rr_probability'];
                    
                    $input['rr_assessment']=GetValue('id','sv_assessment_formula',array('impact'=>'where/'.$input['rr_impact'],'probability'=>'where/'.$input['rr_probability']));
                    $input['r_appetite']=$export['L'];
                    $input['r_tolerance']=$export['M'];
                    $input['kejadian']=$export['N'];
                    $input['estimasi']=round(($input['r_tolerance']-$input['kejadian'])/$input['r_tolerance']*100).'%';
                    $input['size']=$export['O'];
                    $input['divisi']=GetValue('id','ref_divisi',array('title'=>'where/'.$export['P']));
                    $input['risk_owner']=GetValue('id','admin',array('name'=>'where/'.$export['Q']));
                    $input['risk_identifier']=GetValue('id','admin',array('name'=>'where/'.$export['R']));
                    $input['skmr_impact']=$export['S'];
                    $input['skmr_probability']=$export['T'];
                    $input['skmr_x']=$input['skmr_impact']*$input['skmr_probability'];
                    
                    $input['skmr_assessment']=GetValue('id','sv_assessment_formula',array('impact'=>'where/'.$input['skmr_impact'],'probability'=>'where/'.$input['skmr_probability']));
                    
                    $input['id_register']= generatenumbering($input['divisi']);
                    $input['created_by'] = webmasterid();
                    $input['created_on'] = date("Y-m-d H:i:s");
                    $this->db->insert('sv_'.$this->utama, $input);
                    addnumbering($input['divisi']);
                    //$start++;
                }
                // array Count
//                $arrayCount = count($allDataInSheet);
//                $flag = 0;
//                $createArray = array('First_Name', 'Last_Name', 'Email', 'DOB', 'Contact_No');
//                $makeArray = array('First_Name' => 'First_Name', 'Last_Name' => 'Last_Name', 'Email' => 'Email', 'DOB' => 'DOB', 'Contact_No' => 'Contact_No');
//                $SheetDataKey = array();
//                foreach ($allDataInSheet as $dataInSheet) {
//                    foreach ($dataInSheet as $key => $value) {
//                        if (in_array(trim($value), $createArray)) {
//                            $value = preg_replace('/\s+/', '', $value);
//                            $SheetDataKey[trim($value)] = $key;
//                        } 
//                    }
//                }
//                $dataDiff = array_diff_key($makeArray, $SheetDataKey);
//                if (empty($dataDiff)) {
//                    $flag = 1;
//                }
//                // match excel sheet column
//                if ($flag == 1) {
//                    for ($i = 2; $i <= $arrayCount; $i++) {
//                        $addresses = array();
//                        $firstName = $SheetDataKey['First_Name'];
//                        $lastName = $SheetDataKey['Last_Name'];
//                        $email = $SheetDataKey['Email'];
//                        $dob = $SheetDataKey['DOB'];
//                        $contactNo = $SheetDataKey['Contact_No'];
// 
//                        $firstName = filter_var(trim($allDataInSheet[$i][$firstName]), FILTER_SANITIZE_STRING);
//                        $lastName = filter_var(trim($allDataInSheet[$i][$lastName]), FILTER_SANITIZE_STRING);
//                        $email = filter_var(trim($allDataInSheet[$i][$email]), FILTER_SANITIZE_EMAIL);
//                        $dob = filter_var(trim($allDataInSheet[$i][$dob]), FILTER_SANITIZE_STRING);
//                        $contactNo = filter_var(trim($allDataInSheet[$i][$contactNo]), FILTER_SANITIZE_STRING);
//                        $fetchData[] = array('first_name' => $firstName, 'last_name' => $lastName, 'email' => $email, 'dob' => $dob, 'contact_no' => $contactNo);
//                    }   
//                    $data['dataInfo'] = $fetchData;
//                    $this->site->setBatchImport($fetchData);
//                    $this->site->importData();
//                } else {
//                    echo "Please import correct file, did not match excel sheet column";
//                }
            echo "<script>"
            . "window.alert('Berhasil Di Upload');"
                    . "window.location.href='".base_url().$this->utama."';"
            
            . "</script>";
            }         
    }
        function upload_submit_bak(){
            echo "<script>"
            . "window.alert('Berhasil Di Upload');"
                    . "window.location.href='".base_url().$this->utama."';"
            
            . "</script>";
        }

	function delete($id){
            $this->db->where('id',$id);
            $this->db->delete('sv_'.$this->utama);	
            $this->session->set_flashdata("message", 'Sukses dihapus');
            redirect($this->utama);
		
	}
        function download_xls(){
            $data=array();
            $this->db->select("a.id idnya,a.*,DATE_FORMAT(a.tgl_register,'%d/%m/%Y') tgl_register_,DATE_FORMAT(a.created_on,'%d/%m/%Y') created_on_,DATE_FORMAT(a.modify_on,'%d/%m/%Y') modify_on_,DATE_FORMAT(a.app_date,'%d/%m/%Y') app_date_,DATE_FORMAT(a.skmr_date,'%d/%m/%Y') skmr_date_,b.title divisi_,c.name risk_owner_,d.name risk_identifier_,e.name pic_,f.name app_by_,g.title size_,h.name modify_by_,i.name skmr_by_",false)->from($this->utama." a");
            $this->db->join("sv_ref_divisi b","b.id=a.divisi","left");
            $this->db->join("sv_admin c","c.id=a.risk_owner","left");
            $this->db->join("sv_admin d","d.id=a.risk_identifier","left");
            $this->db->join("sv_admin e","e.id=a.created_by","left");
            $this->db->join("sv_admin f","f.id=a.app_by","left");
            $this->db->join("sv_admin h","h.id=a.modify_by","left");
            $this->db->join("sv_admin i","i.id=a.skmr_by","left");
            $this->db->join("sv_ref_size g","g.id=a.size","left");
            if(!diaadmin() && !diaojk())$this->db->where('a.created_by', webmasterid());
            
            if($this->input->get('id_register'))$this->db->like('a.id_register', $this->input->get('id_register'));
            if($this->input->get('jenis_resiko'))$this->db->where('a.jenis_risk', $this->input->get('jenis_resiko'));
            if($this->input->get('divisi'))$this->db->where('a.divisi', $this->input->get('divisi'));
            
            $data['isi']=$this->db->get()->result();
            //$data['col']=$this->listcol();  
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=hasil-export".date('YmdHis').".xls");
            ///$op = explode("%",$lastq);
            //foreach($op as $or){
            //        $inz[]="'$or'";
            //   }
            //    $oops=implode($inz,',');
            // $q="SELECT * FROM sv_activity_view WHERE id IN (".$oops.")";
                
            //$data['lastq']=$this->db->query($q)->result_array();
            $this->load->view('contents/'.$this->utama.'/download',$data);
        }
	function assessment(){
            $impact=$this->input->post('impact');
            $probability=$this->input->post('probability');
            $assess=GetAll('sv_assessment_formula',array('impact'=>'where/'.$impact,'probability'=>'where/'.$probability))->row();
            //$assess=GetValue('assessment','sv_assessment_formula',array('impact'=>'where/'.$impact,'probability'=>'where/'.$probability));
            $dataassess=GetAll('ref_assessment',array('id'=>'where/'.$assess->assessment))->row_array();
            $arr=array('text'=>"<div class='col-md-12' style='background-color:".$dataassess['color']."'>".$dataassess['title']."</div>",'val'=>$assess->id);
            echo json_encode($arr);
        }
        function gantidivisi(){
            $ro=$this->input->post('ro');
            $divisi=GetValue('divisi','sv_admin',array('id'=>'where/'.$ro));
            $arr=array(
                'val'=>$divisi,
                'text'=>GetValue('title','ref_divisi',array('id'=>'where/'.$divisi))
            );
            echo json_encode($arr);
            
        }
          
	function approve()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
                    $appby=GetValue('app_by','risk_data',array('id'=>'where/'.$country_id));
                    if($appby==NULL){
                        $this->db->where('id',$country_id);
			$del=$this->db->update($this->utama,array('app_by'=> webmasterid(),'app_date'=>date('Y-m-d H:i:s')));
                        if($del)$flag='ok';
                        else $flag='nook';
                    }
		}
                echo $flag;
	}
}
?>