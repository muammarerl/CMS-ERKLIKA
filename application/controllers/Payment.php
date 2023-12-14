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

class Payment extends CI_Controller {
	
		var $utama ='payment';
		var $title ='Payment';
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
		// Chart Payment
		$resultPayment = $this->Chart_model->getPaymentData();
		$dataPointsPayment = [];
		foreach ($resultPayment as $row) {
		$dataPointsPayment[] = [
				'date' => $row->date,
				'value' => $row->count
		];
		}
		$jsonChartDataPayment = json_encode($dataPointsPayment);
		$data['jsonChartDataPayment'] = $jsonChartDataPayment;

		// pie chart 
		$count_consumer_1 = $this->Chart_model->getCountByConsumer('retail');
		$count_consumer_2 = $this->Chart_model->getCountByConsumer('school');
		$count_actv_1 = $this->Chart_model->getCountByActivation('sub');
		$count_actv_2 = $this->Chart_model->getCountByActivation('voc');
				$data['count_consumer_1'] = $count_consumer_1;
				$data['count_consumer_2'] = $count_consumer_2;
				$data['count_actv_1'] = $count_actv_1;
				$data['count_actv_2'] = $count_actv_2;

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


		$count_apple = $this->Chart_model->countByPlatform('apple');
		$count_midtrans = $this->Chart_model->countByPlatform('midtrans');
		$count_google = $this->Chart_model->countByPlatform('google');
				$data['count_apple'] = $count_apple;
				$data['count_midtrans'] = $count_midtrans;
				$data['count_google'] = $count_google;

		$data['payment_details'] = $this->Chart_model->getPaymentAll();

		$data['settlement_details'] = $this->Chart_model->getPaymentSettlement();
		$data['pending_details'] = $this->Chart_model->getPaymentPending();
		$data['expired_details'] = $this->Chart_model->getPaymentExpired();
		$data['cancel_details'] = $this->Chart_model->getPaymentCancel();
		$data['refound_details'] = $this->Chart_model->getPaymentRefound();

		// $data['transaction_counts'] = $this->Payment_model->countByTransactionStatus();

		// bar chart 
		// $resultStatus = $this->Chart_model->getStatusTransaction();
        //                 $dataPointsStatus = [];
        //                 foreach ($resultStatus as $row) {
        //                         $dataPointsStatus[] = [
        //                         'country' => $row->transaction_status,
        //                         'visits' => $row->total_status
        //                         ];
        //                 }
        //                 $jsonChartDataStatus = json_encode($dataPointsStatus);
        //                 $data['jsonChartDataStatus'] = $jsonChartDataStatus;

