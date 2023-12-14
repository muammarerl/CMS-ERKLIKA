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
class User_packages extends CI_Controller {
	
		var $utama ='user_packages'; 
		var $title ='User Package';
	function __construct()
	{
		parent::__construct();
        izin();
		error_reporting(0);
		$this->load->library('flexigrid');
    	$this->load->helper('flexigrid');
		$this->load->model('Chart_model');
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
		$data['userPackageCounts'] = $this->Chart_model->getUsersWithPackageCount();
		$data['userTotalPrices'] = $this->Chart_model->getUsersWithTotalPrice();
		$data['packages'] = $this->Chart_model->getPackageWithTotalPriceSchool();

		// top package 
		$resultPackages = $this->Chart_model->getPackageWithTotalPrice();
                        $dataPointsPackages = [];
                        foreach ($resultPackages as $row) {
                                $dataPointsPackages[] = [
                                'country' => $row->name,
                                'visits' => $row->total_package_id
                                ];
                        }
                        $jsonChartDataPackages = json_encode($dataPointsPackages);
                        $data['jsonChartDataPackages'] = $jsonChartDataPackages;
		// pie chart 
		$count_consumer_1 = $this->Chart_model->getCountByConsumer('retail');
		$count_consumer_2 = $this->Chart_model->getCountByConsumer('school');
		$count_actv_1 = $this->Chart_model->getCountByActivation('sub');
		$count_actv_2 = $this->Chart_model->getCountByActivation('voc');
				$data['count_consumer_1'] = $count_consumer_1;
				$data['count_consumer_2'] = $count_consumer_2;
				$data['count_actv_1'] = $count_actv_1;
				$data['count_actv_2'] = $count_actv_2;

		// table 
        // $data['user_packages'] = $this->Chart_model->getPackageData();
		
		// table 
        $data['user_packages'] = $this->Chart_model->getAllUserPackages();

		$count_pending = $this->Chart_model->countByTransactionStatus('pending');
		$count_settlement = $this->Chart_model->countByTransactionStatus('settlement');
		$count_capture = $this->Chart_model->countByTransactionStatus('capture');
		$count_expired = $this->Chart_model->countByTransactionStatus('expired');
		$count_cancel = $this->Chart_model->countByTransactionStatus('cancel');
		$count_deny = $this->Chart_model->countByTransactionStatus('deny');
		$count_refund = $this->Chart_model->countByTransactionStatus('refund');
				$data['count_pending'] = $count_pending;
				$data['count_settlement'] = $count_settlement;
				$data['count_capture'] = $count_capture;
				$data['count_expired'] = $count_expired;
				$data['count_cancel'] = $count_cancel;
				$data['count_deny'] = $count_deny;
				$data['count_refund'] = $count_refund;

		$data['packages'] = $this->Chart_model->getTopPackages();
          

        		
		$this->load->view('layout/main',$data);
	}
	public function getAllUserPackages() {
        $data = $this->Chart_model->getAllUserPackages();
        echo json_encode(["data" => $data]);
	}
        function listcol(){
            
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['full_name'] = array('Nama',200,TRUE,'left',2);
            $colModel['email'] = array('Email',170,TRUE,'left',2);
            $colModel['school'] = array('School',110,TRUE,'left',2);
            $colModel['packages_'] = array('Paket',150,TRUE,'left',2);
            $colModel['price_'] = array('Price',170,TRUE,'left',2);
            $colModel['createdAt_'] = array('Mulai Berlangganan',120,TRUE,'left',2);
            $colModel['expiredAt_'] = array('Expired Date',110,TRUE,'left',2);
            return $colModel;
        }
	
	function get_column(){
	$colModel=$this->listcol();
        
			$email=rawurlencode($this->input->get('email'));
			$package=rawurlencode($this->input->get('package'));
			$status=rawurlencode($this->input->get('status'));
			$start=rawurlencode($this->input->get('periode_start'));
			$end=rawurlencode($this->input->get('periode_end'));
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
				'height'=>600,
                'showTableToggleBtn' => TRUE
		);
        
