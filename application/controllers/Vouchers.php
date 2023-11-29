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

class Vouchers extends CI_Controller {
	
		var $utama ='vouchers';
		var $title ='Vouchers';
	function __construct()
	{
		error_reporting(0);
		parent::__construct();
        izin();
		$this->load->library('flexigrid');
        $this->load->helper('flexigrid');
	}
	
	function index()
	{
		$this->main();
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
	
	function void()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			$isredeem=GetValue('is_redeem','sv_vouchers',array('id'=>'where/'.$country_id));
				if($isredeem!=1){
				$this->db->where('id',$country_id);
				$del=$this->db->update('sv_vouchers',array('is_redeem'=>2));
            		if($del)$flag='ok';
                    else $flag='nook';
				}else{
					$flag='redeemed';
				}
			
		}
                echo $flag;
	}
	function unvoid()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			$isredeem=GetValue('is_redeem','sv_vouchers',array('id'=>'where/'.$country_id));
				if($isredeem!=1){
				$this->db->where('id',$country_id);
				$del=$this->db->update('sv_vouchers',array('is_redeem'=>0));
            		if($del)$flag='ok';
                    else $flag='nook';
				}else{
					$flag='redeemed';
				}
		}
                echo $flag;
	}
        function listcol(){
            
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['job_'] = array('Job Generate',110,TRUE,'left',2);
            $colModel['status_redeem'] = array('Status Redeem',110,TRUE,'left',2);
            $colModel['email'] = array('Pembeli',180,TRUE,'left',2);
            $colModel['order_id'] = array('Order ID',180,TRUE,'left',2);
            $colModel['package_'] = array('Paket',180,TRUE,'left',2);
            $colModel['code'] = array('Code',180,TRUE,'left',2);
            $colModel['createdAt'] = array('Create Date',110,TRUE,'left',2);
            $colModel['expiredAt'] = array('Expired Date',110,TRUE,'left',2);
            $colModel['redeemby'] = array('Diredeem Oleh',180,TRUE,'left',2);
            $colModel['tgl_redeem'] = array('Tgl Redeem',110,TRUE,'left',2);
            return $colModel;
        }
	
	function get_column(){
	$colModel=$this->listcol();
        
			$code=rawurlencode($this->input->get('code'));
			$email=rawurlencode($this->input->get('email'));
			$job=rawurlencode($this->input->get('job'));
			$status=rawurlencode($this->input->get('status'));

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
            $buttons[] = array('void','delete','btn');
            $buttons[] = array('separator');
			$buttons[] = array('unvoid','check','btn');
            $buttons[] = array('separator');
			$buttons[] = array('export','edit','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record?code=$code&email=$email&job=$job&status=$status"),$colModel,'a.id','desc',$gridParams,$buttons);
	}
	
	function get_flexigrid($code,$email,$job,$status,$limit=true)
        {

            //Build contents query
			if(!empty($code))$this->db->like('a.code',$code);
			if(!empty($email))$this->db->like('u.email',$email);
			if(!empty($job))$this->db->where('a.job_id',$job);
			if(!empty($status)){
				if($status!='expired'){
					if(!empty($status))$this->db->where('a.is_redeem',$status);
				}else{
					$this->db->where('a.expiredAt < UNIX_TIMESTAMP()');
				}
			}
            $this->db->select("a.id idnya,a.*,b.name package_,c.title job_,u.email email,d.order_id,
			case a.is_redeem
			when '0' then 'Belum Diredeem'
			when '1' then 'Sudah Diredeem'
			when '2' then 'Void'
			end as status_redeem,
			eu.email as redeemby,DATE_FORMAT(e.createdAt,'%d/%m/%Y') as tgl_redeem
			",false)->from($this->utama." a");
			$this->db->join("sv_packages b","b.id=a.package_id","left");
			$this->db->join("sv_voucher_job c","c.id=a.job_id","left");
			$this->db->join("sv_payment d","d.id=a.payment_id","left");
			$this->db->join("sv_users u","u.id=a.uid","left");
			$this->db->join("sv_redeem_history e","a.code=e.code","left");
			$this->db->join("sv_users eu","e.redeemBy=eu.id","left");
            $this->flexigrid->build_query($limit);

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
			if(!empty($code))$this->db->like('a.code',$code);
			if(!empty($email))$this->db->like('u.email',$email);
			if(!empty($job))$this->db->where('a.job_id',$job);
			if(!empty($status)){
				if($status!='expired'){
					if(!empty($status))$this->db->where('a.is_redeem',$status);
				}else{
					$this->db->where('a.expiredAt < UNIX_TIMESTAMP()');
				}
			}
            $this->db->select("count(a.id) as record_count")->from($this->utama ." a");
			$this->db->join("sv_users u","u.id=a.uid","left");
            $this->flexigrid->build_query(FALSE,FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
		function getvouchersparent(){
			$id=$this->input->post('parents');
			$a=GetValue('vouchers','vouchers',array('id'=>'where/'.$id));
			echo ($a!='0' ? $a : '');
		}
	
	function get_record(){
            $colModel=$this->listcol();
			$code=rawurldecode($this->input->get('code'));
			$email=rawurldecode($this->input->get('email'));
			$job=rawurldecode($this->input->get('job'));
			$status=rawurldecode($this->input->get('status'));

            $z=0;
            foreach($colModel as $key=>$cm){
				$valid_fields[$z]=$key;
				$z++;
            }

            $this->flexigrid->validate_post('a.id','DESC',$valid_fields);
            $records = $this->get_flexigrid($code,$email,$job,$status);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();
            $a=0;
            $coloring='black';
			$exception=array('id','code');
            foreach ($records['records']->result() as $row)
            {
                $record_items[$a][]=$row->id;
				$record_items[$a][]=$row->id;
				$b=2;
				foreach($colModel as $key=>$cm){
                    if(!in_array($key,$exception)){
                        $record_items[$a][$b]="<span style='color:$coloring'>".$row->$key."</span>";
					$b++;
                    }else{
						if($key=='code'){
							$record_items[$a][$b]="<input oncontextmenu='this.focus();this.select()' type='text' value='".$row->$key."' class='trans codes' readonly>";
						$b++;
						}
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
			$vouchers=GetValue('vouchers','vouchers',array('id'=>'where/'.$country_id));
			//$delete=delvouchers($vouchers);
			$delete['httpcode']=204;
			if($delete['httpcode']==204){
				$del=$this->db->delete($this->utama,array('id'=>$country_id));
            		if($del)$flag='ok';
                    else $flag='nook';
			}else{
				
				$flag='nook';
			}
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
                
		$data['opt']=GetOptAll('admin_grup');
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
			$oldvouchers=GetValue('vouchers','vouchers',array('id'=>'where/'.$id));
			//$updatevouchers=updvouchers($oldvouchers,$data['vouchers']);
			//print_mz($updatevouchers);
			$updatevouchers['httpcode']=200;
			if($updatevouchers['httpcode']==201 || $updatevouchers['httpcode']==200){
				$data['modify_by'] = $webmaster_id;
				$data['modify_on']=date("Y-m-d");
				$this->db->where("id", $id);
				$this->db->update('sv_'.$this->utama, $data);
				//$q="UPDATE sv_vouchers SET vouchers=REPLACE(vouchers, '$oldvouchers', '".$data['vouchers']."') WHERE vouchers LIKE '$oldvouchers%' ";
				//$this->db->query($q);
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Sukses diupdate');
			}else{
				print_mz($updatevouchers);
				$this->session->set_flashdata("err_code", $updatevouchers['response'][0]->VALIDATION_ERROR);
				$this->session->set_flashdata("message", $updatevouchers['response'][0]->message);

			}
		}
		else
		{
			//$insertvoucherstobc=insertvouchers($data['vouchers']);
			//print_mz($insertvoucherstobc);
			$insertvoucherstobc['httpcode']=201;
			if($insertvoucherstobc['httpcode']==201){
				$data['created_by'] = $webmaster_id;
				$data['created_on'] = date("Y-m-d H:i:s");
				$this->db->insert('sv_'.$this->utama, $data);
				$id = $this->db->insert_id();
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Sukses ditambahkan');
			}else{
				$this->session->set_flashdata("err_code", $insertvoucherstobc['response'][0]->VALIDATION_ERROR);
				$this->session->set_flashdata("message", $insertvoucherstobc['response'][0]->message);

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
		
	}function export(){
		$code=rawurldecode($this->input->get('code'));
		$email=rawurldecode($this->input->get('email'));
		$job=rawurldecode($this->input->get('job'));
		$status=rawurldecode($this->input->get('status'));
		
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
		$content = $this->get_flexigrid($code,$email,$job,$status,FALSE);

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
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['job_'] = array('Job Generate',110,TRUE,'left',2);
            $colModel['status_redeem'] = array('Status Redeem',110,TRUE,'left',2);
            $colModel['email'] = array('Pembeli',180,TRUE,'left',2);
            $colModel['order_id'] = array('Order ID',180,TRUE,'left',2);
            $colModel['package_'] = array('Paket',180,TRUE,'left',2);
            $colModel['code'] = array('Code',180,TRUE,'left',2);
            $colModel['createdAt'] = array('Create Date',110,TRUE,'left',2);
            $colModel['expiredAt'] = array('Expired Date',110,TRUE,'left',2);
            $colModel['redeemby'] = array('Diredeem Oleh',180,TRUE,'left',2);
            $colModel['tgl_redeem'] = array('Tgl Redeem',110,TRUE,'left',2);
			*/
			$sheet->setCellValue('A1', "Data Voucher"); // Set kolom A1 dengan tulisan "DATA SISWA"
			//$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
			$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
			// Buat header tabel nya pada baris ke 3
			$sheet->setCellValue('A3', "No"); 
			$sheet->setCellValue('B3', "Job Generate"); 
			$sheet->setCellValue('C3', "Status Redeem");
			$sheet->setCellValue('D3', "Pembeli"); 
			$sheet->setCellValue('E3', "Order ID");
			$sheet->setCellValue('F3', "Paket");
			$sheet->setCellValue('G3', "Code");
			$sheet->setCellValue('H3', "Create Date");
			$sheet->setCellValue('I3', "Expired Date");
			$sheet->setCellValue('J3', "Diredeem Oleh");
			$sheet->setCellValue('K3', "Tgl Redeem");
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
			$sheet->setCellValue('B'.$numrow, $dt->job_);
			$sheet->setCellValue('C'.$numrow, $dt->status_redeem);
			$sheet->setCellValue('D'.$numrow, $dt->email);
			$sheet->setCellValue('E'.$numrow, $dt->order_id);
			$sheet->setCellValue('F'.$numrow, $dt->package_);
			$sheet->setCellValue('G'.$numrow, $dt->code);
			$sheet->setCellValue('H'.$numrow, $dt->createdAt);
			$sheet->setCellValue('I'.$numrow, $dt->expiredAt);
			$sheet->setCellValue('J'.$numrow, $dt->redeemby);
			$sheet->setCellValue('K'.$numrow, $dt->tgl_redeem);
			
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
			header('Content-Disposition: attachment; filename="List Voucher.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
	}
}
?>