		$data['payment_counts'] = $this->Chart_model->getCountPerId();
        
        


		
		$this->load->view('layout/main',$data);
	}
        function listcol(){
            
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['uid'] = array('UID',100,TRUE,'left',2,TRUE);
            $colModel['order_id'] = array('Order ID',200,TRUE,'left',2);
            $colModel['transaction_status'] = array('Trans Status',80,TRUE,'left',2);
            $colModel['consumer'] = array('Consumer',150,TRUE,'left',2);
            $colModel['email'] = array('Email',150,TRUE,'left',2);
            $colModel['school'] = array('School',110,TRUE,'left',2);
            $colModel['package_'] = array('Package',200,TRUE,'left',2);
            $colModel['qty'] = array('QTY',110,TRUE,'left',2);
            $colModel['total_amount_'] = array('Total Amount',110,TRUE,'left',2);
            $colModel['payable_amount_'] = array('Payable Amount',110,TRUE,'left',2);
            $colModel['platform'] = array('Platform',80,TRUE,'left',2);
            $colModel['payment_type'] = array('Payment Type',100,TRUE,'left',2);
            $colModel['tansaction_id'] = array('Trans ID',80,TRUE,'left',2);
            $colModel['transaction_time_'] = array('Trans Time',150,TRUE,'left',2);
            $colModel['settlement_time_'] = array('Settlement Time',150,TRUE,'left',2);
            $colModel['createdAt_'] = array('Create Date',110,TRUE,'left',2);
            return $colModel;
        }
	
	function get_column(){
			$colModel=$this->listcol();
			$consumer=rawurlencode($this->input->get('consumer'));
			$method=rawurlencode($this->input->get('method'));
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
            //$buttons[] = array('separator');
            //$buttons[] = array('edit','edit','btn');
            $buttons[] = array('export','edit','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record?consumer=$consumer&method=$method&start=$start&end=$end"),$colModel,'id','desc',$gridParams,$buttons);
	}
	
	function get_flexigrid($consumer,$method,$start,$end,$limit=true)
        {

            //Build contents query
			if(!empty($consumer))$this->db->where('a.consumer',$consumer);
			if(!empty($method)){
				if($method=='midtrans'){
					$this->db->where('a.platform',$method);
				}else{
					$this->db->where("a.platform !='midtrans'");
				}
			}
            if(!empty($start)) $this->db->where('DATE(FROM_UNIXTIME(a.createdAt)) >=', $start);
            if(!empty($end)) $this->db->where('DATE(FROM_UNIXTIME(a.createdAt)) <=', $end);
            $this->db->select("a.id idnya,a.*,b.name package_,FORMAT(total_amount,0) AS total_amount_,FORMAT(payable_amount,0) AS payable_amount_,FROM_UNIXTIME(a.transaction_time) as transaction_time_,FROM_UNIXTIME(a.settlement_time) as settlement_time_,FROM_UNIXTIME(a.createdAt) as createdAt_,c.email",false)->from("$this->utama a");
            $this->db->join("packages b","a.package_id=b.id","left");
            $this->db->join("users c","a.uid=c.id","left");
            $this->flexigrid->build_query($limit);

            //Get contents
            $return['records'] = $this->db->get();
			//lastq();
            //Build count query
			if(!empty($consumer))$this->db->where('a.consumer',$consumer);
			if(!empty($method)){
				if($method=='midtrans'){
					$this->db->where('a.platform',$method);
				}else{
					$this->db->where('a.platform !=',$method);
				}
			}
            if(!empty($start))$this->db->where('DATE(FROM_UNIXTIME(a.createdAt)) >=', $start);
            if(!empty($end))$this->db->where('DATE(FROM_UNIXTIME(a.createdAt)) <=', $end);
            $this->db->select("count(id) as record_count")->from($this->utama.' a');
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

			$consumer=rawurldecode($this->input->get('consumer'));
			$method=rawurldecode($this->input->get('method'));
			$start=rawurldecode($this->input->get('start'));
			$end=rawurldecode($this->input->get('end'));
        
            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid($consumer,$method,$start,$end);

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
	function export(){
		$consumer=rawurldecode($this->input->get('consumer'));
		$method=rawurldecode($this->input->get('method'));
		$start=rawurldecode($this->input->get('periode_start'));
		$end=rawurldecode($this->input->get('periode_end'));
		
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
		$content=$this->get_flexigrid($consumer,$method,$start,$end,false);

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
			$sheet->setCellValue('A1', "Data Transaksi"); // Set kolom A1 dengan tulisan "DATA SISWA"
			//$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
			$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
			// Buat header tabel nya pada baris ke 3
			$sheet->setCellValue('A3', "No"); 
			$sheet->setCellValue('B3', "Order ID"); 
			$sheet->setCellValue('C3', "Trans Status");
			$sheet->setCellValue('D3', "Consumer");
			$sheet->setCellValue('E3', "Email");
			$sheet->setCellValue('F3', "School"); 
			$sheet->setCellValue('G3', "Package");
			$sheet->setCellValue('H3', "QTY");
			$sheet->setCellValue('I3', "Total Amount_");
			$sheet->setCellValue('J3', "Payable Amount_");
			$sheet->setCellValue('K3', "Platform");
			$sheet->setCellValue('L3', "Payment Type");
			$sheet->setCellValue('M3', "Trans ID");
			$sheet->setCellValue('N3', "Trans Time");
			$sheet->setCellValue('O3', "Settlement Time");
			$sheet->setCellValue('P3', "Create Date");
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
			$sheet->setCellValue('B'.$numrow, $dt->order_id);
			$sheet->setCellValue('C'.$numrow, $dt->transaction_status);
			$sheet->setCellValue('D'.$numrow, $dt->consumer);
			$sheet->setCellValue('E'.$numrow, $dt->email);
			$sheet->setCellValue('F'.$numrow, $dt->school);
			$sheet->setCellValue('G'.$numrow, $dt->package_);
			$sheet->setCellValue('H'.$numrow, $dt->qty);
			$sheet->setCellValue('I'.$numrow, $dt->total_amount);
			$sheet->setCellValue('J'.$numrow, $dt->payable_amount);
			$sheet->setCellValue('K'.$numrow, $dt->platform);
			$sheet->setCellValue('L'.$numrow, $dt->payment_type);
			$sheet->setCellValue('M'.$numrow, $dt->tansaction_id);
			$sheet->setCellValue('N'.$numrow, $dt->transaction_time_);
			$sheet->setCellValue('O'.$numrow, $dt->settlement_time_);
			$sheet->setCellValue('P'.$numrow, $dt->createdAt_);
			
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
			$sheet->getColumnDimension('I')->setWidth(20);  // Set width kolom D
			$sheet->getColumnDimension('J')->setWidth(20);  // Set width kolom D
			$sheet->getColumnDimension('K')->setWidth(20);  // Set width kolom D
			$sheet->getColumnDimension('L')->setWidth(20);  // Set width kolom D
			$sheet->getColumnDimension('M')->setWidth(20);  // Set width kolom D
			$sheet->getColumnDimension('N')->setWidth(20);   // Set width kolom D
			$sheet->getColumnDimension('O')->setWidth(20); // Set width kolom E
			$sheet->getColumnDimension('P')->setWidth(20); // Set width kolom E
			
			// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
			$sheet->getDefaultRowDimension()->setRowHeight(-1);
			// Set orientasi kertas jadi LANDSCAPE
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			// Set judul file excel nya
			$sheet->setTitle("Laporan Data Transaksi");
			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Laporan Data Transaksi.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
	}
	
	
}
?>