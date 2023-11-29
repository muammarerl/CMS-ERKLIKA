<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/*************************************
  * Created : January 2021
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

// require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Customer extends CI_Controller {
	
		var $utama ='customer';
		var $title ='Customer';
	function __construct()
	{
		parent::__construct();
        izin();
		error_reporting(0);
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
            $colModel['gid'] = array('GID',200,TRUE,'left',2,TRUE);
            $colModel['full_name'] = array('Full Name',110,TRUE,'left',2);
            $colModel['email'] = array('Email',170,TRUE,'left',2);
            $colModel['phone'] = array('Phone',100,TRUE,'left',2);
            $colModel['birthdate'] = array('Birthdate',110,TRUE,'left',2);
            $colModel['school'] = array('School',110,TRUE,'left',2);
            $colModel['address'] = array('Address',200,TRUE,'left',2);
            $colModel['city_'] = array('City',120,TRUE,'left',2);
            $colModel['province_'] = array('Province',150,TRUE,'left',2);
            $colModel['country'] = array('Country',80,TRUE,'left',2);
            $colModel['zip_code'] = array('ZIPCODE',80,TRUE,'left',2);
            $colModel['user_type_'] = array('User Type',80,TRUE,'left',2);
            //$colModel['is_verified'] = array('Is Verified',80,TRUE,'left',2);
            //$colModel['recurring'] = array('Recurring',80,TRUE,'left',2);
            $colModel['createdAt'] = array('Create Date',110,TRUE,'left',2);
            return $colModel;
        }
	
	function get_column(){
	$colModel=$this->listcol();
	$name=rawurlencode($this->input->get('name'));
	$email=rawurlencode($this->input->get('email'));
	$phone=rawurlencode($this->input->get('phone'));
	$school=rawurlencode($this->input->get('school'));
	$province=rawurlencode($this->input->get('province'));
	$city=rawurlencode($this->input->get('city'));
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
				'height'=>600,
                'showTableToggleBtn' => TRUE
		);
        
           	$buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            //$buttons[] = array('separator');
            //$buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
            //$buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
            $buttons[] = array('reset password','refresh','btn');
            $buttons[] = array('separator');
            $buttons[] = array('export','edit','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record?name=$name&email=$email&phone=$phone&school=$school&province=$province&city=$city"),$colModel,'id','desc',$gridParams,$buttons);
	}
	
	function get_flexigrid($name,$email,$phone,$school,$province,$city,$limit=true)
        {

            //Build contents query
			if(!empty($name))$this->db->like('a.full_name',$name);
			if(!empty($email))$this->db->like('a.email',$email);
			if(!empty($phone))$this->db->like('a.phone',$phone);
			if(!empty($school))$this->db->like('a.school',$school);
			if(!empty($province))$this->db->like('a.province',$province);
			if(!empty($city))$this->db->like('a.city',$city);
            $this->db->select("a.id idnya,a.*,b.title_id user_type_,c.prov_name province_,d.city_name city_",false)->from("sv_users a");
            $this->db->join("sv_users_type b","a.user_type=b.id","left");
            $this->db->join("sv_provinces c","a.province=c.id","left");
            $this->db->join("sv_cities d","a.city=d.id","left");
            $this->flexigrid->build_query($limit);

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
			if(!empty($name))$this->db->like('a.full_name',$name);
			if(!empty($email))$this->db->like('a.email',$email);
			if(!empty($phone))$this->db->like('a.phone',$phone);
			if(!empty($school))$this->db->like('a.school',$school);
			if(!empty($province))$this->db->like('a.province',$province);
			if(!empty($city))$this->db->like('a.city',$city);
            $this->db->select("count(id) as record_count")->from("sv_users a");
            $this->flexigrid->build_query(FALSE,FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
            $colModel=$this->listcol();
			$name=rawurldecode($this->input->get('name'));
			$email=rawurldecode($this->input->get('email'));
			$phone=rawurldecode($this->input->get('phone'));
			$school=rawurldecode($this->input->get('school'));
			$province=rawurldecode($this->input->get('province'));
			$city=rawurldecode($this->input->get('city'));
            $z=0;
            foreach($colModel as $key=>$cm){
				$valid_fields[$z]=$key;
				$z++;
            }

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid($name,$email,$phone,$school,$province,$city);

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
			$del=$this->db->delete("sv_users",array('id'=>$country_id));
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
		if(!$this->input->post('status')){$data['status']='0';}
//		else{$data['is_active']='Active';}
		
		if($id != NULL && $id != '')
		{
			if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			$data['updatedBy'] = $webmaster_id;
			$data['updatedAt']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
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
        function auth($id=null){
		
		error_reporting(0);
		
		$data['modul']=GetAll('menu',array('id_parents'=>'where/0','is_active'=>'where/Active'));
		//lastq();
		$data['id_user']=$id;
		//$this->data['id_grup']=GetValue('id','admin_grup',array('user_id'=>'where/'.$id));
		$data['opt']=GetOptAll('master_sales');
		$data['content'] = 'contents/'.$this->utama.'/auth';
		//End Global
		
		
		$this->load->view('layout/main',$data);
	}
        function auth_submit(){
            error_reporting(0);
		$menu=$this->input->post('menu');
		
		$m_c=$this->input->post('m_c');
		$m_v=$this->input->post('m_v');
		$m_u=$this->input->post('m_u');
		$m_d=$this->input->post('m_d');
		
		$submenu=$this->input->post('submenu');
		$s_c=$this->input->post('s_c');
		$s_v=$this->input->post('s_v');
		$s_u=$this->input->post('s_u');
		$s_d=$this->input->post('s_d');
		$s_e=$this->input->post('s_e');
		$s_p=$this->input->post('s_p');
		$s_b=$this->input->post('s_b');
		
		$user=$this->input->post('user_group');
		foreach($menu as $m){
				$cek=GetAll('users_permission_sf',array('user_id'=>'where/'.$user,'menu_id'=>'where/'.$m))->num_rows();
				$data['menu_id']=$m;
				$data['create']=($m_c[$m] ? '1':'0');
				$data['view']=($m_v[$m] ? '1':'0');
				$data['update']=($m_u[$m] ? '1':'0');
				$data['delete']=($m_d[$m] ? '1':'0');
				//$data['user_id']=$user;
				//$data['user_id']=GetValue('group_id','users_groups',array('user_id'=>'where/'.$user));
				$data['user_id']=$user;
				if($cek==0){
						$this->db->insert('users_permission_sf',$data);
				}
				else{
						$this->db->where(array('user_id'=>$user,'menu_id'=>$m));
						$this->db->update('users_permission_sf',$data);
				}
                }
		foreach($submenu as $sm){
				$cek=GetAll('users_permission_sf',array('user_id'=>'where/'.$user,'menu_id'=>'where/'.$sm))->num_rows();
				$data['menu_id']=$sm;
				$data['create']=($s_c[$sm] ? '1':'0');
				$data['view']=($s_v[$sm] ? '1':'0');
				$data['update']=($s_u[$sm] ? '1':'0');
				$data['delete']=($s_d[$sm] ? '1':'0');
				$data['export']=($s_e[$sm] ? '1':'0');
				$data['print']=($s_p[$sm] ? '1':'0');
				$data['cancel']=($s_b[$sm] ? '1':'0');
				//$data['user_id']=$user;
				//$data['user_id']=GetValue('group_id','users_groups',array('user_id'=>'where/'.$user));
				
				$data['user_id']=$user;
				if($cek==0){
						$this->db->insert('users_permission_sf',$data);
				}
				else{
						$this->db->where(array('user_id'=>$user,'menu_id'=>$sm));
						$this->db->update('users_permission_sf',$data);
				}
                                
                                //if($sm==182)lastq();
                }
                redirect($this->utama);
        }
		function resetemail(){
			$countries_ids_post_array = explode(",",$this->input->post('items'));
			array_pop($countries_ids_post_array);
			foreach($countries_ids_post_array as $index => $country_id){
				$a=new stdClass();
				$a->email=$country_id;
				$data_string=json_encode($a);
				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL, "https://erklika.id:8000/api/v1/auth/resetpasswordcms"); 
				
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
					//'Authorization: Bearer '.$auth, 
					'Accept: application/json',
					'Content-Type: application/json')                                                      
					);                
				//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
				curl_setopt($ch, CURLOPT_POST, true);                                                                   
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
				//curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
				//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
																						   
					$errors = curl_error($ch);                                                                                                            
					$result = curl_exec($ch);
					$returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
					$sent = curl_getinfo($ch);
					$resp=array(
						'httpcode'=>$returnCode,
						'error'=>$errors,
						'sent'=>$sent,
						'response'=>json_decode($result)
					);
					curl_close($ch);  
			}
			echo json_encode($resp);
		}
		function export(){
			$name=rawurldecode($this->input->get('name'));
			$email=rawurldecode($this->input->get('email'));
			$phone=rawurldecode($this->input->get('phone'));
			$school=rawurldecode($this->input->get('school'));
			$province=rawurldecode($this->input->get('province'));
			$city=rawurldecode($this->input->get('city'));
			
			/*if(!empty($consumer))$this->db->where('a.consumer',$consumer);
			if(!empty($method)){
				if($method=='midtrans'){
					$this->db->where('a.platform',$method);
				}else{
					$this->db->where("a.platform !='midtrans'");
				}
			}
			if(!empty($start)) $this->db->where('FROM_UNIXTIME(a.createdAt) >=', $start);
			if(!empty($end)) $this->db->where('FROM_UNIXTIME(a.createdAt) <=', $end);
			$this->db->select("a.id idnya,a.*,b.name package_,FORMAT(total_amount,0) AS total_amount_,FORMAT(payable_amount,0) AS payable_amount_,FROM_UNIXTIME(a.transaction_time) as transaction_time_,FROM_UNIXTIME(a.settlement_time) as settlement_time_,FROM_UNIXTIME(a.createdAt) as createdAt_",false)->from("$this->utama a");
			$this->db->join("packages b","a.package_id=b.id","left");
			*/
			$content=$this->get_flexigrid($name,$email,$phone,$school,$province,$city,FALSE);
	
			$data=$content['records'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
			$style_col = [
				  'font' => ['bold' => true], // Set font nya jadi bold
				  'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				],
				'borders' => [
					'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
					'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
					'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
					'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
				]
			];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
				$style_row = [
				'alignment' => [
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				],
				'borders' => [
					'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
					'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
					'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
					'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
				]
				];
				/*
	
				$colModel['order_id'] = array('Order ID',200,TRUE,'left',2);
				$colModel['consumer'] = array('Consumer',150,TRUE,'left',2);
				$colModel['school'] = array('School',110,TRUE,'left',2);
				$colModel['package_'] = array('Package',200,TRUE,'left',2);
				$colModel['qty'] = array('QTY',110,TRUE,'left',2);
				$colModel['total_amount'] = array('Total Amount',110,TRUE,'left',2);
				$colModel['payable_amount'] = array('Payable Amount',110,TRUE,'left',2);
				$colModel['platform'] = array('Platform',80,TRUE,'left',2);
				$colModel['payment_type'] = array('Payment Type',100,TRUE,'left',2);
				$colModel['transaction_status'] = array('Trans Status',80,TRUE,'left',2);
				$colModel['tansaction_id'] = array('Trans ID',80,TRUE,'left',2);
				$colModel['transaction_time_'] = array('Trans Time',150,TRUE,'left',2);
				$colModel['settlement_time_'] = array('Settlement Time',150,TRUE,'left',2);
				$colModel['createdAt_'] = array('Create Date',110,TRUE,'left',2);
				*/
				$sheet->setCellValue('A1', "Data Customer"); // Set kolom A1 dengan tulisan "DATA SISWA"
				//$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
				$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
				// Buat header tabel nya pada baris ke 3
				$sheet->setCellValue('A3', "No"); 
				$sheet->setCellValue('B3', "Nama"); 
				$sheet->setCellValue('C3', "Email");
				$sheet->setCellValue('D3', "Phone"); 
				$sheet->setCellValue('E3', "Birthdate");
				$sheet->setCellValue('F3', "School");
				$sheet->setCellValue('G3', "Address");
				$sheet->setCellValue('H3', "City");
				$sheet->setCellValue('I3', "Province");
				$sheet->setCellValue('J3', "Country");
				$sheet->setCellValue('K3', "ZIP Code");
				$sheet->setCellValue('L3', "User Type");
				//$sheet->setCellValue('M3', "Is Verified");
				//$sheet->setCellValue('N3', "Recurring");
				$sheet->setCellValue('M3', "Create Date");
				// Apply style header yang telah kita buat tadi ke masing-masing kolom header
				//$sheet->getStyle('A3')->applyFromArray($style_col);
				//$sheet->getStyle('B3')->applyFromArray($style_col);
				//$sheet->getStyle('C3')->applyFromArray($style_col);
				//$sheet->getStyle('D3')->applyFromArray($style_col);
				//$sheet->getStyle('E3')->applyFromArray($style_col);
				// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
				$no = 1; // Untuk penomoran tabel, di awal set dengan 1
				$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
				foreach($data->result() as $dt){ // Lakukan looping pada variabel siswa
				$sheet->setCellValue('A'.$numrow, $no);
				$sheet->setCellValue('B'.$numrow, $dt->full_name);
				$sheet->setCellValue('C'.$numrow, $dt->email);
				$sheet->setCellValue('D'.$numrow, $dt->phone);
				$sheet->setCellValue('E'.$numrow, $dt->birthdate);
				$sheet->setCellValue('F'.$numrow, $dt->school);
				$sheet->setCellValue('G'.$numrow, $dt->address);
				$sheet->setCellValue('H'.$numrow, $dt->city_);
				$sheet->setCellValue('I'.$numrow, $dt->province_);
				$sheet->setCellValue('J'.$numrow, $dt->country);
				$sheet->setCellValue('K'.$numrow, $dt->zip_code);
				$sheet->setCellValue('L'.$numrow, $dt->user_type_);
				//$sheet->setCellValue('M'.$numrow, $dt->is_verified);
				//$sheet->setCellValue('N'.$numrow, $dt->recurring);
				$sheet->setCellValue('M'.$numrow, $dt->createdAt);
				
				// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
				//$sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
				//$sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
				//$sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
				//$sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
				//$sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
				
				$no++; // Tambah 1 setiap kali looping
				$numrow++; // Tambah 1 setiap kali looping
				}
				// Set width kolom
				$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
				$sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
				$sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
				$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
				$sheet->getColumnDimension('E')->setWidth(20); // Set width kolom D
				$sheet->getColumnDimension('F')->setWidth(20);  // Set width kolom D
				$sheet->getColumnDimension('G')->setWidth(20);  // Set width kolom D
				$sheet->getColumnDimension('H')->setWidth(20);  // Set width kolom D
				
				// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
				$sheet->getDefaultRowDimension()->setRowHeight(-1);
				// Set orientasi kertas jadi LANDSCAPE
				$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
				// Set judul file excel nya
				$sheet->setTitle("Laporan List User");
				// Proses file excel
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment; filename="Laporan Data Paket User.xlsx"'); // Set nama file excel nya
				header('Cache-Control: max-age=0');
				$writer = new Xlsx($spreadsheet);
				$writer->save('php://output');
		}
		function load_city(){
			
			$prov=$this->input->post('p');
			$getcity=GetAll('sv_cities',array('prov_id'=>'where/'.$prov))->result();
			//foreach($getcity as $gc){
			//}
			echo json_encode($getcity);
		}
	
	
}
?>