           	//$buttons[] = array('select','check','btn');
            //$buttons[] = array('deselect','uncheck','btn');
            //$buttons[] = array('separator');
            //$buttons[] = array('add','add','btn');
            $buttons[] = array('export','edit','btn');
            //$buttons[] = array('edit','edit','btn');
            //$buttons[] = array('delete','delete','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record?email=$email&package=$package&status=$status&start=$start&end=$end"),$colModel,'b.id','desc',$gridParams,$buttons);
	}
	
	function get_flexigrid($email,$package,$status,$limit=true,$start,$end)
        {

            //Build contents query
			if(!empty($email))$this->db->like('a.email',$email);
			if(!empty($status)){
				if($status=='active'){
					$this->db->where('b.expiredAt > UNIX_TIMESTAMP()');
				}else{
					$this->db->where("b.expiredAt < UNIX_TIMESTAMP()");
				}
			}
            if(!empty($start)) $this->db->where('DATE(FROM_UNIXTIME(b.createdAt)) >=', $start);
            if(!empty($end)) $this->db->where('DATE(FROM_UNIXTIME(b.createdAt)) <=', $end);
			if(!empty($package))$this->db->where('b.package_id',$package);
            $this->db->select("a.id idnya,a.*,c.name packages_,DATE_FORMAT(FROM_UNIXTIME(b.createdAt),'%d %M %Y') as createdAt_, DATE_FORMAT(FROM_UNIXTIME(b.expiredAt),'%d %M% %Y') as expiredAt_,FORMAT(b.price,0) price_ ",false)->from("sv_user_packages b");
            $this->db->join("sv_users a","a.id=b.uid","left");
            $this->db->join("sv_packages c","c.id=b.package_id","left");
            $this->flexigrid->build_query($limit);

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
			if(!empty($email))$this->db->like('a.email',$email);
			if(!empty($status)){
				if($status=='active'){
					$this->db->where('b.expiredAt > UNIX_TIMESTAMP()');
				}else{
					$this->db->where("b.expiredAt < UNIX_TIMESTAMP()");
				}
			}
            if(!empty($start)) $this->db->where('DATE(FROM_UNIXTIME(b.createdAt)) >=', $start);
            if(!empty($end)) $this->db->where('DATE(FROM_UNIXTIME(b.createdAt)) <=', $end);
			if(!empty($package))$this->db->where('b.package_id',$package);
            $this->db->select("count(b.id) as record_count")->from("sv_user_packages b");
            $this->db->join("sv_users a","a.id=b.uid","left");
            $this->db->join("sv_packages c","c.id=b.package_id","left");
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
			$email=rawurldecode($this->input->get('email'));
			$package=rawurldecode($this->input->get('package'));
			$status=rawurldecode($this->input->get('status'));
			$start=rawurldecode($this->input->get('start'));
			$end=rawurldecode($this->input->get('end'));
            $z=0;
            foreach($colModel as $key=>$cm){
				$valid_fields[$z]=$key;
				$z++;
            }

            $this->flexigrid->validate_post('b.id','DESC',$valid_fields);
            $records = $this->get_flexigrid($email,$package,$status,true,$start,$end);

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
				curl_setopt($ch, CURLOPT_URL, "http://erklika.id:8000/api/v1/auth/resetpasswordcms"); 
				
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
			$email=rawurldecode($this->input->get('email'));
			$package=rawurldecode($this->input->get('package'));
			$status=rawurldecode($this->input->get('status'));
			
			$content=$this->get_flexigrid($email,$package,$status,false);
			// $content=$this->getAllUserPackages();
	
			$data=$content['data'];
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
				$sheet->setCellValue('A1', "Paket User"); // Set kolom A1 dengan tulisan "DATA SISWA"
				//$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
				$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
				// Buat header tabel nya pada baris ke 3
				$sheet->setCellValue('A3', "No"); 
				$sheet->setCellValue('B3', "Nama"); 
				$sheet->setCellValue('C3', "Email");
				$sheet->setCellValue('D3', "School"); 
				$sheet->setCellValue('E3', "Package");
				$sheet->setCellValue('F3', "Price");
				$sheet->setCellValue('G3', "Mulai Berlangganan");
				$sheet->setCellValue('H3', "Tgl Expired");
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
				$sheet->setCellValue('D'.$numrow, $dt->school);
				$sheet->setCellValue('E'.$numrow, $dt->packages_);
				$sheet->setCellValue('F'.$numrow, $dt->price_);
				$sheet->setCellValue('G'.$numrow, $dt->createdAt_);
				$sheet->setCellValue('H'.$numrow, $dt->expiredAt_);
				
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
				$sheet->setTitle("Laporan Data Paket User");
				// Proses file excel
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment; filename="Laporan Data Paket User.xlsx"'); // Set nama file excel nya
				header('Cache-Control: max-age=0');
				$writer = new Xlsx($spreadsheet);
				$writer->save('php://output');
		}

		function exportexcel(){
			// Import library PHPExcel
require_once 'path/to/assets/PHPExcel/Classes/PHPExcel.php';

if (isset($_POST['exportexcel'])) {
    // Misalnya, $user_packages berisi data yang ingin diekspor dari tabel
    $user_packages = $this->Chart_model->getAllUserPackages(); // Isi dengan data yang sesuai dari database atau sumber lainnya

    // Inisialisasi objek PHPExcel
    $objPHPExcel = new PHPExcel();

    // Set properti-properti file Excel
    $objPHPExcel->getProperties()->setCreator("Your Name")
                                 ->setLastModifiedBy("Your Name")
                                 ->setTitle("Data Export")
                                 ->setSubject("Data Export")
                                 ->setDescription("Data exported to Excel")
                                 ->setKeywords("excel, data export, php")
                                 ->setCategory("Data Export");

    // Isi data ke dalam file Excel
    $objPHPExcel->setActiveSheetIndex(0);
    $sheet = $objPHPExcel->getActiveSheet();
    $row = 1;

    // Menulis data ke dalam file Excel
    foreach ($user_packages as $package) {
        $sheet->setCellValue('A'.$row, $package->full_name);
        $sheet->setCellValue('B'.$row, $package->email);
        $sheet->setCellValue('C'.$row, $package->school);
        $sheet->setCellValue('D'.$row, $package->name);
        $sheet->setCellValue('E'.$row, 'Rp ' . number_format($package->price, 0, ',', '.'));
        $sheet->setCellValue('F'.$row, $package->createdAt);
        $sheet->setCellValue('G'.$row, $package->expiredAt);
        $row++;
    }

    // Set header untuk file Excel yang akan diunduh
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="data_export.xlsx"');
    header('Cache-Control: max-age=0');

    // Simpan file Excel
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}

		}
	
	
}
?>